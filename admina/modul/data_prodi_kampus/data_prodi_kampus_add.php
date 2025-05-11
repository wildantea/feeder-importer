
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Data Prodi Kampus
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-prodi-kampus">Data Prodi Kampus</a></li>
                        <li class="active">Tambah Data Prodi Kampus</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Data Prodi Kampus</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/data_prodi_kampus/data_prodi_kampus_action.php?act=in">
                      <div class="form-group">
                        <label for="nm_lemb" class="control-label col-lg-2">nm_lemb</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_lemb" placeholder="nm_lemb" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="kode_prodi" class="control-label col-lg-2">kode_prodi</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_prodi" placeholder="kode_prodi" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->

                      
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
 <a href="<?=base_index();?>data-prodi-kampus" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
            