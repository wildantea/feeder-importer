<?php
session_start();
include "../../inc/config.php";
session_check();

echo '<option value="all">Semua</option>';
foreach ($db->query("select * from nilai where semester='".$_POST['semester']."' and kode_jurusan='".$_POST['jurusan']."' group by kode_mk order by nama_mk asc") as $isi) {
echo "<option value='$isi->kode_mk'>$isi->kode_mk $isi->nama_mk</option>";
}

?>
