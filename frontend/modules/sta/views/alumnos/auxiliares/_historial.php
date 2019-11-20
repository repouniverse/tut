<?php
$i=1;
foreach($dataProviders as $periodo=> $dataProvider){  
  
    echo $this->render('_cursos_por_alumno_periodo',
            ['dataProvider'=>$dataProvider,'codperiodo'=>$periodo,'i'=>$i]);
    $i++;
}

?>