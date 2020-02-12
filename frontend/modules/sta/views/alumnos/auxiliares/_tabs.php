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
            'label' =>'<i class="glyphicon glyphicon-hourglass"></i> '.yii::t('base.names','Historial'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_historial',['dataProviders'=>$dataProviders,'codperiodo'=>$codperiodo]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => true,
             'options' => ['id' => 'tnID3'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-education"></i> '. yii::t('base.names','ORCE'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_orce',[]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'myy6nID4'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-file"></i> '. yii::t('base.names','Informes'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('/programas/_tab_documentos',['model'=>$modelTallerdet]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'myveaw3D4'],
        ],
      [
            'label' =>'<i class="glyphicon glyphicon-calendar"></i> '. yii::t('base.names','Programa '.$codperiodo), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_programa',['modelTallerdet'=>$modelTallerdet,'examenes'=>$examenes,'citasArray'=> $citasArray,]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'myoyvf577dID4'],
        ],
        [
            'label' =>'<i class="glyphicon glyphicon-pencil"></i> '. yii::t('base.names','Tutor Académico'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_academica',['modelTallerdet'=>$modelTallerdet]),
//'content' => $this->render('detalle',['form'=>$form,'orden'=>$this->context->countDetail(),'modelDetail'=>$modelDetail]),
            'active' => false,
             'options' => ['id' => 'academi8946'],
        ],
    ],
]); 
    ?> 
