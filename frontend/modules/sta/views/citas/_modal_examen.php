<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use frontend\modules\sta\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-unidades-form">

    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="btn-group">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> ($model->isNewRecord)?
                      \yii\helpers\Url::to(['/sta/'.$this->context->id.'/agrega-examen','id'=>$id]):
                      \yii\helpers\Url::to(['/sta/'.$this->context->id.'/edita-examen','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
           <?php if(!$model->isNewRecord && $model->virtual){ ?>
                 <a href="#" id="enlace_examen" onclick="notificaexamen()" class="btn btn-warning btn-lg ">
        <i class="glyphicon glyphicon-envelope" aria-hidden="true"></i> <?=yii::t('sta.labels','Notificar')?>
              </a>  
           <?php } ?>   
            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    

          
  <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codtest')->
            dropDownList(comboHelper::getCboTestByPrograma($modelCita->taller->id),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'virtual')->checkbox() ?>

 </div>
          
       
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>

     
    <?php ActiveForm::end(); ?>

</div>
    </div>
<?php 
  $string="function notificaexamen(){ 
       $.ajax({
              url: '".Url::to(['/sta/citas/notifica-examen-digital'])."', 
              type: 'get',
              data:{id:".$model->id.",idalu:".$model->cita->tallerdet->alumno->id."},
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                      
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             }";
  //echo $string;
  if(!$model->isNewRecord)
  $this->registerJs($string, \yii\web\View::POS_HEAD);
?>