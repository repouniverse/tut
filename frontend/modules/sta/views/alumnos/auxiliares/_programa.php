<?php
use miloschuman\highcharts\Highcharts;
?>
<div class ="box-body">

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
    <?php
  $inasistencias=$modelTallerdet->inasistencias();
  $asistencias=$modelTallerdet->asistencias();
  $total=$inasistencias+$asistencias;
  $inasistencias=($total>0)?$inasistencias/$total:0;
  $asistencias=($total>0)?$asistencias/$total:0;
  
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
      'title' => ['text' => yii::t('sta.labels','Asistencias'),
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
          
         ['name' => 'Citas', 
             'data' => [                 
                 ['name'=>'Asistencias','y'=>$asistencias,'color'=>'#e822d0'],
                 ['name'=>'Inasistencias','y'=>$inasistencias,'color'=>'#00c0ef'],
                 ]
             
         ],
          
         //['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);


?>
</div>
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
         <?php 
           foreach($examenes as $examen){ ?>
              <div class="checkbox checkbox-info">  
                       <?=\yii\helpers\Html::checkbox('sfsf'.$examen['codtest'] ,true,['id'=>'mycv'.$examen['codtest'],'class'=>'styled'])?>
                        <label for="mycv">
                          <?= ucwords(strtolower(substr($examen['descripcion'],0,25))) ?>
                        </label>
              </div> 
           <?php } ?>
         
         
                  
      
    
     <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-brain"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">HORAS</span>
              <span class="info-box-number">19</span>

              <div class="progress">
                <div class="progress-bar" style="width: 90%"></div>
              </div>
              <span class="progress-description">
                    En 5 citas
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>  
    
    <div class="col-lg-6 col-md-5 col-sm-6 col-xs-12"> 
    
    
    <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Cita</th>
                    <th>Status</th>
                   
                    <th>Fecha</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
           foreach($citasArray as $cita){ 
               $marcador=$cita->marcadorStatus();
               $color=array_keys($marcador)[0];
               $estado=array_values($marcador)[0];
               ?>
              <tr>  
                  <td><?= \yii\helpers\Html::a($cita->numero,\yii\helpers\Url::toRoute(['/sta/citas/view','id'=>$cita->id]))?></td>
                    <td><span class="label label-<?=$color?>"><?=$estado?></span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=substr($cita->fechaprog,0,10)?></div>
                    </td>
              </tr> 
           <?php } ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
    
     </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>