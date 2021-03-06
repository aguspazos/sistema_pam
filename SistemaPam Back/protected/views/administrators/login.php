<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es"  xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        
        <link rel="shortcut icon" sizes="16x16 32x32 48x48 64x64" href="/favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
	<!-- For Opera Speed Dial -->
	<link rel="icon" type="image/png" sizes="195x195" href="/favicon-195.png">
	<!-- For iPad with high-resolution Retina Display running iOS ≥ 7 -->
	<link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">
	<!-- For iPad with high-resolution Retina Display running iOS ≤ 6 -->
	<link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png">
	<!-- For iPhone with high-resolution Retina Display running iOS ≥ 7 -->
	<link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">
	<!-- For iPhone with high-resolution Retina Display running iOS ≤ 6 -->
	<link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">
	<!-- For Google TV devices -->
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96.png">
	<!-- For iPad Mini -->
	<link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">
	<!-- For first- and second-generation iPad -->
	<link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">
	<!-- For non-Retina iPhone, iPod Touch and Android 2.1+ devices -->
	<link rel="apple-touch-icon" href="/favicon-57.png">
	<!-- Windows 8 Tiles -->
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/favicon-144.png">
        
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
        
	<link href="/css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="/css/main.css" rel="stylesheet" type="text/css"/> 
        <link href="/css/administrators/login.css" rel="stylesheet" type="text/css"/>
        
        <script src="/js/jquery/jquery.js"></script>
        <script src="/js/jquery/jquery-ui.js"></script>
        
        <script type="text/javascript" src="/js/tools.js"></script>
        <script type="text/javascript" src="/js/administrators/login.js"></script>
        
        <title><?php echo $this->pageTitle; ?></title>
        <meta name="description" content="<?php echo $this->pageDescription; ?>">
        <meta property="og:title" content="<?php echo $this->pageTitle; ?>">
        <meta property="og:description" content="<?php echo $this->pageDescription; ?>">
        <?php 
            foreach($this->pageImages as $pageImagePath){
        ?>
                <meta property="og:image" content="<?php echo $pageImagePath; ?>">
        <?php
            }
        ?>
</head>

<body class="backgroundColor4 color1 font1">	
    <div id="content">
            <img id="logo" src="/files/administrators/loginLogo.png"/>
        <div id="signInLine" class="backgroundColor1"></div>
        <div id="emailDiv">
            <div class="inputText">Email</div>
            <input id="email" name="email" type="text" value="" class="backgroundColor1 color2"/>
        </div>
        <div id="passwordDiv">
            <div class="inputText">Contraseña</div>
            <input id="password" name="password" type="password" value="" class="backgroundColor1 color2"/>
        </div>
        <div id="signIn" class="backgroundColor2 font2 color2">INICIAR SESIÓN</div>
        <div id="signInLine" class="backgroundColor1"></div>
    </div>
    <div id="poweredBy">
        <div id="poweredByText" class="font2">Powered by:</div>
        <img id="moonLogo" src="/files/layouts/moonLogoLight.png">
    </div>
    
    
    <div id="loaderFixedContainer">
        <div id="loaderDivContainer">
            <div class="blackBkg50"></div>
            <div id="loaderDiv">
                <img src="/files/loader.gif" width="40" height="40"/>
            </div>
        </div>
    </div>
        <div id="alertMessageFixedContainer">
            <div id="alertMessageDivContainer">
                <div class="whiteOpacity"></div>
                <div id="alertMessageDiv">
                    <div id="alertMessageLogoDiv">
                        <img id="alertMessageLogo" src="/files/layouts/logo.png"/>
                    </div>
                    <div id="alertCloseButton" class="alertMessageCloseMessage">X</div>
                    <div id="alertMessageMessage" ></div>
                    <div id="alertMessageAceptarWrapper"><div id="alertMessageAceptar" class="normalButton font2">Aceptar</div></div>
                </div>
            </div>
        </div>
</body>
</html>


