!function ($) {
    $(function () {
        var table = $('#search').DataTable({
            processing: true,
            serverSide: true,
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'pdf'
            ],
            ajax: {
                url: '/search/find',
                method: 'post',
                data: function (d) {
                    d.name = $('input[name=name]').val();
                    d.operator = $('select[name=operator]').val();
                    d.post = $('input[name=post]').val();
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'requested_on', name: 'requested_on'},
                {data: 'requester', name: 'users.name'},
                {data: 'equipment', name: 'equipment.name'},
                {data: 'description', name: 'descrption'},
                {data: 'area', name: 'areas.name'},
                {data: 'location', name: 'locations.name'},
                {data: 'category', name: 'categories.name'},
                {data: 'organization', name: 'organizations.name'},
                {data: 'status', name: 'status.name'}
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
            }
        });

        //table.buttons().container()
        //    .appendTo($('.col-sm-6:eq(0)', table.table().container()));
    })
}(window.jQuery);