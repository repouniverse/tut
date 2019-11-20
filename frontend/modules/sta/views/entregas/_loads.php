<?php
 use yii\helpers\Url;
 use yii\web\View;
 use frontend\modules\import\models\ImportLogCargamasivaSearch;
 USE common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="btn-group">
             <a id="link-carga" href="#" class="btn btn-warning btn-lg ">
                        <i class="glyphicon glyphicon-upload " aria-hidden="true"></i> <?=yii::t('sta.labels','Generar carga')?>
             </a>
             
             
     </div>
<div id="carga-temporal">
    
</div>
<?php 
  $this->registerJs("$('#link-carga').on( 'click', function() { 
      //alert(this.id);
      $.ajax({
              url: '".Url::toRoute(['ajax-create-upload'])."', 
              type: 'get',
              data:{id:".$model->id."},
              dataType: 'json', 
               error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                },  
              success: function(json) {  
                       $.pjax.reload({container: '#grilla-cargas'});
                        }
                        });
             })", View::POS_READY);
?>

<?php use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;


?>
     <?php Pjax::begin(['id'=>'grilla-cargas']); ?>
    <?= GridView::widget([
        'id'=>'grillax-cargax',
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            /* [
    'attribute' => 'ruta',
    'format' => 'raw',
    'value' => function ($model) {             
        return $model->urlFirstFile;
             },

          ], */ 
            [ 'attribute' => 'hasFile',
               'headerOptions' => ['style' => 'width:10%'],
                'format' => 'raw',
                'value' =>  function ($model, $key, $index, $column){
                        //$options=['width' => '40','height' => '42','class'=>"img-thumbnail"];
                        
        return ($model->hasAttachments())?Html::a('<span class="glyphicon glyphicon-paperclip"></span>',$model->urlFirstFile/*, $options*/):
            '<span class="glyphicon glyphicon-folder-open"></span>';
                       
              },
            ],
               
            'descripcion',
            'fechacarga',
            'tienecabecera',
            'duracion',
            'activo',                          
            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{attachCarga}{upload}{try}',
               'buttons' => [
                    'attachCarga' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','extension'=>'csv','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                        'try' => function ($url,$model) {
			    $url = Url::toRoute(['/import/importacion/import'/*'verdadero'=>'1','isJson'=>'si'*/]);
                             return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-cog"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=> \yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                        
                        'upload' => function ($url,$model) {
			    $url = Url::toRoute(['/import/importacion/import','verdadero'=>'1'/*,'isJson'=>'si'*/]);
                             return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-upload"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=> \yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                    ]
                ],
        ],
    ]); ?>



<div id="div_carga_reflejo"></div>


<?php
     echo linkAjaxGridWidget::widget([
           'id'=>'mifpapay67xfx',
            'idGrilla'=>'grillax-cargax',
            'divReplace'=>'div_carga_reflejo',
            'family'=>'holas',
             'mode'=>'html',
          'type'=>'GET',
           'evento'=>'click',
            //'foreignskeys'=>[1,2,3],
        ]); 
    ?>
 <?php Pjax::end(); ?>