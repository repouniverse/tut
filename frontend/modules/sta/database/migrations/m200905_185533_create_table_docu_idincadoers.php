<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200905_185533_create_table_docu_idincadoers extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_eventosdet}}';
     const NAME_TABLE_ALUMNOS='{{%sta_alu}}';
     const NAME_TABLE_EVENTOS='{{%sta_eventos}}';
      const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
   const NAME_TABLE_TALLERES='{{%sta_talleres}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),  
        'eventos_id'=>$this->integer(3)->notNull(), 
        'talleresdet_id'=>$this->integer(11)->notNull(),
          'talleres_id'=>$this->integer(11)->notNull(),
        'codalu'=>$this->string(14)->notNull()->append($this->collateColumn()), 
        //'testdet_id'=>$this->integer(11)->notNull(),
         'asistio'=>$this->char(1)->notNull()->append($this->collateColumn()),
        'nombres'=>$this->string(60)->notNull()->append($this->collateColumn()), 
        'codalu'=>$this->string(14)->notNull()->append($this->collateColumn()), 
         'detalle'=>$this->text()->append($this->collateColumn()), 
        //'peso'=>$this->integer(3),
        'correo'=>$this->string(60)->append($this->collateColumn()), 
        'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()),
        'celulares'=>$this->string(18)->append($this->collateColumn()),
        'numerocita'=>$this->string(10)->append($this->collateColumn()),
        'libre'=>char(1)->notNull()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'eventos_id', static::NAME_TABLE_EVENTOS,'id');
  $this->addForeignKey($this->generateNameFk($table), $table,
              'codalu', static::NAME_TABLE_ALUMNOS,'codalu');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'talleres_id', static::NAME_TABLE_TALLERES,'id');
     $this->addForeignKey($this->generateNameFk($table), $table,
              'talleresdet_id', static::NAME_TABLE_TALLERESDET,'id');
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