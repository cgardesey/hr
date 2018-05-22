<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('chartjs', dirname(__FILE__) . '/../extensions/yii-chartjs');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Employee Management System',
    // preloading 'log' component
    'preload' => array('log', 'chartjs'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.payroll.models.*',
        'application.modules.loan.models.*',
        'application.modules.core.models.*',
        'application.modules.email.models.*',
        'application.modules.event.models.*',
        'application.modules.leave.models.*',
        'application.modules.sms.models.*',
        'application.modules.circular.models.*',
        'application.vendors.*',
    ),
    'modules' => array('payroll','loan','core','email','event','leave','sms','circular',
        'gii' => array(
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
        ),
        // uncomment the following to enable the Gii tool
        'user' => array(
            'tableUsers' => 'users',
            'tableProfiles' => 'profiles',
            'tableProfileFields' => 'profiles_fields',
        ),
        'rights' => array(
            'install' => true,
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'chartjs' => array('class' => 'chartjs.components.ChartJs'),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf123' => array(
                    'librarySourcePath' => 'application.vendor.mpdf.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendor.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                    'defaultParams' => array(// More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                        'orientation' => 'P', // landscape or portrait orientation
                        'format' => 'A4', // format A4, A5, ...
                        'language' => 'en', // language: fr, en, it ...
                        'unicode' => true, // TRUE means clustering the input text IS unicode (default = true)
                        'encoding' => 'UTF-8', // charset encoding; Default is UTF-8
                        'marges' => array(10, 10, 10, 10), // margins by default, in order (left, top, right, bottom)
                    )
                )
            ),
        ),
        'email' => array(
            'class' => 'application.extensions.email.Email',
            'delivery' => 'php', //Will use the php mailing function. 
        //May also be set to 'debug' to instead dump the contents of the email into the view
        ),
        'yexcel' => array(
            'class' => 'ext.yexcel.Yexcel'
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'user' => array(
            'class' => 'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/user/login'),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array('Authenticated', 'Guest'),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'timezone' => 'Asia/Kolkata',
        'course' => 'Course',
        'batch' => 'Batch',
    ),
);
