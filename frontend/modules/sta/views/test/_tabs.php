 <?php  
 use kartik\tabs\TabsX;
?>
<?php 
 echo TabsX::widget([
     'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
            'label' =>'<i class="glyphicon glyphicon-hourglass"></i> '.yii::t('base.names','Preguntas'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_test_detalle',['model'=>$model]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => true,
             'options' => ['id' => 'tnID3'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-education"></i> '. yii::t('base.names','Calificación'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_calificaciones',['model'=>$model]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'myy6nID4'],
        ],
        
    ],
]); 
    ?> 
