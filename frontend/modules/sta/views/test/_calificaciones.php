<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html,yii\helpers\Url;
 //use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//use kartik\editable\Editable;
//use kartik\grid\GridView ;
use frontend\modules\sta\helpers\comboHelper;

?>


    <div class="box-body">
  
    <?php // echo $thigrids->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
   <?php 
    Pjax::begin(['id'=>'grid-cali']);
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
      
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                   
                        'delete' => function ($url,$model) {
			    $url = Url::toRoute($this->context->id.'/deletemodel-for-ajax',['id'=>$model->id]);
                             return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'pink','id'=> \yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                    ]
                ],
                       
                            

[  'attribute' => 'valor',
],
[  'attribute' => 'descripcion', 
], 

      
];
   
   
   
   
   ?>
        <?php 
       
        echo GridView::widget([
             'id' => 'kv-grid-demo',
        'dataProvider' => (new \frontend\modules\sta\models\StaTestcaliSearch())->searchByTest($model->codtest),
         //'summary' => '',
        // 'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchAlumnos,
        'columns' => $gridColumns,
           //  'pjax' => true, // pjax is set to always true for this demo
            //'toggleDataContainer' => ['class' => 'btn-group mr-2'],
           /* 'panel' => [
        'type' => GridView::TYPE_WARNING,
        //'heading' => $heading,
    ],*/
    
    ]);
        //Pjax::end();
        ?>
        
    
    </div>
    

<?PHP
echo linkAjaxGridWidget::widget([
           'id'=>'mifpapi',
            'idGrilla'=>'grid-cali',
            'family'=>'pink',
          'type'=>'POST',
           'evento'=>'click',     
       'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); 
 Pjax::end();
?>
    </div>
 <?php
 $url= Url::to(['agrega-calificacion','id'=>$model->codtest,'gridName'=>'grid-cali','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar calificacion'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar calificacion'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
?> 