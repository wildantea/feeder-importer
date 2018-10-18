
           
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Kurikulum
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>kurikulum">Kurikulum</a></li>
                        <li class="active">Tambah Kurikulum</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Kurikulum</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/kurikulum/kurikulum_action.php?act=in">
                      <div class="form-group">
                        <label for="Nama Kurikulum" class="control-label col-lg-2">Nama Kurikulum</label>
                        <div class="col-lg-10">
                          <input type="text" name="nama_kur" placeholder="Nama Kurikulum" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Berlaku" class="control-label col-lg-2">Mulai Berlaku</label>
                        <div class="col-lg-10">
                         <input type="text" number="true" name="mulai_berlaku" placeholder="Mulai Berlaku contoh : 20151" minlength="5" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Wajib" class="control-label col-lg-2">Jumlah SKS Wajib</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="jml_sks_wajib" placeholder="Jumlah SKS Wajib" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Pilihan" class="control-label col-lg-2">Jumlah SKS Pilihan</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="jml_sks_pilihan" placeholder="Jumlah SKS Pilihan" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jumlah SKS Pilihan" class="control-label col-lg-2">Total SKS</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="total_sks" placeholder="Total SKS" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->

 <input type="hidden" name="kode_jurusan" value="<?=$id_jur;?>">                   
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
        
            