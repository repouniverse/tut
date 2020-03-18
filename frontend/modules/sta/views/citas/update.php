<?php
 use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Citas */
$alumno=$model->tallerdet->alumno;
$vencida=$model->isVencida();
$nombre=$alumno->fullName();
$codigo=$alumno->codalu; 
$taller=$model->taller;
$facultad=$taller->facultad;
$this->title = Yii::t('sta.labels', 'Edita Cita: {name}', [
    'name' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>yii::t('sta.labels', 'Ir a programa').' '.$model->taller->numero, 'url' => ['/sta/programas/update', 'id' => $model->talleres_id]];
$this->params['breadcrumbs'][] = Yii::t('sta.labels', 'Editar');
?>

 <h4> <i class="fa fa-edit"></i><?= Html::encode($this->title) ?>-<?=$nombre.Html::a(Html::img($model->tallerdet->alumno->getUrlImage(),['width'=>60,'height'=>65, 'class'=>"img-thumbnail cuaizquierdo"])) ?></h4>

    <div class="box box-body">
       <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="btn-group">   
          <?php $url=Url::toRoute(['/sta/programas/trata-alumno','id'=>$model->talleresdet_id,'idalumno'=>$model->tallerdet->alumno->id,'codperiodo'=>$model->taller->codperiodo]);  ?>      
              <?=Html::a('<span class="fa fa-file-pdf" ></span>'.'  '.yii::t('sta.labels','Datos del estudiante'),$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
            <?= common\widgets\auditwidget\auditWidget::widget(['model'=>$model])?>
           <?php  
            $id=$model->firstCitaByStudent();
            $idFirstCita=$id;
           ?> 
           
            <?php if(!$model->asistio && !$vencida){
              echo Html::button('<span class="fa fa-check"></span>   '.Yii::t('sta.labels', 'Confirmar asistencia'), ['id'=>'btn-conf-asistencia','class' => 'btn btn-warning']);
                } ?>
            
                <?php 
               
               
                $url=Url::to(['update','id'=>$id]);
                echo ($id && $id <> $model->id)?Html::a('<i style=" font-size:25px;color:#57a21d;"><span class="glyphicon glyphicon-step-backward"></span></i>',$url):'';
                ?>
                <?php 
                $id=$model->previousCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id)?Html::a('<i style="font-size:25px;color:#57a21d;"><span class="glyphicon glyphicon-arrow-left"></span></i>', $url):'';
                ?> 
                <?php 
                $id=$model->nextCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id)?Html::a('<i style="font-size:25px;color:#57a21d;"><span class="glyphicon glyphicon-arrow-right"></span></i>',$url):'';
                ?>
                 <?php 
                $id=$model->lastCitaByStudent();
                $url=Url::to(['update','id'=>$id]);
                echo ($id && $id <> $model->id)?Html::a('<i style="font-size:25px;color:#57a21d;"><span class="glyphicon glyphicon-step-forward"></span></i>', $url):'';
                ?>
                </div> 
                </div> 
                
               
               
            
                
                
                
               </div> 
            </div>
        </div>
    
        
        
        
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <?= Html::activeLabel($model,'numero')?>
      <?= Html::activeTextInput($model, 'numero',['class'=>'form-control','disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>

        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
      <?= Html::activeLabel($taller,'descripcion')?>
      <?= Html::activeTextInput($taller, 'descripcion',['class'=>'form-control','disabled'=>'disabled']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <?= Html::activeLabel($taller,'codperiodo')?>
              <?= Html::activeTextInput($taller, 'codperiodo',['class'=>'form-control','disabled'=>'disabled']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>
            
          </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <?= Html::activeLabel($facultad,'desfac')?>
              <?= Html::activeTextInput($facultad, 'desfac',['class'=>'form-control','disabled'=>'disabled']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>
            </div>         
          
        
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               <?= Html::activeLabel($alumno,'codalu')?>
              <?= Html::activeTextInput($alumno, 'codalu',['class'=>'form-control','disabled'=>'disabled']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>
            
        </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <?= Html::activeLabel($alumno,'nombres')?>
              <?= Html::activeTextInput($alumno, 'nombres',['value'=>$nombre,'class'=>'form-control','disabled'=>'disabled']) /*   textInput($name, $value)  $form->field($model, 'numero')->textInput(['disabled'=>'disabled','style'=>'color:#ad5eb7; font-weight:700;'])*/ ?>
            
        </div> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
        </div>
         <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php Pjax::begin(['id'=>'check-asistencia-cita']);  ?>
                <?php if($model->asistio){ ?>
                 <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['id'=>'mycv','class'=>'styled','disabled'=>'disabled'])?>
                        <label for="mycv">
                            Asistió
                        </label>
                 </div>
               <?php } ?>
               <?php  Pjax::end() ?>
        </div> 
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
               <?php 
             echo Html::label($model->getAttributeLabel('flujo_id'));  
          echo Html::dropDownList(
                  'hishfisf',
                  $model->flujo_id.'',
                  \frontend\modules\sta\helpers\comboHelper::getCboFlujoTotal(),
                  [//'prompt'=>'--'.yii::t('base.verbs','Seleccione un Valor')."--",
                    'class' => 'form-control',
                     'disabled'=>true,
                        ]
                    ) ?>
                </div>
      
      
    <?php 
      $items=  [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('sta.labels','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form',['model' => $model,'vencida'=>$vencida]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Calendario'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_calendario',[ 'model' => $model,'eventos'=>$eventos,'vencida'=>$vencida]),
            'active' => false,
             'options' => ['id' => 'myvyr76wnID4'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Resultados'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_resultados',[ 'model' => $model,'nombre'=>$nombre,'vencida'=>$vencida,'idFirstCita'=>$idFirstCita]),
            'active' => false,
             'options' => ['id' => 'myv2bgnI6'],
        ]
    ];  ?>
        <?php 
        if($model->masivo){
           $items[]=[
          'label'=>'<i class="fa fa-users"></i> '.yii::t('sta.labels','Examenes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_examenes',[ 'model' => $model,'vencida'=>$vencida]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ];
        
       
        }
        
        ?>

    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => $items,
]); 

?>

</div>