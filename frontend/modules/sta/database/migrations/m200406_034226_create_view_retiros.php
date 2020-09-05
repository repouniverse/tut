<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use yii\db\Migration;
class m200406_034226_create_view_retiros extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_retiros}}';
 
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
        's.codperiodo','s.descripcion','s.numero',
        // 'c.codalu',
         'a.ap','a.am','a.nombres','a.codcar'])
    ->from(['b'=>'{{%sta_retiros}}'])->
     innerJoin('{{%sta_talleresdet}} c', 'c.id=b.tallerdet_id')->
     innerJoin('{{%sta_talleres}} s', 's.id=c.talleres_id')->   
     innerJoin('{{%sta_alu}} a', 'c.codalu=a.codalu'))->execute();
       
   }
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }
    
}
