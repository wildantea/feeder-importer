<?php 
$data_edit = $db->fetch_single_row("config_user","id",1);
?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Setting Koneksi Importer ke Feeder
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
                                    
                                </div>

                  <div class="box-body">
<div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Untuk menghubungkan IMPORTER dengan NEO FEEDER, Silakan Masukan username, password Admin PT NEO FEEDER dibawah ini. Isi IP/Domain jika NEO FEEDER beda lokasi server dengan importer, biarkan url jika satu server/komputer</strong>
        </div>

                                     <div class="alert alert-danger pass_salah" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><span class="isi_config_error"></span> </strong>
        </div>
                     <form id="update_config" method="post" class="form-horizontal" action="<?=base_admin();?>modul/config_akun_feeder/config_akun_feeder_action.php?act=up">
                      <div class="form-group">
                        <label for="Username Feeder" class="control-label col-lg-2">Username Feeder Dikti</label>
                        <div class="col-lg-10">
                          <input type="text" name="username" value="<?=dec_data($data_edit->username);?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Password Feeder" class="control-label col-lg-2">Password Feeder Dikti</label>
                        <div class="col-lg-10">
                          <input type="password" name="password" value="<?=dec_data($data_edit->password);?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Password Feeder" class="control-label col-lg-2">PORT</label>
                        <div class="col-lg-10">
                          <input type="port" name="port" value="<?=$data_edit->port;?>" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">

                        <label for="URL Feeder" class="control-label col-lg-2">URL Feeder</label>
                        <div class="col-lg-10">
                        <span style="color:#f00">Jika Feeder Dikti satu komputer dengan Importer isi localhost, jika beda komputer, isi dengan ip address atau alamat domain</span>
                          <input type="text" name="url" value="<?=$data_edit->url;?>" class="form-control" id="url" required> 
                        </div>
                      </div><!-- /.form-group -->

                      <input type="hidden" name="id" value="<?=$data_edit->id;?>">
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    
                        </div>
                      </div><!-- /.form-group -->
                    </form>
                  
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->
   <script src="<?=base_admin();?>assets/login/js/jqueryform.js"></script>
  <script src="<?=base_admin();?>assets/login/js/validate.js"></script>
<script type="text/javascript">

  $(document).ready(function(){



      $.validator.addMethod("myFunc", function(val) {
        var match = val.match(/^(?:https?:)?(?:\/\/)?([^\/\?]+)/i);
        var hostname = match && match[1];
        url = hostname.replace(/:.*$/, "");
        //console.log(match);
        //alert(domain);
        $("#url").val(url);
        return true;
      }, "Untuk Cetak Data Silakan Pilih Prodi");

    $("form#update_config").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },
        
        rules: {
          url: {
            myFunc:true
          //minlength: 2
        },
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
                                window.location = '<?=base_index();?>';
                              }, 2000); //will call the function after 2 secs.
                                //redirect jika berhasil login
                              }
                      }
                    });
            }

        });  
  });
</script>