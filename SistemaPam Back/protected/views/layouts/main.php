<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="es" />
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
        <link rel="icon" type="image/png" sizes="196x196" href="/favicon-192.png">
        <link rel="icon" type="image/png" sizes="160x160" href="/favicon-160.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96.png">
        <link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
        <link rel="apple-touch-icon" href="/favicon-57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicon-60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicon-180.png">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="/favicon-144.png">
        <meta name="msapplication-config" content="/browserconfig.xml">
        <meta property="og:title" content="<?php echo $this->pageTitle; ?>" />
        <meta property="og:description" content="<?php echo $this->pageDescription; ?>" />
        <?php foreach ($this->pageImages as $pageImage) { ?>
            <meta property="og:image" content="<?php echo $pageImage; ?>" />
        <?php } ?>
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $this->pageTitle; ?></title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css">
        <link href="/css/main.css" rel="stylesheet" type="text/css">
        <link href="/css/layouts/main.css?v=2" rel="stylesheet" type="text/css">

        <script src="/js/google/ga.js"></script>
        <script src="/js/jquery/jquery.js"></script>
        <script src="/js/jquery/jquery-ui.js"></script>
        <script type="text/javascript" src="/js/tools.js"></script>
        <script type="text/javascript" src="/js/layouts/main.js"></script>
    </head>

    <body class="font1">
        <!-- Google Tag Manager --> <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-NT2CCL');</script> <!-- End Google Tag Manager -->
        <div id="logoContainer">
            <img id="footerLogos" src="/files/layouts/bud66.png"/>
            <img id="mainLogo" src="/files/layouts/logo.png"/>
            <div id="itsUpToYou" class="font2">IT'S UP TO YOU</div>
        </div>
        
        <div id="menu">
            <a class="menuItem" href="/">Inicio</a>
            <div class="menuSeparation"> | </div>
            <a class="menuItem" href="/site/info">Info</a>
            <div class="menuSeparation"> | </div>
            <a class="menuItem" href="/BasesYCondiciones.pdf" target="_blank">Bases y condiciones</a>
            <div class="menuSeparation"> | </div>
            <a class="menuItem" href="/winners.pdf" target="_blank">Ganadores</a>
        </div>
        <?php echo $content; ?>
        
        <div id="loaderFixedContainer">
            <div id="loaderDivContainer">
                <div class="blackOpacity"></div>
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