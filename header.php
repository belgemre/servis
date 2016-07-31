<?php require('../includes/config.php');

//if not logged in redirect to login page
$_SESSION['username'] = 'farukbelge';
		    $_SESSION['memberID'] = 84;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="tr-TR">
<head profile="http://gmpg.org/xfn/11">
    <meta name="distribution" content="global"/>
    <meta name="language" content="tr"/>
    <meta name="robots" content="index,follow"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1254"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
    <meta http-equiv="Content-Language" content="tr"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	
    <title>BELGEM | Yönetici Paneli</title>


    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/mobileservismenu.css"/>
    <link rel="stylesheet" href="../css/font-awesome.min.css"/><!-- İcon CSS -->
    <link href="../css/dataTables.bootstrap.min.css" type="text/css" rel="stylesheet"><!-- Table CSS -->
    <script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
    <!-- Include the plugin's CSS and JS: -->
    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>
</head>
<body>

<div class="navbar-more-overlay"></div>
<nav class="navbar navbar-inverse navbar-fixed-top animate">
    <div class="container navbar-more visible-xs">
        <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Ne aramıştınız?">
                    <span class="input-group-btn">
							<button class="btn btn-default" type="submit">Ara</button>
						</span>
                </div>
            </div>
        </form>
        <ul class="nav navbar-nav">
            <hr />
            <li>
                <a href="profil.php?kullanici=<?php echo $_SESSION['username']; ?>">
                    <span class="menu-icon fa fa-user"></span>
                    <b>Profilime git</b>

                </a>
            </li>
            <li>
                <a href="../logout.php" >
                    <span class="menu-icon glyphicon glyphicon-log-out red"></span>
                    <b class="red">Çıkış Yap</b>
                </a>
            </li>
        </ul>
    </div>
    <div class="container">
        <div class="navbar-header hidden-xs">
            <a class="navbar-brand" href="#">BELGEM SÜT</a>
        </div>

        <ul class="nav navbar-nav navbar-right mobile-bar">
            <li>
                <a href="./">

                    <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                    <span class="hidden-xs">Ekranım</span>
                    <span class="visible-xs">Ekranım</span>

                </a>
            </li>
            <li>
                <a href="servis.php">
                    <i class="fa fa-truck fa-2x"></i>
                    <span class="hidden-xs">Servis</span>
                    <span class="visible-xs">Servis</span>
                </a>
            </li>
            <li class="hidden-xs">
                <a href="#">
                    <i class="fa fa-cutlery fa-2x" aria-hidden="true"></i>
                    <span class="hidden-xs">Ürünler</span>
                    <span class="visible-xs">Ürünler</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-suitcase fa-2x" aria-hidden="true"></i>
                    <span class="hidden-xs">Müşteri</span>
                    <span class="visible-xs">Müşteri</span>
                </a>
            </li>
            <li class="hidden-xs">
                <a href="#">
                    <i class="fa fa-car fa-2x"></i>
                    <span class="hidden-xs">Araç</span>
                    <span class="visible-xs">Araç</span>
                </a>
            </li>
            <li>
                <a href="raporlar.php">
                    <i class="fa fa-line-chart fa-2x"></i>
                    <span class="hidden-xs">Raporlar</span>
                    <span class="visible-xs">Raporlar</span>
                </a>
            </li>
            <li class="visible-xs">
                <a href="#navbar-more-show">
                    <span class="menu-icon fa fa-bars"></span>
                    Daha
                </a>
            </li>
        </ul>
    </div>
</nav>
<script>
$(document).ready(function() {
$('a[href="#navbar-more-show"], .navbar-more-overlay').on('click', function(event) {
event.preventDefault();
$('body').toggleClass('navbar-more-show');
if ($('body').hasClass('navbar-more-show'))	{
$('a[href="#navbar-more-show"]').closest('li').addClass('active');
}else{
$('a[href="#navbar-more-show"]').closest('li').removeClass('active');
}
return false;
});
});
</script>