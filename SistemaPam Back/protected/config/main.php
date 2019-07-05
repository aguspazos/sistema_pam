<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Boiler Bud 66',
        'defaultController' => 'Site/index',
	
        // user language (for Locale)
        'language'=>'es',
    
        //language for messages and views
        'sourceLanguage'=>'es',
 
        // charset to use
        'charset'=>'utf-8',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*'
	),

	'modules' => array(
			'gii'=>array(
	    		'class'=>'system.gii.GiiModule',
	    		'password'=>'chacras',
			),
	),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        'loginUrl'=>array('site/index'),
		),
		
		// Image helper class
		'image'=>array(
                    'class'=>'application.extensions.image.CImageComponent',
                // GD or ImageMagick
                    'driver'=>'GD',
                // ImageMagick setup path
                    'params'=>array('directory'=>'C:/xampp/htdocs'),
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<action:\w+>/<id:\d+>/<name:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		*/
		/*
		 * 'db'=>array(
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=trabajos',
			'emulatePrepare' => true,
			'username' => 'matias@trabajos.pam.com.uy',
			'password' => 'N9DYLVppQaLNJRT4tgHK',
			'charset' => 'utf8',
		),
		 * */
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=arocena_db',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
                    'errorAction'=>'site/error',
                ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                
                'request'=>array(
                    'enableCookieValidation'=>true,
                    //'enableCsrfValidation'=>true,
                ),
            
//                'session' => array(
//                        'class' => 'CCacheHttpSession',
//                ),
            
//		'cache' => array (
//                    'class' => 'system.caching.CMemCache',
//                    'servers'=>array(
//                            array(
//                                'host'=>'localhost',
//                                'port'=>11211,
//                            ),
//                    ),
//		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
            'useAmazonS3'=>false,
            'amazon'=>array(
                'key'=>'',
                'secret'=>'',
                'bucket'=>'',
                'sdkdir'=>'',
                'bucketDir'=>'',
            ),
            'smtp'=>array(
                'host'=> '',
                'username'=> '',
                'password'=> '',
                'screenname'=> ''
            ),
            'mailchimp'=>array(
              'apiKey'=>'',
              'endpoint'=>'',
              'leadList'=>'',
              'interestedList'=>'',
              'waitingSignatureList'=>'',
              'signedList'=>'',
              'allList'=>'',
            ),
            'mandrill'=>array(
                'key'=>'',
                'endPoint'=>'https://mandrillapp.com/api/1.0/',
            ),
            'facebook'=>array(
                'appId'=>'',
                'appSecret'=>'',
            ),
            'domain'=>'http://arocena.com',
            'cookies'=>array(
                'prefix'=> 'arocena'
             ),
            'google'=>array(
                'key'=>''
            ),
            'salt'=>'$2y$10$c7efb37223f19ec766a9cd2f08ff2d948a180e5b4944',
            'emails'=>array(
                'alerts'=> array(
                    'agustin.pazosm@gmail.com'
                ),
                'info'=> array(
                    'info@arocena.com'
                )
             ),
             'security'=> array(
                 'fixedIpsInAdmin'=>false,
                 'adminIps'=>array(
                 )
             )
        ),
        
);