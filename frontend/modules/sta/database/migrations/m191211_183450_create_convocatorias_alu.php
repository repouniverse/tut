<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191211_183450_create_convocatorias_alu extends baseMigration
{
   const NAME_TABLE='{{%sta_convocatoria}}';
     const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
      //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
      public function safeUp()
    {
       $table=static::NAME_TABLE;
       $collate=$this->collateColumn();
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'talleresdet_id'=>$this->integer(11),
         'codfac'=>$this->string(8)->notNull()->append($collate),
        'canal'=>$this->char(3)->append($collate)->notNull(),
         'fecha'=>$this->char(10)->append($collate),
        'hora'=>$this->char(5)->append($collate),
        'resultado'=>$this->char(1)->append($collate),
        'detalle'=>$this->text()->append($collate),
        
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'talleresdet_id', static::NAME_TABLE_TALLERESDET,'id');    
     $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTAD,'codfac');
        $this->putCombo($table,'canal', ['CELULAR','FIJO','TERCERA PERSONA','CORREO','DIRECTAMENTE']);
    
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