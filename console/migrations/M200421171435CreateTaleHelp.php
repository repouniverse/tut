<?php
namespace console\migrations;
use yii\db\Migration;
class M200421171435CreateTaleHelp extends baseMigration
{   
 const NAME_TABLE='{{%help_ayuda}}';
 //const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
       
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
        'tipo' =>$this->char(3)->append($this->collateColumn()),
        'user_id' =>$this->integer(6),
        'fecha_hora' =>$this->string(19)->notNull()->append($this->collateColumn()),            
        'problema' => $this->string(40)->append($this->collateColumn()),
         'ruta' => $this->string(40)->append($this->collateColumn()),
        'detalles' => $this->text()->append($this->collateColumn()),
         'respuesta' => $this->text()->append($this->collateColumn()),        
        'cerrado'=>$this->char(1),
        'satisfaccion'=>$this->char(1),
        'codocu' =>$this->string(4)->notNull()->append($this->collateColumn()), 
         'fecha_respuesta' =>$this->string(19)->notNull()->append($this->collateColumn()),
             ],$this->collateTable());
         
           }
    
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
