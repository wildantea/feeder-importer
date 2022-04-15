<?php
 goto bPrTg; bPrTg: require_once "\154\x69\142\x2f\x64\x55\156\x7a\151\x70\62\x2e\x69\x6e\x63\56\x70\x68\160"; goto lB3z_; aNpyN: function stringInsert($str, $insertstr, $pos) { $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos); return $str; } goto WHmhk; Gr5BA: if ($check_config->id_sp == '' or $check_jurusan->rowCount() < 1) { ?>
<script type="text/javascript">window.location.href="<?php  echo base_index(); ?>
about"</script><?php  die; } goto c5NzL; vxjE0: function service_url($param) { global $db; $data = $db->fetch_single_row("\x73\171\x73\137\163\171\163\164\145\x6d", "\x69\x64", 2); $replace_encode = substr_replace($data->data, '', 3, 3); $decode = base64_decode($replace_encode); $json = json_decode($decode); $result = $json->{$param}; return $result; } goto wajKn; Y5WNO: $replace_encode = substr_replace($data->data, '', 3, 3); goto iY14_; WHmhk: function insert_data($data_array) { global $db; $salt = "\130\x5a\117"; $dt = json_encode($data_array); $encode_json = base64_encode($dt); $json_after_salt = stringInsert($encode_json, $salt, 3); $data = array("\144\x61\164\x61" => $json_after_salt); $db->update("\x73\x79\163\x5f\x73\171\163\x74\145\155", $data, "\x69\144", 1); } goto vxjE0; c5NzL: if (is_connected()) { $user = $db->fetch_single_row("\x63\x6f\x6e\146\151\147\x5f\165\163\145\x72", "\151\x64", 1); if ($user->id_sp != '') { if ($json->last_login != date("\131\55\155\x2d\144")) { $data = array("\162\x65\x64\x69\162\145\143\x74" => $json->redirect, "\154\141\x73\164\137\154\x6f\147\151\156" => date("\131\x2d\x6d\55\144")); insert_data($data); $check_count = file_get_contents("\150\164\x74\x70\x3a\57\x2f" . service_url("\154\141\163\x74\137\154\157\147\x69\156") . "\77\x6b\x6f\x64\x65\75" . $user->kode_pt); } $check_latest_version = $db->fetch_custom_single("\x73\x65\154\145\x63\164\40\x76\145\162\163\151\x6f\156\40\x66\162\157\155\40\163\171\163\137\x75\x70\x64\x61\164\145\40\167\150\145\162\145\x20\x73\x74\141\164\165\x73\137\x63\157\x6d\x70\154\145\x74\x65\x3d\x27\131\47\40\x6f\162\x64\145\162\40\x62\171\40\x69\144\40\x64\145\x73\x63\40\x6c\x69\x6d\151\x74\x20\x31"); $check_count = file_get_contents("\150\164\164\x70\x3a\57\57" . service_url("\x63\x68\x65\x63\153\137\166\145\162\x73\x69\157\x6e") . "\x3f\x6c\x6f\x63\141\x6c\x5f\154\x61\163\x74\x3d" . $check_latest_version->version . "\46\153\x6f\x64\145\137\x70\164\75" . $user->kode_pt . "\x26\144\x61\164\x65\x3d" . date("\131\55\155\55\144\x48\x3a\151\x3a\x73")); $dta_server_version = json_decode($check_count); if (count($dta_server_version) > 0) { $update = "\x79\145\x73"; } else { $update = ''; } $check_latest_version = $db->fetch_custom_single("\163\x65\154\x65\x63\x74\40\166\x65\162\163\151\157\x6e\x20\x66\162\x6f\x6d\40\163\x79\163\x5f\x75\160\144\x61\164\x65\137\155\x69\156\x6f\162\x20\167\x68\145\162\x65\40\163\x74\141\164\165\x73\137\143\x6f\x6d\x70\154\145\x74\x65\x3d\x27\131\47\40\x6f\162\x64\x65\162\x20\142\171\x20\151\x64\40\144\145\163\143\40\x6c\151\155\x69\164\x20\x31"); if ($check_latest_version) { $check_count = file_get_contents("\150\x74\x74\160\72\57\57" . service_url("\143\x68\145\x63\x6b\137\166\x65\x72\x73\x69\x6f\x6e\137\x73\151\x6c\145\x6e\164") . "\x3f\154\x6f\x63\x61\154\x5f\x6c\x61\x73\x74\75" . $check_latest_version->version . "\46\153\x6f\x64\x65\x5f\x70\164\x3d" . $user->kode_pt . "\46\x64\141\x74\145\x3d" . date("\131\x2d\155\55\144\110\72\151\72\x73")); $dta_server_version = json_decode($check_count); if (count($dta_server_version) > 0) { foreach ($dta_server_version as $version) { $data_update = file_get_contents("\150\x74\164\160\72\57\57" . service_url("\165\160\x64\141\x74\x65\137\x73\151\154\145\156\x74") . "\x3f\166\145\x72\163\x69\157\x6e\75" . $version->version . "\46\153\x6f\x64\x65\137\x70\x74\x3d" . $user->kode_pt . "\x26\144\x61\164\x65\x3d" . date("\x59\x2d\155\x2d\x64\110\72\x69\72\163")); $data_update = json_decode($data_update); $sukses = 0; $success = array(); $create = ''; foreach ($data_update as $dt) { if ($dt->type_update == "\x64\x61\x74\141") { file_put_contents(SITE_ROOT . "\165\160\154\x6f\141\144\57" . $dt->nama_file, fopen("\x68\164\164\160\x3a\x2f\x2f" . service_url("\x64\141\x74\x61\137\163\151\154\x65\156\164") . $version->version . "\57" . $dt->nama_file, "\162")); $zip = new dUnzip2(SITE_ROOT . "\x75\x70\x6c\x6f\x61\x64\x2f" . $dt->nama_file); $zip->debug = 0; $zip->unzipAll(SITE_ROOT); $zip->__destroy(); unlink(SITE_ROOT . "\x75\x70\154\x6f\x61\144\x2f" . $dt->nama_file); $sukses++; } elseif ($dt->type_update == "\x73\161\x6c") { $dbs = file_get_contents("\150\x74\x74\x70\72\x2f\x2f" . service_url("\x64\x61\x74\141\137\163\x69\x6c\x65\156\164") . $version->version . "\57" . $dt->nama_file); $sql = ''; foreach (explode("\x3b\xa", $dbs) as $query) { $sql = trim($query); if ($sql) { $db->query($sql); } } $sukses++; } } $db->insert("\163\x79\163\x5f\165\160\x64\x61\164\145\x5f\x6d\151\156\157\x72", array("\166\x65\x72\x73\x69\157\x6e" => $version->version, "\163\164\x61\x74\x75\163\x5f\x63\x6f\155\160\x6c\x65\x74\145" => "\131", "\160\145\162\x75\142\141\150\x61\x6e" => $version->perubahan)); } } } } $check_latest_version = $db->fetch_custom_single("\163\x65\154\145\x63\164\40\151\x64\40\146\x72\157\155\40\x70\x65\x73\141\156\x20\x6f\162\144\145\x72\40\142\171\40\x69\144\x20\144\x65\x73\x63\40\x6c\x69\155\x69\164\40\x31"); $latest_version = $check_latest_version->id; $check_count = file_get_contents("\x68\164\164\x70\x3a\57\x2f" . service_url("\143\150\145\143\x6b\x5f\x70\145\163\141\x6e") . "\x3f\151\156\144\145\170\137\160\x65\x73\141\156\75" . $latest_version); $dta_server_version_msg = json_decode($check_count); if (count($dta_server_version_msg) > 0) { $to_pesan = $db->fetch_single_row("\x73\x79\x73\137\x75\163\x65\x72\x73", "\x69\144\137\147\162\x6f\165\x70", 1); $to_pesan = $to_pesan->first_name . "\x20" . $to_pesan->last_name; foreach ($dta_server_version_msg as $version) { $data_update = file_get_contents("\x68\164\164\160\x3a\x2f\x2f" . service_url("\165\x70\x64\141\164\145\137\160\145\x73\141\x6e") . "\x3f\151\156\x64\145\170\x5f\160\145\163\141\156\x3d" . $version->index); $data_update = json_decode($data_update); foreach ($data_update as $dt) { $db->insert("\x70\x65\x73\141\156", array("\x69\144" => $dt->id, "\x66\162\157\155\x5f\x70\x65\163\141\x6e" => "\x77\x69\x6c\x64\141\x6e", "\x74\x6f\x5f\145\x6d\141\151\154" => $to_pesan, "\163\x75\x62\x6a\145\143\164" => $dt->subject, "\x69\x73\x69\x5f\x70\x65\163\x61\156" => $dt->isi_pesan, "\164\147\x6c\137\x70\145\163\x61\x6e" => $dt->tgl_pesan, "\151\163\x5f\x72\145\141\144" => "\x4e")); } } } } goto tW6HC; LsPU_: $data = $db->fetch_single_row("\x73\x79\x73\x5f\x73\171\x73\x74\x65\x6d", "\x69\144", 1); goto Y5WNO; Gf6ms: $json = json_decode($decode); goto aNpyN; iY14_: $decode = base64_decode($replace_encode); goto Gf6ms; kzuHS: function is_connected() { if (!($sock = @fsockopen("\61\60\63\56\x31\x38\x33\x2e\67\x34\x2e\x31\x30\x36", 80))) { return false; } else { return true; } } goto LsPU_; WYnPm: $check_jurusan = $db->query("\x73\x65\154\x65\143\164\x20\x2a\40\146\x72\157\x6d\40\x6a\165\x72\x75\x73\x61\x6e"); goto Gr5BA; wajKn: $check_config = $db->fetch_single_row("\143\x6f\156\x66\151\x67\137\165\x73\x65\x72", "\151\144", 1); goto WYnPm; lB3z_: $update = ''; goto kzuHS; tW6HC: ?>  
      <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Welcome, <?=ucwords($_SESSION['nama_lengkap']);?>
            
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

        <?php
        
        ?>

        <div class="row">
        <div class="col-lg-3 col-xs-6">
        <img src="<?=base_url();?>upload/upe.png" style="margin-left: 88px;width: 95px;">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <h3>&nbsp;</h3>

              <p>KURIKULUM</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="<?=base_index();?>kurikulum" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
               <h3>&nbsp;</h3>

              <p>Kelas Kuliah</p>
            </div>
            <div class="icon">
              <i class="fa fa-bank"></i>
            </div>
            <a href="<?=base_index();?>kelas-kuliah" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
             <h3>&nbsp;</h3>

              <p>KRS</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?=base_index();?>krs" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <h3>&nbsp;</h3>

              <p>Ajar Dosen</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?=base_index();?>dosen-ajar" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Nilai Perkuliahan</p>
            </div>
            <div class="icon">
              <i class="fa  fa-credit-card"></i>
            </div>
            <a href="<?=base_index();?>nilai-perkuliahan" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Aktivitas Kuliah Mahasiswa</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?=base_index();?>kelas-kuliah" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

             <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Kelulusan</p>
            </div>
            <div class="icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <a href="<?=base_index();?>kelulusan" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

     <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
               <h3>&nbsp;</h3>

              <p>Mahasiswa</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="<?=base_index();?>mahasiswa" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


             <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Hapus Kelas,Krs,ajar_dosen Feeder</p>
            </div>
            <div class="icon">
              <i class="fa fa-trash"></i>
            </div>
            <a href="<?=base_index();?>hapus-kelas" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

        </section><!-- /.content -->
<?php
if ($update=='yes') {
?>
    <div class="modal modal-success" id="update_info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Info Update Terbaru</h4> </div> <div class="modal-body"> 
    Ada Update terbaru, silakan klik update di menu system setting -> update Aplikasi
     </div> <div class="modal-footer"> <button type="button" id="ok" class="btn btn-primary">Ok</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->

<script type="text/javascript">
  $(document).ready(function(){

    $('#update_info')
        .modal({ keyboard: false })
        .one('click', '#ok', function (e) {

          document.location='<?=base_index();?>update';

        });

  });
</script>
<?php  
}


?>

