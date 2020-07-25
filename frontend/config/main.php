<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'name'=>'Tutoría_Psicológica_R',
    'sourceLanguage' => 'en',
    'id' => 'frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    
    'modules' => [
	
	'attachments' => [
		'class' => nemmo\attachments\Module::className(),
		'tempPath' => '@app/uploads/temp',
		'storePath' => '@app/uploads/store',
		'rules' => [ // Rules according to the FileValidator
		    'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
			//'mimeTypes' => 'image/png', // Only png images
			'maxSize' => 1024 * 1024 // 1 MB
		],
		'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
	],
        
        'avisos' => [
            'class' => 'frontend\modules\avisos\Module',
        ],
           
	
],
    
        
   
    
    
    'components' => [
         'mailer' =>['class'=>'common\components\Mailer',
                'viewPath'=>'@frontend/mail',
            ],
       'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '',
           'decimalSeparator' => '.',
            'thousandSeparator' => ', ',
          ], 
        
       'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
               
              
           
            ],
        ],
        
        
        'view' => [
         'theme' => [
             'pathMap' => [
                //'@app/views' => '@app/views/yii2-app-frontend',
                 '@app/views' => '@app/views/skins/purple'
             ],
         ],
          ],
        
         'assetManager'=>[
               'bundles'=>[
                   'dmstr\web\AdminLteAsset'=>['skin'=>'skin-green'],
                   /*'yii\web\JqueryAsset' => [
                                        'js' => [YII_DEBUG ? 'https://code.jquery.com/jquery-3.2.1.js' : 'https://code.jquery.com/jquery-3.2.1.min.js'],
                                        'jsOptions' => ['type' => 'text/javascript'],
                                            ],*/
                             ],
                        ],
         'request' => [

        	// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation

        	'cookieValidationKey' => 'HOLIS',
            'csrfParam' => '_csrf-frontend',
        	//'enableCsrfValidation' => false,

           ],
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],*/
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
                //'traceLevel' => YII_DEBUG ? 3 : 0,            
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                ],
               /* [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                       'from' => ['log@example.com'],
                       'to' => ['admin@example.com', 'developer@example.com'],
                       'subject' => 'Database errors at example.com',
                    ],
                ],*/
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
         
        
        
        
        
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login/',
            'site/clear-cache/',
           // 'site/signup',
             'site/request-password-reset',
            'site/reset-password', 
           'site/logout',
            'sta/citas/examen-banco',
            'sta/citas/arregla-for-ajax',
            'sta/citas/respuesta-examen',
            'sta/citas/termina-examen',
        ]
    ],
    'params' => $params,
];
