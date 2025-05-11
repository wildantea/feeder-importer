<?php
include "../../inc/config.php";
$json_response = array();
/**
 * curl posting or getting data 
 * @param  string $url  url to post or get
 * @param  array  $post array post data if any
 * @param  array  $get  array for get parameter if any
 * @return object       object result
 */
function post_data($url,$post=array(),$get=array(),$header) 
{ 
   $ch = curl_init(); 
   $postvars = "";
   $get_vars = "";
   if ($header=='json') {
     $postvars = json_encode($post);
   } else {
     if (!empty($post)) {
          $array_post_var = array();
          foreach($post as $key=>$value) {
              $array_post_var[] = $key . "=" . $value;
          }
          $postvars = implode("&", $array_post_var);
     }
   }

   if (!empty($get)) {
        $array_get_var = array();
        foreach($get as $key=>$value) {
            $array_get_var[] = $key . "=" . $value;
        }
        $get_vars = implode("&", $array_get_var);
        curl_setopt ($ch, CURLOPT_URL, $url."?".$get_vars); 
   } else {
        curl_setopt ($ch, CURLOPT_URL, $url); 
   }

   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
   if (!empty($post)) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars); 
   }
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
   $result = curl_exec($ch); 

   //$http_respond = trim( strip_tags( $result ) );
   $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

   curl_close($ch); 
   return $result;
}
if ($_POST['total_data']<1) {
    $msg =  "<div class=\"alert alert-warning \" role=\"alert\">
        <font color=\"#3c763d\">Tidak ada data berhasil di Download</font><br />
        </div>";

    $jumlah['last_notif'] = $msg;
    array_push($json_response, $jumlah);

    echo json_encode($json_response);
    exit();
}


$offset = $_POST['offset'];

$jumlah['offset'] = $offset;

$limit = 101;

        $temp_rec = array();
        $data_rec_sms = array();
$data_rec_sms = array();
$id_sp = array();
$temp_rec_data = file_get_contents("http://103.183.74.106/services/get_kampus.php?offset=$offset");
$temp_rec = json_decode($temp_rec_data);
                    foreach ($temp_rec as $key) {
                    $data_rec_kampus[] = array(
                       'id_sp' => convert_ascii($key->id_sp),
                       'nm_lemb' => convert_ascii($key->nm_lemb),
                       'npsn' => convert_ascii($key->npsn),
                       'id_wil' => convert_ascii($key->id_wil)
                       );
                    $id_sp[] = "'".$key->id_sp."'";
                    }

/*$temp_rec_data_sms = file_get_contents("http://103.183.74.106/services/get_sms.php?id_sp=$key->id_sp");
$temp_rec_sms = json_decode($temp_rec_data_sms);

*/

$db->insertMulti('satuan_pendidikan',$data_rec_kampus);
//get sms
if (!empty($id_sp)) {
  $implode_id_sp = implode(",", $id_sp);
$data_post = array(
  'id_sp' => $implode_id_sp
);
$post_data = post_data('http://103.183.74.106/services/get_sms.php',$data_post,array(),'POST');
$decode_data = json_decode($post_data);
//dump($post_data);

if (!empty($decode_data)) {
  foreach ($decode_data as $sms) {
    //dump($sms);
                    $data_rec_sms[] = array(
                       'id_sms' => convert_ascii($sms->id_sms),
                       'nm_lemb' => convert_ascii($sms->nm_lemb),
                       'kode_prodi' => convert_ascii($sms->kode_prodi),
                       'id_sp' => convert_ascii($sms->id_sp),
                       'id_jenj_didik' => (int) $sms->id_jenj_didik
                       );
                    //dump($data_rec_sms);
  }

}

//echo $db->getErrorMessage();
  if (!empty($data_rec_sms)) {
   // echo "yes";
      $db->insertMulti('sms',$data_rec_sms);
  }
}


//echo $db->getErrorMessage();
if ($_POST['last']=='yes') {
  $jumlah_total = $_POST['total_data'];
$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
        <font color=\"#3c763d\">".$jumlah_total." data berhasil di Download</font><br />";
        $msg .= "</div>
        </div>";

        $jumlah['last_notif'] = $msg;
}

array_push($json_response, $jumlah);

echo json_encode($json_response);
exit();

?>