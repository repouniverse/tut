<?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\sta\models\TalleresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->codfac.'  --  '.Yii::t('sta.labels', 'Ranking de Programación ');
$this->params['breadcrumbs'][] = $this->title;
?>

<h4>'<span class="fa fa-calendar"></span>'<?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
<?php
\common\widgets\timelinewidget\timeLineWidget::widget(
        ['datos'=>[[
            'titulo'=>'titulo1',
             'subtitulo'=>'subtitulo1',
             'texto'=>'Texto',
                ],
            [
            'titulo'=>'titulo2',
             'subtitulo'=>'subtitulo2',
             'texto'=>'Texto2',
                ]
            ]
            ]
        );


?>

<div class="row">
       <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $model->nalumnos(); ?></h3>

              <p>Alumnos en riesgo</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-users"></i></span>
            </div>
            <?php 
            $url=Url::to(['cantidades-en-riesgo']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?>
            
          </div>
        </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-teal-gradient">
            <div class="inner">
              <h3><?php echo $model->periodo ?></h3>

              <p>Periodo promedio (días)</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-users"></i></span>
            </div>
            <?php 
            $url=Url::to(['cantidades-en-riesgo']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?>
            
          </div>
        </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
          <!-- small box -->
           <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $model->aluactivos ?></h3>

              <p>Alumnos Continuadores</p>
            </div>
            <div class="icon">
                <span style="color:white;opacity:0.5;"><i class="fa fa-users"></i></span>
            </div>
            <?php 
            $url=Url::to(['cantidades-en-riesgo']);
            echo Html::a(yii::t('sta.labels','Detalles').'<i class="fa fa-arrow-circle-right"></i>',$url, ['class'=>"botonAbre small-box-footer"]);
            ?>
            
          </div>
        </div>
  </div>
<div class="talleres-index">

    
    <?php Pjax::begin(['id'=>'fsfs','timeout'=>false]); ?>
    <?php //echo $this->render('_searchriesgo', ['model' => $searchModel]); ?>

    <?php
    
    
    
    ?>
         
         
    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grupo-pjax',
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
        ],
   
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sta\models\Talleresdet::find()->andWhere(
                    [
                        'talleres_id'=>$model->id,
                        
                       
                    ])->andWhere(['<','puntaje',2000])->
                orderby(['puntaje'=>SORT_DESC,'frecuencia'=>SORT_DESC]),
            'pagination'=>['pageSize'=>10]
        ]),
         'summary' => '',
        //'bootstrap'=>false,
         //'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['ajax-detalle-historial']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
             ], 
                                        [
             'attribute'=>'Imagen',
             'format'=>'html',
              'value'=>function($model){
                 return \yii\helpers\Html::img(\frontend\modules\sta\staModule::getPathImage($model->codalu),['width'=>45, 'height'=>60]) ;
              }
                
                ],
                        ['attribute'=>'Anticuamiento',
                'format'=>'raw',
                'value'=>function($model){
                    return ($model->puntaje>1000)?($model->puntaje-1000).' DÍAS':$model->puntaje.' DÍAS';
                       //return  '<span class="label label-success">'.$model->frecuencia().'  /  '.$model->talleres->periodo.'</span> ';
                }
                ],
            [
                'attribute'=>'codalu',
                'format'=>'raw',
                 //'contentOptions'=>['width'=>'300px'],
                'value' => function ($model, $key, $index, $column) {
                    $options=['id'=>$model->codalu,
                              //'class'=>'class_link_ajax'
                               'data-pjax'=>'0',
                                'target'=>'_blank'
                               ];
                    $url=\yii\helpers\Url::to(['programas/trata-alumno','id'=>$model->id]);
                    if(!empty($model->codtra)){
                        return Html::a($model->codalu,$url, $options);
                    }else{
                        return $model->codalu;
                    }
                    
                        },
            ],
                               
                                
            ['attribute'=>'Intervalo Prom',
                'format'=>'raw',
                'value'=>function($model){
                     $texto='No hay';
                     $texto2=$model->frecuencia;
                     return ($model->frecuencia >0)?$model->frecuencia.'  Días':'No hay  <span class="fa fa-circle"></span>';
                            //$url=\yii\helpers\Url::to(['ajax-detalle-citas']);
                   //return \yii\helpers\Html::a($model->frecuencia, '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id]),/*'title' => 'Borrar'*/]);          
                }
                ],
                         ['attribute'=>'Programado',
                'format'=>'raw',
                'value'=>function($model){
                    if($model->puntaje>1000){
                         $mensaje='<i class="color:red;">NO </i> ';
                    }ELSE{
                         $mensaje='';
                    }
                       
                       return  '<i class="color:red;">'.$mensaje.'</i> ';
                }
                ],
           ['attribute'=>'nombres',
               'value'=>function ($model, $key, $index, $column) {
                    return $model->alumno->fullName(false);
                        },
               ],
            //'frecuencia',
            
           
        ],
    ]); ?>
     <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grupo-pjax',
            'family'=>'holas',
            'divReplace'=>'detalle_hi',
          'type'=>'GET',
          'mode'=>'html',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>   
        
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       