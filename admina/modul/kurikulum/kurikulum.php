
<?php
switch ($path_act) {
  case "tambah":
   $id_jur = $path_id;
          foreach ($db->fetch_all("sys_menu") as $isi) {
               if ($path_url==$isi->url&&$path_act=="tambah") {
                          if ($role_act["insert_act"]=="Y") {
                             include "kurikulum_add.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }
    break;
  case "edit":
    $data_edit = $db->fetch_single_row("kurikulum","id",$path_id);
        foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url&&$path_act=="edit") {
                          if ($role_act["up_act"]=="Y") {
                             include "kurikulum_edit.php";
                          } else {
                            echo "permission denied";
                          }
                       } 

      }

    break;
    case 'kurmat':
      $data_edit = $db->query("select mk.id, k.nama_kur,mk.kode_mk,mk.nama_mk,mk.jns_mk from mat_kurikulum mk inner join kurikulum k
on mk.id_kurikulum=k.id and k.id=?",array("k.id" =>$path_id));
      foreach ($data_edit as $dt) {
       
      }
      $tahun = $path_id;
      $id_kur = $path_id;
      $id_jur = $path_four;
       include "mat_kurikulum.php";
      break;
         case "detail":
    $data_edit = $db->fetch_single_row("kurikulum","id",$path_id);
    include "kurikulum_detail.php";
    break;
  case 'choose':
    $id_jur = $path_id;

       include "kurikulum_view_detail.php";
      break;
  default:
    include "kurikulum_view.php";
    break;
}

?>