

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     AKM
                    </h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>akm">AKM</a></li>
                        <li class="active">Detail AKM</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Detail AKM</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                   <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->semester;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nim;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nama;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IP Semester" class="control-label col-lg-2">IP Semester</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->ips;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="IPK" class="control-label col-lg-2">IPK</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->ipk;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Semester" class="control-label col-lg-2">SKS Semester</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_smt;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="SKS Total" class="control-label col-lg-2">SKS Total</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->sks_total;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <?php foreach ($db->fetch_all("jurusan") as $isi) {
                  if ($data_edit->kode_jurusan==$isi->id) {

                    echo "<input disabled class='form-control' type='text' value='$isi->id'>";
                  }
               } ?>
              
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="status" class="control-label col-lg-2">status</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->status;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="sent" class="control-label col-lg-2">sent</label>
                        <div class="col-lg-10">
                          <?php if ($data_edit->sent=="Y") {
      ?>
      <input name="sent" class="make-switch" disabled type="checkbox" checked>
      <?php
    } else {
      ?>
      <input name="sent" class="make-switch" disabled type="checkbox">
      <?php
    }?>
                        </div>
                      </div><!-- /.form-group -->

                   
                    </form>
                    <a href="<?=base_index();?>akm" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
