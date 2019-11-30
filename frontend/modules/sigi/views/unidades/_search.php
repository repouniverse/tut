<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\sigi\helpers\comboHelper;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiUnidadesSearch */
/* @var $form yii\widgets\\ActiveForm */
?>



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
         <?= Html::resetButton("<span class='fa fa-reply'></span>     ".Yii::t('sta.labels', 'Limpiar'), ['class' => 'btn btn-success']) ?>
       <?= Html::button("<span class='fa fa-eye'></span>     ", ['onClick'=>"$('#buscador').toggle()",  'class' => 'btn btn-success']) ?>
    </div>
</div>
<div id="buscador">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'edificio_id')->
            dropDownList(comboHelper::getCboEdificios() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'numero') ?>
    </div>

    
</div>
    

    <?php ActiveForm::end(); ?>

