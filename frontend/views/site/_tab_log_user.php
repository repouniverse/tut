<?php

 //use frontend\modules\sta\models\StaDocuAluSearch;
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;
  use common\models\audit\Activerecordlog;
  use common\models\Useraudit;
  USE common\helpers\h;
  use common\helpers\FileHelper;
 //use frontend\modules\sta\models\ExamenesSearch;
?>
<div>
   
    
   <?php Pjax::begin(['id'=>'grid_auditfinal']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-audiotdftr',
        'dataProvider' =>new \yii\data\ActiveDataProvider([
            'query' => common\models\audit\Activerecordlog::find()->andWhere(['username'=>h::userName()])->orderBy(['creationdate'=>SORT_DESC]),
            'pagination'=>['pageSize'=>20]
        ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
            
            
                                   [
              'attribute' => 'action',
                'value'=>function($model){
                    return $model::t($model->action);
                }
                    ],
            [
              'attribute' => 'metodo',
                'value'=>function($model){
                    return $model::t($model->metodo);
                }
                    ],
             
             
              
            [
              'attribute' => 'creationdate',
                
                    ],
            [
              'attribute' => 'model',
               'header'=>'Tabla',
                'value'=>function($model){
                    return FileHelper::getShortName($model->model);
                }
                
                    ],
              [
              'attribute' => 'field',
                 'header'=>'Campo Modif',
               ]
                 ,
              [
              'attribute' => 'oldvalue',
                 'header'=>'Antes',
                   'value'=>function($model){
                    return substr($model->oldvalue,0,10);
                  }
               ],
                            [
              'attribute' => 'newvalue',
                 'header'=>'Ahora',
                    'value'=>function($model){
                    return substr($model->newvalue,0,10);
                  }             
               ],
               [
              'attribute' => 'clave',
                 'header'=>'Id',
               ]
             
        ],
    ]); ?>
        
    <?php Pjax::end(); ?> 
    
 
</div>
