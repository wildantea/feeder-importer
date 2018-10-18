<?php
session_start();
include "../../inc/config.php";
session_check();

echo '<option value="all">Semua</option>';
foreach ($db->fetch_custom("select * from data_wilayah where id_induk_wilayah='".$_POST['provinsi']."'") as $isi) {
echo "<option value='$isi->id_wil'>$isi->nm_wil</option>";
}

?>
