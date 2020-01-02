<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191130_053049_create_table_detfacturacion extends baseMigration
{
    const NAME_TABLE='{{%sigi_detfacturacion}}';
   const NAME_TABLE_FACTURACION='{{%sigi_facturacion}}';
   const NAME_TABLE_CONCEPTO_EDIFICIO='{{%sigi_cargosedificio}}';
   
     
    public function safeUp()
    {
      
    }

public function safeDown()
    {
     
    }

}