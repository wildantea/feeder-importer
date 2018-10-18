<?php
include "../../inc/config.php";

 
$columns = array(
  
  'dwc.id_wil',
  'data_wilayah.nm_wil',
  'dw.nm_wil',
  'dwc.nm_wil',

  );

  
//set order by column 
$clean->set_order_by("dwc.nm_wil");
$clean->disable_search = array('data_wilayah.nm_wil','dw.nm_wil');
//set order by type 
$clean->set_order_type("asc");

if (isset($_POST['provinsi'])) {
    if ($_POST['provinsi']=='all') {
        $provinsi = '';
    } else {
        $provinsi = " and data_wilayah.id_wil='".$_POST['provinsi']."'";
    }

    if ($_POST['kabupaten']=='all') {
      $kabupaten = '';
    } else {
      $kabupaten = " and dw.id_wil='".$_POST['kabupaten']."'";
    }

     $query = $clean->get_custom("select dwc.id_wil as id_wil, data_wilayah.nm_wil as provinsi,dw.nm_wil as kab,dwc.nm_wil as kecamatan from data_wilayah
inner join data_wilayah dw on data_wilayah.id_wil=dw.id_induk_wilayah
inner join data_wilayah dwc on dw.id_wil=dwc.id_induk_wilayah
where data_wilayah.id_level_wil='1' $provinsi $kabupaten",$columns);

} else {

    $query = $clean->get_custom("select dwc.id_wil as id_wil, data_wilayah.nm_wil as provinsi,dw.nm_wil as kab,dwc.nm_wil as kecamatan from data_wilayah
inner join data_wilayah dw on data_wilayah.id_wil=dw.id_induk_wilayah
inner join data_wilayah dwc on dw.id_wil=dwc.id_induk_wilayah
where data_wilayah.id_level_wil='1'",$columns);
}



//set group by column
//$new_table->group_by = "group by kabupaten.id_kab";


  //buat inisialisasi array data
  $data = array();

 $i=1;
  foreach ($query as $value) {

  //array data
  $ResultData = array();

  
  
  $ResultData[] = $value->id_wil;
  $ResultData[] = $value->provinsi;
  $ResultData[] = $value->kab;
  $ResultData[] = $value->kecamatan;


  $data[] = $ResultData;
  $i++;
}

//set data
$clean->set_data($data);
//create our json
$clean->create_data();

?>
