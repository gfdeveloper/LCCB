<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LCCB Application</title>

    <!-- Bootstrap core CSS -->


    <link href="/css/main-dev.css" rel="stylesheet">
    <!--
    <link href="/css/test.css" rel="stylesheet">
    -->
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/select2.css" rel="stylesheet">
    <link href="/css/sweetalert.css" rel="stylesheet">
    <link href="/css/toastr.min.css" rel="stylesheet">
    <!--
    <link href="/css/select2-bootstrap.css" rel="stylesheet">
    -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    @yield('css')


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>



<!-- Fixed navbar -->
@include('navbar')


@yield('content')

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/select2.full.min.js"></script>
<script src="/plugins/sweet/sweetalert.min.js"></script>
<script src="/plugins/toastr.min.js"></script>
<script src="/plugins/block/jquery.blockUI.js"></script>
@yield('js')
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-50484696-2', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>