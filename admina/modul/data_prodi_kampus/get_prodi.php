<?php
session_start();
include "../../inc/config.php";
session_check();

echo '<option value="all">Semua</option>';
foreach ($db->fetch_custom("select * from sms where id_sp='".$_POST['kampus']."' inner join jenjang_pendidikan on sms.id_jenj_didik=jenjang_pendidikan.id_jenj_didik") as $isi) {
echo "<option value='$isi->id_sms'>$isi->nm_jenj_didik $isi->nm_lemb</option>";
}

?>
