

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Mahasiswas <?php echo $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->nama_jurusan;?>
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>aktivitas-kuliah-mahasiswa">Mahasiswa</a></li>
                        <li class="active">Tambah Mahasiswa</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Import Mahasiswa <?php echo $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->nama_jurusan;?></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
<div id="isi_import"></div>
                     <form id="input_import" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/mahasiswa/mahasiswa_action.php?act=import">
                     <div class="form-group">
                        <label for="nim" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                           <a href="<?=base_url();?>upload/sample/sample_mhs_baru.xlsx" class="btn btn-success btn-flat"><i class="fa fa-cloud-download"></i> Download Contoh Template XLS</a>
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Upload Data Akm" class="control-label col-lg-2">Upload Data Mahasiswa</label>
                        <div class="col-lg-10">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                              <div class="form-control uneditable-input span3" data-trigger="fileinput">
                                <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span>
                              </div>
                              <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                                <input type="file" name="semester" required>
                              </span>
                              <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.form-group -->
                      <?php
          $id_jur = $path_id;
    ?>
    <input type="hidden" name="jurusan" value="<?=$id_jur;?>"


                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="Upload Data">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
 <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>

                  </div>
                  </div>
              </div>
</div>

                </section><!-- /.content -->


