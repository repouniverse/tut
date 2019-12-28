<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191101_195637_create_table_cargos_edificio extends baseMigration
{
    const NAME_TABLE='{{%sigi_cargosedificio}}';
     const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
      const NAME_TABLE_CARGOS='{{%sigi_cargos}}';
       const NAME_TABLE_CARGOS_GRUPO_EDIFICIOS='{{%sigi_cargosgrupoedificio}}';
     /*const NAME_TABLE_BANCOS='{{%bancos}}';
     const NAME_TABLE_CLIPRO='{{%clipro}}';
     const NAME_TABLE_EDIFICIOS='{{%sigi_edificios}}';
   //const NAME_TABLE_ALUMNO='{{%sta_alu}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
        'id'=>$this->primaryKey(),
        'edificio_id'=>$this->integer(11)->notNull(),
        'cargo_id'=>$this->integer(11)->notNull(),
        'grupo_id'=>$this->integer(11)->notNull(),
        'tasamora'=>$this->decimal(6,3)->notNull(),
         'grupo_id'=>$this->integer(11)->notNull()->append($this->collateColumn()),  
        'plazovencimiento'=>$this->integer(3), 
        /*Si es masivo o alicado individualmente a un departamento */
         'individual'=>$this->char(1)->append($this->collateColumn()), 
        /*Si es para cobrar cada mes*/
        'regular'=>$this->char(1)->notNull()->append($this->collateColumn()), 
        /*Si se deduce de un contrato o prespuesto fijo o es un valor variable
         *ejemplo:  monto fijo contrato de ascensores 
         *          monto no fijo, consumo de agua  o luz
         **/        
        'emisorexterno'=>$this->char(1)->notNull()->append($this->collateColumn()), 
        'montofijo'=>$this->char(1)->notNull()->append($this->collateColumn()), 
        //en meses , mensual 1, bomestral 2 , semestral 6 
        'frecuencia'=>$this->string(3)->notNull()->append($this->collateColumn()),
        /*depende de lectura de un medidos*/
        'tipomedidor'=>$this->char(3)->append($this->collateColumn()), 
        ],$this->collateTable());
            $this->addForeignKey($this->generateNameFk($table), $table,
              'edificio_id', static::NAME_TABLE_EDIFICIOS,'id');
             $this->addForeignKey($this->generateNameFk($table), $table,
              'cargo_id', static::NAME_TABLE_CARGOS,'id');
             $this->addForeignKey($this->generateNameFk($table), $table,
              'grupo_id', static::NAME_TABLE_CARGOS_GRUPO_EDIFICIOS,'id');
             
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