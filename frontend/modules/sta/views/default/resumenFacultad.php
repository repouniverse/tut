<?php  
use dosamigos\chartjs\ChartJs;
use yii\grid\GridView;
use frontend\modules\sta\models\Talleresdet;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use frontend\modules\sta\components\Indicadores;
?>
<div class="box box-success">
        
     
     
    <DIV CLASS="box-body">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <h5><?= $model->desfac?></h5>
            
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <DIV CLASS="alert alert-danger">
                  </span><?=yii::t('sta.labels','Cantidad de Alumnos: {nalumnos}',['nalumnos'=>$nalumnos])?></p>
            </DIV>
        </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= \yii\helpers\Html::label(yii::t('sta.labels','Ir a otra Facultad'),'micombo',['class'=>'control-label'])?>
        
        <?= \yii\helpers\Html::dropDownList('micombofac',$model->codfac,\frontend\modules\sta\helpers\comboHelper::getCboFacultadesByUser(\common\helpers\h::userId()),
                    ['prompt'=>yii::t('sta.labels','--Seleccione un valor--'),
                     'class'=>'form-group form-control',
                     'id'=>'id_micombofac'
                        ]
                    )?>
                 
        </div>
      </div>
        <hr>
     <div class="row">
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <p class="text-center text-info"><span class="fa fa-flag">   </span><?='   '.yii::t('sta.labels','Top 5 alumnos con mayor cant cursos')?></p>
         <?= GridView::widget([
        'dataProvider' => $provAlumnos,
         'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-condensed table-hover table-borderless table-striped table-responsive text-nowrap'
             ],
             'columns' => [
          [
                'attribute' => 'cant',
                'format'=>'raw',
                'value' => function($data) {
                    return '<span class="label label-warning">'.$data['cant'].'</span>';
                },
                
            ],
            'codalu',
            'nombres',
            'ap',
                       
        ],
    ]); ?>
     </div> 
    
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
         <p class="text-center text-info"><span class="fa fa-repeat">   </span><?='  '.yii::t('sta.labels','Top 5 cursos frecuentes')?></p>
         <?= GridView::widget([
        'dataProvider' => $provCursos,
         'summary' => '',
         'tableOptions'=>[
             'class'=>'table table-condensed table-hover table-borderless table-striped table-responsive text-nowrap'
             ],
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'cant',
                'format'=>'raw',
                'value' => function($data) {
                    return '<span class="label label-danger">'.$data['cant'].'</span>';
                },
                
            ],
            'codcur',
           [
                'attribute' => 'nomcur',
                'value' => function($data) {
                    return substr($data['nomcur'],0,20);
                },
                
            ],
                       
        ],
    ]); ?>
     </div> 
        
     </div>     
         
              <div class="row">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  
                  <div class="chart">
                  <?php
                  
                 /*echo Indicadores::queryCountCategoriasResultadosBaseFilter($codfac,$codperiodo)->
                        createCommand()->getRawSql();die();*/
                $matriz= Indicadores::queryCountCategoriasResultadosBaseFilter($codfac,$codperiodo)->asArray()->all(); 
                $indicadores=ARRAY_VALUES(array_unique(array_column($matriz,'nombre')));
                $categorias=ARRAY_VALUES(array_unique(array_column($matriz,'categoria')));
                $faltantes=[];
                //yii::error($matriz);
                $matrizFinal=[];
                foreach($indicadores as $nombreindicador){
                   $matrizFiltrada= array_filter($matriz, function($v, $k) use($nombreindicador) {
                        return  trim($v['nombre']) == trim($nombreindicador);
                             }, ARRAY_FILTER_USE_BOTH);
                 // var_dump($matrizFiltrada);die();
                           //yii::error($matrizFiltrada);
                  // $matrizFinal=array_merge($matrizFinal,$matrizFiltrada);
                             $copiaMatrizFiltrada=$matrizFiltrada;
                   if(count($matrizFiltrada) < 3){
                       $faltan=array_diff($categorias, array_column($matrizFiltrada,'categoria'));
                       //yii::error($faltan);
                       asort($faltan);
                       if(count($faltan)>0){
                           foreach($faltan as $categoriafaltante){
                                //YII::ERROR('SE AGREGA  '.$categoriafaltante);
                               $copiaMatrizFiltrada[]=['ncategoria'=>0,'categoria'=>$categoriafaltante,'nombre'=>$nombreindicador];
                                yii::error('crudo');
                    yii::error($copiaMatrizFiltrada);
                   $copiaMatrizFiltrada=\common\helpers\ArrayHelper::array_sort($copiaMatrizFiltrada, 'categoria', SORT_ASC);
                   yii::error('ordenada');
                    yii::error($copiaMatrizFiltrada);
                           }
                       }
                   }
                  
                  $matrizFinal=array_merge($matrizFinal,$copiaMatrizFiltrada); 
                  //yii::error($matrizFinal);
                }
                $cantidad=count($matriz);
                $bajo=[];$alto=[];$promedio=[];
               // $cantidad=0;
                  foreach($matrizFinal as $fila){ 
                 if($fila['categoria']== frontend\modules\sta\models\StaPercentiles::CALIFICACION_BAJO)
                 {
                     $bajo[]=$fila['ncategoria'];
                    //$cantidad+=$fila['ncategoria'];
                 }
                  if($fila['categoria']== frontend\modules\sta\models\StaPercentiles::CALIFICACION_PROMEDIO)
                   $promedio[]=$fila['ncategoria'];
                  if($fila['categoria']== frontend\modules\sta\models\StaPercentiles::CALIFICACION_ALTO)
                   $alto[]=$fila['ncategoria'];
                }
                $bajo=array_map('intval', $bajo);
                $promedio=array_map('intval', $promedio);
                $alto=array_map('intval', $alto);
