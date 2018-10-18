
<?php
switch ($path_act) {
  case "tambah":
  $id_jur = $path_id;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "kelas_kuliah_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
  $id_jur = $path_four;
    $data_edit = $db->fetch_single_row("kelas_kuliah","id",$path_id);
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "kelas_kuliah_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
      case "detail":
    $data_edit = $db->fetch_single_row("kelas_kuliah","id",$path_id);
    include "kelas_kuliah_detail.php";
    break;
     case 'import':
      include "import.php";
      break;
    case 'choose':
    $id_jur = $path_id;

       include "kelas_kuliah_view_detail.php";
      break;
  default:
    include "kelas_kuliah_view.php";
    break;
}

?>