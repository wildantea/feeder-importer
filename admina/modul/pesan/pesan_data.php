
<?php

include "../../inc/config.php";


$tes=$dtable->get("pesan", "pesan.id", array('pesan.from_pesan','pesan.subject','pesan.tgl_pesan','pesan.is_read',"pesan.id"),"");


?>