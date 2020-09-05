<?php
use common\helpers\h;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use frontend\modules\sta\models\StaGrupoflujo;
$tipo=h::user()->profile->tipo;
$isPsico=($tipo==\frontend\modules\sta\staModule::PROFILE_PSICOLOGO);
?>
<div class="box box-body"> 
 <?PHP IF($isPsico){ ?>
   <div class="alert alert-warning">Versión en fase de desarrollo.</div>

  
   <p class="text-green"></span>  Del Psicólogo :</p>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?php
 
    $ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    //$ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
    $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo,'codtra'=>$codtra])->count();
    $porcAvancePsico=StaGrupoflujo::porcTotal($codperiodo,$codfac,$codtra)*100;
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
                 ['name'=>$codtra,'y'=> $nPorPiscologo+0,'color'=>'#d6e812'],
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
 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
   <?php
   //var_dump(\frontend\modules\sta\components\Indicadores::IndiAvanceByPsico($codfac,$codperiodo,$codtra));
echo $this->render('_flujo_1',[
    'indiAvances'=>
    \frontend\modules\sta\components\Indicadores::IndiAvanceByPsico($codperiodo,$codfac,$codtra)
    ]);
    ?> 
</div>

</div> 
   <br>
   <br>
   <p class="text-green"></span>  De la Facultad :</p>
   
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> 
    <?php
 
    $ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    $ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
    $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo,'codtra'=>$codtra])->count();
$porcAvanceFacultad=StaGrupoflujo::porcTotal($codperiodo,$codfac)*100;
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
      'title' => ['text' => yii::t('sta.labels','Participación ({parti}%)',['parti'=>round(($ntotalFacultad+0)*100/($ntotalPeriodo),1)]),
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
                 ['name'=>$codfac,'y'=>$ntotalFacultad+0,'color'=>'#d6e812'],
                 ['name'=>'Resto','y'=>($ntotalPeriodo+0-$ntotalFacultad),'color'=>'#eeeeee'],
                 
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
      <div class="progress-bar" role="progressbar" style="width: <?= $porcAvanceFacultad?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$porcAvanceFacultad?>%</div>
   </div>  
   
    
</div>  
 <?PHP }else{ ?>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
   <?php
echo $this->render('_flujo_1',[
    'indiAvances'=>
    \frontend\modules\sta\components\Indicadores::IndiAvanceByFac($codperiodo,$codfac)
    ]);
    ?> 
</div>
<?PHP } ?>
</div>  
    
</div>
    