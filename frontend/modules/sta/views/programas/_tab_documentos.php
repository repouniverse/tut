<?php
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
 use frontend\modules\sta\models\StaDocuAluSearch;
  use frontend\modules\sta\models\StaDocuAlu;
 use yii\widgets\Pjax;
 use yii\grid\GridView;
 use yii\helpers\Html;
  use yii\helpers\Url;
 //use frontend\modules\sta\models\ExamenesSearch;
?>
<div>
     <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <div class="row">     
         <?php //$url= \yii\helpers\Url::to(['agrega-documento','id'=>$model->id,'gridName'=>'grilla-docus','idModal'=>'buscarvalor']);
      ?>
       <?= \yii\helpers\Html::button('<span class="fa fa-book-reader"></span>   '.Yii::t('sta.labels', 'Agregar documento'), ['id'=>'btn-add-docus','class' => 'btn btn-warning'])?>
          
             </div>
            </div>
        </div>
    </div> 
    
   <?php Pjax::begin(['id'=>'grid_docu','timeout'=>false]); ?>
    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'id'=>'grid-docusx',
        'dataProvider' =>(new StaDocuAluSearch())->searchByTalleresdet($model->id),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{attach}{pdf}{grafico}',
               'buttons' => [
                  /* 'delete' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute($this->context->id.'/deletemodel-for-ajax');
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,'family'=>'pinke','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar']);
                            },*/
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
                        
                        'edit' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/programas/edita-docu','id'=>$model->id,'gridName'=>'grid_docu','idModal'=>'buscarvalor']);

                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-pencil"></span>', $url, ['class'=>'botonAbre']);
                            },
                        'pdf' => function ($url,$model) {
			   $url = \yii\helpers\Url::toRoute(['/sta/citas/report-inf-psicologico','id'=>$model->id,'gridName'=>'grid_docu','idModal'=>'buscarvalor']);
                              if($model->cita_id > 0 or $model->codocu=='104')
                              return \yii\helpers\Html::a('<span class="btn btn-warning fa fa-eye"></span>', $url, ['data-pjax'=>'0','target'=>'_blank']);
                              return '';
                             },
                        'grafico' => function ($url,$model) {
			   $url = \yii\helpers\Url::to(['/sta/citas/data-to-graph','id'=>$model->id]);
                              if($model->cita_id > 0 or $model->codocu=='104')
                              return \yii\helpers\Html::a('<span class="btn btn-success fa fa-hammer"></span>','#', ['id'=>$model->id,'title'=>$url,'family'=>'pinke']);
                              return '';
                             } 
                         
                    ]
                ],
            [
              'attribute' => 'codocu',
                  //'header'=>'Código',
              
                    ],
              [
              'attribute' => '',
                  'header'=>'Nombre',
               'format'=>'raw',
                'value' => function ($model) {
                    if($model->hasAttachments()){
                        //var_dump($model->testTalleres);
                        return Html::a($model->documento->desdocu, $model->files[0]->getUrl(), ['data-pjax'=>'0']);      
                     
                    }else{
                       return $model->documento->desdocu ;
                    }
                   },
                    ],
                 [
              'attribute' => 'cita_id',
               'format'=>'raw',
                'value' => function ($model) {
                       if(!empty($model->cita_id)){
                           $cadena= '<span style="font-size:14px; color:#ad5eb7; font-weight:700;">'.$model->cita->numero.'</span>';   
                           return Html::a($cadena,Url::toRoute(['/sta/citas/update','id'=>$model->cita_id]),['data-pjax'=>'0','target'=>'_blank']);
                       }else{
                           return '';
                       }
                     }
                    ],
                [
              'attribute' => 'detalle',
               //'format'=>'raw',
                'value' => function ($model) {
                    return substr($model->detalle,0,30).'...';
                   },
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
        ],
    ]); ?>
        <?php 
  /* echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBanuyucos',
            'idGrilla'=>'grid_docu',
            'family'=>'pinke',
            'type'=>'POST',
            'data'=> StaDocuAlu::dataGraph(),
           'evento'=>'click',
            'posicion'=>\yii\web\View::POS_END,
            //'foreignskeys'=>[1,2,3],
        ]); */
   ?>
    
    <?php 
  $this->registerJs("$('#btn-add-docus').on( 'click', function() { 
     // alert(this.id);
      $.ajax({
              url: '".Url::to([$this->context->id.'/agrega-docs'])."', 
              type: 'get',
              data:{id:".$model->id."},
              dataType: 'html', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(data) {
             

               $.pjax.reload({container: '#grid_docu',timeout:3000});
                   
                        }
                        });


             })", \yii\web\View::POS_READY);
?>
  
  
    <?PHP 
     $this->registerJs("$(\"div[id='grid_docu'] [family='pinke']\").on( 'click', function() { 
        var resulta;
   var identi=this.id;
  
 var promesa1= $.ajax({
          url : this.title,
          type : 'GET', 
          data : {}, 
          dataType: 'json', 
          success : function(json) {
                            resulta1=json['success'];
                                                  
                     }, //fin funcion success ajax 1
                    error : function(xhr,errmsg,err) {
                     console.log(xhr.status + ': ' + xhr.responseText);
                            } //fin de funcion  error ajax 1
        });//fin de ajax 1
  
 var promesa2=promesa1.then(function(){    
         $.ajax({
      url : 'http://export.highcharts.com/',
      type : 'POST', 
     data : resulta1, 
     success : function(data) {
      resulta2=data; 
               },
             error : function(xhr,errmsg,err) {
             console.log(xhr.status + ': ' + xhr.responseText);                                                                                }
           }); 
       });
       
    promesa2.then(function(){
 $.ajax({
            url : '".\yii\helpers\Url::to(['citas/report-inf-psicologico','id'=>0])."',
            type : 'GET',
            data :  {urlimagen: resulta2,identidad:identi},
            success: function(data2){
            $.pjax.reload({container: '#grid_docu',timeout:3000});
                 console.log(data2); // Debería imprimir {ajax2: true}
                        },
               error : function(xhr,errmsg,err) {
                         console.log(xhr.status + ': ' + xhr.responseText);
                      }
                 });
    });
    
});

", \yii\web\View::POS_READY);
    ?>  
    
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