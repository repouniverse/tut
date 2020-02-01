<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
class m191123_160840_create_view_citas extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_citas}}';
 
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
         'd.ap as aptutor',
         'd.am as amtutor',
         'd.nombres as nombrestutor',
        's.codperiodo','s.descripcion','s.numero',
        'b.codalu',
         'c.ap','c.am','c.nombres','c.codcar','c.id as idalumno',
         'a.*',
        ])
    ->from(['b'=>'{{%sta_talleresdet}}'])->
     innerJoin('{{%sta_alu}} c', 'c.codalu=b.codalu')->
     innerJoin('{{%sta_talleres}} s', 's.id=b.talleres_id')->          
      leftJoin('{{%sta_citas}} a', 'a.talleresdet_id=b.id')->
      leftJoin('{{%trabajadores}} d', 'd.codigotra=a.codtra')
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
