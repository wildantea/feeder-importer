
<?php
switch ($path_act) {
  case "tambah":
     $id_jur = $path_id;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "mahasiswa_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
     $id_jur = $path_four;
    $data_edit = $db->fetch_custom_single("select * from mhs where id=?",array("mhs.id" =>$path_id));
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "mahasiswa_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
      case "detail":
       $id_jur = $path_four;
    $data_edit = $db->query("select * from mhs inner join mhs_pt on mhs.id=mhs_pt.id_mhs","mhs.id",$path_id);
    include "mahasiswa_detail.php";

      case 'choose':
 $id_jur = $path_id;

       include "mahasiswa_view_detail.php";
      break;
  case 'import':
  $id_jur = $path_id;
      include "import.php";
      break;
    break;
  default:
    include "mahasiswa_view.php";
    break;
}

?>