//var_dump($indicadores);die();
              if(array_key_exists(0, $bajo)) {
                  
              
                   ECHO Highcharts::widget([
    'id'=>'grafiquito',
   'options' => [
       'chart'=>['type'=>'column',
            'height'=>800],
      'title' => ['text' => 'Resultados '.($alto[0]+$bajo[0]+$promedio[0]).' evaluados de '.$nalumnos.' alumnos '],
      'xAxis' => [
         //'categories' => $indicadores,
          'categories' => $indicadores,
          'labels'=>['rotation'=>-45],
      ],
      'yAxis' => [
         'min'=>0,
         'title' => ['text' => 'Cantidades'],
          'stackLabels'=>[
            'enabled'=>true,
            'style'=>[
                'fontWeight'=> 'bold',
                'color'=>'gray'
            ]
        ]
      ],
       
       
       
      'legend'=>[
           'align'=>'right',
        'x'=> -30,
        'verticalAlign'=> 'top',
        'y'=> 25,
        'floating'=> true,
        'backgroundColor'=> 'white',
        'borderColor'=> '#CCC',
        'borderWidth'=> 1,
        'shadow'=>false
          ],
        'tooltip'=> [
        'headerFormat'=> '<b>{point.x}</b><br/>',
        'pointFormat'=> '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                ],
       'credits'=>false,
       'plotOptions'=> [
        'column'=> [
            'stacking'=> 'normal',
            'dataLabels'=> [
                'enabled'=> true
                    ]
                ],
          // 'series'=>['color'=>'red']
          ],
       
         'series'=> [[
        'name'=> 'BAJO',
        'data'=>$bajo, 'color'=>'#e03131'
    ], [
        'name'=>'PROMEDIO',
        'data'=>$promedio, 'color'=>'#fdd658'
    ], [
        'name'=> 'ALTO',
        'data'=>$alto, 'color'=>'#4c8a0d'
    ]],
       ]
]);
          }         
                  ?>
                 
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <p class="text-center text-info">
                    <?=yii::t('sta.labels','Metas Cumplimieto de Citas')?>
                  </p>

                  <div class="progress-group">
                      <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos sin ubicar')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_SIN_RESPUESTA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_SIN_RESPUESTA]?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos Contactados')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_CON_RESPUESTA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-warning" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_CON_RESPUESTA]?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos con Asistencia')?></span>
                    <span class="progress-number"><b><?=round($kpiContacto[Talleresdet::CONTACTO_CON_CITA]*$nalumnos/100,0)?></b>/<?=$nalumnos?></span>

                    <div class="progress sm">
                        <div class="progress-bar progress-bar-green" style="width: <?=$kpiContacto[Talleresdet::CONTACTO_CON_CITA]?>%"></div>
                    </div>
                  </div>
           
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
         
        
        
        
        
        
        
  </div>
     
</div>
 <?php 
 echo \common\helpers\h::request()->referrer;
 echo \yii\helpers\Html::script("$(function(){
       $('#id_micombofac').on('change', function () {
        //alert($(this).val());
          var url = '".\yii\helpers\Url::current()."';
             //  alert(url);
          //url=url.replace('codfac=".$model->codfac."','codfac='+$(this).val());
             if(url.search('codfac')>0){
             url=url.replace('codfac=".$model->codfac."','codfac='+$(this).val());
             }else{
             url=url+'?codfac='+$(this).val(); 
             }
              
              //alert(url);
           window.location=url;
          
          return false;
      });
    });" ); ?>