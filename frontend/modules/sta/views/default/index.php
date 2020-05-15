<?php
//use dosamigos\chartjs\ChartJs;
use frontend\modules\sta\components\Indicadores;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
  ?>
<div class="box box-success">
    <section class="content">
      
        <!-- Info boxes -->
        
        <div class="btn-group">
   <!-- <a href="<?=\yii\helpers\Url::toRoute('/sta/entregas')?>" class="btn btn-warning btn-lg ">
        <i class="glyphicon glyphicon-briefcase" aria-hidden="true"></i> <?=yii::t('sta.labels','Entregas')?>
    </a>
    <a href="<?=\yii\helpers\Url::toRoute('/sta/test')?>" class="btn btn-success btn-lg ">
        <i class="glyphicon glyphicon-paste " aria-hidden="true"></i> <?=yii::t('sta.labels','Exámenes Piscotécnicos')?>
    </a>
            <a href="<?=\yii\helpers\Url::toRoute('/masters/trabajadores')?>" class="btn btn-primary btn-lg ">
        <i class="glyphicon glyphicon-user " aria-hidden="true"></i> <?=yii::t('sta.labels','Psicólogos')?>
    </a>
            
    <a href="<?=\yii\helpers\Url::toRoute('/sta/periodos')?>" class="btn btn-dark btn-lg ">
        <i class="glyphicon glyphicon-calendar " aria-hidden="true"></i> <?=yii::t('sta.labels','Periodos')?>
    </a> !-->
</div>
        
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            <h4>Etapas del plan de tutoría psicológica - R</h4>
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
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('_searchRiesgo', []); ?>
</DIV>   

        
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
     <H4><?=yii::t('sta.labels','Facultades'); ?></H4>
 
          <div class="row">
        <!---Income-->
         <div class="col-12 col-sm-6 col-md-3">  
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >COORDINACIÓN</h3></div> 
               <div class="panel-body">
          <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIA'])  ?>"><span class="info-box-icon bg-yellow-gradient"><i class="fa fa-sitemap"></i></span></a>
           </div> 
               </div> 
        </div> 
        
        
       <div class="col-12 col-sm-6 col-md-3">  
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIA</h3></div> 
               <div class="panel-body">
          <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIA'])  ?>"><span class="info-box-icon bg-green-gradient"><i class="fa fa-tree"></i></span></a>
           </div> 
               </div> 
        </div> 
       <div class="col-12 col-sm-6 col-md-3"> 
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FAUA</h3></div> 
               <div class="panel-body">
            <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FAUA'])  ?>"><span class="info-box-icon bg-aqua"><i class="fa fa-city"></i></span></a>
       </div> 
        </div> 
        </div>
        
        
       <div class="col-12 col-sm-6 col-md-3"> 
           <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIQT</h3></div> 
               <div class="panel-body">
               <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIQT'])  ?>"><span class="info-box-icon bg-orange-active"><i class="fa fa-flask"></i></span></a>
       </div> 
        </div> 
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">    
            <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIC</h3></div> 
               <div class="panel-body">
               <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIC'])   ?>"><span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-building"></i></span></a>
        </div> 
        </div> 
        </div>
        
        
            <div class="col-12 col-sm-6 col-md-3"> 
                <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIEECS</h3></div> 
               <div class="panel-body">
                 <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIEECS']) ?>"><span class="info-box-icon bg-red-gradient"><i class="fa fa-usd"></i></span></a>
              </div> 
             </div>    
            </div> 
        
            <div class="col-12 col-sm-6 col-md-3">    
              <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIIS</h3></div> 
               <div class="panel-body">   
                  <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIIS'])   ?>"><span class="info-box-icon bg-purple-gradient"><i class="fa fa-industry"></i></span></a>
            </div> 
            </div> 
           </div>
            <div class="col-12 col-sm-6 col-md-3"> 
                 <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIM</h3></div> 
               <div class="panel-body"> 
                  <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIM'])  ?>"><span class="info-box-icon bg-aqua"><i class="fa fa-wrench"></i></span></a>
        </div> 
               </div> 
           </div>
        
            <div class="col-12 col-sm-6 col-md-3"> 
                 <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIEE</h3></div> 
               <div class="panel-body"> 
                 <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIEE']) ?>"><span class="info-box-icon bg-blue-active"><i class="fa fa-microchip"></i></span></a>
                 </div>  
                 </div> 
           </div>
        
          <div class="col-12 col-sm-6 col-md-3"> 
                 <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIC</h3></div> 
               <div class="panel-body"> 
                 <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIC'])  ?>"><span class="info-box-icon bg-yellow-gradient"><i class="fa fa-atom"></i></span></a>
                 </div>  
                 </div> 
           </div>
        <div class="col-12 col-sm-6 col-md-3"> 
                 <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIGMM</h3></div> 
               <div class="panel-body"> 
                 <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIGMM'])   ?>"><span class="info-box-icon bg-gray-active"><i class="fa fa-bacon"></i></span></a>
                 </div>  
                 </div> 
           </div>
        <div class="col-12 col-sm-6 col-md-3"> 
                 <div class="panel panel-success">
               <div class="panel-heading"><h3 class="panel-title" >FIP</h3></div> 
               <div class="panel-body"> 
                 <a href="<?=\yii\helpers\Url::to(["/sta/default/resumen-facultad",'codfac'=>'FIP']) ?>"><span class="info-box-icon bg-purple-gradient"><i class="fa fa-fill-drip"></i></span></a>
                 </div>  
                 </div> 
           </div>
            
    </div>

     </diV>  
        <!-- /.row -->

 <h4 class="card-title"><?= yii::t('sta.labels','Asistencias') ?></h4>

        
        
              
          
              <div class="card-header">
               
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            
                 
                   

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                     
  
    
    
</div>
</div>
    </section>
</div>
              
              
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

 </div>  
        
