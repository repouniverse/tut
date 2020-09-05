<?php
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use kartik\grid\GridView;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\modules\sta\models\StaEventosSesiones;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use kartik\export\ExportMenu;

 // echo $this->render('_search', ['model' => $searchModel]);
 Pjax::begin(['id'=>'sesiones-pjax']); 
IF(!$model->isNewRecord && !$model->isClosed()){
 $url= Url::to(['crear-sesion','id'=>$model->id,'gridName'=>'sesiones-pjax','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar sesión'), ['href' => $url, 'title' => yii::t('sta.labels','Agregar Sesión'),'id'=>'btn_sesion', 'class' => 'botonAbre btn btn-warning']); 
} 
echo "<br>";
   $gridColumns=[
                [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{delete}{edit}{attach}{lock}',
               'buttons'=>[              
                    'delete' => function ($url,$model) {
                        if(!$model->hasAsistencias() && !$model->cerrado){
                            $url = Url::toRoute([$this->context->id.'/eligmina-alumno','id'=>$model->id]);
                              return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                          }else{
                             return '';
                        }
			   },
                       'edit' => function($url, $model) {
                          
                           $url= Url::to(['edita-sesion','id'=>$model->id,'gridName'=>'sesiones-pjax','idModal'=>'buscarvalor']);
                            return  Html::button('<span class="fa fa-pencil-alt"></span>', ['href' => $url, 'title' => yii::t('sta.labels','Editar'), 'class' => 'botonAbre btn btn-success']); 
                         
                            
                          }, 
                      'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
                             'isImage'=>false,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['png','jpg','jpeg','doc','docx','docxx','pdf','mp4','avi']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                                         
                          'lock' => function ($url,$model) {
                           if(!$model->cerrado){
                              $url = Url::toRoute([$this->context->id.'/close-sesion','id'=>$model->id]);
                              return Html::a('<span class="btn btn-warning fa fa-unlock"></span>', '#', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                          
                           }else{
                              $url = Url::toRoute([$this->context->id.'/unclose-sesion','id'=>$model->id]);
                              return Html::a('<span class="btn btn-info fa fa-undo"></span>', '#', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                           
                           }
                            
			   },               
                                         
                                         
                         ]
                    
                ],
                    
                  [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                      'detail' => function ($model, $key, $index, $column) {
                            return $this->render('_indicadores_sesiones', ['model'=>$model,'sesion_id' => $model->id]);
                            },
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],                             
                                   
      ['attribute'=>'secuencia',
          'format'=>'raw',
                'value' => function ($model) {
                     return '<span class="circulo-warning">'.$model->secuencia.'</span>';   
                    },
          ],
           
      ['attribute'=>'fecha',
          'value'=>function($model){
                return substr($model->fecha,0,16);
          }],
                               
       [
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=>[
                            'pjaxContainerId'=>'sesiones-pjax',
                            //'format' => Editable::FORMAT_BUTTON,
                            //'inputType' => Editable::INPUT_DROPDOWN_LIST,
                          //'data'=>['1'=>'Yes','0'=>'No'],  
                                            ],
            'attribute' => 'tema',
           // 'pageSummary' => 'Total',
            'vAlign' => 'left',
            'width' => '310px',
            'readonly' => false,
           //'data'=>['modelo'=>'mimodelo']
            
         ],
         [
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=>[
                            'pjaxContainerId'=>'sesiones-pjax',
                            //'format' => Editable::FORMAT_BUTTON,
                            'inputType' => Editable::INPUT_DROPDOWN_LIST,
                          'data'=> frontend\modules\sta\models\StaEventosSesiones::comboDataField('tipo'),  
                                            ],
            'attribute' => 'tipo',
           // 'pageSummary' => 'Total',
            'vAlign' => 'left',
            'width' => '100px',
            'readonly' => false,
           //'data'=>['modelo'=>'mimodelo']
            
         ],
        
     [
           
            'attribute' => 'Asist',
           'format'=>'raw',
          
            'value'=>function($model){
               return $model->nAsistencias().'     <i style="font-size:12px;"><span class="fa fa-users"></span></i>';                      
            }
         ],
                 [
           
            'attribute' => 'audit',
           'format'=>'raw',
            //'width' => '310px',
            'value'=>function($model){
               return common\widgets\auditwidget\auditWidget::widget(['model'=>$model]);                    
            }
         ],
          [
              'attribute' => '',
               'format'=>'raw',
                'value' => function ($model) {
                          $tieneFile= $model->countFiles();
                       IF($tieneFile>0){
                           return Html::a('<span class="btn btn-success glyphicon glyphicon-download"></span>', $model->files[0]->getUrl(), ['data-pjax'=>'0']);
                       }else{
                           return '';
                       }
                    },
                    ],
   ];?>
    
    <div style="overflow: auto;" >
    <?php
   echo GridView::widget([
       'id'=>'grillaxxx-grupo',
    'dataProvider'=>NEW \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\sta\models\StaEventosSesiones::find()->where(['eventos_id'=>$model->id])
    ]),
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
       //'summary'=>'',
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?>
    </div> 
<?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'srttrwidgetgruidBancos',
            'idGrilla'=>'sesiones-pjax',
       'otherContainers'=>['grupo-pjax'],
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>



    <?php Pjax::end(); ?>
   