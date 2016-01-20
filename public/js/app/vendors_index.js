!function ($) {
    $(function () {
        var $table = $('#vendors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/api/org',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('.add-new-vendor').on('click', function () {
            $('#name').val('');
            $('#add-org-form').attr("action", '/api/org/save');
            $('#add-new-vendor-modal').modal('show');
            $('#method').val('POST');
        });

        $('#vendors-table').on('click', '.edit-vendor', function(){
            $('#name').val($(this).data('name'));
            $('#add-org-form').attr("action", '/api/org/update/' + $(this).data('id'));
            $('#method').val('PUT');
            $('#add-new-vendor-modal').modal('show');
        });

        $('#add-org-form').ajaxForm({
            method: 'POST',
            beforeSubmit: stuff,
            success: showResponse,
            error: showError
        });

        function showResponse(responseText, statusText, xhr, $form)  {
            $('#add-new-vendor-modal').modal('hide');
            $('#error-message-div').hide();
            $('#save-button').html('Save Changes').prop('disabled', false);
            $('#name').val('');
            $table.draw();
        }

        function stuff() {
            $('#save-button').html('Please Wait!').prop('disabled', true);
        }

        function showError(response) {
            $('#error-message').html(response.responseJSON.name[0]);
            $('#error-message-div').show();
            $('#save-button').html('Save Changes').prop('disabled', false);
        }
    })
}(window.jQuery);