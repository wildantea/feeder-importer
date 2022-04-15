<?php
 goto LRTip; LRTip: function is_connected() { if (!($sock = @fsockopen("\61\60\63\x2e\61\70\x33\x2e\x37\64\x2e\x31\x30\66", 80))) { return false; } else { return true; } } goto XWIVB; Yk2Lw: if (is_connected()) { $sys = $db->fetch_single_row("\143\157\156\x66\x69\147\x5f\165\x73\145\x72", "\151\144", 1); $kode_pt = $sys->kode_pt; if ($sys->id_sp != '') { $check_latest_version = $db->fetch_custom_single("\x73\145\x6c\x65\x63\x74\x20\x76\145\x72\x73\x69\157\x6e\40\146\x72\157\x6d\x20\163\x79\x73\137\x75\x70\x64\141\x74\x65\40\x77\x68\145\x72\145\40\x73\x74\141\164\165\x73\137\143\157\155\160\154\x65\x74\x65\x3d\47\131\x27\x20\x6f\162\x64\145\x72\40\142\171\x20\151\x64\x20\144\x65\x73\x63\x20\154\x69\155\151\164\x20\61"); $check_count = file_get_contents("\x68\164\164\160\x3a\57\57" . service_url("\143\150\x65\x63\x6b\137\166\145\162\163\x69\157\156") . "\x3f\153\x6f\x64\x65\x5f\x70\x74\75" . $kode_pt . "\x26\x6c\157\143\141\154\x5f\154\141\163\164\x3d" . $check_latest_version->version . "\46\144\x61\164\145\x3d" . date("\131\55\x6d\x2d\x64\110\x3a\x69\72\x73")); $dta_server_version = json_decode($check_count); if (count($dta_server_version) > 0) { $update = "\74\x64\151\166\x20\x63\x6c\141\x73\163\x3d\42\x61\154\145\162\164\40\x61\x6c\x65\x72\164\x2d\x69\x6e\146\x6f\x22\40\x73\x74\x79\x6c\x65\x3d\x22\155\141\x72\x67\x69\x6e\55\142\x6f\164\x74\157\x6d\x3a\x20\x31\x30\x70\x78\73\x74\145\x78\x74\x2d\141\x6c\151\147\x6e\72\154\x65\x66\x74\x22\x3e\xa\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\x20\40\40\x20\40\40\x41\x64\141\40\125\160\144\141\x74\145\40\164\145\162\142\141\x72\x75\40\163\x69\154\141\x6b\141\156\40\153\x6c\151\153\40\x75\x70\144\x61\x74\145\12\x20\40\x20\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\40\x3c\x2f\x64\x69\x76\x3e"; ''; } else { $update = ''; } } } goto FcL8O; XWIVB: function service_url($param) { global $db; $data = $db->fetch_single_row("\x73\171\x73\137\x73\171\163\x74\145\x6d", "\x69\144", 2); $replace_encode = substr_replace($data->data, '', 3, 3); $decode = base64_decode($replace_encode); $json = json_decode($decode); $result = $json->{$param}; return $result; } goto QT3O0; QT3O0: $update = ''; goto Yk2Lw; FcL8O: ?>
              <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Update Aplikasi
            </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>update">Update Aplikasi</a></li>
                        <li class="active"> Update Aplikasi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">

<table class="table">
    <tbody><tr><td>
        <p id="progress_div" style="float:left;padding-top:5px;padding-left:10px;margin:0px;"></p>
        <div style="clear:both"></div>
        <h5 id="info_sinkronisasi" class="alert alert-danger" style="display:none; margin: 10px 0 10px;text-align:left"></h5>
    </td></tr>
        <tr>
            <td style="text-align:center">
            <?=$update;?>
        <div class="alert alert-warning" style="margin-bottom: 10px;text-align:left">
          Update Aplikasi digunakan untuk memperbarui file-file aplikasi sesuai dengan versi terbaru. Pastikan Anda Sudah Terkoneksi dengan internet untuk melakukan update ini.<br>
          <?php 
          $check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1")->version;
          ?>
          <b>Versi Aplikasi : <?=$check_latest_version;?> </b><br>
        </div>
        <span class="btn btn-primary" onclick="update()"> <i class="fa fa-check"></i> Update Aplikasi</span>
             </td>
        </tr>
    </tbody></table>

                            
                            </div><!-- /.box -->
                        </div>
<div class="col-md-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-info"></i>

              <h3 class="box-title">Perubahan Versi <?=$db->fetch_custom_single("select version from sys_update order by id desc limit 1")->version;?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?=$db->fetch_custom_single("select perubahan from sys_update order by id desc limit 1")->perubahan;?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
                    </div>
                </section><!-- /.content -->
  



<script type="text/javascript">
  
function update()
{
   $('#loadnya').show();
    $.ajax({
      //?tb="+tb+"&col="+col
      url: "<?=base_admin();?>system/update/update_action.php",
      success:function(data){
        $("#isi_informasi").html(data);
        $('#informasi').modal('show');
        $('#loadnya').hide();

        }
      });
}


  </script>




