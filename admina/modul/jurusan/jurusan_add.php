
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Jurusan
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>jurusan">Jurusan</a></li>
                        <li class="active">Tambah Jurusan</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Jurusan</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/jurusan/jurusan_action.php?act=in">
<div class="form-group">
                        <label for="Kode jurusan lokal" class="control-label col-lg-2">Kode Jurusan</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="kode_jurusan" placeholder="Kode jurusan" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode jurusan Dikti" class="control-label col-lg-2">Nama Jurusan</label>
                        <div class="col-lg-10">
                          <input type="text"  name="nama_jurusan" placeholder="Nama Jurusan" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Jurusan" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-10">
                          <input type="text" name="status" placeholder="Status" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Jurusan" class="control-label col-lg-2">Jenjang</label>
                        <div class="col-lg-10">
                          <input type="text" name="jenjang" placeholder="Jenjang" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                      
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
 <a href="<?=base_index();?>jurusan" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
            