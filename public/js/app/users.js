!function ($) {
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/api/user-data',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'organization', name: 'organization', orderable: false, searchable: false},
                {data: 'role', name: 'role', orderable: false, searchable: false}
            ]
        }).on('draw.dt', function (e, settings, data) {
            $('.organization').select2({
            }).on("select2:select", function (e) {
                $.ajax({
                    url: '/api/org/' + $(this).data('userid') + '/' + $(this).val()
                }).done(function(json){
                    toastr.success(json.message, json.messageTitle)
                });
            });

            $('.role').select2({
                minimumResultsForSearch: Infinity
            }).on("select2:select", function (e) {
                $.ajax({
                    url: '/api/role/' + $(this).data('userid') + '/' + $(this).val()
                }).done(function(json){
                    toastr.success(json.message, json.messageTitle)
                });
            });
        });
    })
}(window.jQuery);
