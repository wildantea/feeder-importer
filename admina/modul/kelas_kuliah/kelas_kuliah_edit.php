               <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Kelas Kuliah
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kelas-kuliah">Kelas Kuliah</a></li>
                        <li class="active">Edit Kelas Kuliah</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Kelas Kuliah</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/kelas_kuliah/kelas_kuliah_action.php?act=up">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="semester" value="<?=$data_edit->semester;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Kode Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_mk" value="<?=$data_edit->kode_mk;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Matakuliah" class="control-label col-lg-2">Nama Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_mk" value="<?=$data_edit->nama_mk;?>" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Nama Kelas</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kelas" value="<?=$data_edit->nama_kelas;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Bahasan</label>
                        <div class="col-lg-10">
                          <input type="text" name="bahasan_case" value="<?=$data_edit->bahasan_case;?>" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Tanggal Mulai Efektif</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl1" name="tgl_mulai_koas" value="<?=$data_edit->tgl_mulai_koas;?>" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Tangal Akhir Efektif</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl2" name="tgl_selesai_koas" value="<?=$data_edit->tgl_selesai_koas;?>" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Prodi</label>
                        <div class="col-lg-10">
                          <select name="jurusan" data-placeholder="Pilih Jurusan..." class="form-control chzn-select" tabindex="2" required>

               <?php 
               echo $path_four;
$jur = $db->query('select * from jurusan where kode_jurusan=?',array('kode_jur' => $path_four));
foreach ($jur as $isi) {
           echo "<option value='$isi->kode_jurusan' selected>$isi->jenjang $isi->nama_jurusan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                         <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
                           <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                   
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 