<?php
$yii = dirname(__FILE__) . '/../../../../../yii-1.1.13.e9e4a0/framework/yii.php';

return array(
	'preload'    => array('log'),

	// autoloading model and component classes
	'import'     => array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.extensions.*',
		'application.behaviors.*',
	),

	'modules'    => array(),

	'components' => array(
		'pd'           => array(
			'class' => 'application.components.PluginsDispatcher',
		),
		'user'         => array(
			'class'          => 'application.components.WebUser',
			'allowAutoLogin' => true,
			'behaviors'      => array(
				'botRecognizer' => array(
					'class' => 'application.extensions.botRecognizer.botRecognizer',
				)
			),
		),

		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => require(dirname(__FILE__) . '/../urlManager/base.php'),
		),

		'db'           => array(
			'connectionString'      => 'mysql:host=localhost;dbname=torrpeda',
			'username'              => 'torrpeda',
			'password'              => 'X0DuFYB29rr5bJ9poU2Y',
			'schemaCachingDuration' => 3600,
			'enableParamLogging'    => false,
			'enableProfiling'       => false,
			'charset'               => 'utf8',
		),

		'errorHandler' => array(
			'errorAction' => 'site/error',
			'adminInfo'   => 'at.torrpeda@gmail.com'
		),

		'log'          => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'  => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				/*array(
								'class' => 'CEmailLogRoute',
								'levels'=>'error, warning, info',
								'emails'=> array('at.torrpeda@gmail.com'),
								'sentFrom' => 'error@torrpeda.org',
								'headers' => array(
									'Content-type: text/plain; charset="utf-8"'
								),
								'filter'=> array(
									'class' => 'CLogFilter',
									'logVars' => array('_GET','_SERVER'),
								),
							),*/
			),
		),

		'cache'        => array(
			'class'     => 'system.caching.CApcCache',
			'keyPrefix' => 'ts_',
		),

		'clientScript' => array(
			'class'       => 'ext.ExtendedClientScript.ExtendedClientScript',
			'combineCss'  => true,
			'compressCss' => true,
			'combineJs'   => true,
			'compressJs'  => true,
			'filePath'    => realpath(dirname(__FILE__) . '/../../../assets'),
			'fileUrl'     => 'http://st.torrpeda.org/assets',
		),


		'assetManager' => array(
			'basePath' => realpath(dirname(__FILE__) . '/../../../assets'),
			'baseUrl'  => 'http://st.torrpeda.org/assets',
		),

		'viewRenderer' => array(
			'class'         => 'ext.yiiext.renderers.twig.ETwigViewRenderer',
			'fileExtension' => '.twig',
			'globals'       => array(
				'Yii' => 'Yii',
			),
			'options'       => array(
				'autoescape' => false,
			),
		),

		'image'        => array(
			'class' => 'ext.ImageHandler.CImageHandler',
		),

		'mail'         => array(
			'class'         => 'ext.mail.YiiMail',
			'transportType' => 'php',
			'viewPath'      => 'application.views.mail',
			'logging'       => false,
			'dryRun'        => false
		),
		'request'      => array(
			'enableCsrfValidation' => true,
			'csrfTokenName'        => 'csrf'
		),
		'search'       => array(
			'class'             => 'ext.DGSphinxSearch.DGSphinxSearch',
			'server'            => '127.0.0.1',
			'port'              => 3312,
			'maxQueryTime'      => 3000,
			'enableProfiling'   => 0,
			'enableResultTrace' => 0,
			/*    'fieldWeights' => array(
							'name' => 10000,
							'keywords' => 100,
						),*/
		),
		'config'        => array(
			'class'=> 'EConfig',
			'cache'=> 3600,
		),
	),
);