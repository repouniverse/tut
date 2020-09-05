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


?>
<?php ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\StaEventos */

$this->title = Yii::t('sta.labels', 'Enviar correo', [
   
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Correo Masivo'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 3, 'url' => ['view', 'id' => 3]];
$this->params['breadcrumbs'][] = Yii::t('sta.labels', 'Actualizar');
?>

<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   

  <div class="box box-body">
    <?php $form = ActiveForm::begin([
       //'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="btn-group">   
        <?= Html::submitButton('<span class="fa fa-envelope"></span>   '.Yii::t('sta.labels', 'Enviar correo'), ['class' => 'btn btn-success']) ?>
                <br>
            </div>
        </div>
    </div>
    
        
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?= $form->field($model, 'email')->
            dropDownList($correosReply,
                  ['prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                  
                    //  'disabled'=>($isClosed)?true:false,
                        ]
                    ) ?>
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'destinatarios')->textarea(['disabled'=>true,'value'=>implode(';',$lista)]); ?> 
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'subject')->textInput(); ?> 
  </div>
          
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?php /*echo $form->field($model, 'detalles_secre')->textArea(['rows' => 4,'disabled'=>!$model->isEditableField( 'detalles_secre', $tipo)]);*/ ?>
      <?php echo $form->field($model, 'body')->widget(\rikcage\sceditor\SCEditor::className(), [
        'options' => ['rows' => 10],
        'clientOptions' => [
            'toolbar'=>'bold,italic,underline,left,center,right,justify,font,size,color|cut,copy,paste,table,image,link,unlinkemail,youtube,print,maximize',
            'plugins' => 'bbcode',
            'locale'=>'es'
        ]
    ]); ?> 
  </div>


     
    <?php ActiveForm::end(); ?>

</div>
    </div>
