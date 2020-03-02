

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      AKM
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>akm">AKM</a></li>
                        <li class="active">Edit AKM</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit AKM</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/akm/akm_action.php?act=up">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="semester" value="<?=$data_edit->semester;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" name="nim" value="<?=$data_edit->nim;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama" value="<?=$data_edit->nama;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IP Semester" class="control-label col-lg-2">IP Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="ips" value="<?=$data_edit->ips;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">IPK</label>
                        <div class="col-lg-10">
                          <input type="text" name="ipk" value="<?=$data_edit->ipk;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Semester" class="control-label col-lg-2">SKS Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="sks_smt" value="<?=$data_edit->sks_smt;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Total" class="control-label col-lg-2">SKS Total</label>
                        <div class="col-lg-10">
                          <input type="text" name="sks_total" value="<?=$data_edit->sks_total;?>" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan..." class="form-control chzn-select" tabindex="2" required>

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
<div class="form-group">
                        <label for="status" class="control-label col-lg-2">Status Kuliah</label>
                        <div class="col-lg-10">
 <select name="status" data-placeholder="Pilih Status ..." class="form-control chzn-select" tabindex="2" required>
 <?php
 $stat = array(
  'A' => "Aktif",
  'C' => "Cuti",
  'D' => "Drop Out",
  'K' => "Keluar",
  'L' => "Lulus",
  'N' => "Non-aktif"
  );
 foreach ($stat as $key => $value) {
    if ($data_edit->status_kuliah==$key) {
      echo "<option value='$data_edit->status_kuliah' selected>".$value."</option>";
    } else {
      echo "<option value='$key'>".$value."</option>";
    }
 }

?>
</select>
              </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Total" class="control-label col-lg-2">Biaya Kuliah (semester)</label>
                        <div class="col-lg-10">
                          <input type="number" name="biaya_smt" value="<?=$data_edit->biaya_smt;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
          <input type="hidden" name="jurusan" value="<?=$id_jur;?>">
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


