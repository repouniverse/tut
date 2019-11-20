<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-cargos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('sigi.labels', 'Guardar'), ['class' => 'btn btn-success']) ?>
            
<?php echo yii2mod\tree\Tree::widget([
    /*
     * Buscar FancyTree en internet
     */
            'items' => [
                      [
                       'icon'=>'fa fa-building',
                          'title' => '<A  HREF="EWEWE" class="botonAbre">Category 1</A>',
                      'lazy' => true ,
                        'OTHER'=>'holis',
                          
                    ],
                     [
                       'title' => 'Category 2',
                      'lazy' => true 
                    ],
                [
                    'title' => 'Category 3',
                    'children' => [
                        [
                            'title' => 'Category 3.1',
                        ],
                        [
                            'title' => 'Category 3.2',
                            'children' => [
                                [
                                    'title' => 'Category 3.2.1',
                                ]
                            ],
                            'folder' => true,
                        ],
                    ],
                    'folder' => true,
                ],

            ],
            'clientOptions' => [
                'autoCollapse' => true,
                'lazyLoad'=>new \yii\web\JsExpression('
                    function(event, data) {
                 var node = data.node;
                // Issue an Ajax request to load child nodes
                     data.result = {
                        url: "'.\yii\helpers\Url::toRoute([$this->context->id.'/apis']).'",
                    data: {key: node.key}
                    }
                    }'),
                'clickFolderMode' => 3,
               /* 'click'=>new \yii\web\JsExpression('
                    function(event, data){
                                     alert(data.node); 
                                        }'),      */            
    
                'activate' => new \yii\web\JsExpression('
                        function(node, data) {
                              node  = data.node;
                              // Log node title
                              console.log(node.title);
                        }
                '),
            ],
        ]); ?>
            </div>
        </div>
    </div>
      <div class="box-body">
    
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codcargo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descargo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'esegreso')->checkBox([]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'regular')->checkBox([]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
