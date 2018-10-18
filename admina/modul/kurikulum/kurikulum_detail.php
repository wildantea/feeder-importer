

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Kurikulum
                    </h1>
                   <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kurikulum">Kurikulum</a></li>
                        <li class="active">Detail Kurikulum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Detail Kurikulum</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                   <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Nama Kurikulum" class="control-label col-lg-2">Nama Kurikulum</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->nama_kur;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Berlaku" class="control-label col-lg-2">Mulai Berlaku</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->mulai_berlaku;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Wajib" class="control-label col-lg-2">Jumlah SKS Wajib</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jml_sks_wajib;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Pilihan" class="control-label col-lg-2">Jumlah SKS Pilihan</label>
                        <div class="col-lg-10">
                          <input type="text" disabled="" value="<?=$data_edit->jml_sks_pilihan;?>" class="form-control">
                        </div>
                      </div><!-- /.form-group -->

                   
                    </form>
                    <a href="<?=base_index();?>kurikulum" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
