<?php
namespace common\widgets\handbagwidget;
use yii\base\Widget;
use yii;
use yii\web\View;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
class handBagWidget extends Widget
{
   const OP_PRIMERA=1;
   const OP_SEGUNDA=2;
    const OP_TERCERA=2;
    public $id;
   public $idGrilla=null; //Id del sectro Pjax par arefrescar luego de la accion 
    public $idForm=null; //NOMDE O ID DEL FOMRULARIO A hahacer submit
   public $idModal=null;    //id de la ventana MOdal
   public $url=null; //Direccion a la cual se redirecciona 
   public $title='Guardar';
   public $clase_modelo=null;
   public $preserve=true; //Preservar los items
   
    
    public function init()
    {
        
       /* if($this->url===NULL)
        throw new InvalidConfigException('The "url" property is Null.');
      */
         if($this->idForm===NULL)
        throw new InvalidConfigException('La propiedad  "idForm" es nula.');
       
        if($this->idGrilla===NULL)
        throw new InvalidConfigException('La propiedad  "idGrilla" es nula.');
       /* if($this->idModal===NULL)
        throw new InvalidConfigException('The "idModal" property is Null or not Valid');
     */
        parent::init();
    }

    public function run()
    {
        
        echo Html::hiddenInput('preserve', $this->preserve);
        echo Html::hiddenInput('clase',$this->clase_modelo);
        echo  Html::submitButton('<span class="fa fa-briefcase"></span>   '.Yii::t('sta.labels', ''), ['class' => 'btn btn-success']);
        $this->makeJs();
        
        
    }
  
     
  private function makeJs(){
   $cadenaJs="jQuery(document).ready(function($) {
       $('#".$this->idForm."').submit(function(event) {
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
          
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                 error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                    $.pjax.reload({container: '#".$this->idGrilla."', async: false});
                        
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                       
            });
            
        
        });
    });";
   $this->getView()->registerJs($cadenaJs, \yii\web\View::POS_HEAD);
  } 
}

?>