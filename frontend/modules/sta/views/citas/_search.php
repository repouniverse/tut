<?php
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\widgets\cbofacultades\cbofacultades;
use frontend\modules\sta\widgets\cboperiodos\cboperiodos;
use frontend\modules\sta\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\CitasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['class' => 'btn btn-primary']) ?>
         <?php // Html::resetButton("<span class='fa fa-eye'></span>     ".Yii::t('sta.labels', 'Limpiar'), ['class' => 'btn btn-success']) ?>
       <?php // Html::button("<span class='fa fa-eye'></span>     ".Yii::t('sta.labels', 'Ver'), ['onClick'=>"$('#buscador').toggle()",  'class' => 'btn btn-success']) ?>
   
        
    </div>
     </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechaprog')->widget(
        DateTimePicker::classname(), [
         'name' => 'fechaprog',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
        echo $form->field($model, 'fechaprog1')->widget(
        DateTimePicker::classname(), [
         'name' => 'fechaprog1',
            'options' => ['placeholder' =>yii::t('sta.labels', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDateTime(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div>   
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'aptutor')->textInput()?>
 </div>
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php
           $filtro=h::request()->get('StaVwCitasSearch')['asistio'];
           // var_dump($filtro);
            //var_dump($model->asistio);
           if(is_null($filtro) or $filtro=='')
           {
               $combovalor='';
           }elseif($filtro=='0'){
              $combovalor='0'; 
           }elseif($filtro=='1'){
               $combovalor='1';  
           }
          
           echo $form->field($model, 'asistio')->
            dropDownList(
                    [
                       '0'=>yii::t('sta.labels','Ausente'),
                        '1'=>yii::t('sta.labels','Asistió'),
                        
                    ] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Todas')."--",
                     'value'=>$combovalor,
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    );  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php
      $filtro=h::request()->get('StaVwCitasSearch')['codperiodo'];
           // var_dump($filtro);
            //var_dump($model->asistio);
           if(is_null($filtro) or $filtro=='')
           {
              $codperiodo=null;
           }else{
               $codperiodo=$filtro;  
           }
          
            echo $form->field($model, 'flujo_id')->
            dropDownList(comboHelper::getCboFlujoTotal($codperiodo) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
 </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    
 <?=$form->field($model, 'codalu')->textInput()?>
 </div>
 
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'codperiodo')->
            dropDownList(comboHelper::getCboPeriodos() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'codfac')->
            dropDownList(comboHelper::getCboFacultades() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'ap') ?>
    </div> 
    
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'numerocita') ?>
    </div> 
 
   

    <?php ActiveForm::end(); ?>

</div>
