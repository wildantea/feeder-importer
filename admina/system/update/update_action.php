<?php
include "../../inc/config.php";
require_once "../../lib/dUnzip2.inc.php";

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

if (is_connected()) {
    
$check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");

$check_kode_pt = $db->fetch_single_row('config_user','id',1)->kode_pt;

$check_count = file_get_contents('https://wildantea.com/importer-free-up/count_version_left.php?local_last='.$check_latest_version->version.'&kode_pt='.$check_kode_pt.'&do_update=yes');

$dta_server_version = json_decode($check_count);



if (count($dta_server_version)>0) {
    foreach ($dta_server_version as $version) {
          $data_update = file_get_contents('https://wildantea.com/importer-free-up/update.php?version='.$version->version.'&kode_pt='.$check_kode_pt);

          $data_update = json_decode($data_update);


          $sukses=0;
          $success=array();
          $create = "";
            foreach ($data_update as $dt) {

              if ($dt->type_update=='data') {

                file_put_contents(SITE_ROOT."upload/".$dt->nama_file, fopen('https://wildantea.com/importer-free-up/data/'.$version->version.'/'.$dt->nama_file, 'r'));
                $zip = new dUnzip2(SITE_ROOT."upload/".$dt->nama_file);
                $zip->debug = 0; // debug?

                $zip->unzipAll(SITE_ROOT);
                $zip->__destroy();

                unlink(SITE_ROOT."upload/".$dt->nama_file);
                $sukses++;

              } elseif ($dt->type_update=='sql') {
                   $dbs = file_get_contents('https://wildantea.com/importer-free-up/data/'.$version->version.'/'.$dt->nama_file);
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
       
           $db->insert('sys_update',array('version' => $version->version,'status_complete' => 'Y','perubahan' => $version->perubahan));
          }

                if (($sukses>0)) {
            $msg =  "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\" >
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
                <font color=\"#3c763d\">Feeder Importer berhasil di Update</font><br />";
                $msg .= "</div>
              </div>";
          }
            
            echo $msg;
} else {
  echo "Aplikasi Masih Terbaru";
}

} else {
  echo "Pastikan Anda Terkoneksi ke Internet";
}
?>