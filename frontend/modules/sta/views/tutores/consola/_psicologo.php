<?php 
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box box-success">

    <?php $form = ActiveForm::begin([
    'id' => 'trabajadores-form',
     ]); ?>
    
    
    <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                <?= Html::submitButton(Yii::t('base.verbs', 'Grabar'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    
    
    
    <div class="box-body">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codigotra')->textInput(['disabled'=>'disabled','maxlength' => true]) ?>
  </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
    <?= $form->field($model, 'ap')->textInput(['disabled'=>'disabled']) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'am')->textInput(['disabled'=>'disabled']) ?>
</div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'nombres')->textInput(['disabled'=>'disabled']) ?>
</div>
   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codpuesto')->textInput(['disabled'=>'disabled','value'=>$model->comboValueField('codpuesto')]) ?>
</div> 
    <?php ActiveForm::end(); ?>
        
   
 <?php  

use yii\grid\GridView;

?>
        <hr>
     <div class="row">
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <p class="text-center text-info"><span class="fa fa-flag">   </span><?='   '.yii::t('sta.labels','Programas en periodo Actual')?></p>
         <?php Pjax::begin(['id'=>'jijo']);  ?>
        <?= GridView::widget([
             'id'=>'geronimo',
        'dataProvider' => $providerTalleresActivos,
         'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-condensed table-hover table-borderless table-striped table-responsive text-nowrap'
             ],
             'columns' => [
          [
                'attribute' => 'numero',
                
            ],
            ['attribute'=>'descripcion',
                'format'=>'raw',
                'value' => function ($model) {             
                $url = \yii\helpers\Url::toRoute(['tutores/pendientes','id'=>$model->id]);
                return \yii\helpers\Html::a($model->descripcion, '#', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                   }],
           
            'codfac',
            'codperiodo',
                       
        ],
    ]); ?>
     </div> 
      
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'jijo',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
           'mode'=>'html',
            'divReplace'=>'espacio',
           'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
     <?php Pjax::end();  ?>     
    
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <p class="text-center text-info"><span class="fa fa-repeat">   </span><?='  '.yii::t('sta.labels','Programas Anteriores')?></p>
         <?= GridView::widget([
        'dataProvider' => $providerTalleresAntiguos,
         'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-condensed table-hover table-borderless table-striped table-responsive text-nowrap'
             ],
        //'filterModel' => $searchModel,
        'columns' => [
          [
                'attribute' => 'numero',
                
            ],
            'descripcion',
            'codfac',
            'codperiodo',
                       
        ],
    ]); ?>
     </div> 
        
     </div> 
 <div id="espacio"></div>    

</div>
   </div>


