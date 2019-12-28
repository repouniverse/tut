<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
class m191213_160238_create_VW_test extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_test}}';
 
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
         'b.item','b.pregunta',
        'c.desdocu',
         'a.*',
        ])
    ->from(['b'=>'{{%sta_testdet}}'])->
     innerJoin('{{%sta_test}} a', 'a.codtest=b.codtest')
                ->innerJoin('{{%documentos}} c', 'a.codocu=c.codocu')
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
