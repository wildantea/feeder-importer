

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Matakuliah Kurikulum
                    </h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>matakuliah-kurikulum">Matakuliah Kurikulum</a></li>
                        <li class="active">Detail Matakuliah Kurikulum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Detail Matakuliah Kurikulum</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                   <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Kurikulum" class="control-label col-lg-2">Kurikulum</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("kurikulum") as $isi) {
                  if ($data_edit->id_kurikulum==$isi->id) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nama_kur'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Kode Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->kode_mk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Matakuliah" class="control-label col-lg-2">Nama Matakuliah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nama_mk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenjang" class="control-label col-lg-2">Jenjang</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->id_jenj_didik;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Mata Kuliah" class="control-label col-lg-2">Jenis Mata Kuliah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jns_mk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Tatap Muka" class="control-label col-lg-2">SKS Tatap Muka</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_tm;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Praktikum" class="control-label col-lg-2">SKS Praktikum</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_prak;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Praktek Lapangan" class="control-label col-lg-2">SKS Praktek Lapangan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_prak_lap;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Simulasi" class="control-label col-lg-2">SKS Simulasi</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_sim;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Ada SAP ?" class="control-label col-lg-2">Ada SAP ?</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->a_sap;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Ada Silabus ?" class="control-label col-lg-2">Ada Silabus ?</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->s_silabus;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Ada Bahan Ajar ?" class="control-label col-lg-2">Ada Bahan Ajar ?</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->a_bahan_ajar;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Ada Diktat ?" class="control-label col-lg-2">Ada Diktat ?</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->acara_prakata_dikdat;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->semester;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->kode_jurusan;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->

                   
                    </form>
                    <a href="<?=base_index();?>matakuliah-kurikulum" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
