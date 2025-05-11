<?php
include "../../inc/config.php";
require_once "../../lib/dUnzip2.inc.php";

function is_connected()
{
  if(!$sock = @fsockopen('103.183.74.106', 80))
  {
     return false;
  }
  else
  {
      return true;
  }


} 
function service_url($param) {
  global $db;
  $data = $db->fetch_single_row('sys_system','id',2);
  $replace_encode = substr_replace($data->data, '', 3 , 3);
  $decode = base64_decode($replace_encode);
  $json = json_decode($decode);
  // dump($json);
  $result = $json->$param;

  return $result;
}

if (is_connected()) {
    
$check_latest_version = $db->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");

$check_kode_pt = $db->fetch_single_row('config_user','id',1)->kode_pt;

$check_count = file_get_contents('http://'.service_url('check_version').'?kode_pt='.$check_kode_pt.'&local_last='.$check_latest_version->version.'&date='.date('Y-m-dH:i:s'));

$dta_server_version = json_decode($check_count);


if (count($dta_server_version)>0) {

    foreach ($dta_server_version as $version) {
          $data_update = file_get_contents('http://'.service_url('data_update').'?version='.$version->version.'&kode_pt='.$check_kode_pt);

          $data_update = json_decode($data_update);


          $sukses=0;
          $success=array();
          $create = "";
            foreach ($data_update as $dt) {

              if ($dt->type_update=='data') {
                file_put_contents(SITE_ROOT."upload/".$dt->nama_file, fopen('http://'.service_url('data_update_file').$version->version.'/'.$dt->nama_file, 'r'));
                $file = SITE_ROOT."upload/".$dt->nama_file;
                $zip = new dUnzip2(SITE_ROOT."upload/".$dt->nama_file);
                $zip->debug = 0; // debug?
                $zip->unzipAll(SITE_ROOT);
                $zip->__destroy();
                unlink(SITE_ROOT."upload/".$dt->nama_file);
                $sukses++;

              } elseif ($dt->type_update=='sql') {
                   $dbs = file_get_contents('http://'.service_url('data_update_file').$version->version.'/'.$dt->nama_file);
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