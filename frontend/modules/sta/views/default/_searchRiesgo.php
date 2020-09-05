<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sta\helpers\comboHelper;
use frontend\modules\sta\models\VwAluriesgoSearch;
use common\widgets\selectwidget\selectWidget;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\AlumnosController */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $model=New VwAluriesgoSearch() ?>
<div class="alumnos-search">

    <?php $form = ActiveForm::begin([
        'id'=>'miformulario',
        'action' => ['/sta/default/busca-alumno'],
        'method' => 'post',
       // 'multiple'=>'multiple',
        'options' => [
          // 'data-pjax' => 0
        ],
    ]); ?>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group">
        <?= Html::button("<span class='fa fa-search'></span>     ".Yii::t('sta.labels', 'buscar'), ['id'=>'boton-buscador','class' => 'btn btn-primary']) ?>
        

    </div>
     </div>
    <div id="buscador">
        
    
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codperiodo')->
            dropDownList(comboHelper::getCboPeriodos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
 
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model,'codalu') ?>
</div> 
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model, 'nombres') ?>
</div> 
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
    <?= $form->field($model, 'ap') ?>
</div> 
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">     
    <?= $form->field($model, 'am') ?>
 </div>   
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codfac')->
            dropDownList(comboHelper::getCboFacultades(),
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
</div>
    
  <?php $this->registerJs("
         
$('#boton-buscador').on( 'click', function(){ 
    
    var form =$('#miformulario');
    var url = form.attr('action');

    $.ajax({
           type: 'POST',
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
                $('#divbusqueda').html(data);
           }
         });

});",\yii\web\View::POS_END);  
  ?>
    <?php ActiveForm::end(); ?>
    <div id="divbusqueda">
        
    </div>   
    

</div>

  