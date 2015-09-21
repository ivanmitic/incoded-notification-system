<!doctype html>
<!--[if IE 8]>    <html class="no-js ie ie8 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head> 
    <meta charset="utf-8"> 

    <title><?php echo $this->getTitle() ?></title>

    <meta name="description" content=""> 
    <meta name="keywords" content=""> 
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->showAssets('stylesheets') ?> 

    <link href="/assets/img/icons/favicon.png" rel="shortcut icon" type="image/png"/>
<body>

    <div class="wrapper">

        <?php $this->includeTemplate('_header') ?> 

        <?php $this->showTemplate() ?> 

    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p>Notification System</p>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->showAssets('javascripts') ?> 

</body>
</html>
