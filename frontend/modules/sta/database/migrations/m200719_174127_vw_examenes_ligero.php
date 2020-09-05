<?php

namespace frontend\modules\sta\database\migrations;
//use yii\db\Migration;
use console\migrations\viewMigration;
class m200719_174127_vw_examenes_ligero extends viewMigration
{
  const NAME_VIEW='{{%vw_sta_examenes_ligero}}';
 
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
        //'x.ap as appsico','x.am as ampsico','x.nombres as nombrespsico','x.codigotra',
        //'m.numero as numerocita','m.finicio','m.fechaprog',
        //'t.numero','t.codperiodo','t.descripcionprograma',
       // 'c.desdocu',
          's.id as idexamen','s.citas_id','s.detalles','s.codfac','s.user_id','s.virtual','s.fnotificacion',
          'k.puntaje','k.id','k.test_id','k.examenes_id','k.valor',
         'b.item','b.pregunta','b.grupo',
       // 'c.desdocu',
          'al.codalu',
       // 'al.ap','al.am','al.nombres','al.correo','al.codcar','al.dni','al.celulares','al.fijos',
         'a.codtest', 'a.descripcion', 'a.opcional', 'a.codocu', 'a.codtest', 'a.reporte_id','a.detalles as detalletest', 'a.nveces',
        ])
    ->from(['k'=>'{{%sta_examenesdet}}'])->
   innerJoin('{{%sta_examenes}} s', 's.id=k.examenes_id')->
   innerJoin('{{%sta_testdet}} b', 'b.id=k.test_id')->
     innerJoin('{{%sta_test}} a', 'a.codtest=b.codtest')-> 
      innerJoin('{{%sta_citas}} m', 's.citas_id=m.id')->  
       innerJoin('{{%sta_talleresdet}} td', 'td.id=m.talleres_id')->
        innerJoin('{{%sta_talleres}} t', 'td.talleres_id=t.id')-> 
        innerJoin('{{%trabajadores}} x', 'x.codigotra=m.codtra')-> 
         innerJoin('{{%sta_alu}} al', 'al.codalu=td.codalu')-> 
         innerJoin('{{%documentos}} c', 'a.codocu=c.codocu')
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
