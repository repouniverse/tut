<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191106_024629_create_table_base_presup extends baseMigration
{
   const NAME_TABLE='{{%sigi_base_presupuesto}}';
   //const NAME_TABLE_GRUPOS='{{%sigi_grupo_presupuesto}}';
    const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
    // const NAME_TABLE_CARGOS='{{%sigi_cargos}}';
     //const NAME_TABLE_CARGOSGRUPOEDIFICIO='{{%sigi_cargosgrupoedificio}}';
        const NAME_TABLE_CARGOSEDIFICIO='{{%sigi_cargosedificio}}';
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
        'edificio_id'=>$this->integer(11)->notNull(),
        /*
         * Adioconales para romper la normalizacion y mejorar
         * los selects , evitar complicarse con las vistas 
         */
        'cargo_id'=>$this->integer(11)->notNull(), //{{sigi_cargos}} master cargos tabla {{sigi_cargos}}
        'cargosgrupoedificio_id'=>$this->integer(11)->notNull(), // {{sigi_cargosgrupedificio}} master grupo por edificio
        'cargosedificio_id'=>$this->integer(11)->notNull(),//{{sigi_cargosedificio}}  master cargoedificio 
        /*
         * ojo
         */
        /*
         * CAMPOS HELPER PARA IMPORTAR SIN TENER QUE MEORIZARSE LOS IDS */
         
        'codgrupo_concepto'=>$this->char(3)->append($this->collateColumn()),
         ///'codedificio'=>$this->string(8)->append($this->collateColumn()),
        /* FINDE CAMPOS HELPER*/
        'codcargo'=>$this->char(4)->notNull()->append($this->collateColumn()),
        'codgrupo'=>$this->char(3)->notNull()->append($this->collateColumn()),
        'codigo'=>$this->string(10)->notNull()->append($this->collateColumn()),
        'descripcion'=>$this->string(100)->append($this->collateColumn()),
         'activo'=>$this->char(1)->append($this->collateColumn()),
        'ejercicio'=>$this->char(4)->append($this->collateColumn()),
        //'periodo'=>$this->char(4)->append($this->collateColumn()),
        'mensual'=>$this->decimal(9,3)->notNull(),
        'anual'=>$this->decimal(10,3)->notNull(),
        'restringir'=>$this->char(1)->append($this->collateColumn()),
         'acumulado'=>$this->decimal(10,3)->notNull(), //Romper la normalizacion
        'detalles'=>$this->text()->append($this->collateColumn()),
        ],$this->collateTable());
  
    /*$this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
    /* $this->addForeignKey($this->generateNameFk($table), $table,
              'cargo_id', static::NAME_TABLE_CARGOS,'id');*/
    /* $this->addForeignKey($this->generateNameFk($table), $table,
              'cargosgrupoedificio_id', static::NAME_TABLE_CARGOSGRUPOEDIFICIO,'id');
   */  $this->addForeignKey($this->generateNameFk($table), $table,
              'cargosedificio_id', static::NAME_TABLE_CARGOSEDIFICIO,'id');
     /* $this->addForeignKey($this->generateNameFk($table), $table,
              'codgrupo', static::NAME_TABLE_GRUPOS,'codigo');  */
    
    
    
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