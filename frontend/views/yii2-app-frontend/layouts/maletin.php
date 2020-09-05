<?php 
  use common\helpers\h;
  use yii\helpers\Html;
  use yii\widgets\Pjax;
  $sesion= h::session();
  //var_dump($sesion[h::SESION_MALETIN]);die();
 $cuantos=($sesion->has(h::SESION_MALETIN)?count($sesion[h::SESION_MALETIN]):0);
?>
<li class="dropdown notifications-menu">
                    <a href="#" id="maletin" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-briefcase"></i>
                   <?php Pjax::begin(['id'=>'mi_maletin','timeout'=>false]); ?>
                    <?php if($cuantos >0){ ?>
                        <div class="notificacion" ><?=$cuantos?></div>
                    <?php }?>
                     <?php Pjax::end(); ?>
                    </a>
    <ul class="dropdown-menu">
                        <li class="header"><?=yii::t('base.actions','Documentos en el maletín')?>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                   
                                      
                                              
                                           
                                           <?php echo Html::a(yii::t('base.actions','Eliminar Documentos'),'#',['id'=>'link_limpia_maletin']) ?>
                                        
                                        
                                    
                                </li>
                               
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#"><?=yii::t('base.actions','Ver todos...')?></a>
                        </li>
                    </ul>
                  
 </li>
        
 <?php $this->registerJs("
         
$('#link_limpia_maletin').on( 'click', function(){    
  $.ajax({ 
  
   method:'get',    
      url: '".\yii\helpers\Url::toRoute('/finder/flushmaletin')."',
   delay: 250,
 data: {},
             error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id, json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                              } 
                              $.pjax.defaults.timeout = false;  
                        $.pjax.reload({container: '#mi_maletin'});
                        
                        },
   cache: true
  })
 }
 
);",\yii\web\View::POS_END);  
  ?>