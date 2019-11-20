<?php
use miloschuman\highcharts\Highcharts;
?>
<div class ="box-body">

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
    <?php
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
                 ['name'=>'Asistencias','y'=>90,'color'=>'#e822d0'],
                 ['name'=>'Inasistencias','y'=>10,'color'=>'#00c0ef'],
                 ]
             
         ],
          
         //['name' => 'John', 'data' => [5, 7, 3]]
      ]
   ]
]);


?>
</div>
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
                  <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['id'=>'mycv','class'=>'styled'])?>
                        <label for="mycv">
                            Examen psicotecnico
                        </label>
                    </div>
           <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['id'=>'mycv','class'=>'styled'])?>
                        <label for="mycv">
                            Examen psicotecnico
                        </label>
                    </div>
           <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['checked' => false,'id'=>'mycv','class'=>'styled'])?>
                        <label for="mycv">
                            Examen Habilidades Soci
                        </label>
                    </div>
           <div class="checkbox checkbox-info">
                         <?=\yii\helpers\Html::checkbox('sfsf',true,['id'=>'mycv','class'=>'styled'])?>
                        <label for="mycv">
                            Examen Big Five
                        </label>
                    </div>
          
      
    
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
                  <tr>
                    <td><a href="pages/examples/invoice.html">OR9842</a></td>
                   
                    <td><span class="label label-success">Efectuada</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">15/03/2020</div>
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                    
                    <td><span class="label label-warning">Pendiente</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f39c12" data-height="20">25/02/2020</div>
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                   
                    <td><span class="label label-danger">Ausente</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f56954" data-height="20">18/03/2020</div>
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">OR7429</a></td>
                    
                    <td><span class="label label-info">Evaluacion</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00c0ef" data-height="20">14/02/2020</div>
                    </td>
                  </tr>
                  <tr>
                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                   
                    <td><span class="label label-warning">Pendiente</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f39c12" data-height="20">15/03/2020</div>
                    </td>
                  </tr>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
    
     </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>