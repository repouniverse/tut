<?php use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\models\StaVwCitas;

?>


    
   <br>
<p class="text-green"><b><span class="fa fa-list-ul"></span><?='      '.yii::t('sta.labels','Distribución de horarios')?></p></b>


    <?php Pjax::begin(['id'=>'grilla-rangos']); ?>
   
    <?php 
     echo GridView::widget([
        'dataProvider' => $dataProviderRangos,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}',
                'buttons' => [
                   
                         'edit' => function ($url,$model) {
			    $url= Url::to(['edit-rango','id'=>$model->id,'gridName'=>'grilla-rangos','idModal'=>'buscarvalor']);
                             //echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
                            return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            }
                    ]
                ],
            'dia',
             [
                 'attribute'=>'nombredia',
                 'format'=>'raw',
                    'value' => function ($model, $key, $index, $column) {
                        $formato=($model->activo)?'  <i style="color:#3ead05;font-size:12px"><span class="glyphicon glyphicon-ok"></span></i>':
                        '  <i style="color:red;font-size:12px"><span class="glyphicon glyphicon-remove"></span></i>';
                        return $model->nombredia.$formato;
                        },
                 
                 ],
             'tolerancia',
            [
                'attribute'=>'psico',
                'header'=>'Psicólogo',
                 'value'=>function($model){
                   if(!empty($model->codtra)){
                       return $model->trabajadores->fullName();
                   }else{
                      return  ''; 
                   }
                   
                        
                 }
            ],                 
            'hinicio',
             'hfin',
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>


  
       
<?php
/* $url= Url::to(['edit-rango','id'=>$model->id,'gridName'=>'grilla-rangos','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Modificar Rangos'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Tutor'),'id'=>'btn_contacts', 'class' => 'botonAbre btn btn-success']); 
*/?> 
<br>
<p class="text-green"><b><span class="fa fa-list-ul"></span><?='      '.yii::t('sta.labels','Carga de atenciones')?></p></b>

<?php 


    echo GridView::widget([
        'dataProvider' =>new \yii\data\ArrayDataProvider([
            'allModels'=> StaVwCitas::find()->select([
                ' count(talleresdet_id) as cantidad','codtra' , 'codfac' ,
'aptutor','nombrestutor','proceso'])->andWhere([
    'asistio'=>'1',
    'codfac'=>$model->codfac
        ])->
  groupBy(['codtra' , 'codfac','aptutor','nombrestutor','proceso'])->
  orderBy(['codfac'=>SORT_ASC,'codtra'=>SORT_ASC,'proceso'=>SORT_ASC,])->asArray()->all()
        ]
                ),
         'summary' => '',
         'tableOptions'=>['class'=>'table no-margin'],
       // 'filterModel' => $searchModel,
        'columns' => [
              ['attribute'=>'#Citas Atendidas',
                  'value'=>function($model){
                        return $model['cantidad'];
                     }
                     ],
            'codtra',
            //'aptutor',
            'proceso',
            'nombrestutor'
             
          
        ],
    ]);  

?>
 

