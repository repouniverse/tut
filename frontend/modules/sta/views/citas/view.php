<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */

$this->title = yii::t('sta.labels','Cita '.$model->numero.'-'.$model->tallerdet->alumno->fullName());
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="citas-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('sta.labels', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>
<?php
    $tipo=h::user()->profile->tipo;

?>

<div class="citas-form">
  <div class="box box-body">
    <?php $form = ActiveForm::begin([
       'id'=>'formulario_cita',
       'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
         
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?php 
      echo $form->field($model, 'fechaprog')->textInput(['disabled' =>true]);
     
                ?>
      
  </div> 

  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?php 
      
       echo $form->field($model, 'finicio')->textInput(['disabled' =>true]);
         
      
                ?>
  </div> 
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?php 
      
       echo $form->field($model, 'ftermino')->textInput(['disabled' =>true]);
        ?>
  </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
   
    </div> 
          
          
          
 <?php if($model->isVisibleField('detalles_secre', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     //echo $form->field($model, 'sugerencias')->textarea();
     echo $form->field($model, 'detalles_secre')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2,'disabled'=>true],
         'clientOptions'=>['language'=>'es',
               'toolbar'=>[],],
        ]);
      ?>
  </div>
 <?php } ?>

 
 <?php if($model->isVisibleField('detalles', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?PHP
     //echo $form->field($model, 'sugerencias')->textarea();
     echo $form->field($model, 'detalles')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2,'disabled'=>true],
         'clientOptions'=>['language'=>'es',
               'toolbar'=>[],],
        ]);
      ?>
  </div>
 <?php } ?>
    
 

 <?php if($model->isVisibleField('detalles_tareas_pend', $tipo)){  ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?PHP
     //echo $form->field($model, 'sugerencias')->textarea();
     echo $form->field($model, 'detalles_tareas_pend')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2,'disabled'=>true],
         'clientOptions'=>['language'=>'es',
               'toolbar'=>[],],
        ]);
      ?>
  </div>
 <?php } ?>
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>

    
</diV>
    
    
    
    
    
</div>
