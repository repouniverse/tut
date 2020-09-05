<?php
use kartik\tabs\TabsX;
use yii\helpers\Html;

use common\components\CalendarScheduleWidget;
use yii\web\JsExpression;

use yii\helpers\Json;

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use frontend\modules\avisos\Module as ModAvisos;
use frontend\modules\sta\staModule;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
$this->title = Yii::t('sta.labels', 'Panel de bienvenida');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Programas'), 'url' => ['/sta/programas/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Citas'),  'url' => ['/sta/citas/index']];

?>
<div class="talleres-update">

    <h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
 <?php

  IF(staModule::getCurrentPeriod()==$codperiodo){?>      
     <?php 
     $profile=h::user()->profile;
     if ($profile->tipo==staModule::PROFILE_PSICOLOGO){
         
         $nombre=common\models\masters\Trabajadores::findOne(['codigotra'=>$codtra])->fullName(); 
     }
     else{
        $nombre=$profile->names; 
     
     }  ?>
    
     <?php
    if(ModAvisos::hasAvisosActuales() ){
       echo $this->render('_avisos');
    }
    ?>
    
 <div class="alert alert-warning">
      <span class="label label-warning"><?=$codfac?></span>
     <?php  
       $sesion=h::session();
       if($sesion->has('psico_por_dia')){
           $codtra=$sesion['psico_por_dia'];
           $nombrepsico= common\models\masters\Trabajadores::findOne(['codigotra'=>$codtra])->fullName();
           $nombre=$nombre.' Con:  -> '.$nombrepsico.'-'.Html::a('<i style="color:red;">Cambiar</i>',Url::to(['seleccionar-psicologo','codfac'=>$codfac,'codperiodo'=>$codperiodo]));
       }
     echo $nombre;  
     ?>
    
 </div>
  
   <?php     
    //var_dump($this->context);die();
 echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-id-card"></i> '.yii::t('sta.labels','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('psicologo',[
                'fecha' => $fecha,
                 'codtra' => $codtra,
                'codfac'=>$codfac,
                'provider'=>$provider,
                'citasPendientes'=> $citasPendientes,
                  'codperiodo'=>  \frontend\modules\sta\staModule::getCurrentPeriod(),
                ]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => true,
             'options' => ['id' => 'tabid1'],
        ],
        [
          'label'=>'<i class="fa fa-hands-helping"></i> '.yii::t('sta.labels','Alumnos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_estadisticas_psico',[ 'providerAlu'=>$providerAlu,'searchAlumnos'=>$searchAlumnos]),
           'active' => false,
             'options' => ['id' => 'tabid2'],
        ],
        [
          'label'=>'<i class="fa fa-chart-pie"></i> '.yii::t('sta.labels','KPI'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_tab_kpi',['codfac'=>$codfac,'codperiodo'=>$codperiodo,'codtra'=>$codtra ]),
           'active' => false,
             'options' => ['id' => 'tabid3'],
        ],
       
    ],
]);  
 
  
    
    ?> 
  <?php  }
  
  ?>
</div>
    </div>






