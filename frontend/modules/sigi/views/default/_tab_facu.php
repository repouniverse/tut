
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use common\helpers\h;
use frontend\modules\sta\helpers\comboHelper;


$this->title = 'Profile';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
   

    

    <br>
   
       
             
            <?php /*h::user()->switchIdentity($identidad);*/ ?>
            
               
             
              <?php 
              $i=0;
              foreach($useredificios as $useredificio) { 
                // vr_dump($userfacultad->facultad->desfac);
                 // echo $userfacultad->facultad->desfac."<br>";
                  echo $this->render('checkboxfacultad',['i'=>$i,'form'=>$form,'useredificio'=>$useredificio]);
               $i++;
               } ?> 
             
            
            
        
 
</div>
    

