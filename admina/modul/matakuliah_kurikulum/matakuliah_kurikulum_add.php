
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Matakuliah Kurikulum
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>matakuliah-kurikulum">Matakuliah Kurikulum</a></li>
                        <li class="active">Tambah Matakuliah Kurikulum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Matakuliah Kurikulum</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/matakuliah_kurikulum/matakuliah_kurikulum_action.php?act=in">
                      <div class="form-group">
                        <label for="Kurikulum" class="control-label col-lg-2">Kurikulum</label>
                        <div class="col-lg-10">
                          <select name="id_kurikulum" data-placeholder="Pilih Kurikulum ..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
              <?php foreach ($db->fetch_all("kurikulum") as $isi) {

                  if ($id_kur==$isi->id) {
                    echo "<option value='$isi->id' selected>$isi->nama_kur</option>";
                  } 
               }
$tahun = $db->fetch_single_row("kurikulum",'id',$id_kur)->mulai_berlaku;
                ?>
              </select>
              <input type="hidden" name="tahun" value="<?=$tahun;?>">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Kode Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_mk" placeholder="Kode Matakuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Matakuliah" class="control-label col-lg-2">Nama Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_mk" placeholder="Nama Matakuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Jenis Mata Kuliah" class="control-label col-lg-2">Jenis Mata Kuliah</label>
        
                        <div class="col-lg-3">
<select name="jns_mk" class="form-control" tabindex="2" required>

 <?php
 $stat = array(
  'W' => "Wajib Nasional",
  'A' => "Wajib Program Studi",
  'B' => "Pilihan",
  'C' => "Peminatan",
  'S' => "Tugas Akhir / Skripsi"
  );
 foreach ($stat as $key => $value) {
      echo "<option value='$key'>".$value."</option>";
 }

?>
</select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Tatap Muka" class="control-label col-lg-2">SKS Tatap Muka</label>
                        <div class="col-lg-1">
                          <input type="text" name="sks_tm" placeholder="SKS Tatap Muka" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Praktikum" class="control-label col-lg-2">SKS Praktikum</label>
                        <div class="col-lg-1">
                          <input type="text" name="sks_prak" placeholder="SKS Praktikum" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Praktek Lapangan" class="control-label col-lg-2">SKS Praktek Lapangan</label>
                        <div class="col-lg-1">
                          <input type="text" name="sks_prak_lap" placeholder="SKS Praktek Lapangan" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Simulasi" class="control-label col-lg-2">SKS Simulasi</label>
                        <div class="col-lg-1">
                          <input type="text" name="sks_sim" placeholder="SKS Simulasi" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-2">
                          <input type="text" name="semester" placeholder="Semester" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-5">
                               <select name="kode_jurusan" data-placeholder="Pilih Jurusan..." class="form-control chzn-select" tabindex="2" required>

      <?php 
if ($_SESSION['level']==1) {
  $jur = $db->query("select * from jurusan");
} else {
  $jur = $db->query("select * from jurusan where id_fakultas='".$_SESSION['fakultas']."'");
}
foreach ($jur as $isi) {

                  if ($id_jur==$isi->kode_jurusan) {
                    echo "<option value='$isi->kode_jurusan' selected>$isi->nama_jurusan</option>";
                  }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

                      
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
        
            