<?php
//use dosamigos\chartjs\ChartJs;
use frontend\modules\avisos\models\AvisosTablonSearch;
$modelos= AvisosTablonSearch::searchCurrents()->models;
use common\helpers\h;
  ?>
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr >
                      <th colspan="3"><p class="text-green"><span class="fa fa-volume-up"></span>      Tablón de anuncios</p></th> 
                    
                  </tr>
                  <tr>
                      <th>Usuario</th> 
                      <th>Mensaje</th> 
                      <th>Fecha de Publicación</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                   <?php 
                   $i=1;
           foreach($modelos as $modelo){ 
              
               ?>
              <tr> 
                  <td><?=h::getNameUserById($modelo->user_id)?><span class="fa fa-user"></span></td>
                  <td width="60%"><?=$modelo->texto?></td>
                    <td>
                     <?=substr($modelo->finicio,0,16)?>
                    </td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
 </div>   
<br>
<br>
<br>
<br>
<br>
<br>
<hr style="border: 1px dashed #4CAF50;" >

<br>
<br>

