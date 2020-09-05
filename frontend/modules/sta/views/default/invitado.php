<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="instedteall-content">
          

            <div class="box box-success box-solid">
                <div class="box-header">
                    <div class="col-md-12">
                        <h3 class="box-title"><?=  Yii::t('sta.labels', 'Seleccionar Facultad') ?></h3>
                    </div>
                </div>
                <!-- /.box-header -->

                <div id="install-form">
                    
                    
                      
                    <div class="col-md-12">
                         <div class="table-responsive">
                <table class="table no-margin">
                  
                  <tbody>
                      
                   <?php 
                   $i=1;
           foreach(frontend\modules\sta\models\Facultades::find()
                   ->where(['codfac'=>$facultades])->all() as $facultad){
               ?>
              <tr> 
                 
                  <td><?=$facultad->codfac?></td>
                    <td>
                     <?=Html::a($facultad->desfac,Url::to([$this->context->id.'/panel-inicio','codfac'=>$facultad->codfac]))?> 
                    </td>
              </tr> 
           <?php $i++;} ?>   
                      
               
                  
                  </tbody>
                </table>
              </div>
                        
                        
                    </div>
                     
                 <div class="box-footer">
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8 text-right">
                                 
                            </div>
                        </div>
                    </div>
           
                    
             </div>        
                    
                    
                    
                </div>

               
            </div>
        