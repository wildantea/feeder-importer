<?php
 function check_token() {
    global $db;
    $config = $db->fetch_single_row('config_user','id',1);

      $data = array(
        'act' => 'GetToken',
        'username' => dec_data($config->username),
        'password' => dec_data($config->password)
      );
      $result = service_request($data);
      if ($result->data) {
         $token = $result->data->token;
         $array_return = array(
          'status' => 1,'error' => '','token' => $token);
         return $array_return;

      } else {
        $array_return = array(
          'status' => 0,'error' => $result->error_desc,'token' => '');
         return $array_return;
         //exit();
      }
     

  }
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function validateDateTime($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
function tgl_indo_angka($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDate($date)) {
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      
      $result = $tgl . "-" . $bulan . "-". $tahun;
      return($result);
  } else {
    return '';
  }

}
function dump($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}
  function get_token() {
    if (check_token()['status']=='1') {
      return check_token()['token'];
    } else {
      echo check_token()['error'];
      //exit();
    }
  }
function convert_ascii($string) 
{ 
  // Replace Single Curly Quotes
  $search[]  = chr(226).chr(128).chr(152);
  $replace[] = "'";
  $search[]  = chr(226).chr(128).chr(153);
  $replace[] = "'";
  // Replace Smart Double Curly Quotes
  $search[]  = chr(226).chr(128).chr(156);
  $replace[] = '"';
  $search[]  = chr(226).chr(128).chr(157);
  $replace[] = '"';
  // Replace En Dash
  $search[]  = chr(226).chr(128).chr(147);
  $replace[] = '--';
  // Replace Em Dash
  $search[]  = chr(226).chr(128).chr(148);
  $replace[] = '---';
  // Replace Bullet
  $search[]  = chr(226).chr(128).chr(162);
  $replace[] = '*';
  // Replace Middle Dot
  $search[]  = chr(194).chr(183);
  $replace[] = '*';
  // Replace Ellipsis with three consecutive dots
  $search[]  = chr(226).chr(128).chr(166);
  $replace[] = '...';
  // Apply Replacements
  $string = str_replace($search, $replace, $string);
  // Remove any non-ASCII Characters
  $string = preg_replace("/[^\x01-\x7F]/","", $string);
  $string = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

  $string = preg_replace( '/[^[:print:]]/', '',$string);
  $string = trim($string);
  return $string; 
}
  function dec_data($data) {
  $replace_encode = substr_replace($data, '', 3 , 3);
  $decode = base64_decode($replace_encode);
  $json_sys = json_decode($decode);
  return $json_sys;
}

  function get_service_url($type='rest') {
    global $db;
    $config = $db->fetch_single_row('config_user','id',1);
    $url = 'http://'.$config->url.':'.$config->port.'/ws/live2.php'; // gunakan live
    return $url;
  }

  function service_request($data,$url='') {
      if ($url=='') {
        $url = get_service_url('rest');
      }
      
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_POST, 1); 

      $headers = array();
      $headers[] = 'Content-Type: application/json';

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      $data = json_encode($data);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      //curl_setopt($ch, CURLOPT_HEADER, 1);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt($ch, CURLOPT_TIMEOUT, 0);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $result = curl_exec($ch);

      //dump($data);

      //print_r($data);
      curl_close($ch);

      return json_decode($result);
  }