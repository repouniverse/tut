<?php
$this->title = Yii::t('sta.labels', 'Trata Alumno: {name}', [
    'name' => $model->codalu,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Programas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Programa'), 'url' => ['update', 'id' => $modelTallerdet->talleres_id]];
$this->params['breadcrumbs'][] = Yii::t('sta.labels', 'Trata Alumno');
?>
<?php
echo \common\widgets\spinnerWidget\spinnerWidget::widget();
?>
<h4><span class="fa fa-calendar"></span><?='   '.\yii\helpers\Html::encode(yii::t('sta.labels','Programar Alumno')).'-'.$model->codalu ?></h4>
<div class="box box-success">
<div class="box body">
<?php  
 use kartik\tabs\TabsX;
?>
<?php

 echo $this->render('/alumnos/auxiliares/_form_view_alu_basico',
               ['model'=>$model,
                ]);

?>

<?php 
 echo TabsX::widget([
     'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
            'label' =>'<i class="glyphicon glyphicon-hourglass"></i> '.yii::t('base.names','Citas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_citas',['modelTallerDet'=>$modelTallerdet,'codperiodo'=>$codperiodo,'dataProvider'=>$dataProvider]),
            'active' => true,
             'options' => ['id' => 'tnID3'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-calendar"></i> '. yii::t('base.names','Programación'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_calendario',['codalu'=>$codalu,'codperiodo'=>$codperiodo,'idalu'=>$model->id,'modelPsico'=>$modelPsico,  'items'=>[['name'=>$codalu,'color'=>$color]],'citasPendientes'=>$citasPendientes,'model'=>$modelPsico]),
            'active' => false,
             'options' => ['id' => 'myy6nID4'],
        ],
      [
            'label' =>'<i class="glyphicon glyphicon-calendar"></i> '. yii::t('base.names','Documentos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_documentos',['model'=>$modelTallerdet]),
            'active' => false,
             'options' => ['id' => 'mxx4ID4'],
        ],
    ],
]); 
    ?> 
</div>
    </div>