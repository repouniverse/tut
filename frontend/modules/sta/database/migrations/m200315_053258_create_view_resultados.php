<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use yii\db\Migration;
/**
 * Class m200315_053258_create_view_resultados
 */
class m200315_053258_create_view_resultados extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_resultados}}';
 
    public function safeUp()
    {
         $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $comando= $this->db->createCommand(); 
        
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
         'd.ap as aptutor',
         'd.am as amtutor',
         'd.nombres as nombrestutor',
        's.codperiodo','s.descripcion','s.numero','s.codfac',
        'b.codalu',
         'c.ap','c.am','c.nombres','c.codcar',
         'a.numero as numerocita','a.fechaprog',
        'e.codtest',
'x.puntaje_total','x.indicador_id','x.puntaje_total',
        'x.percentil','x.categoria','x.interpretacion',
        'i.nemonico','i.nombre','i.bateria'
        ])
    ->from(['b'=>'{{%sta_talleresdet}}'])->
     innerJoin('{{%sta_alu}} c', 'c.codalu=b.codalu')->
     innerJoin('{{%sta_talleres}} s', 's.id=b.talleres_id')->          
      innerJoin('{{%sta_citas}} a', 'a.talleresdet_id=b.id')->
      innerJoin('{{%trabajadores}} d', 'd.codigotra=a.codtra')->
     innerJoin('{{%sta_examenes}} e', 'a.id = e.citas_id')->
     innerJoin('{{%sta_resultados}} x', 'x.examen_id=e.id')-> 
      innerJoin('{{%sta_testindicadores}} i', 'i.id=x.indicador_id')       
                )->execute();
       
       
   }
public function safeDown()
    {
     
    $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }
    
}
