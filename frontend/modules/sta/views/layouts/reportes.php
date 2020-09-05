<?php
use yii\helpers\Html;
?>
    <?php $this->beginPage() ?>
    
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <?php $this->registerCssFile("@web/css/reporte.css"); ?>
        <?php $this->registerCssFile("@web/css/bootstrap.min.css");?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <body>
       
 <?php $this->beginBody() ?>
        <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>



