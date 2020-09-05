<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
use yii;
class m200203_162348_create_view_kardexdepa  extends viewMigration
{
    const NAME_VIEW='{{%vw_sigi_kardexdepa}}';
    // const NAME_TABLE_UNIDADES='{{%sigi_unidades}}';
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
         'a.*',//TEMP SIGI LECTURA  a
         'b.nombre','b.numero','b.codtipo', //unidades b
        'c.desunidad',
         'x.nombre as nombreedificio','x.codigo',
        'd.identidad','sum(d.monto) as montodepa',
        ])
    ->from(['a'=>'{{%sigi_kardexdepa}}'])->
     innerJoin('{{%sigi_detfacturacion}} d', 'a.id=d.kardex_id')->
     innerJoin('{{%sigi_unidades}} b', 'a.unidad_id=b.id')->
   innerJoin('{{%sigi_edificios}} x', 'x.id=a.edificio_id')->
     innerJoin('{{%sigi_tipounidad}} c', 'c.codtipo=b.codtipo')->
       groupBy(['d.kardex_id'])         
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
    

