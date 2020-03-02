

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     AKM
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>akm">AKM</a></li>
                        <li class="active">Tambah AKM</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah AKM</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/akm/akm_action.php?act=in">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="semester" placeholder="Semester" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" name="nim" placeholder="NIM" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama" placeholder="Nama" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IP Semester" class="control-label col-lg-2">IP Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="ips" placeholder="IP Semester" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">IPK</label>
                        <div class="col-lg-10">
                          <input type="text" name="ipk" placeholder="IPK" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Semester" class="control-label col-lg-2">SKS Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="sks_smt" placeholder="SKS Semester" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Total" class="control-label col-lg-2">SKS Total</label>
                        <div class="col-lg-10">
                          <input type="text" name="sks_total" placeholder="SKS Total" class="form-control" required>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->fetch_all("jurusan") as $isi) {
                if ($id_jur==$isi->kode_jurusan) {
                  echo "<option value='$isi->kode_jurusan'>$isi->nama_jurusan</option>";
                }
                  
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Status Kuliah</label>
                        <div class="col-lg-10">
                          <select name="status" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <option value="A">Aktif</option>
               <option value="C">Cuti</option>
               <option value="D">Drop Out</option>
                <option value="K">Keluar</option>
                 <option value="L">Lulus</option>
                 <option value="N">Non-aktif</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="SKS Total" class="control-label col-lg-2">Biaya Kuliah (semester)</label>
                        <div class="col-lg-10">
                          <input type="number" name="biaya_smt" placeholder="Biaya Kuliah (semester)" class="form-control">
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


