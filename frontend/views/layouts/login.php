<?php
use yii\helpers\Html;
      ?>
    <?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
      <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<?php $this->registerCssFile("@web/login/vendor/bootstrap/css/bootstrap.min.css"); ?>
 <?php $this->registerCssFile("@web/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css"); ?>
 <?php $this->registerCssFile("@web/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css"); ?>
 <?php $this->registerCssFile("@web/login/vendor/animate/animate.css"); ?>  	
   <?php $this->registerCssFile("@web/login/vendor/css-hamburgers/hamburgers.min.css"); ?>
 <?php $this->registerCssFile("@web/login/vendor/select2/select2.min.css"); ?>
 <?php $this->registerCssFile("@web/login/css/util.css"); ?>
  <?php $this->registerCssFile("@web/login/css/main.css"); ?>  

       <?php $this->registerJsFile("@web/login/vendor/jquery/jquery-3.2.1.min.js"); ?>  
      <?php $this->registerJsFile("@web/login/vendor/bootstrap/js/popper.js"); ?>  
       <?php $this->registerJsFile("@web/login/vendor/bootstrap/js/bootstrap.min.js"); ?>  
       <?php $this->registerJsFile("@web/login/vendor/select2/select2.min.js"); ?>  
      <?php $this->registerJsFile("@web/login/js/main.js"); ?>
	
       
        
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <body>
       
 <?php $this->beginBody() ?>
     <?php \shifrin\noty\NotyWidget::widget([
    'options' => [ // you can add js options here, see noty plugin page for available options
        'dismissQueue' => true,
        'layout' => 'center',
        'theme' => 'relax',
        'animation' => [
            'open' => 'animated flipInX',
            'close' => 'animated flipOutX',
        ],
        'timeout' => false,
    ],
    'enableSessionFlash' => true,
    'enableIcon' => true,
    'registerAnimateCss' => true,
    'registerButtonsCss' => true,
    'registerFontAwesomeCss' => true,
]); ?>
       

        <?= $content ?>
 
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>



