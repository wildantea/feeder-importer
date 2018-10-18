

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Kelulusan
                    </h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kelulusan">Kelulusan</a></li>
                        <li class="active">Detail Kelulusan</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Detail Kelulusan</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                   <form class="form-horizontal">
                      <div class="form-group">
                        <label for="NIM /NIPD" class="control-label col-lg-2">NIM /NIPD</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nim;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Mahasiswa" class="control-label col-lg-2">Nama Mahasiswa</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nama;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Keluar" class="control-label col-lg-2">Jenis Keluar</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("agama") as $isi) {
                  if ($data_edit->id_jenis_keluar==$isi->id_agama) {

                    echo "<input disabled class='form-control' type='text' value='$isi->id_agama'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SK Yudisium" class="control-label col-lg-2">SK Yudisium</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sk_yudisium;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal SK Yudisium" class="control-label col-lg-2">Tanggal SK Yudisium</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->tgl_sk_yudisium;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">IPK</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->ipk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="No seri Ijazah" class="control-label col-lg-2">No seri Ijazah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->no_seri_ijasah;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jalur Skripsi" class="control-label col-lg-2">Jalur Skripsi</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jalur_skripsi;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Judul Skripsi" class="control-label col-lg-2">Judul Skripsi</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->judul_skripsi;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Bulan Awal Bimbingan" class="control-label col-lg-2">Bulan Awal Bimbingan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->bulan_awal_bimbingan;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Bulan Akhir Bimbingan" class="control-label col-lg-2">Bulan Akhir Bimbingan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->bulan_akhir_bimbingan;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->

                   
                    </form>
                    <a href="<?=base_index();?>kelulusan" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
