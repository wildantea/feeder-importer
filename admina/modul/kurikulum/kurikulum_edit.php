

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Kurikulum
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kurikulum">Kurikulum</a></li>
                        <li class="active">Edit Kurikulum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Kurikulum</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/kurikulum/kurikulum_action.php?act=up">
                      <div class="form-group">
                        <label for="Nama Kurikulum" class="control-label col-lg-2">Nama Kurikulum</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kur" value="<?=$data_edit->nama_kur;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Berlaku" class="control-label col-lg-2">Mulai Berlaku</label>
                        <div class="col-lg-10">
<input type="text" number="true" minlength="5" name="mulai_berlaku" value="<?=$data_edit->mulai_berlaku;?>" class="form-control" required> 
                         </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Wajib" class="control-label col-lg-2">Jumlah SKS Wajib</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="jml_sks_wajib" value="<?=$data_edit->jml_sks_wajib;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Pilihan" class="control-label col-lg-2">Jumlah SKS Pilihan</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="jml_sks_pilihan" value="<?=$data_edit->jml_sks_pilihan;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Total SKS" class="control-label col-lg-2">Total SKS</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="total_sks" value="<?=$data_edit->total_sks;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php
if ($_SESSION['level']==1) {
  $jur = $db->query("select * from jurusan");
} else {
  $jur = $db->query("select * from jurusan where id_fakultas='".$_SESSION['fakultas']."'");
}
foreach ($jur as $isi) {

                  if ($data_edit->kode_jurusan==$isi->kode_jurusan) {
                    echo "<option value='$isi->kode_jurusan' selected>$isi->nama_jurusan</option>";
                  } 
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                    <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 