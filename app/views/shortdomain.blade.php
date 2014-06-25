
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <title>{{ $_ENV['COMPANY_NAME'] }}</title>
    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 100px;
            padding-bottom: 100px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 650px;
            padding: 30px;
            margin: 0 auto;
            background:white;
            font-size:24px;
            border-radius:10px
        }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="form-signin" role="form">
       <p>{{ $_ENV['COMPANY_NAME'] }} uses <b>{{ $_ENV['SHORT_DOMAIN'] }}</b> as part of its URL shortener service.</p>
        <p>It's a service that will be 100% free forever. You can try register/signup for it with Facebook or email.</p>
        <br/>
        <p><a href="{{ $_ENV['COMPANY_SITE'] }}" class="btn btn-primary"> Go to Shortener</a></p>
    </div>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
