<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use common\helpers\FileHelper;
use yii;
class m200112_183254_creat_view_lecturastemp  extends viewMigration
{
    const NAME_VIEW='{{%vw_sigi_lecturas}}';
  public function safeUp()
    {
         /*$vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $comando= $this->db->createCommand(); 
        
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
         'a.id','a.mes','a.suministro_id','a.edificio_id','a.unidad_id','a.cuentaspor_id','a.codtipo','a.codedificio','a.anio','a.delta','a.codepa','a.user_id','a.lecturaant','a.lectura','a.flectura','a.delta','a.facturable',//TEMP SIGI LECTURA  a
         'b.codsuministro','b.numerocliente','b.codum', //SUMIISNTROS  b
         'c.numero','c.nombre',// UNIDADES C
        'd.codigo', ///EDIFICIOS D
        ])
    ->from(['a'=>'{{%sigi_lecturas}}'])->
     innerJoin('{{%sigi_suministros}} b', 'a.suministro_id=b.id')->
     innerJoin('{{%sigi_edificios}} d', 'b.edificio_id=d.id')->
     innerJoin('{{%sigi_unidades}} c', 'a.unidad_id=c.id') )->execute();
       yii::error($comando->getRawSql());*/
   }
public function safeDown()
    {
     
   /* $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }*/
    }
    
}