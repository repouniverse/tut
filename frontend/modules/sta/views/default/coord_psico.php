<?php
use yii\helpers\Html;
use frontend\modules\sta\models\StaGrupoflujo;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
$this->title = Yii::t('sta.labels', 'Psicólogos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Panel Coord'), 'url' => ['/sta/default/panel-coord']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('sta.labels', 'Psicólogos')];

?>


    
<div class="box">
 <?php 
   foreach($psicologos as $psicologo){
  ?>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <h4><?= $psicologo->codfac.'-'.Html::encode($psicologo->trabajador->fullName()) ?></h4>
 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
    <?php
 
    $ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    //$ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
    $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$psicologo->codfac,'codperiodo'=>$codperiodo,'codtra'=>$psicologo->codtra])->count();
    $porcAvancePsico=StaGrupoflujo::porcTotal($codperiodo,$psicologo->codfac,$psicologo->codtra)*100;
echo Highcharts::widget([
   'options' => [
      
       'chart'=>['type'=>'pie',
           'height'=>230,
          
           ],
       
       'plotOptions'=>[
        'pie'=> [
            'allowPointSelect'=>true,
            'cursor'=>'pointer',
            'showInLegend'=>true,
            'dataLabels'=>[
                'enabled'=>false
            ],
        ],
           ],
       'credits'=>false,
      'title' => ['text' => yii::t('sta.labels','Participación ({parti}%)',['parti'=>round(($nPorPiscologo+0)*100/($ntotalPeriodo),1)]),
           'style'=>[
                        'color'=> '#f39c12',
                        'fontWeight'=>'bold',
                        'fontSize'=>'15px'
                        ]
          ],
     /* 'xAxis' => [
         'categories' => ['14-01','18-02', '27-02', '03-03','25-03','26-03']
      ],
      'yAxis' => [
         'title' => ['text' => 'Asistencias']
      ],*/
      'series' => [
          
         ['name' => 'Cantidad de Pacientes', 
             'data' => [                 
                 ['name'=>$psicologo->codtra,'y'=> $nPorPiscologo+0,'color'=>'#d6e812'],
                 ['name'=>'Resto','y'=>($ntotalPeriodo+0- $nPorPiscologo),'color'=>'#eeeeee'],
                 
                 ]
             
         ],
          
         //['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);


?>
    <div style="
    color: #f39c12;
    font-size: 15px;
    font-weight: bold;
    fill: #f39c12; text-align: center">
        % Avance periodo
    </div>
  <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: <?= $porcAvancePsico?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$porcAvancePsico?>%</div>
   </div>  
   
 </div> 
    
    
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <?php
 
    //$ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    //$ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
    $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$psicologo->codfac,'codperiodo'=>$codperiodo,'codtra'=>$psicologo->codtra])->count();
    $porcAvancePsico=StaGrupoflujo::porcTotal($codperiodo,$psicologo->codfac,$psicologo->codtra)*100;
echo Highcharts::widget([
   'options' => [
      
       'chart'=>['type'=>'pie',
           'height'=>230,
          
           ],
       
       'plotOptions'=>[
        'pie'=> [
            'allowPointSelect'=>true,
            'cursor'=>'pointer',
            'showInLegend'=>true,
            'dataLabels'=>[
                'enabled'=>false
            ],
        ],
           ],
       'credits'=>false,
      'title' => ['text' => yii::t('sta.labels','Participación ({parti}%)',['parti'=>round(($nPorPiscologo+0)*100/($ntotalPeriodo),1)]),
           'style'=>[
                        'color'=> '#f39c12',
                        'fontWeight'=>'bold',
                        'fontSize'=>'15px'
                        ]
          ],
     /* 'xAxis' => [
         'categories' => ['14-01','18-02', '27-02', '03-03','25-03','26-03']
      ],
      'yAxis' => [
         'title' => ['text' => 'Asistencias']
      ],*/
      'series' => [
          
         ['name' => 'Cantidad de Pacientes', 
             'data' => [                 
                 ['name'=>$psicologo->codtra,'y'=> $nPorPiscologo+0,'color'=>'#d6e812'],
                 ['name'=>'Resto','y'=>($ntotalPeriodo+0- $nPorPiscologo),'color'=>'#eeeeee'],
                 
                 ]
             
         ],
          
         //['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);


?>
        
        
    </div>
    
    
    
 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
   <?php
   //var_dump(\frontend\modules\sta\components\Indicadores::IndiAvanceByPsico($codfac,$codperiodo,$codtra));
echo $this->render('_flujo_1',[
    'indiAvances'=>
    \frontend\modules\sta\components\Indicadores::IndiAvanceByPsico($codperiodo,$psicologo->codfac,$psicologo->codtra)
    ]);
    ?> 
</div>

</div> 

    
    
    
    
    
    
  <?php  }
  
  ?>
</div>



    
