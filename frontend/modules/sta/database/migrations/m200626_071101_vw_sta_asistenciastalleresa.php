<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use yii\db\Migration;
class m200626_071101_vw_sta_asistenciastalleresa extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_asistenciastaller}}';
 
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
          ' count(c.codaula) as asistencias',
        's.id',  's.secuencia', 'e.tipo','f.proceso',
        'e.numero' , 's.fecha','e.codfac','t.codperiodo','t.clase'
        ])
    ->from(['s'=>'{{%sta_eventos_sesiones}}'])->
     innerJoin('{{%sta_citas}} c', 'c.codaula=s.id')->
     innerJoin('{{%sta_eventos}} e', 'e.id=s.eventos_id')->
      innerJoin('{{%sta_flujo}} f', 'e.tipo=f.actividad')->
     innerJoin('{{%sta_talleres}} t', 'e.talleres_id=t.id')
      ->groupBy(['s.id', 'e.tipo','f.proceso' ,'s.secuencia',
 'e.numero','s.fecha','e.codfac','t.codperiodo','t.clase'])
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
