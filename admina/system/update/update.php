<?php

function is_connected()
{
  if(!$sock = @fsockopen('wildantea.com', 80))
  {
     return false;
  }
  else
  {
      return true;
  }

}


$update = "";

if (is_connected()) {
  $sys = $db->fetch_single_row('config_user','id',1);
  $kode_pt = $sys->kode_pt;
  if ($sys->id_sp!='') {
      $check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");

        $check_count = file_get_contents('https://wildantea.com/importer-free-up/count_version_left.php?kode_pt='.$kode_pt.'&local_last='.$check_latest_version->version);

        $dta_server_version = json_decode($check_count);

        if (count($dta_server_version)>0) {

          $update = '<div class="alert alert-info" style="margin-bottom: 10px;text-align:left">
                  Ada Update terbaru silakan klik update
                </div>';"";

        } else {
          $update = "";
        }
  }


}
?>                <!-- Content Header (Page header) -->
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




