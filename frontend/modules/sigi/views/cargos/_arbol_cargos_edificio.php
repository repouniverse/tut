<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sigi-cargos-form">
    
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
                          'key'=>'78',
                          
                    ],
                     [
                       'title' => 'Category 2',
                      'lazy' => true, 
                          'key'=>'2',
                    ],
                [
                    'title' => 'Category 3',
                    'key'=>'3',
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
                                        }'),                
    */
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
    
   
<div class="box-body">
 

</div>
 
