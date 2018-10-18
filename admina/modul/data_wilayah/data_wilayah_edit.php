

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Data Wilayah
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-wilayah">Data Wilayah</a></li>
                        <li class="active">Edit Data Wilayah</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Data Wilayah</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="update" method="post" class="form-horizontal" action="<?=base_admin();?>modul/data_wilayah/data_wilayah_action.php?act=up">
                      <div class="form-group">
                        <label for="ID WIlayah" class="control-label col-lg-2">ID WIlayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="id_wil" value="<?=$data_edit->id_wil;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Wilayah" class="control-label col-lg-2">Nama Wilayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_wil" value="<?=$data_edit->nm_wil;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="ID Level Wilayah" class="control-label col-lg-2">ID Level Wilayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="id_level_wil" value="<?=$data_edit->id_level_wil;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <input type="submit" class="btn btn-primary btn-flat" value="submit">
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                    <a href="<?=base_index();?>data-wilayah" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
 