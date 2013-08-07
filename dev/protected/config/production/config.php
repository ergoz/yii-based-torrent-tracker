<?php
$yii = dirname(__FILE__) . '/../../../../../../../yii-1.1.13.e9e4a0/framework/yii.php';

return array(

	// preloading 'log' component
	'preload'    => array(
		'log',
		'config',
		//'bootstrap',
	),

	// autoloading model and component classes
	'import'     => array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.extensions.*',
		'application.behaviors.*',

		'application.modules.yiiadmin.components.*',
	),

	'modules'    => array(
	),

	// application components
	'components' => array(
		/**
		 * @var Yii::app()->pd PluginsDispatcher
		 */
		'pd'           => array(
			'class' => 'application.components.PluginsDispatcher',
		),

		'authManager'  => array(
			'behaviors'       => array(
				'auth' => array(
					'class'  => 'application.modules.auth.components.AuthBehavior',
					'admins' => array(
						'admin',
					),
					// users with full access
				),
			),
			'class'           => 'application.modules.auth.components.CachedDbAuthManager',
			'cachingDuration' => 3600,
			'defaultRoles'    => array('guest'),
		),

		'bootstrap'    => array(
			'class'                    => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss'            => true,
			//'republishAssetsOnRequest' => false,
		),

		'urlManager'   => array(
			'urlFormat'        => 'path',
			'showScriptName'   => false,
			'useStrictParsing' => true,
			'rules' => array(
				'/' => 'site/index',
			)
		),

		'db'           => array(
			'connectionString'      => 'mysql:host=localhost;dbname=yii-torrent',
			'username'              => 'yii-torrent',
			'password'              => '7jVXKyrGkiAvmNBuPxJtWzdFT',
			'schemaCachingDuration' => 3600,
			'enableParamLogging'    => false,
			'enableProfiling'       => false,
			'charset'               => 'utf8',
			'tablePrefix'           => '',
		),

		'errorHandler' => array(
			'errorAction' => 'site/error',
			'adminInfo'   => 'admin@yii-torrent.com'
		),

		'log'          => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'  => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
					'class'    => 'CEmailLogRoute',
					'levels'   => 'error, warning, info',
					'emails'   => array('nafania293@gmail.com'),
					'sentFrom' => 'error@yii-torrent.com',
					'headers'  => array(
						'Content-type: text/plain; charset="utf-8"'
					),
					'filter'   => array(
						'class'   => 'CLogFilter',
						'logVars' => array(
							'_GET',
							'_SERVER'
						),
					),
				),
			),
		),

		'cache'        => array(
			'class'     => 'system.caching.CApcCache',
			'keyPrefix' => 'tor_',
		),

		'mail'         => array(
			'class'         => 'ext.mail.YiiMail',
			'transportType' => 'php',
			'viewPath'      => 'application.views.mail',
			'logging'       => true,
			'dryRun'        => false
		),
		'request'      => array(
			'enableCsrfValidation' => true,
			'csrfTokenName'        => 'csrf'
		),
		'clientScript' => array(
			'class'    => 'ext.nsclientscript.NLSClientScript',
			//'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
			//'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'

			'mergeJs'  => false,
			//def:true
			//'compressMergedJs'      => false,
			//def:false

			'mergeCss' => false,
			//def:true
			//'compressMergedCss'     => false,
			//def:false

			//'serverBaseUrl'         => 'http://localhost',
			//can be optionally set here
			//'mergeAbove'            => 1,
			//def:1, only "more than this value" files will be merged,
			//'curlTimeOut'           => 5,
			//def:5, see curl_setopt() doc
			//'curlConnectionTimeOut' => 10,
			//def:10, see curl_setopt() doc

			//'appVersion'            => 1.0
			//if set, it will be appended to the urls of the merged scripts/css
			'packages' => array(
				'common' => array(
					'baseUrl' => '/js/',
					'js'      => array('common.js'),
					'depends' => array(
						'jquery',
						'bbq'
					),
				),
			)
		),

		'config'       => array(
			'class' => 'EConfig',
			'cache' => 3600,
		),
	),
);