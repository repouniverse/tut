<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m200213_212900_create_table_eventos extends baseMigration
{
      //const NAME_TABLE_FACULTAD='{{%sta_facultades}}';
    const NAME_TABLE='{{%sta_eventos}}';
     const NAME_TABLE_TALLERES='{{%sta_talleres}}';
     const NAME_TABLE_TRABAJADORES='{{%trabajadores}}';
    // const NAME_TABLE_ALUMNOS='{{%sta_alu}}';
      //const NAME_TABLE_FACULTAD='{{%sta_test}}';
   //const NAME_TABLE_ALUMNO='{{%sta_alu}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(), 
        'talleres_id'=>$this->integer(11)->notNull(),
         'descripcion'=>$this->string(40)->notNull()->append($this->collateColumn()),         
        'numero'=>$this->string(8)->notNull()->append($this->collateColumn()), 
         'fechaprog'=>$this->string(19)->notNull()->append($this->collateColumn()), 
        'tipo'=>$this->char(1)->notNull()->append($this->collateColumn()), 
        'codtra'=>$this->char(6)->notNull()->append($this->collateColumn()),
        'codfac'=>$this->string(8)->notNull()->append($this->collateColumn()), 
        'semana'=>$this->integer(2)->notNull()->comment('indincador de la semna, sirve para agrupar eventos en una convocatoria'), 
        'detalle'=>$this->text()->append($this->collateColumn()),
        
//'testdet_id'=>$this->integer(11)->notNull(),
        // 'valor'=>$this->integer(3)->notNull(),
        
       // 'peso'=>$this->integer(3),
        
        //'tiporespuesta'=>char(2)->notNull()->append($this->collateColumn()),
        ],$this->collateTable());
   $this->addForeignKey($this->generateNameFk($table), $table,
              'talleres_id', static::NAME_TABLE_TALLERES,'id');
 $this->addForeignKey($this->generateNameFk($table), $table,
              'codtra', static::NAME_TABLE_TRABAJADORES,'codigotra');
    
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