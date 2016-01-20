!function ($) {
    $(function () {
        $('#newRequests').DataTable();

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
                    url: '/lccb/'+location.data('id'),
                    type: 'post',
                    data: {
                        _method: "DELETE",
                        _token: location.data('token')
                    },
                    success: function(){
                        location.closest('tr').hide();
                        swal("Deleted!", "The request has been put into purgatory.", "success");
                    }
                })

            });
        })
    })
}(window.jQuery)