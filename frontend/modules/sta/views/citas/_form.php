<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use kartik\datetime\DateTimePicker;
use common\helpers\h;
use frontend\modules\sta\staModule;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */
/* @var $form yii\widgets\ActiveForm */
$tipo=h::user()->profile->tipo;
$isPsicologo=($tipo==staModule::PROFILE_PSICOLOGO)?true:false;
$isSecre=($tipo==staModule::PROFILE_PSICOLOGO)?true:false;
?>

<div class="citas-form">
  <div class="box-body">
    <?php $form = ActiveForm::begin([
       'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="btn-group">   
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sta.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
                <br>
            </div>
        </div>
    </div>
    
        
          

        
           
          
 
          
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>2,
         'addCampos'=>[3,4],
        ]);  ?>

 </div>
          
          
  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
        echo $form->field($model, 'fechaprog')->widget(
        DateTimePicker::classname(), [
         'name' => 'finicio',
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
        echo $form->field($model, 'finicio')->widget(
        DateTimePicker::classname(), [
         'name' => 'finicio',
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
        echo $form->field($model, 'ftermino')->widget(
        DateTimePicker::classname(), [
         'name' => 'ftermino',
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
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles_secre')->textArea(['rows' => 4,/*'disabled'=>!$isSecre*/]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php if($isPsicologo){  ?>
     <?= $form->field($model, 'detalles')->textArea(['rows' => 4]) ?>
     <?php }  ?>
 </div>
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles_indicadores')->textArea(['rows' => 4,'disabled'=>!$isPsicologo]) ?> 

 </div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles_tareas_pend')->textArea(['rows' => 4,'disabled'=>!$isPsicologo]) ?>

 </div> 
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
<?php 
  $this->registerJs("$('#btn-conf-asistencia').on( 'click', function() { 
      //alert(this.id);
      $.ajax({
              url: '".Url::toRoute(['ajax-confirma-asistencia'])."', 
              type: 'get',
              data:{id:".$model->id."},
              dataType: 'json', 
               error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                },  
            success: function(json) {  
                  $('#btn-conf-asistencia').hide();
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                      
                   $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok-sign\'></span>' + json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-info-sign\'></span>' +json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                              } 
                              
                      
                        },
                        });
             })", View::POS_READY);
?>
</diV>