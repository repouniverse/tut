<?php  
use dosamigos\chartjs\ChartJs;
use yii\grid\GridView;

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
        
        <?= \yii\helpers\Html::dropDownList('micombofac',$model->codfac,\frontend\modules\sta\helpers\comboHelper::getCboFacultades(),
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
                <div class="col-md-8">
                  <p class="text-center text-info">
                     <span class="fa fa-calendar-o"></span><?='  '.yii::t('sta.labels','Número de Citas {desde} - {hasta} {ano}',[
                         'desde'=>'18/09/2019',
                         'hasta'=>'25/12/2019',
                         'ano'=>date('Y')
                     ])?> 
                    
                  </p>

                  <div class="chart">
                  
                    
                        <?= ChartJs::widget([
                            'type' => 'line',
                                'options' => [
                                    'height' => 400,
                                         'width' => 400
                                            ],
                                'data' => [
        'labels' => ["Día 1", "Día 2", "Día 3", "Día 4", "Día 5", "Día 6", "Día 7"],
        'datasets' => [
            [
                'label' => "Primer grupo",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40]
            ],
            [
                'label' => "Segundo grupo",
                'backgroundColor' => "rgba(255,99,132,0.2)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [28, 48, 40, 19, 96, 27, 100]
            ]
        ]
    ]
]);
?>             
                
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center text-info">
                    <?=yii::t('sta.labels','Metas Cumplimieto de Citas')?>
                  </p>

                  <div class="progress-group">
                      <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos ubicados')?></span>
                    <span class="progress-number"><b>160</b>/200</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos citados')?></span>
                    <span class="progress-number"><b>310</b>/400</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos con informe')?></span>
                    <span class="progress-number"><b>480</b>/800</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="text-info"><span class="fa fa-users"></span><?='  '.yii::t('sta.labels','Alumnos con citas finalizadas')?></span>
                    <span class="progress-number"><b>250</b>/500</span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
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
          url=url.replace('codfac=".$model->codfac."','codfac='+$(this).val()); 
             // alert(url);
           window.location=url;
          
          return false;
      });
    });" ); ?>