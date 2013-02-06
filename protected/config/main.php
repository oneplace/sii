<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Sii',
	'theme'=>'bootstrap',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.eauth.*',
		'ext.eauth.services.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
	),

	'modules'=>array(
		'rights'=>array(
			'userNameColumn'=>'name',
			'appLayout' => '//layouts/main',
			// 'install'=>true,	// Enables the installer.
		),
		'conversation','notify'
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'SWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
			'coreCss'=>true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
			'coreCss'=>true, // whether to register the Bootstrap core CSS (bootstrap.min.css), defaults to true
			'responsiveCss'=>false, // whether to register the Bootstrap responsive CSS (bootstrap-responsive.min.css), default to false
			'plugins'=>array(
	        
			),
		),
		
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType' => 'smtp',
			'transportOptions'=>array(
				'host'=>'smtp.exmail.qq.com',
				'username'=>'sii@freeloop.net',
				// or email@googleappsdomain.com
				'password'=>'chuck911',
				'port'=>'25',
				// 'encryption'=>'ssl',
			),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		),
		
		'db'=>require('db.php'),

		'authManager'=>array(
			'class'=>'RDbAuthManager',	// Provides support authorization item sorting.
			'defaultRoles'=>array('Authenticated'),
			'showErrors'=>true,
		),

		'eauth'=>array(
			'class'=>'ext.eauth.EAuth',
			'popup'=>false,
			'services'=>array(
				'sina' => array(
					'class' => 'SinaOAuthService',
					'client_id' => '1174339454',
					'client_secret' => '7381bcd29b5607cf7b43226e93ca33a5',
				),
			),
		),

		'phpThumb'=>array(
			'class'=>'ext.EPhpThumb.EPhpThumb',
			//'options'=>array(optional phpThumb specific options are added here)
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

		'eventsManager'=>array(
			'class'=>'application.components.events.SEventsManager',
			'listeners'=>array(
			),
		),

		'event'=>array(
			'class'=>'application.components.events.EventEmitter',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sii@freeloop.net',
	),
);