<?php
namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
use yii\db\Migration;
class m200511_123449_view_informes_alumnos extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_informes}}';
 
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
          'f.proceso',
         't.codperiodo',
      //  's.codperiodo','s.descripcion','s.numero','s.codfac',
        'b.codalu',
         'c.ap','c.am','c.nombres','c.codcar','c.correo',
        's.id','s.codocu','s.codfac', 's.descripcion', 's.status','s.impreso','s.ultimamod',
        'a.numero as numerocita','a.fechaprog','a.flujo_id',
          'x.desdocu',
       // 'e.codtest',
//'x.puntaje_total','x.indicador_id','x.puntaje_total',
        //'x.percentil','x.categoria','x.interpretacion',
        //'i.nemonico','i.nombre','i.bateria'
        ])
    ->from(['b'=>'{{%sta_talleresdet}}'])->
     innerJoin('{{%sta_alu}} c', 'c.codalu=b.codalu')->
     innerJoin('{{%sta_docu_alu}} s', 'b.id=s.talleresdet_id')->  
    innerJoin('{{%sta_talleres}} t', 'b.talleres_id=t.id')->  
     innerJoin('{{%documentos}} x', 's.codocu=x.codocu')->
     leftJoin('{{%sta_citas}} a', 's.cita_id=a.id')->
      innerJoin('{{%sta_flujo}} f', 'a.flujo_id=f.actividad')->
      innerJoin('{{%trabajadores}} d', 'd.codigotra=a.codtra')
     //innerJoin('{{%sta_examenes}} e', 'a.id = e.citas_id')->
     //innerJoin('{{%sta_resultados}} x', 'x.examen_id=e.id')-> 
     // innerJoin('{{%sta_testindicadores}} i', 'i.id=x.indicador_id')       
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
