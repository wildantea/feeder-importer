<?php
      session_start();
      include "../../inc/config.php";

      $provinsi = $_POST["id_kab"];

      $data = $db->query("select * from data_wilayah where id_induk_wilayah=?",array("id_prov" => $provinsi));
       echo "<option value=''>Pilih </option>";
      foreach ($data as $dt) {
        echo "<option value='$dt->id_wil'>$dt->nm_wil</option>";
      }
      