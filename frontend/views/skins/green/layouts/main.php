<?php
use yii\helpers\Html;

/* @var $this \yii\web\\View */
/* @var $content string */



    if (class_exists('frontend\assets\AppAsset')) {
        frontend\assets\AppAsset::register($this);
       
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="icon" type="image/ico" href="<?=\yii\helpers\Url::home()?>img/psico.ico" />  
          <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        
       
              
        
        
        
        
       <link rel="icon" type="image/ico" href="<?=\yii\helpers\Url::home()?>img/diar.ico" />  
        
        
    </head>
  

    
    
    
    <body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() ?>">
    <?php 
    
          $this->registerJs("$(window).on('load', function () {
    $('#page-loader').delay(1).fadeOut('slow');
});", \yii\web\View::POS_HEAD);  ?>
        
      
      <div id="page-loader"><span class="preloader-interior"></span></div>
     
        
        
    <?php $this->beginBody(); ?>
    <div class="wrapper">

      
 
        
        
        
        
        
        
        
        
             <?php


use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'buscarvalor',
    'header' => 'Buscar Valor',
    'toggleButton' => false,
    //'mode'=>ModalAjax::MODE_MULTI,
    'size'=>\yii\bootstrap\Modal::SIZE_LARGE,    
    'selector'=>'.botonAbre',
   // 'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);
 ?>  
         <?php \shifrin\noty\NotyWidget::widget([
    'options' => [ // you can add js options here, see noty plugin page for available options
        'dismissQueue' => true,
        'layout' => 'center',
        'theme' => 'metroui',
        'animation' => [
            'open' => 'animated flipInX',
            'close' => 'animated flipOutX',
        ],
        'timeout' =>1000, //false para que no se borre
        'progressBar'=>true,
    ],
    'enableSessionFlash' => true,
    'enableIcon' => true,
    'registerAnimateCss' => true,
    'registerButtonsCss' => true,
    'registerFontAwesomeCss' => true,
]); ?>
        
        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>

