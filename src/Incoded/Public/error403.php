<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Incoded Framework - PHP, MySQL, HTML, CSS, Javascript, MVC, Framework">
    <meta name="author" content="">

    <title><?php echo $this->getTitle() ?></title>

    <?php $this->showAssets('stylesheets') ?> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/icon-precomposed.png">
</head>
<body>

<?php $this->includeTemplate('_header') ?> 

<div class="container container-home text-center">

    <div class="row">
        <div class="col-md-12">
            <h1>Access to this page is forbidden. Sorry.</h1>
            <p>&nbsp;</p>
            <p>
                Sorry, but access to this page is forbidden. Even if you have authentication, you are still not allowed to access this page. 
                It's not meant for your eyes - ever! Check the URL you entered for any mistakes and try again. Alternatively, search for 
                whatever is missing or take a look around the rest of our site.
            </p>
            <p>&nbsp;</p>
            <p class="text-center">
                E-mail us if you need help.<br>
                <a href="mailto:office@incoded.net" data-toggle="tooltip" title="E-mail us if you need help.">office@incoded.net</a>
            </p>
            <p>&nbsp;</p>
            <p class="text-center">
                Return to Homepage.<br>
                <a href="/" data-toggle="tooltip" title="Return to Homepage"><i class="fa fa-home" style="font-size:36px; text-shadow: 0 1px 3px rgba(51, 51, 51, 0.7);"></i></a>
            </p>
        </div>
    </div>

</div>

<?php $this->includeTemplate('_footer') ?> 

<?php $this->showAssets('javascripts') ?> 

</body>
</html>