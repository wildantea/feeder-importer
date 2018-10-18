
<?php
switch ($path_act) {
  case "tambah":
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "hapus_akm_feeder_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
    $data_edit = $db->fetch_single_row("config_user","id",$path_id);
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "hapus_akm_feeder_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
      case 'choose':
    $id_jur = $path_id;

       include "hapus_akm_feeder_view.php";
      break;
      case "detail":
    $data_edit = $db->fetch_single_row("config_user","id",$path_id);
    include "hapus_akm_feeder_detail.php";
    break;
  default:
    include "hapus_akm_feeder_views.php";
    break;
}

?>