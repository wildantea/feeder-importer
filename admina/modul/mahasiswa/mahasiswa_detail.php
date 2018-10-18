

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Mahasiswa
                    </h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>mahasiswa">Mahasiswa</a></li>
                        <li class="active">Detail Mahasiswa</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Detail Mahasiswa</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                   <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nm_pd;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Kelamin" class="control-label col-lg-2">Jenis Kelamin</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">Nomor KTP</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nik;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tempat Lahir" class="control-label col-lg-2">Tempat Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->tmpt_lahir;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir" class="control-label col-lg-2">Tanggal Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=tgl_indo($data_edit->tgl_lahir);?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Agama" class="control-label col-lg-2">Agama</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("agama") as $isi) {
                  if ($data_edit->id_agama==$isi->id_agama) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_agama'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jalan" class="control-label col-lg-2">Jalan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jln;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RT" class="control-label col-lg-2">RT</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->rt;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RW" class="control-label col-lg-2">RW</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->rw;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Dusun" class="control-label col-lg-2">Dusun</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nm_dsn;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kelurahan" class="control-label col-lg-2">Kelurahan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->ds_kel;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kodepos" class="control-label col-lg-2">Kodepos</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->kode_pos;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Jenis Tinggal</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("jenis_tinggal") as $isi) {
                  if ($data_edit->id_jns_tinggal==$isi->id_jns_tinggal) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_jns_tinggal'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Telepon" class="control-label col-lg-2">Telepon</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->no_tel_rmh;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="HP" class="control-label col-lg-2">HP</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->no_hp;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->email;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Status" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->stat_pd;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ayah" class="control-label col-lg-2">Nama Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nm_ayah;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ayah" class="control-label col-lg-2">Tanggal Lahir Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->tgl_lahir_ayah;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ayah" class="control-label col-lg-2">Pendidikan Ayah</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  if ($data_edit->id_jenjang_pendidikan_ayah==$isi->id_jenj_didik) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_jenj_didik'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ayah" class="control-label col-lg-2">Pekerjaan Ayah</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  if ($data_edit->id_pekerjaan_ayah==$isi->id_pekerjaan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_pekerjaan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ayah" class="control-label col-lg-2">Penghasilan Ayah</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  if ($data_edit->id_penghasilan_ayah==$isi->id_penghasilan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_penghasilan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ibu" class="control-label col-lg-2">Nama Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nm_ibu_kandung;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ibu" class="control-label col-lg-2">Tanggal Lahir Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=tgl_indo($data_edit->tgl_lahir_ibu);?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ibu" class="control-label col-lg-2">Pendidikan Ibu</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  if ($data_edit->id_jenjang_pendidikan_ibu==$isi->id_jenj_didik) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_jenj_didik'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ibu" class="control-label col-lg-2">Penghasilan Ibu</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  if ($data_edit->id_penghasilan_ibu==$isi->id_penghasilan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_penghasilan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ibu" class="control-label col-lg-2">Pekerjaan Ibu</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  if ($data_edit->id_pekerjaan_ibu==$isi->id_pekerjaan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_pekerjaan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="nm_wali" class="control-label col-lg-2">nm_wali</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nm_wali;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Wali" class="control-label col-lg-2">Tanggal Lahir Wali</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=tgl_indo($data_edit->tgl_lahir_wali);?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenjang Pendidikan" class="control-label col-lg-2">Jenjang Pendidikan</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  if ($data_edit->id_jenjang_pendidikan_wali==$isi->id_jenj_didik) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_jenj_didik'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan" class="control-label col-lg-2">Pekerjaan</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  if ($data_edit->id_pekerjaan_wali==$isi->id_pekerjaan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_pekerjaan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Penghasilan</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  if ($data_edit->id_penghasilan_wali==$isi->id_penghasilan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_penghasilan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="i" class="control-label col-lg-2">i</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  if ($data_edit->id_penghasilan_wali==$isi->id_penghasilan) {

                    echo "<input disabled class='form-control' type='text' value='$isi->nm_penghasilan'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->

                   
                    </form>
                    <a href="<?=base_index();?>mahasiswa" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
