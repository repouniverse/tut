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
    Pjax::begin(['id'=>'sumilla']);
   ////$dataTutores= comboHelper::getCboTutoresByProg($model->id);
   //print_r($dataTutores);die();
   $gridColumns = [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{delete}',
                'buttons' => [
                    'delete' => function ($url,$model) {
			    $url = Url::toRoute($this->context->id.'/deletemodel-for-ajax',['id'=>$model->id]);
                             return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'pink','id'=> \yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                         'edit' => function ($url,$model) {
			    $url= Url::to(['edita-pregunta','id'=>$model->id,'gridName'=>'sumilla','idModal'=>'buscarvalor']);
                             //echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                            return Html::a('<span class="btn btn-danger btn-sm btn-sm glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            }
                    ]
                ],
        [
    'class' => 'kartik\grid\ExpandRowColumn',
    'width' => '50px',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    // uncomment below and comment detail if you need to render via ajax
    // 'detailUrl'=>Url::to(['/site/book-details']),
    'detail' => function ($model, $key, $index, $column) {
        return Yii::$app->controller->renderPartial('nada',  ['codtest' => $model->codtest]);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'], 
    'expandOneOnly' => true
],                    
                            

[  'attribute' => 'item',
],
[  'attribute' => 'grupo', 
],
[
    'attribute' => 'inversa',
    'format' => 'raw',
    'value' => function ($model) {
        return \yii\helpers\Html::checkbox('inversa[]', $model->inversa, [ 'disabled' => true]);

             },

          ],
[ 
    'attribute' => 'pregunta', 
    'value'=>function($model){
        return substr($model->pregunta,0,50).'...';
    }
],
      
];
   
   
   
   
   ?>
        <?php 
       
        echo GridView::widget([
             'id' => 'grid-sumilla',
        'dataProvider' => (new \frontend\modules\sta\models\StaTestdetSearch())->searchByTest($model->codtest),
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
            'idGrilla'=>'sumilla',
            'family'=>'pink',
          'type'=>'POST',
           'evento'=>'click',
    'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 


 Pjax::end();
?>
    </div>
 <?php
 $url= Url::to(['agrega-pregunta','id'=>$model->codtest,'gridName'=>'sumilla','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar Pregunta'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Pregunta'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
?> 