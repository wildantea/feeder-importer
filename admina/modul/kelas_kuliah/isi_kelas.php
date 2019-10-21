<?php
session_start();
include "../../inc/config.php";
session_check();

echo '<option value="all">Semua</option>';
foreach ($db->query("select * from kelas_kuliah where semester='".$_POST['semester']."' and kode_jurusan='".$_POST['jurusan']."' and kode_mk='".$_POST['kode_mk']."' group by kelas_kuliah.nama_kelas order by kelas_kuliah.nama_kelas asc") as $isi) {
echo "<option value='$isi->nama_kelas'>$isi->nama_kelas</option>";
} 


?>