
<?php
switch ($path_act) {
  case "tambah":
   $id_jur = $path_id;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "dosen_ajar_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
  $id_jur = $path_four;
    $data_edit = $db->fetch_single_row("ajar_dosen","id",$path_id);
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "dosen_ajar_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
      case 'import':
      include "import.php";
      break;
      case "detail":
    $data_edit = $db->fetch_single_row("krs","id",$path_id);
    include "krs_detail.php";
    break;
  case 'choose':
   $id_jur = $path_id;

       include "dosen_ajar_view_detail.php";
      break;
  default:
    include "dosen_ajar_view.php";
    break;
}

?>