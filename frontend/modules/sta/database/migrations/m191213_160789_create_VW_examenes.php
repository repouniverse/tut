<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
class m191213_160789_create_VW_examenes extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_examenes}}';
 
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
          's.id as idexamen','s.citas_id','s.detalles','s.codfac','s.user_id','s.virtual','s.fnotificacion',
          'k.id','k.test_id','k.examenes_id','k.valor',
         'b.item','b.pregunta','b.grupo',
        'c.desdocu',
         'a.codtest', 'a.descripcion', 'a.opcional', 'a.codocu', 'a.codtest', 'a.reporte_id', 'a.nveces',
        ])
    ->from(['k'=>'{{%sta_examenesdet}}'])->
   innerJoin('{{%sta_examenes}} s', 's.id=k.examenes_id')->
   innerJoin('{{%sta_testdet}} b', 'b.id=k.test_id')->
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
