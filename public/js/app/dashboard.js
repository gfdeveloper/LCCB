!function ($) {
    $(function () {
        $('#reportrange').daterangepicker({
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                ranges: {
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                }
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                buildChart('/reports/organization/', start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59", '#functionalReport')
                buildChart('/reports/approvals/', start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59", '#approvalsReport')
                updateAverage('/reports/average/', start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59", '#averageReport')
            }
        );
        $('#reportrange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        var start = $("#reportrange").data().daterangepicker.startDate.format('YYYY-MM-DD') + " 00:00:00";
        var end = $("#reportrange").data().daterangepicker.endDate.format('YYYY-MM-DD') + " 23:59:59";
        buildChart('/reports/organization/', start, end, '#functionalReport');
        buildChart('/reports/approvals/', start, end, '#approvalsReport');
        updateAverage('/reports/average/', start, end, '#averageReport')

        function buildChart(url, start, finish, div) {
            $(div).block({
                message: '<h4>Loading Report</h4>'
            });
            $.getJSON(url + start + '/' + finish, function (data) {
                $(div).unblock();
                if (data.status == 'error') {
                    $(div).html(data.message);
                } else {
                    $(div).highcharts(data)
                }
            });
        }

        function updateAverage(url, start, finish, div) {
            $(div).block({
                message: '<h4>Updating</h4>'
            });
            $('#statistics').block({
                message: '<h4>Updating</h4>'
            });
            $.getJSON(url + start + '/' + finish, function (data) {
                $(div).unblock();
                $('#statistics').unblock();

                if (data['average'].status == 'error') {
                    $(div).html(data['average'].message);
                } else {
                    $(div).html(data['average'].message);
                }

                if(data['stats'].status == 'error') {
                    $('#total').html(0);
                    $('#new').html(0);
                    $('#approved').html(0);
                    $('#open').html(0);
                    $('#waiting').html(0);
                    $('#rejected').html(0);
                } else {
                    $('#total').html(data.stats[0].total);
                    $('#new').html(data.stats[0].new);
                    $('#approved').html(data.stats[0].approved);
                    $('#open').html(data.stats[0].open);
                    $('#waiting').html(data.stats[0].waiting);
                    $('#rejected').html(data.stats[0].rejected);
                }
            });
        }

        $.getJSON('/api/get/openActions', function(number){
            $('#openActionItems').html(number);
        });


    });
}(window.jQuery)
