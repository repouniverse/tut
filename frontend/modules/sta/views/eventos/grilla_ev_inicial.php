<?php
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use yii\widgets\ActiveForm;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use kartik\export\ExportMenu;
?>
 <?php // echo $this->render('_search', ['model' => $searchModel]);
 Pjax::begin(['id'=>'grupo-pjax','timeout'=>false]); 

   $gridColumns=[
                [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{delete}{asistencia}{cita}{rescue}',
               'buttons' => [
                   
                    'rescue' => function ($url,$model) {
                        if(!empty($model->numerocita)){
                            $url = Url::toRoute(['/sta/citas/rescue-token','id'=>$model->codalu]);
                              return Html::a('<span class="btn btn-info glyphicon glyphicon-log-in"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                       
                        }else{
                             return '';
                        }
                           
                           
			 
			   }, 
                   
                   
                        'delete' => function ($url,$model) {
                        if(!$model->asistio && empty($model->numerocita) && !$model->libre){
                            $url = Url::toRoute([$this->context->id.'/elimina-alumno','id'=>$model->id]);
                              return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                       
                        }else{
                             return '';
                        }
			   }, 
                        'asistencia' => function ($url,$model) {
                        if(!$model->asistio && !$model->libre){
                            $url = Url::toRoute([$this->context->id.'/asiste-alumno','id'=>$model->id]);
                              return Html::a('<span class="btn btn-success glyphicon glyphicon-ok"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                      
                        }else{
                            return '';
                        }
                           
                            
			 
			     } ,
                         'cita' => function ($url,$model) {
                        if($model->asistio && empty($model->numerocita) && !$model->libre ){
                           $url = Url::toRoute([$this->context->id.'/crea-cita','id'=>$model->id]);
                              return Html::a('<span class="btn btn-warning  glyphicon glyphicon-dashboard"></span>', 'javascript:void();', ['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                        
                        }else{
                            return ''; 
                        }
                           
                           
			 
			    } ,
                               
                    ]
                ],
               [
                    'class' => 'yii\grid\CheckboxColumn',
                     'checkboxOptions' => function($model) {
                    return ['value' => $model->codalu];
                     }
                ],
      ['attribute'=>'numerocita',
          'format'=>'raw',
          'value'=>function($model){
                      $cade='';
              if(!empty($model->numerocita)) {
                  $regCita=frontend\modules\sta\models\Citas::findOne(['numero'=>$model->numerocita]);
                  if(!is_null($regCita)){
                    if($regCita->hasExamenes()){
                        if($regCita->hasPerformedTest()){
                       $cade= '<i style="color:#60a917;"><span class="fa fa-circle"></span></i>'; 
                     }else{
                        if($regCita->isTokenActive()){
                            $cade='<i style="color:orange;"><span class="fa fa-circle"></span></i>'; 
                       
                        }else{
                            
                           $cade='<i style="color:red;"><span class="fa fa-circle"></span></i>';  
                        }
                       
                     }
                    }else{
                       $cade='' ; 
                    }
                     
                  }
              } else{
                 $cade='' ;
              }     
             return $cade.Html::a($model->numerocita,Url::to(['/sta/eventos/edita-cita','id'=>$model->numerocita]),['target'=>'_blank','data-pjax'=>'0']);               
          }
      ],
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
       'codalu',
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
     // echo Html::beginForm(['/finder/addmaletin'],'post',['id'=>'miform']);
   //echo  Html::submitButton('<span class="fa fa-briefcase"></span>   '.Yii::t('sta.labels', ''), ['class' => 'btn btn-success']);
 /*echo \common\widgets\handbagwidget\handBagWidget::widget([
       'idForm'=>'miform', 'idGrilla'=>'mi_maletin'
              ]);  */    
   echo  ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
        'batchSize'=>20,
    'dropdownOptions' => [
        'label' => yii::t('sta.labels','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<hr>\n".grid::widget([
       'id'=>'grilla-grupo',
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
       //'summary'=>'',
    'responsive'=>true,
    'hover'=>true
       ]);
   ?>
  </div>
 <?PHP /*ECHO Html::endForm();*/?> 
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


