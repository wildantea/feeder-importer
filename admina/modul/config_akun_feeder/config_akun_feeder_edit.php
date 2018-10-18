

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                      Config Akun Feeder
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>config-akun-feeder">Config Akun Feeder</a></li>
                        <li class="active">Edit Config Akun Feeder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid box-primary">
                                   <div class="box-header">
                                    <h3 class="box-title">Edit Config Akun Feeder</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                                     <div class="alert alert-danger pass_salah" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><span class="isi_config_error"></span> </strong>
        </div>
                     <form id="update_config" method="post" class="form-horizontal" action="<?=base_admin();?>modul/config_akun_feeder/config_akun_feeder_action.php?act=up">
                      <div class="form-group">
                        <label for="Username Feeder" class="control-label col-lg-2">Username Feeder</label>
                        <div class="col-lg-10">
                          <input type="text" name="username" value="<?=$data_edit->username;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Password Feeder" class="control-label col-lg-2">Password Feeder</label>
                        <div class="col-lg-10">
                          <input type="text" name="password" value="<?=$data_edit->password;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">

                        <label for="URL Feeder" class="control-label col-lg-2">URL Feeder</label>
                        <div class="col-lg-10">
                        <span style="color:#f00">Jika Feeder Dikti satu komputer dengan Importer isi localhost (tanpa http://), jika beda komputer, isi dengan ip address atau domain (tanpa http://)</span>
                          <input type="text" name="url" value="<?=$data_edit->url;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="PORT" class="control-label col-lg-2">PORT</label>
                        <div class="col-lg-10">
                          <input type="text" name="port" value="<?=$data_edit->port;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode PT" class="control-label col-lg-2">Kode PT</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_pt" value="<?=$data_edit->kode_pt;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="live" class="control-label col-lg-2">live</label>
                        <div class="col-lg-10">
                          <?php if ($data_edit->live=="Y") {
      ?>
      <input name="live" class="make-switch" type="checkbox" checked>
      <?php
    } else {
      ?>
      <input name="live" class="make-switch" type="checkbox">
      <?php
    }?>
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
                           <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                  
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
        
<script type="text/javascript">
  $(document).ready(function(){
    $("form#update_config").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
            submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type:"post",
                          url: $(this).attr('action'),
                          data: $("form#update_config").serialize(),
                        success: function(data){
                          $('#loadnya').hide();
                          console.log(data);
                              if (data!='good') { 
                            $('.isi_config_error').html(data);
                            $('.pass_salah').fadeIn();
                                //$('.sukses').html(data);
                              } else {
                                 $('.pass_salah').hide();
                                $('.notif_top_up').fadeIn(1000);
                                 setTimeout(function () {
                                window.history.back();
                              }, 2000); //will call the function after 2 secs.
                                //redirect jika berhasil login
                              }
                      }
                    });
            }

        });  
  });
</script>