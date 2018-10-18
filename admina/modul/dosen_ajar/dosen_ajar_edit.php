

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Dosen Ajar
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>dosen-ajar">Dosen Ajar</a></li>
                        <li class="active">Edit Dosen Ajar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Dosen Ajar</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/dosen_ajar/dosen_ajar_action.php?act=up">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="semester" value="<?=$data_edit->semester;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">NIDN</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nidn" value="<?=$data_edit->nidn;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Dosen" class="control-label col-lg-2">Nama Dosen</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_dosen" value="<?=$data_edit->nama_dosen;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Kode Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_mk" value="<?=$data_edit->kode_mk;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Kelas" class="control-label col-lg-2">Nama Kelas</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kelas" value="<?=$data_edit->nama_kelas;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">Jumlah Tatap Muka</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="tatap_muka" value="<?=$data_edit->rencana_tatap_muka;?>" placeholder="Jumlah Tatap Muka" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIDN" class="control-label col-lg-2">Jumlah Realisasi Tatap Muka</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="tatap_muka_real" value="<?=$data_edit->tatap_muka_real;?>" placeholder="Jumlah Realisasi Tatap Muka" class="form-control" required> 
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
        
 