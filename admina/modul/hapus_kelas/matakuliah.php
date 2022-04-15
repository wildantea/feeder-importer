<?php
include "../../inc/config.php";
$token = get_token();

    $filter_kelas = "id_prodi='".$_POST['jurusan']."' and id_semester='".$_POST['semester']."'";

                $temp_data_kelas = [
      'act' => 'GetDetailKelasKuliah',
        'token' => $token,
        'filter' => $filter_kelas,
        'order' => "id_semester DESC",
        'limit' => "",
        'offset' => ""

    ];


    $kelas = service_request($temp_data_kelas);



foreach ($kelas->data as $data_kelas) {
    $array_kode_mk[$data_kelas->id_matkul] = $data_kelas->nama_mata_kuliah;
}
$kode_mk_group = array_unique($array_kode_mk);

echo '<option value="all">Semua</option>';
foreach ($kode_mk_group as $isi => $data) {
echo "<option value='".$isi."'>".$data."</option>";
} 
