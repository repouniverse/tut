<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use kartik\datetime\DateTimePicker;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-form">

    <?php $form = ActiveForm::begin([
       'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="row">     
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sta.labels', 'Grabar'), ['class' => 'btn btn-success']) ?>
          <?php if(!$model->asistio){
              echo Html::button('<span class="fa fa-check"></span>   '.Yii::t('sta.labels', 'Confirmar asistencia'), ['id'=>'btn-conf-asistencia','class' => 'btn btn-warning']);
          }else{?>
              <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['id'=>'mycv','class'=>'styled'])?>
                        <label for="mycv">
                            Asistió
                        </label>
           </div>
          <?php } ?>
            
                <?php 
                $id=$model->firstCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id && $id <> $model->id)?Html::a('<span class="glyphicon glyphicon-step-backward"></span>',$url):'';
                ?>
                <?php 
                $id=$model->previousCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id)?Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', $url):'';
                ?> 
                <?php 
                $id=$model->nextCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id)?Html::a('<span class="glyphicon glyphicon-arrow-right"></span>',$url):'';
                ?>
                 <?php 
                $id=$model->lastCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id && $id <> $model->id)?Html::a('<span class="glyphicon glyphicon-step-forward"></span>', $url):'';
                ?>
                
             </div>
            </div>
        </div>
    </div>
      <div class="box-body">
    
          
              
          
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model->taller, 'numero')->textInput(['disabled'=>'disabled']) ?>

 </div>
 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model->taller, 'descripcion')->textInput(['disabled'=>'disabled']) ?>

 </div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               <?= $form->field($model->taller, 'codperiodo')->textInput(['disabled'=>'disabled']) ?>

</div>         
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
               <?= $form->field($model->taller->facultad, 'desfac')->label(yii::t('sigi.labels','Facultad'))->textInput(['disabled'=>'disabled']) ?>

</div>
          
     
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
               <?= $form->field($model->tallerdet, 'codalu')->textInput(['disabled'=>'disabled']) ?>

        </div>
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
               <?= $form->field($model->tallerdet->alumno, 'nombres')->textInput(['value'=>$model->tallerdet->alumno->fullName(),'disabled'=>'disabled']) ?>

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
     <?= $form->field($model, 'detalles')->textArea(['rows' => 8]) ?>

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