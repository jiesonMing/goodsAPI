<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>作品集</title>
    <!-- load stylesheets -->
    <link href='public/css/httpfonts.googleapis.com.css' rel='stylesheet' type='text/css'>  
    <!-- Google web font "Open Sans" --> 
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">              
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/animate/animate.css" />
    <link rel="stylesheet" href="public/animate/set.css" />
    <link rel="stylesheet" href="public/gallery/blueimp-gallery.min.css">
    <!-- Bootstrap style -->
    <link rel="stylesheet" href="public/css/magnific-popup.css">                                 
    <!-- Magnific popup style (http://dimsemenov.com/plugins/magnific-popup/) -->
    <link rel="stylesheet" href="public/css/templatemo-style.css">                                   
    <!-- Templatemo style -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/login-register.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
    <body>
    	<div class="navbar-wrapper">
		      <div class="container">
		        <div class="navbar navbar-default navbar-fixed-top" role="navigation" id="top-nav">
		          <div class="container">
		            <div class="navbar-header">
		              <!-- Logo Starts -->
		              <a class="navbar-brand" href="#home"><img src="images/logo.png" alt="logo"></a>
		              <!-- #Logo Ends -->
		              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
		                <span class="sr-only">Toggle navigation</span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		              </button>
		            </div>
		            <!-- Nav Starts -->
		            <div class="navbar-collapse  collapse">
		              <ul class="nav navbar-nav navbar-right scroll">
		                 <li ><a href="/index.php">首页</a></li>
		                 <li class="active"><a href="/photo.php">摄影</a></li>
		                 <li ><a href="#">图文</a></li>
		                 <li ><a href="#">关于jieson</a></li>
		                 <li ><a href="javascript:void(0)" onclick="openLoginModal()"><i class="fa fa-user"></i>&nbsp;游客</a></li>
		              </ul>
		            </div>
		            <!-- #Nav Ends -->
		          </div>
		        </div>
		      </div>
		</div>
        <!-- Header gallery -->
        <div id="works" class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <section class="tm-header-gallery">
                    <?php foreach((array)$resPhoto as &$v) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-pad-0">
                            <!-- <a href="<?php echo $v; ?>">
                                <img src="<?php echo $v; ?>" alt="Image" class="img-fluid tm-header-img">    
                            </a> -->
                            <a href="<?php echo $v; ?>">
                                <img src="<?php echo $v; ?>" onerror="javascript:this.src='/images/404.jpg';" class="img-fluid tm-header-img col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" style="width: 100%;">        
                            </a>                        
                        </div>                
                    <?php } ?>    
                        <!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-pad-0">
                            <a href="img/img-11-03.jpg">
                                <img src="img/img-11-03.jpg" alt="Image" class="img-fluid tm-header-img col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">    
                            </a>
                            <a href="img/img-11-04.jpg">
                                <img src="img/img-11-04.jpg" alt="Image" class="img-fluid tm-header-img col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">        
                            </a>                        
                        </div> -->
                        
                    </section>
                </div>
            </div>                  
        </div> 
        <!-- container -->      
        <!-- load JS files -->
        <script src="public/js/jquery.min.js"></script>             
        <!-- jQuery (https://jquery.com/download/) -->
        <script src="public/js/tether.min.js"></script> 
        <!-- Tether for Bootstrap (http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h) -->
        <script src="public/bootstrap/js/bootstrap.js"></script>             
        <!-- Bootstrap (http://v4-alpha.getbootstrap.com/) -->
        <script src="public/js/jquery.magnific-popup.min.js"></script> 
        <!-- Magnific popup (http://dimsemenov.com/plugins/magnific-popup/) -->
        <script>           
            $(window).load(function(){
                $('.tm-header-gallery').magnificPopup({
                    delegate: 'a', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery:{enabled:true}                
                });                           
            });
        </script>             

</body>
</html>