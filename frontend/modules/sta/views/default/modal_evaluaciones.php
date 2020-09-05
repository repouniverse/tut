<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\sta\models\Test;
?>


    
    

            <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th><p class="text-green"><span class="fa fa-pie-chart"></span>  Avance por facultad </p></th> 
                    <th><?php
                       
                            
                             
                             echo Html::a('<p class="text-green"><span class="fa fa-paperclip"></span> Examenes tomados </p>', Test::findOne(['codtest'=>'TE0034'])->files[0]->getUrl());
                       ?></th> 
                  </tr>
                  <tr>
                      <th>Facultad</th> 
                     
                      <th>avance</th> 
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
                   $i=1;
                   foreach($facultades as $key=>$codfac){ 
              
                    ?>
              <tr> 
                  
                  <td><?=$codfac?></td>
                    <td>
                         <div class="sparkbar" data-color="#00a65a" data-height="20">
                             
                             <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= round($nNoEvaluados[$key]/$nevaluados[$key],2)*100?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?= round($nNoEvaluados[$key]/$nevaluados[$key],2)*100?>%</div>
                             </div>
                         </div>
                    </td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
    
    




    
