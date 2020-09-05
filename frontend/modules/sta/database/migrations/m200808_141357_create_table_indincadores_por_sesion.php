<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200808_141357_create_table_indincadores_por_sesion extends baseMigration {
  //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_indisesiones}}';
   const NAME_TABLE_SESIONES='{{%sta_eventos_sesiones}}';
   const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
    const NAME_TABLE_INDICADORES='{{%sta_testindicadores}}';
      //const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
  // const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'codfac'=>$this->string(8)->notNull(), 
         'sesiones_id'=>$this->integer(11)->notNull(),
        'eventos_id'=>$this->integer(11)->notNull(),
         'indicador_id'=>$this->integer(11)->notNull(),
        'detalles'=>$this->text()->append($this->collateColumn()), 
         'relevancia'=>$this->integer(1),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'sesiones_id', static::NAME_TABLE_SESIONES,'id'); 
   $this->addForeignKey($this->generateNameFk($table), $table,
              'eventos_id', static::NAME_TABLE_EVENTOS,'id'); 
   $this->addForeignKey($this->generateNameFk($table), $table,
              'indicador_id', static::NAME_TABLE_INDICADORES,'id'); 
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