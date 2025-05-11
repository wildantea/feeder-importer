<?php
      session_start();
      include "../../inc/config.php";

      $id_sp = $_POST["id_sp"];

      $id_sp_kode = $db->fetch_single_row("satuan_pendidikan","npsn",$id_sp);

      $data = $db->fetch_custom("SELECT concat(nm_jenj_didik,' ',nm_lemb) as nama_jurusan,kode_prodi from jenjang_pendidikan INNER join sms USING(id_jenj_didik) where id_sp=?",array("id_sp" => $id_sp_kode->id_sp));
       echo "<option value=''>Pilih Prodi Asal</option>";
      foreach ($data as $dt) {
        echo "<option value='$dt->kode_prodi'>$dt->nama_jurusan</option>";
      }
      