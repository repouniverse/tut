<div class="row">
    <div class="box-body">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-contract"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Plan de Trabajo</span>
              <span class="info-box-number">167 Kb</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-file-contract"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Informe Tutor</span>
              <span class="info-box-number">345 Kb</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-file-contract"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Informe Depara</span>
              <span class="info-box-number">12,3 KB</span>
            </div>
            <!-- /.info-box-content -->
             </div>
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div id="informe-presentacion">
              
          </div>
      </div>  
</div> 
   
      <?php 
  $this->registerJs("$('div.info-box > span').on( 'click', function() { 
           $('#informe-presentacion').load('".\yii\helpers\Url::to(['/report/make/creareporte','id'=>2,'idfiltro'=>200])."');
             })", \yii\web\View::POS_READY);
?>