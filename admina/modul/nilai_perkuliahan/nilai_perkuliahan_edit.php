

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Nilai Perkuliahan
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>nilai-perkuliahan">Nilai Perkuliahan</a></li>
                        <li class="active">Edit Nilai Perkuliahan</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Nilai Perkuliahan</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/nilai_perkuliahan/nilai_perkuliahan_action.php?act=up">
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
                        <label for="Kode MK" class="control-label col-lg-2">Kode MK</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_mk" value="<?=$data_edit->kode_mk;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama MK" class="control-label col-lg-2">Nama MK</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_mk" value="<?=$data_edit->nama_mk;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Nama Kelas</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kelas" value="<?=$data_edit->nama_kelas;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="semester" class="control-label col-lg-2">semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="semester" value="<?=$data_edit->semester;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("jurusan") as $isi) {

                  if ($data_edit->kode_jurusan==$isi->kode_jurusan) {
                    echo "<option value='$isi->kode_jurusan' selected>$isi->nama_jurusan</option>";
                  } 
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nilai Huruf" class="control-label col-lg-2">Nilai Huruf</label>
                        <div class="col-lg-10">
                          <input type="text" name="nilai_huruf" value="<?=$data_edit->nilai_huruf;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nilai Index" class="control-label col-lg-2">Nilai Index</label>
                        <div class="col-lg-10">
                          <input type="text" name="nilai_indek" value="<?=$data_edit->nilai_indek;?>" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nilai Index" class="control-label col-lg-2">Nilai Angka</label>
                        <div class="col-lg-10">
                          <input type="text" name="nilai_angka" value="<?=$data_edit->nilai_angka;?>" class="form-control" > 
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
        
 