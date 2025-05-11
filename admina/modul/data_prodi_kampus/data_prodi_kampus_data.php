<?php
include "../../inc/config.php";

$columns = array(
  'satuan_pendidikan.nm_lemb',
  'satuan_pendidikan.npsn',
	'sms.nm_lemb',
	'jenjang_pendidikan.nm_jenj_didik',
	'kode_prodi'
  );

  
//set order by column 
$clean->set_order_by("satuan_pendidikan.nm_lemb");
//set order by type 
$clean->set_order_type("asc");

if (isset($_POST['kampus'])) {
    if ($_POST['kampus']=='all') {
        $kampus = '';
    } else {
        $kampus = " and satuan_pendidikan.id_sp='".$_POST['kampus']."'";
    }

     $query = $clean->get_custom("select jenjang_pendidikan.nm_jenj_didik,npsn,sms.nm_lemb as prodi,kode_prodi,satuan_pendidikan.nm_lemb as kampus from sms inner join satuan_pendidikan on sms.id_sp=satuan_pendidikan.id_sp inner join jenjang_pendidikan on sms.id_jenj_didik=jenjang_pendidikan.id_jenj_didik where satuan_pendidikan.id_sp is not null $kampus ",$columns);

} else {
    $query = $clean->get_custom("select jenjang_pendidikan.nm_jenj_didik,npsn,sms.nm_lemb as prodi,kode_prodi,satuan_pendidikan.nm_lemb as kampus,jenjang_pendidikan.nm_jenj_didik from sms inner join satuan_pendidikan on sms.id_sp=satuan_pendidikan.id_sp left join jenjang_pendidikan on sms.id_jenj_didik=jenjang_pendidikan.id_jenj_didik ",$columns);
}



//set group by column
//$new_table->group_by = "group by kabupaten.id_kab";


  //buat inisialisasi array data
  $data = array();

 $i=1;
  foreach ($query as $value) {

  //array data
  $ResultData = array();

  
  
	$ResultData[] = $value->kampus;
  $ResultData[] = $value->npsn;
	$ResultData[] = $value->prodi;
		$ResultData[] = $value->nm_jenj_didik;
	
	$ResultData[] = $value->kode_prodi;
	
  $data[] = $ResultData;
  $i++;
}

//set data
$clean->set_data($data);
//create our json
$clean->create_data();

?>