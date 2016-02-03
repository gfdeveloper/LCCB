!function ($) {
    $(function () {
        $('#reportrange').daterangepicker({
                startDate: moment().subtract(6, 'days'),
                endDate: moment(),
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                ranges: {
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last Week': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
                    'Two Weeks Ago': [moment().subtract(2, 'weeks').startOf('isoWeek'), moment().subtract(2, 'weeks').endOf('isoWeek')]
                }
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                buildReport(start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59")
                //buildChart('/reports/approvals/', start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59", '#approvalsReport')
                //updateAverage('/reports/average/', start.format('YYYY-MM-DD') + " 00:00:00", end.format('YYYY-MM-DD') + " 23:59:59", '#averageReport')
            }
        );
        $('#reportrange span').html(moment().subtract(6, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        var start = $("#reportrange").data().daterangepicker.startDate.format('YYYY-MM-DD') + " 00:00:00";
        var end = $("#reportrange").data().daterangepicker.endDate.format('YYYY-MM-DD') + " 23:59:59";

        var newSource = $("#newTemplate").html();
        var approvals = $("#approvalsTemplate").html();
        var actionItems = $("#actionItemsTemplate").html();
        var newTemplate = Handlebars.compile(newSource);
        var approvalsTemplate = Handlebars.compile(approvals);
        var actionsTemplate = Handlebars.compile(actionItems);

        buildReport(start, end);

        function buildReport(start, finish) {
            $('#newRequestBlock').block({
                message: '<h4>Loading</h4>'
            });

            $('#newApprovalsBlock').block({
                message: '<h4>Loading</h4>'
            });

            $('#actionItemsBlock').block({
                message: '<h4>Loading</h4>'
            });

            $.getJSON('/reports/minutes/get/' + start + '/' + finish, function (context) {
                $('#newReport').html('');
                $.each(context, function (index, element) {
                    var html = newTemplate(element);
                    $('#newReport').append(html);
                });
                $('#newRequestBlock').unblock();
            });

            $.getJSON('/reports/approvals/get/' + start + '/' + finish, function (context) {
                $('#newApprovals').html('');
                $.each(context, function (index, element) {
                    var html = approvalsTemplate(element);
                    $('#newApprovals').append(html);
                });
                $('#newApprovalsBlock').unblock();
            });

            $.getJSON('/reports/actions/get/' + start + '/' + finish, function (context) {
                $('#actionItems').html('');
                $.each(context, function (index, element) {
                    var html = actionsTemplate(element);
                    $('#actionItems').append(html);
                });
                $('#actionItemsBlock').unblock();
            });
        }

        $('#actionItemsBlock').on('click', '.close-ai', function () {
            $.ajax({
                url: '/action/close/' + $(this).data('a_id'),
                method: 'GET'
            }).done(function (data) {
                $('#ai-'+data.id).fadeOut();
            })
        })
    })
}(jQuery);