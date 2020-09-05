<?php
//use dosamigos\chartjs\ChartJs;
use frontend\modules\sta\components\Indicadores;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
  ?>

    <div class="box box-body">
        <h4>Estadísticas de usuarios</h4>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="3"><p class="text-green"><span class="fa fa-key"></span>      Frecuencia de acceso</p></th> 
                    
                  </tr>
                  <tr>
                      <th>Rank</th> 
                      <th>Usuario</th> 
                    <th>Veces</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
                   $i=1;
           foreach($userLogin as $login){ 
              
               ?>
              <tr> 
                  <td><?=$i?></td>
                  <td><?=$login['username']?> <i style="color:#ccc;"><span class="fa fa-user"></span></i></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$login['nlogin']?></div>
                    </td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>       
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
           <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="3"><p class="text-green"><span class="fa fa-chart-line"></span>        Operaciones y nivel de actividad</p></th> 
                    
                  </tr>
                  <tr>
                     <th>Rank</th> 
                    <th>Usuario</th> 
                    <th>Veces</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php $i=1; 
           foreach($userActivity as $actividad){ 
              
               ?>
              <tr> <td><?=$i?></td> 
                   <td><?=$actividad['username']?> <i style="color:#ccc;"><span class="fa fa-user"></span></i></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$actividad['nactividad']?></div>
                    </td>
              </tr> 
           <?php $i++; } ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>     
       
        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <br>
            <br>
            <h4>Etapas del plan de tutoría</h4>
            <?php        



$steps=[];
foreach($etapas as $clave=>$valor){
        $steps[$clave]=[
              'title' => $valor,
              'icon' => $iconos[$clave],
              'content' => $this->render('_flujo_'.$clave,
                                [
                                    'indiAvances'=>$indiAvances,
                                    'mensaje'=>'3']
                     
                      ),
              'buttons' => [
				'next' => [
					'title' => 'Siguiente', 
					'options' => [
						'class' => 'btn btn-success'
					],
				 ],
                                 'prev' => [
					'title' => 'Previo', 
					'options' => [
						'class' => 'btn btn-success'
					],
				 ],
                                 'save' => [
					'title' => 'Terminar', 
					'options' => [
						'class' => 'btn btn-warning'
					],
				 ],
			 ],
          ];
    }
  
    



 $wizard_config = [
	'id' => 'stepwizard',
        'steps'=>$steps,
	/*'steps' => [
		1 => [
			'title' => 'Step 1',
			'icon' => 'glyphicon glyphicon-cloud-download',
			'content' => '<h3>Step 1</h3>This is step 1',
			'buttons' => [
				'next' => [
					'title' => 'Forward', 
					'options' => [
						'class' => 'disabled'
					],
				 ],
			 ],
		],
		2 => [
			'title' => 'Step 2',
			'icon' => 'glyphicon glyphicon-cloud-upload',
			'content' => '<h3>Step 2</h3>This is step 2',
			'skippable' => true,
		],
		3 => [
			'title' => 'Step 3',
			'icon' => 'glyphicon glyphicon-transfer',
			'content' => '<h3>Step 3</h3>This is step 3',
		],
    
	],*/
	'complete_content' =>'',// $this->render('_completado',['model'=>$model]), // Optional final screen
	'start_step' => 1, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

            
        </div>       
 
        
    <div class="chart">
                      <!-- Sales Chart Canvas -->
                     
   <?php 
   $indicador= Indicadores::IAsistenciasPorFacultad();
   $arrayNcitas=array_map('intval',array_column(array_values($indicador),'ncitas'));
   $arrayPcitas=array_column(array_values($indicador),'pasistencias');
   $arrayAsist=[];
   foreach($arrayNcitas as $clave=>$ncita){
       
         $arrayAsist[]= round($ncita* $arrayPcitas[$clave]/100,0);
       
   }
   
   
   $cienporciento=[];
   foreach($arrayNcitas as $valor){
     $cienporciento[]=100;  
   }
   ?>
                      
   <?php
   ECHO Highcharts::widget([
    'id'=>'grafiquitoyty',
   'options' => [
       'chart'=>['type'=>'column'],
       'title'=>['text'=>'Performance de Citas'],
       //'subtitle'=>['text'=>'Avance de primera etapa'],
        'xAxis'=>[
            'categories'=>array_keys($indicador),
            'title'=>['text'=>null],
            ],
       'yAxis'=>[
            'min'=>0,
            'title'=>[ 'text'=>'Num Alumnos'],
           'align'=>'high',
            ],
        
   
   
    'tooltip'=>[
        'headerFormat'=>'<span style="font-size:10px">{point.key}</span><table>',
        'pointFormat'=>'<tr><td style="color:{series.color};padding:0">{series.name}: </td>'.'<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
        'footerFormat'=>'</table>',
        'shared'=>true,
        'useHTML'=>true
            ],
    'plotOptions'=>[
        'bar'=>[
            'dataLabels'=>[
                'enabled'=>true
            ]
        ]
    ],
    'series'=> [
        [
          'name'=>'Citas Com asistencia',
          'data'=> $arrayAsist,
            'dataLabels'=>['enabled'=>true],
           'color'=>'#12d4f3',
        ],
        [
          'name'=>'Citas elaboradas',
          'data'=>$arrayNcitas,
            'dataLabels'=>['enabled'=>true],
             'color'=>'#f7d350',
        ],
        ]
]]);

   
   
   
   
   ?>
                      
                      
                      
                      
           
        
        
 </div>  

