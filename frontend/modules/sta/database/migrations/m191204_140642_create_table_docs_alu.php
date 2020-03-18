<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191204_140642_create_table_docs_alu extends baseMigration
{
   const NAME_TABLE='{{%sta_docu_alu}}';
     const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
      const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
      public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'talleresdet_id'=>$this->integer(11),
         'cita_id'=>$this->integer(11),
        'codocu'=>$this->char(3)->append($this->collateColumn())->notNull(),
        'descripcion'=>$this->string(30)->append($this->collateColumn()),
        'detalle'=>$this->text()->append($this->collateColumn()),
         'indi_altos'=>$this->text()->append($this->collateColumn()),
         'indi_riesgo_1'=>$this->text()->append($this->collateColumn()),
         'obs_entre'=>$this->text()->append($this->collateColumn()),
         'cuenta_buena'=>$this->text()->append($this->collateColumn()),
         'adecuado_nivel'=>$this->text()->append($this->collateColumn()),
         'indi_riesgo'=>$this->text()->append($this->collateColumn()),
        'sugerencias'=>$this->text()->append($this->collateColumn()),
        'metas'=>$this->text()->append($this->collateColumn()),
        'indi_encont'=>$this->text()->append($this->collateColumn()),
        'conclu_acad'=>$this->text()->append($this->collateColumn()),
         'metas_acad'=>$this->text()->append($this->collateColumn()),
         'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()),
        
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'talleresdet_id', static::NAME_TABLE_TALLERESDET,'id');
    $this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');
     $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTAD,'codfac');
       
   
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