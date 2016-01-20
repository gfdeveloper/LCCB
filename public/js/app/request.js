!function ($) {
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD H:mm:ss',
            defaultDate: moment()
        });

        $('#new-request-form').ajaxForm({
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
        $('#organization_id').select2({
            placeholder: "Select an Organization"
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

        Dropzone.autoDiscover = false;
        Dropzone.options.myDrop = {
            paramName: "files", // The name that will be used to transfer the file
            parallelUploads: 15,
            maxFilesize: 5, // MB
            uploadMultiple: true,
            autoProcessQueue: false,
            addRemoveLinks: true,
            accept: function (file, done) {
                // TODO: Image upload validation
                done();
            },
            sending: function (file, xhr, formData) {
                var formValues = $('#new-request-form').serializeObject()
                $.each(formValues, function (key, value) {
                    formData.append(key, value);
                });
            },
            init: function () {
                this.on("success", function (file, response) {
                    this.removeFile(file)
                    redirectUser(response);
                });
                this.on("complete", function (file, json) {
                    redirectUser(json);
                });
            }
        };

        var myDropzone = new Dropzone("#myDrop", {
            url: $("#new-request-form").attr('action')
        });

        $('#submitForm').on('click', function () {
            console.log(myDropzone.getQueuedFiles().length);
            if (myDropzone.getQueuedFiles().length > 0) {
                //$('#submitForm').prop('disabled', true);
                myDropzone.processQueue();
            }
            else {
                //$('#submitForm').prop('disabled', true);
                $('#new-request-form').ajaxSubmit({
                    clearForm: false,
                    error: displayErrors,
                    beforeSubmit: clearErrors,
                    success: redirectUser
                });
            }
        });
    })
}(window.jQuery)