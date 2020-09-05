<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200313_025720_create_table_flujo extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_flujo}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';
    // const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
    //  const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'codperiodo'=>$this->string(7)->notNull(), 
        'mes'=>$this->integer(2)->notNull(),
        'actividad'=>$this->integer(2)->notNull(),
            'gactividad'=>$this->integer(2)->notNull(),
        'esevento'=>$this->char(1)->append($this->collateColumn()), 
//          'talleres_id'=>$this->integer(11)->notNull(),
        'proceso'=>$this->string(40)->notNull()->append($this->collateColumn()), 
         'nsesiones'=>$this->integer(2)->notNull(),
        'detalle'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'codperiodo', static::NAME_TABLE_PERIODOS,'codperiodo');  
            } 
 }

public function safeDown()
    {
     $table=static::NAME_TABLE;
       if($this->existsTable($table)) {
            $this->dropTable($table);
        }

    }

}