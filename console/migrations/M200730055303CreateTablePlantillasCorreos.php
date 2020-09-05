<?php

namespace console\migrations;

use console\migrations\baseMigration;


class M200730055303CreateTablePlantillasCorreos extends baseMigration
{const NAME_TABLE='{{%plantilla_correos}}';
const NAME_TABLE_FACULTADES='{{%sta_facultades}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
        'programa_id' =>$this->integer(11),
        'codfac' =>$this->string(6)->notNull()->append($this->collateColumn()),       
        'masivo' =>$this->char(1)->append($this->collateColumn()),            
        'descripcion' =>$this->string(40)->notNull()->append($this->collateColumn()),            
        'disparador' =>$this->string(3)->notNull()->append($this->collateColumn()),            
        'titulo' =>$this->string(60)->notNull()->append($this->collateColumn()),            
        'cuerpo' =>$this->text()->notNull()->append($this->collateColumn()),
        'detalles' =>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
        
           }
      $this->addForeignKey($this->generateNameFk($table), $table,
              'codfac', static::NAME_TABLE_FACULTADES,'codfac');
         $this->putCombo($table, 'disparador',
            [
                'Cada vez que creas una cita',
                 'Cuando anticipas la cita',
                'Cuando reprogramas la cita',
                'Cuando envías un token para psicometría',
                ]);    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }

    }
}
