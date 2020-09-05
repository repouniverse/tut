<?php
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 //use kartik\date\DatePicker;
 use kartik\datetime\DateTimePicker;
use common\helpers\h;
//use frontend\modules\sigi\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidades */
/* @var $form yii\widgets\ActiveForm */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
?>

<div class="sigi-unidades-form">

    <?php $form = ActiveForm::begin([
        'id'=>'myformulario'/*,'enableAjaxValidation'=>true*/
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> \yii\helpers\Url::to(['/sta/'.$this->context->id.'/'.(($model->isNewRecord)?'crear':'edita').'-sesion','id'=>$id]),
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
         
                  
                <?php echo Html::button('<span class="fa fa-envelope"></span>   '.Yii::t('sta.labels', 'Mail'), ['id'=>'boton_mail_sesion','class' => 'btn btn-success']); ?>
               
            </div>
            
        </div>
    </div>
     
  
      <div class="box-body">
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php 
    echo $form->field($model, 'fecha')->widget(
         DateTimePicker::classname(), [
         'name' => 'fecha',
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
     <?= $form->field($model, 'tema')->textInput([]) ?> 
 </div> 
 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'tipo')->
            dropDownList($model::comboDataField('tipo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                    //'disabled'=>($model->isNewRecord)?'disabled':null,
                        ]
                    ) ?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'sugerencias')->textarea();
     echo $form->field($model, 'mensajecorreo')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 4],
         'clientOptions'=>['language'=>'es',
             'disableNativeSpellChecker' => false,
             //scayt_sLang=
             ],
        //'preset' => 'basic'
         //'language'=>'es',
        ]);
      ?>
  </div>  
  
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
     <?= $form->field($model, 'objetivos')->textArea(['rows'=>4]) ?> 
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
     <?= $form->field($model, 'url')->textArea(['rows'=>2]) ?> 
 </div> 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">    
     <?= $form->field($model, 'recurso')->textInput() ?> 
 </div> 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">    
     <?= $form->field($model, 'pwd')->textInput() ?> 
 </div>         
          
    <?php ActiveForm::end(); ?>

          
    <?PHP echo $this->render('@frontend/views/comunes/adjuntos', [
                        'model' => $model,
                 //'allowedExtensions' => $allowedExtensions,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);  ?>      
</div>
    </div>

<?php
if(!$model->isNewRecord){
   $stringx="$('#boton_mail_sesion').on( 'click', function(){ 
       $.ajax({
              url: '".Url::to(['/sta/eventos/notifica-por-correo-sesion','id'=>$model->id])."', 
              type: 'get',
              data:{id:".$model->id."},
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


             })";
  $this->registerJs($stringx, \yii\web\View::POS_END); 
}

  
?>
   