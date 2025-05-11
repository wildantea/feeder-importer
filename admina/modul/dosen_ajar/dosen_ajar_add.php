
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Dosen Ajar
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>dosen-ajar">Dosen Ajar</a></li>
                        <li class="active">Tambah Dosen Ajar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Dosen Ajar</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/dosen_ajar/dosen_ajar_action.php?act=in">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="semester" placeholder="contoh : 20151" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">NIDN</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nidn" placeholder="NIDN" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Dosen" class="control-label col-lg-2">Nama Dosen</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_dosen" placeholder="Nama Dosen" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Kode Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_mk" placeholder="Kode Matakuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Nama Kelas</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kelas" placeholder="contoh : 01" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">Jumlah Tatap Muka</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="tatap_muka" placeholder="Jumlah Tatap Muka" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">Jumlah Realisasi Tatap Muka</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="tatap_muka_real" placeholder="Jumlah Realisasi Tatap Muka" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jenis Evaluasi</label>
                        <div class="col-lg-10">
                           <select name="id_jenis_evaluasi" data-placeholder="Pilih Evaluasi..." class="form-control chzn-select" tabindex="2" required>
<?php
$evaluasi = array(
    1 => 'Evaluasi Akademik',
    2 => 'Aktivitas Partisipatif',
    3 => 'Hasil Proyek',
    4 => 'Kognitif/ Pengetahuan'
);
foreach ($evaluasi as $id => $val) {
      echo "<option value='$id'>$val</option>";
    
} 
 ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

                     <input type="hidden" name="jurusan" value="<?=$id_jur;?>"> 
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
        
            