
<?php
switch ($path_act) {
  case "tambah":
    $id_jur = $path_id;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "kelulusan_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
    $id_jur = $path_four;
    $data_edit = $db->fetch_single_row("kelulusan","id",$path_id);
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "kelulusan_edit.php";
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
    $data_edit = $db->fetch_single_row("kelulusan","id",$path_id);
    include "kelulusan_detail.php";
    break;
    case 'choose':
     $id_jur = $path_id;

       include "kelulusan_view_detail.php";
    break;
  default:
    include "kelulusan_view.php";
    break;
}

?>