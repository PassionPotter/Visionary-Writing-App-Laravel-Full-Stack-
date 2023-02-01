<!DOCTYPE HTML>
<html>
<head>
<title>Visionary Writings</title>

<!-- favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://visionarywritings.b-cdn.net/images/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="https://visionarywritings.b-cdn.net/images/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="https://visionarywritings.b-cdn.net/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="https://visionarywritings.b-cdn.net/images/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="https://visionarywritings.b-cdn.net/images/favicon/favicon-16x16.png">
<link rel="manifest" href="{{asset('images/favicon/manifest.json')}}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="https://visionarywritings.b-cdn.net/images/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!-- favicon -->

<link href="https://visionarywritings.b-cdn.net/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="https://visionarywritings.b-cdn.net/css/material-blog.css" rel="stylesheet">
<link rel="stylesheet" href="https://visionarywritings.b-cdn.net/css/bootstrap.min.css">
<script src="https://visionarywritings.b-cdn.net/js/jquery.min.js"></script>
<script src="https://visionarywritings.b-cdn.net/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
@stack('metatag')
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<style>
.error-404 {
  margin: 0 auto;
  text-align: center;
}
.error-404 .error-code {
  bottom: 60%;
  color: #4686CC;
  font-size: 96px;
  line-height: 100px;
  font-weight: bold;
}
.error-404 .error-desc {
  font-size: 12px;
  color: #647788;
}
.error-404 .m-b-10 {
  margin-bottom: 10px!important;
}
.error-404 .m-b-20 {
  margin-bottom: 20px!important;
}
.error-404 .m-t-20 {
  margin-top: 20px!important;
}

</style>
<script>// <![CDATA[
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','https://www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-76356300-1', 'auto'); ga('send', 'pageview');
// ]]></script>
</head><body>
@include('frontend.partials.header')
<div class="about">
<div class="container">  
	<div class="row">
    <div class="error-404">
    <div class="error-code m-b-10 m-t-20">500 <i class="fa fa-warning"></i></div>
    <h2 class="font-bold">Oops 500! Internal Server Error.</h2>

        <div class="error-desc">
        It seems like there is an error in your code. Please check and run again.
            <div><br/>
                <!-- <a class=" login-detail-panel-button btn" href="http://vultus.de/"> -->
                <a href="https://visionarywritings.com" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Go back to Homepage</a>
            </div>
        </div>
    </div>
  </div>
  </div>
</div>
@include('frontend.partials.footer')
