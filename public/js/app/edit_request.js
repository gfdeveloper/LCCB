!function ($) {
    $(function () {
            (function (a) {
                a.createModal = function (b) {
                    defaults = {title: "", message: "Your Message Goes Here!", closeButton: true, scrollable: false};
                    var b = a.extend({}, defaults, b);
                    var c = (b.scrollable === true) ? 'style="max-height: 620px;overflow-y: auto;"' : "";
                    html = '<div class="modal modal-wide fade" id="myModal">';
                    html += '<div class="modal-dialog">';
                    html += '<div class="modal-content">';
                    html += '<div class="modal-header">';
                    html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
                    if (b.title.length > 0) {
                        html += '<h4 class="modal-title">' + b.title + "</h4>"
                    }
                    html += "</div>";
                    html += '<div class="modal-body" ' + c + ">";
                    html += b.message;
                    html += "</div>";
                    html += '<div class="modal-footer">';
                    if (b.closeButton === true) {
                        html += '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'
                    }
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    a("body").prepend(html);
                    a("#myModal").modal().on("hidden.bs.modal", function () {
                        a(this).remove()
                    })
                }
            })(jQuery);

            $('#new-comment-form').ajaxForm({
                success: reloadComments
            });

            $('#new-action-form').ajaxForm({
                clearForm: true,
                success: addAction
            });

            var actionSource = $("#actionItemsTemplate").html();
            var newTemplate = Handlebars.compile(actionSource);

            function addAction(data) {
                $('#noActionItemsFound').remove();
                toastr.success('Your action item has been saved.', 'Delegated!')
                $('#action-item-modal').modal('hide');
                var html = newTemplate(data);
                $('#actionItemList').prepend(html);
            }

            $('#actionItemList').on('click', '.btn.btn-xs.btn-success', function () {
                $.getJSON('/action/close/' + $(this).data('action_id'), function (message) {
                    if (message.status) {
                        toastr.success(message.text, message.title)
                        $('#label-' + message.id).removeClass('label-danger').addClass('label-success').html('Closed on ' + message.closed);
                        $('#actions-' + message.id).remove();
                    } else {
                        toastr.error(message.text, message.title)
                    }
                });
            });

            $('input[type="checkbox"]').change(function () {
                this.value ^= 1;
            });

            $('#run-approval').on('click', function () {
                $.ajax({
                    url: "/lccb/approve/" + $(this).data('id'),
                    data: {
                        '_token': $(this).data('token'),
                        'comments': $('#comment').val(),
                        'approved-offline': $('#approved-offline').val()
                    },
                    method: 'post'
                }).done(function (json) {
                    window.location.reload();
                });
            });

            $('#run-rejection').on('click', function () {
                $.ajax({
                    url: "/lccb/reject/" + $(this).data('id'),
                    data: {
                        '_token': $(this).data('token'),
                        'comments': $('#reject-comment').val(),
                        'approved-offline': $('#rejected-offline').val()
                    },
                    method: 'post'
                }).done(function (json) {
                    window.location.reload();
                });
            });

            $('#files').on('click', '.pdf', function () {
                var pdf_link = $(this).attr('href');
                var iframe = '<div class="iframe-container"><iframe src="' + pdf_link + '"></iframe></div>'
                $.createModal({
                    title: 'Preview PDF',
                    message: iframe,
                    closeButton: true,
                    scrollable: false
                });
                return false;
            });

            $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD H:mm:ss',
                defaultDate: moment()
            });

            $('#edit-request-form').ajaxForm({
                clearForm: false,
                error: displayErrors,
                beforeSubmit: clearErrors,
                success: redirectUser
            });

            function displayErrors(responseText) {
                $('#error').show();
                var errors = $.parseJSON(responseText.responseText);
                $.each(errors, function (index, value) {
                    $('#' + index).parents('.form-group').addClass('has-error');
                    $('#' + index).next('.help-block').html(value);
                });
            }

            function clearErrors() {
                $('#error').hide();
                $('.help-block').html('');
                $('.form-group').each(function (index, value) {
                    $(this).removeClass('has-error');
                });
            }

            function reloadComments(id) {
                toastr.success('Your comment has been saved.', 'Added!')
                $('#comment-modal').modal('hide');
                $.ajax({
                    url: '/api/getComments/' + id
                }).done(function (html) {
                    $('#comments').html(html);
                });
            }


            Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

                switch (operator) {
                    case '==':
                        return (v1 == v2) ? options.fn(this) : options.inverse(this);
                    case '===':
                        return (v1 === v2) ? options.fn(this) : options.inverse(this);
                    case '<':
                        return (v1 < v2) ? options.fn(this) : options.inverse(this);
                    case '<=':
                        return (v1 <= v2) ? options.fn(this) : options.inverse(this);
                    case '>':
                        return (v1 > v2) ? options.fn(this) : options.inverse(this);
                    case '>=':
                        return (v1 >= v2) ? options.fn(this) : options.inverse(this);
                    case '&&':
                        return (v1 && v2) ? options.fn(this) : options.inverse(this);
                    case '||':
                        return (v1 || v2) ? options.fn(this) : options.inverse(this);
                    default:
                        return options.inverse(this);
                }
            });

            function reloadActions(id) {
                toastr.success('Your action item has been saved.', 'Deligated!')
                $('#actionsBlock').block({
                    message: '<h4>Loading</h4>'
                });
                $('#action-item-modal').modal('hide');
                $.getJSON('/actions/get/' + id, function (context) {
                    $('#actionItemsList').html('');
                    $.each(context, function (index, element) {
                        var html = newTemplate(element);
                        $('#actionItemsList').append(html);
                    });
                    $('#actionsBlock').unblock();
                });
            }

            //alert($('#container').data('request_id'))

            //reloadActions($('#container').data('request_id'));

            function reloadUploads(id) {
                $.ajax({
                    url: '/api/getUploads/' + id,
                    dataType: 'text'
                }).done(function (html) {
                    $('#uploadDiv').html(html);
                });
            }

            function redirectUser(json) {
                json = $.parseJSON(json);
                if (json.redirect) {
                    // data.redirect contains the string URL to redirect to
                    window.location.href = json.redirect;
                }
                else {
                    // data.form contains the HTML for the replacement form
                    swal(json.title, json.message, "success")
                }
            }

            $('#location_id').select2({
                placeholder: "Select a Location"
            });
            $('#functional_id').select2({
                placeholder: "Select a Functional Area"
            });
            $('#category_id').select2({
                placeholder: "Select a Category"
            });

            var equipment = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '/equipment/search/%QUERY',
                    wildcard: '%QUERY'
                },
                limit: 10
            });

            equipment.initialize();

            $('#equipment .typeahead').typeahead(null, {
                name: 'equipment_id',
                display: 'value',
                source: equipment.ttAdapter()
            });

            $('#equipment').bind('typeahead:selected', function (obj, datum, name) {
                //$('#equipment_id').val(datum.id);
            });

            $('.input-group.date').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });

            $('#revoke-request').on('click', function () {
                var info = $(this)
                swal({
                    title: "Are you sure?",
                    text: "This will erase your approval for this request?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: "/lccb/revoke/" + info.data('request_id'),
                        data: {
                            '_token': info.data('token')
                        },
                        method: 'post'
                    }).done(function (json) {
                        swal("Deleted!", "Your approval has been deleted.", "success");
                        window.location.reload();
                    });

                });
            });

            $('.delete-request').on('click', function () {
                var location = $(this);
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this request!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: '/lccb/' + location.data('request_id'),
                        type: 'post',
                        data: {
                            _method: "DELETE",
                            _token: location.data('token')
                        },
                        success: function () {
                            location.closest('tr').hide();
                            $('#request-status').html('Deleted');
                            swal("Deleted!", "The request has been put into purgatory.", "success");
                        }
                    })

                });
            });

            $('.update-status').on('click', function () {
                var location = $(this);
                $.ajax({
                    url: '/lccb/status/' + location.data('request_id') + "/" + location.data('status'),
                    type: 'post',
                    data: {
                        _method: "POST",
                        _token: location.data('token')
                    },
                    success: function (data) {
                        swal("Updated!", "The request status has been updated.", "success");
                        $('#request-status').html(data.message);
                    }
                });
            });

            Dropzone.autoDiscover = false;
            Dropzone.options.myDrop = {
                paramName: "files", // The name that will be used to transfer the file
                parallelUploads: 15,
                maxFilesize: 10, // MB
                uploadMultiple: true,
                autoProcessQueue: true,
                addRemoveLinks: true,
                accept: function (file, done) {
                    // TODO: Image upload validation
                    done();
                },
                sending: function (file, xhr, formData) {
                    formData.append('request-id', $('#request-id').val());
                    formData.append('_token', $('input[name=_token]').val());
                },
                init: function () {
                    this.on("success", function (file, response) {
                        this.removeFile(file)
                        reloadUploads(response);
                    });
                    //this.on("complete", function () {
                    //    redirectUser();
                    //});
                }
            };

            var myDropzone = new Dropzone("#myDrop", {
                url: '/lccb/attach/' + $('#request-id').val()
            });

            $('#submitForm').on('click', function () {
                $('#edit-request-form').ajaxSubmit({
                    clearForm: false,
                    error: displayErrors,
                    beforeSubmit: clearErrors,
                    success: redirectUser
                });
            });

            $('#uploadDiv').on('click', '.delete-file', function () {
                ///download/{!! $file->id !!}/delete
                $.ajax({
                    url: '/download/' + $(this).data('fileid') + '/delete',
                    method: 'get'
                }).done(function (id) {
                    $('#file-' + id).remove();
                    swal("Removed!", "The file has been deleted.", "success");
                });

            })
        }
    )
}
(window.jQuery)