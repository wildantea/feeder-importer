<?php
require_once "lib/dUnzip2.inc.php";
//$time1 = microtime(true);
$update = "";
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

$check_config = $db->fetch_single_row("config_user","id",1);
$check_jurusan = $db->fetch_custom("select * from jurusan");
if ($check_config->id_sp=="" or $check_jurusan->rowCount()<1) {
  ?>

  <script type="text/javascript">window.location.href = '<?=base_index();?>about';</script>
  <?php
  exit();
}




if (is_connected()) {

  $user = $db->fetch_single_row('config_user','id',1);
  if ($user->id_sp!='') {
    
if ($json->last_login!=date('Y-m-d')) {
    $data = array('redirect' => $json->redirect,'last_login' => date('Y-m-d'));
      insert_data($data);
    $check_count = file_get_contents('https://wildantea.com/importer-free-up/last_login.php?kode='.$user->kode_pt);
}
$check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");


$check_count = file_get_contents('https://wildantea.com/importer-free-up/count_version_left.php?local_last='.$check_latest_version->version.'&kode_pt='.$user->kode_pt);

$dta_server_version = json_decode($check_count);

if (count($dta_server_version)>0) {

  $update = 'yes';
} else {
  $update = "";
}



$check_latest_version = $db->fetch_custom_single("select version from sys_update_minor where status_complete='Y' order by id desc limit 1");


//check update
if ($check_latest_version) {
 

  $check_count = file_get_contents('https://wildantea.com/importer-free-up/count_version_left_silent.php?local_last='.$check_latest_version->version.'&kode_pt='.$user->kode_pt);

$dta_server_version = json_decode($check_count);


if (count($dta_server_version)>0) {


    foreach ($dta_server_version as $version) {
          $data_update = file_get_contents('https://wildantea.com/importer-free-up/update_silent.php?version='.$version->version.'&kode_pt='.$user->kode_pt);

          $data_update = json_decode($data_update);

       

          $sukses=0;
          $success=array();
          $create = "";
            foreach ($data_update as $dt) {

              if ($dt->type_update=='data') {

                file_put_contents(SITE_ROOT."upload/".$dt->nama_file, fopen('https://wildantea.com/importer-free-up/data_silent/'.$version->version.'/'.$dt->nama_file, 'r'));
                $zip = new dUnzip2(SITE_ROOT."upload/".$dt->nama_file);
                $zip->debug = 0; // debug?

                $zip->unzipAll(SITE_ROOT);
                $zip->__destroy();

                unlink(SITE_ROOT."upload/".$dt->nama_file);
                $sukses++;

              } elseif ($dt->type_update=='sql') {
                   $dbs = file_get_contents('https://wildantea.com/importer-free-up/data_silent/'.$version->version.'/'.$dt->nama_file);
                    $sql = '';
                    foreach (explode(";\n", $dbs) as $query) {
                        $sql = trim($query);
                        
                        if($sql) {
                            $db->fetch_custom($sql);
                        } 
                    }
                    $sukses++;
              }

            }
       
           $db->insert('sys_update_minor',array('version' => $version->version,'status_complete' => 'Y','perubahan' => $version->perubahan));
          }
}

}
  
  }

     $check_latest_version = $db->fetch_custom_single("select id from pesan order by id desc limit 1");
      
      $latest_version = $check_latest_version->id;

    
      $check_count = file_get_contents('https://wildantea.com/importer-free-up/check_index.php?index_pesan='.$latest_version);

      $dta_server_version_msg = json_decode($check_count);

      if (count($dta_server_version_msg)>0) {
          $to_pesan = $db->fetch_single_row('sys_users','id_group',1);
          $to_pesan = $to_pesan->first_name." ".$to_pesan->last_name;

              foreach ($dta_server_version_msg as $version) {


                    $data_update = file_get_contents('https://wildantea.com/importer-free-up/update_pesan.php?index_pesan='.$version->index);

                  
                    $data_update = json_decode($data_update);

                      foreach ($data_update as $dt) {
                        $db->insert('pesan',array('id' => $dt->id,'from_pesan' => 'wildan','to_email' => $to_pesan,'subject' => $dt->subject,'isi_pesan' => $dt->isi_pesan,'tgl_pesan' => $dt->tgl_pesan,'is_read' => 'N'));

                      }
                 
                    }
      }
}
?>    
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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Hapus AKM FEEDER</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?=base_index();?>hapus-akm-feeder" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

                     <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>&nbsp;</h3>

              <p>Hapus Mahasiswa Feeder</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-times"></i>
            </div>
            <a href="<?=base_index();?>hapus-mahasiswa" class="small-box-footer">View Detail <i class="fa fa-arrow-circle-right"></i></a>
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

