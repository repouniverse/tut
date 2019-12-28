<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
class m191217_165538_creatview_papeleta extends viewMigration
{
    const NAME_VIEW='{{%vw_sigi_papeletas}}';
  public function safeUp()
    {
         $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $comando= $this->db->createCommand(); 
        
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
         'a.*',
         'b.nombre','b.direccion','b.codigo', //edificios b
         'c.desdocu', ///documentos c
        'd.despro','d.rucpro',//clipro d
        'e.numero','e.nombre as nombredepa', //Unidades e 
        'f.descripciongrupo','f.descargo' //vw_sigi_colectores 
        ])
    ->from(['a'=>'{{%sigi_cuentaspor}}'])->
     innerJoin('{{%sigi_edificios}} b', 'a.edificio_id=b.id')->
     innerJoin('{{%documentos}} c', 'a.codocu=c.codocu')->          
      innerJoin('{{%clipro}} d', 'a.codpro=d.codpro')->
     innerJoin('{{%vw_sigi_colectores}} f', 'a.colector_id=f.idcolector')->
      leftJoin('{{%sigi_unidades}} e', 'a.unidad_id=e.id')
                )->execute();
       
   }
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }
    
}
