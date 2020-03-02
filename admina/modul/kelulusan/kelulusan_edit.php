

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Kelulusan
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kelulusan">Kelulusan</a></li>
                        <li class="active">Edit Kelulusan</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Kelulusan</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/kelulusan/kelulusan_action.php?act=up">
                      <div class="form-group">
                        <label for="NIM /NIPD" class="control-label col-lg-2">NIM /NIPD</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nim" value="<?=$data_edit->nim;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Mahasiswa" class="control-label col-lg-2">Nama Mahasiswa</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama" value="<?=$data_edit->nama;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Keluar" class="control-label col-lg-2">Jenis Keluar</label>
                        <div class="col-lg-10">
                          <select name="id_jenis_keluar" data-placeholder="Pilih Jenis Keluar..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->fetch_all("jenis_keluar") as $isi) {

                  if ($data_edit->id_jenis_keluar==$isi->id_jns_keluar) {
                    echo "<option value='$isi->id_jns_keluar' selected>$isi->ket_keluar</option>";
                  } else {
                  echo "<option value='$isi->id_jns_keluar'>$isi->ket_keluar</option>";
                    }
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal SK Yudisium" class="control-label col-lg-2">Tanggal Keluar</label>
                        <div class="col-lg-10">
                          <input type="text" name="tanggal_keluar" id="tgl" required="" value="<?=$data_edit->tanggal_keluar;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SK Yudisium" class="control-label col-lg-2">SK Yudisium</label>
                        <div class="col-lg-10">
                          <input type="text" name="sk_yudisium" value="<?=$data_edit->sk_yudisium;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal SK Yudisium" class="control-label col-lg-2">Tanggal SK Yudisium</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl1" name="tgl_sk_yudisium" value="<?=$data_edit->tgl_sk_yudisium;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">IPK</label>
                        <div class="col-lg-10">
                          <input type="text" name="ipk" value="<?=$data_edit->ipk;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="No seri Ijazah" class="control-label col-lg-2">No seri Ijazah</label>
                        <div class="col-lg-10">
                          <input type="text" name="no_seri_ijasah" value="<?=$data_edit->no_seri_ijasah;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">Semester Keluar</label>
                        <div class="col-lg-10">
                          <input type="text" name="semester" placeholder="<?=$data_edit->semester;?>" class="form-control" > 
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
        
 