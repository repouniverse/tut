<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php
    
    $ntotalPeriodo= \frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->count();
   //var_dump(\frontend\modules\sta\models\VwAlutaller::find()->completeFacultades()->andWhere(['codperiodo'=>$codperiodo])->createCommand()->getRawSql());die();
    //$ntotalFacultad= \frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo])->count();
   // $nPorPiscologo=\frontend\modules\sta\models\VwAlutaller::find()->andWhere(['codfac'=>$codfac,'codperiodo'=>$codperiodo,'codtra'=>$codtra])->count();
    //$porcAvancePsico=StaGrupoflujo::porcTotal($codperiodo,$codfac,$codtra)*100;
?>

    
    

            <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="2"><p class="text-green"><span class="fa fa-key"></span>      Distribución de Alumnos </p></th> 
                    
                  </tr>
                  <tr>
                      <th>Facultad</th> 
                      <th>Cantidad</th> 
                   
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
                   $i=1;
                   foreach($cantidades as $registro){ 
              
                    ?>
              <tr> 
                  
                  <td><?=$registro['codfac']?> <i style="color:#ccc;"><span class="fa fa-user"></span></i></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><?=$registro['nalumnos']?></div>
                    </td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
    
    




    
