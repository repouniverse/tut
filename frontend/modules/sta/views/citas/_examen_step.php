<?php
// use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 //use yii\widgets\ActiveForm;
 use yii\helpers\Html;
  use yii\helpers\Url;
 // use kartik\editable\Editable;
 use frontend\modules\sta\models\VwStaExamenesSearch;

?>


<h5><?=$mensaje?></h5>

<?php echo $this->render('calificaciones',['codexamen'=>$codexamen]); ?>
<div class="progress"></div>

<?php Pjax::begin(['id'=>'grilla-examen_'.$codexamen]); ?>
   
 <div style='overflow:auto;'>
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        //'id'=>'grid-test',
        //'responsive'=>true,
        'dataProvider' =>(new VwStaExamenesSearch())->searchByExamenCode($model->id,$codexamen),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                
            ['attribute'=>'codtest',
                'header'=>'Prueba'
                ],
              'item',
            [ 'attribute' => 'pregunta', 'contentOptions' => [ 'style' => 'width: 40%;' ], ], 
             /*[
                        'class' => 'kartik\grid\EditableColumn',
                       
                        'editableOptions'=>[
                             'asPopover'=>false, 
                             'pjaxContainerId'=>'grilla-examen_'.$codexamen,
                            ///'model'=>NEW \frontend\modules\sta\models\Alumnos(),                            
                            //'pjaxContainerId'=>'manita',
                            //'format' => Editable::FORMAT_BUTTON,
                            'inputType' => Editable::INPUT_CHECKBOX_LIST,
                             'data'=>['1'=>'Siempre','2'=>'Nunca','3'=>'casi'], 
                                            ],
                        'attribute' => 'valor',
                            //'pageSummary' => 'Total',
                            'vAlign' => 'middle',
                            //'width' => '50px',
                ],*/
                [
              'attribute' => 'valor',
               'format'=>'raw',
                'value' => function ($model)use($codexamen,$calificaciones) {
                    $url = \yii\helpers\Url::toRoute([$this->context->id.'/arregla-for-ajax']);                       
                    //return \yii\helpers\Html::a($model->id,'#',['id'=>$model->id,'title'=>$url,'family'=>'holas']);
                   return \yii\helpers\Html::radioList('radio_'.$codexamen.'_'.$model->id,
                           null,
                           /*['1'=>'Uno','2'=>'Dos','3'=>'Tres'],*/
                          array_combine(array_keys($calificaciones),array_keys($calificaciones)),
                           ['separator'=>'.......','id'=>'radio_'.$codexamen.'_'.$model->id,'title'=>'','family'=>'holas']
                           );
                   },
                    ],
               
        ],
    ]); ?>
     </div>    

    

<?php 
  /* echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-examen_'.$codexamen,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
           'posicion'=> \yii\web\View::POS_END
           
        ]); */
   ?>
<?PHP
$divPjax='grilla-examen_'.$codexamen;
$family='holas';
$url=Url::to([$this->context->id.'/respuesta-examen']);
$cadenaJs="
 $('div[id=\"".$divPjax."\"] [family=\"".$family."\"] :radio').on( 'click', function() {    
//alert(this.value);
var mycadena = this.name;
var myarr = mycadena.split('_');
var myidentidad=myarr[2];
 $.ajax({
              url: '".$url."',
              type: 'get',
              data:{identidad:myidentidad,valor:this.value,npreg:".$numeroPreguntas."} ,
              dataType: 'html',
               error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              
               success: function(html) {
              $('.progress').html( html );
             // alert($('.progress').html());
            // alert($('.progress-bar-danger').attr('aria-valuenow'));
             var porcentaje=$('.progress-bar-danger').attr('aria-valuenow');
             if(porcentaje >= 100){
             $('#btn-conf-examen').removeAttr('disabled');
               
             }

                        }
                   
                       
                        });




        })";
       
  // echo  \yii\helpers\Html::script($stringJs);
   $this->registerJs($cadenaJs);
   // $this->getView()->registerJs($stringJs2);
         

?>
    <?php Pjax::end(); ?> 