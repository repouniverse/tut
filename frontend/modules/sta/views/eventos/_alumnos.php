<?php
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use kartik\grid\GridView;
use yii\widgets\Pjax;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use kartik\export\ExportMenu;
  use frontend\modules\sta\models\StaEventosdet AS detalle;

 // echo $this->render('_search', ['model' => $searchModel]);


   $gridColumns=[
                [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                    
                 
                    
            'template' => '{delete}{asistencia}',
               'buttons'=>[
                
                   
                    'asistencia' => function ($url,$model) {
                        $secuencia=$model->nextSesion();
                          if(in_array($secuencia,[detalle::SESION_FINAL_LIBRE,detalle::SESION_INICIO_LIBRE])){
                             IF(h::userId()==7){
                                 return $secuencia;
                             }
                              return '';
                          }else{
                            $url = Url::toRoute([$this->context->id.'/asiste-alumno-con-cita','id'=>$model->id]);
                              return Html::a('<span class="btn btn-success">'.$secuencia.'</span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                           
                          }
                            
			   },                  
                                   
                     'delete' => function ($url,$model) {
                        if(!$model->asistio && !$model->libre){
                            $url = Url::toRoute([$this->context->id.'/elimina-alumno','id'=>$model->id]);
                              return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                          }else{
                             return '';
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
                     'detailUrl' =>Url::toRoute([$this->context->id.'/view-ajax-citas']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
        ['attribute'=>'codcar',
          
          ],
        'codalu',
      ['attribute'=>'nombres',
          'value'=>function($model){
          return $model->nombres;
          }
          ],
       [
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=>[
                            'pjaxContainerId'=>'grupo-pjax',
                            //'format' => Editable::FORMAT_BUTTON,
                            //'inputType' => Editable::INPUT_DROPDOWN_LIST,
                          //'data'=>['1'=>'Yes','0'=>'No'],  
                                            ],
            'attribute' => 'correo',
           // 'pageSummary' => 'Total',
            'vAlign' => 'left',
            'width' => '310px',
            'readonly' => false,
           //'data'=>['modelo'=>'mimodelo']
            
         ],
         [ 'attribute' => 'valido',
           'format'=>'raw',
           'value'=>function($model) use ($validator) {
             if($validator->validate($model->correo)){
                return '<i style="font-size:16px;color:green;"><span class="fa fa-check-square"></span></i>'; 
             }else{
                 return '<i style="font-size:16px;color:red;"><span class="fa fa-ban"></span></i>';
             }
             
           }
         ],
              [
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=>[
                            'pjaxContainerId'=>'grupo-pjax',
                            //'format' => Editable::FORMAT_BUTTON,
                            //'inputType' => Editable::INPUT_DROPDOWN_LIST,
                          //'data'=>['1'=>'Yes','0'=>'No'],  
                                            ],
            'attribute' => 'celulares',
           // 'pageSummary' => 'Total',
            'vAlign' => 'left',
            'width' => '300px',
            'readonly' => false,
           //'data'=>['modelo'=>'mimodelo']
            
         ],
       //'celulares',
       
       //'asistio',
       //'libre',
       
       [
    'attribute' => 'asistio',
    'header'=>'Asist',
    'format' => 'raw',
          // 'filter'=>[''=>'No asistio','1'=>'Asistió'],
    'value' => function ($model) {
        return Html::checkbox('asistio[]', $model->asistio, [ 'disabled' => true]);

             },

          ],
     [
    'attribute' => 'libre',
    'header'=>'Libre',
    'format' => 'raw',
    'value' => function ($model) {
        return Html::checkbox('libre[]', $model->libre, [ 'disabled' => true]);

             },

          ],  
      
   ];?>
    
    <div style="overflow: auto;" >
    
  <?php
     Pjax::begin(['id'=>'grupo-pjax', 'timeout'=>false]);      
   echo  ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
        'batchSize'=>20,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n". GridView::widget([
       'id'=>'grilla-grupo',
    //'pjax'=>true,    
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
       //'summary'=>'',
    'responsive'=>true,
    'hover'=>true
       ]);
   ?>
  </div>
<?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grupo-pjax',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>

    <?php Pjax::end(); ?>