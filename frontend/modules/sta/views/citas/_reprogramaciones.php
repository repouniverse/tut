<?php
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;

?>
     
   <?php Pjax::begin(['id'=>'grilla-reprogramaciones']); ?>
    
   <?php 
  
   $query= frontend\modules\sta\models\StaCitalog::find()->where(['citas_id'=>$model->id]);
//var_dump($query->createCommand()->getRawSql()); die();
   $provider= new \yii\data\ActiveDataProvider([
            'query'=>$query,
        ]);
//var_dump($model->examenesId($idCitaEvalInicial)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-inci',
        'dataProvider' =>$provider,
         'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
            'fecha',
            'nuevafecha'
               ],
    ]); ?>
    
    
       <?php Pjax::end(); ?> 