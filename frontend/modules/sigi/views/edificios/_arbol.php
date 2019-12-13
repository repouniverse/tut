<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\SigiCargos */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
$this->title = Yii::t('sigi.labels', 'Diagrama Jerárquico');
$this->params['breadcrumbs'][] = $this->title;
?>


    <h4><i class="fa fa-building"></i> <?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <div class="box-body">
  <?php 
  /* echo \yii\helpers\Json::encode([['title'=>'holas'],
                     ['title'=>'holas er 2','lazy'=>true,'children'=>['title'=>'pipo']],
                       ]);
   echo "<br><br><br>";
 echo \yii\helpers\Json::encode($arr_arbol);*/
  ?>
<?php echo yii2mod\tree\Tree::widget([
    'items'=>$arr_arbol,                   
            'clientOptions' => [
                'autoCollapse' => true,
                'lazyLoad'=>new \yii\web\JsExpression('
                    function(event, data) {
                 var node = data.node;
               var paragraph =data.node.tooltip; 
              // alert(data.node.tooltip);
                        var searchTerm = "_";
                      var indexOfFirst = paragraph.indexOf(searchTerm);
                        var indice=paragraph.substr(indexOfFirst+1);
                         var controlador=paragraph.substr(0,indexOfFirst);
                        // alert(indice);
                        // alert(controlador);
                        var myUrl="'.\yii\helpers\Url::toRoute([$this->context->id.'/']).'";
                           myUrl=myUrl+"/"+controlador;
                         //  alert(myUrl);
                // Issue an Ajax request to load child nodes
                     data.result = {                      
                        url: myUrl,
                    data: {key: node.key,identidad:indice}
                    }
                    }'),
                'clickFolderMode' => 3,
                /*'click'=>new \yii\web\JsExpression('
                    function(event, data){
                                     alert(data.node.tooltip); 
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
    
   

 

</div>
 
