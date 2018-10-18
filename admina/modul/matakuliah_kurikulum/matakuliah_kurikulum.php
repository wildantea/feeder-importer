
<?php
switch ($path_act) {
  case "tambah":
   $id_kur = $path_id;
  $id_jur = $path_four;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "matakuliah_kurikulum_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case 'import':
      include "import.php";
      break;
  case "edit":
    $data_edit = $db->fetch_single_row("mat_kurikulum","id",$path_id);
    $id_kur = $path_four;
    $id_jur = $path_five;
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "matakuliah_kurikulum_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
      case "detail":
    $data_edit = $db->fetch_single_row("mat_kurikulum","id",$path_id);
    include "matakuliah_kurikulum_detail.php";
    break;
  default:
    include "matakuliah_kurikulum_view.php";
    break;
}

?>