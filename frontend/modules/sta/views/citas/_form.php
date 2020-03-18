<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use common\widgets\selectwidget\selectWidget;
use kartik\datetime\DateTimePicker;
use common\helpers\h;
use frontend\modules\sta\staModule;
use frontend\modules\sta\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */
/* @var $form yii\widgets\ActiveForm */
$tipo=h::user()->profile->tipo;

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
    
        
          

        
           
          
 
          
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12"> 
     <?php 
       echo $form->field($model, 'codtra')->
            dropDownList(ComboHelper::getCboTutoresByProg($model->taller->id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    );
     
        ?>

        </div>
          
          
  
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?php 
      echo $form->field($model, 'fechaprog')->textInput(['disabled' =>true]);
        /*echo $form->field($model, 'fechaprog')->widget(
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
                    ]);*/
                ?>
      
  </div> 
  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      if($vencida){
       echo $form->field($model, 'finicio')->textInput(['disabled' =>true]);
         
      }else{
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
      }
       
                ?>
  </div> 
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      if($vencida){
       echo $form->field($model, 'ftermino')->textInput(['disabled' =>true]);
         
      }else{
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
      }   ?>
  </div>
          
 <?php if($model->isVisibleField('detalles_secre', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'detalles_secre')->widget(\rikcage\sceditor\SCEditor::className(), [
        'options' => ['rows' => 10],
        'clientOptions' => [
            'toolbar'=>'bold,italic,underline,left,center,right,justify,font,size,color|cut,copy,paste,table,image,link,unlinkemail,youtube,print,maximize',
            'plugins' => 'bbcode',
            'locale'=>'es'
        ]
    ]); ?> 
  </div>
  
   
       <?php /*
       $problemas=$model->arrayAlertasTotal();
       if(count($problemas)>0){
         echo yii::t('sta.labels','Se encontraron '.count($problemas).' identificadores');
         foreach($problemas as $numerocita=>$problema){
             echo Html::a($numerocita,'#',['class'=>"mamota"]);
         }
       }
       */
       ?>
       
  
 <?php } ?>

 
 <?php if($model->isVisibleField('detalles', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles', $tipo)]) ?>
  </div>
 <?php } ?>
 
 <?php if($model->isVisibleField('detalles_indicadores', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles_indicadores')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_indicadores', $tipo)]) ?>
  </div>
 <?php } ?>      
 

 <?php if($model->isVisibleField('detalles_tareas_pend', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles_tareas_pend')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_tareas_pend', $tipo)]) ?>
  </div>
 <?php } ?>
  
     
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
                  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                      
                   $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                    
                                $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok-sign\'></span>' + json['success']);
                             $.noty.setType(n.options.id, 'success');
                             $('#btn-conf-asistencia').hide();
                              $.pjax.reload({container: '#botones-examenes',async:false});
                              $.pjax.reload({container: '#check-asistencia-cita',async:false});
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-info-sign\'></span>' +json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                             $('#btn-conf-asistencia').hide();
                             $.pjax.reload({container: '#botones-examenes'});
                              $.pjax.reload({container: '#check-asistencia-cita'});
                              } 
                              
                      
                        },
                        });
             })", View::POS_READY);
?>
</diV>