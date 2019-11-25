<?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;
 use frontend\modules\sta\models\ExamenesSearch;
?>
<div>
     <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="row">     
         <?php $url= \yii\helpers\Url::to(['agrega-examen','id'=>$model->id,'gridName'=>'grilla-examenes','idModal'=>'buscarvalor']);
      ?>
       <?= \yii\helpers\Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Agregar evaluacion'), ['href' => $url,'id'=>'btn-add-test','class' => 'botonAbre btn btn-warning'])?>
          
             </div>
            </div>
        </div>
    </div> 
    
   <?php Pjax::begin(['id'=>'grilla-examenes']); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-test',
        'dataProvider' =>(new ExamenesSearch())->searchByTaller($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{attach}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('sta.labels', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                        'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                        'edit' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute([$this->context->id.'/edita-examen','id'=>$model->id,'gridName'=>'grilla-examenes','idModal'=>'buscarvalor']);

                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            } 
                    ]
                ],
            'codtest',
              [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                    if($model->testTalleres->hasAttachments()){
                        //var_dump($model->testTalleres);
                        return Html::a($model->test->descripcion, $model->testTalleres->files[0]->getUrl(), ['pjax'=>'0']);      
                     
                    }else{
                       return $model->test->descripcion ;
                    }
                   },
                    ],
                [
              'attribute' => 'detalles',
               //'format'=>'raw',
                'value' => function ($model) {
                    return substr($model->detalles,0,30).'...';
                   },
                    ],
                [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                          $tieneFile= $model->countFiles();
                       IF($tieneFile>0){
                           return Html::a('<span class="btn btn-success glyphicon glyphicon-download"></span>', $model->files[0]->getUrl(), ['pjax'=>'0']);
                       }else{
                           return '';
                       }
                    },
                    ],
        ],
    ]); ?>
        
    <?php Pjax::end(); ?> 
    
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>