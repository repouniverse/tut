<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
class m200104_000659_create_view_medidores extends viewMigration
{
    const NAME_VIEW='{{%vw_sigi_medidores}}';
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
         'a.*',//medidores a
         'b.nombre','b.direccion','b.codigo', //edificios b
         'e.numero','e.nombre as nombredepa', //Unidades e 
        //'c.numerocliente','c.codsuministro', //Suministros c
         'd.mes','d.flectura','d.lecturaant','d.delta', ///lecturas d
        
        ])
    ->from(['a'=>'{{%sigi_suministros}}'])->
     innerJoin('{{%sigi_lecturas}} d', 'd.suministro_id=a.id')->
     innerJoin('{{%sigi_unidades}} e', 'a.unidad_id=e.id')->
     innerJoin('{{%sigi_edificios}} b', 'e.edificio_id=b.id')
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
