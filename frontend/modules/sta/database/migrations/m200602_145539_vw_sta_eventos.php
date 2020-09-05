<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use yii\db\Migration;
class m200602_145539_vw_sta_eventos  extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_eventos}}';
 
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
         'b.*',
        'c.fechaprog','c.numero',
        'x.proceso','c.tipo',
        'd.status',
         's.codperiodo'])
    ->from(['b'=>'{{%sta_eventosdet}}'])->
     innerJoin('{{%sta_eventos}} c', 'c.id=b.eventos_id')->
     innerJoin('{{%sta_talleres}} s', 's.id=b.talleres_id')->
      innerJoin('{{%sta_talleresdet}} d', 'd.id=b.talleresdet_id')->
     innerJoin('{{%sta_flujo}} x', 'x.actividad=c.tipo')
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
