<?php
/**
 * PDO mysql database helper class
 *
 * @author wildantea <wildannudin@gmail.com>
 * @copyright june 2013
 */
class Database {

    protected $pdo;

    public $type_db;

     public function __construct($type)
    {
        try {
            if ($type=='mysql') {
                  $this->pdo = new PDO($type.":host=".HOST.":".PORT.";dbname=".DATABASE_NAME, DB_USERNAME, DB_PASSWORD );
      
            } else {
                  $this->pdo = new PDO($type.":host=".PG_HOST.";port=".PG_PORT.";dbname=".PG_DATABASE_NAME.";user=".PG_DB_USERNAME.";password=".PG_DB_PASSWORD );
      
            }
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch( PDOException $e ) {
            echo "error ". $e->getMessage();
        }
    }


   /* public function __construct($type)
    {
        $this->type_db = $type;
        try {
            if ($this->type=='mysql') {
                  $this->pdo = new PDO($this->type_db.":host=".HOST.":".PORT.";dbname=".DATABASE_NAME, DB_USERNAME, DB_PASSWORD );
      
            } else {
                  $this->pdo = new PDO($this->type_db.":host=".PG_HOST.";port=".PG_PORT.";dbname=".PG_DATABASE_NAME.";user=".PG_DB_USERNAME.";password=".PG_DB_PASSWORD );
      
            }
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch( PDOException $e ) {
            echo "error ". $e->getMessage();
        }
    }*/

    /**
    * custom query , joining multiple table, aritmathic etc
    * @param  string $sql  custom query
    * @param  array $data associative array
    * @return array  recordset
    */
    public function fetch_custom( $sql,$data=null) {
        if ($data!==null) {
        $dat=array_values($data);
        }
        $sel = $this->pdo->prepare( $sql );
        if ($data!==null) {
            $sel->execute($dat);
        } else {
            $sel->execute();
        }
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return $sel;

    }



    /**
    * fetch only one row
    * @param  string $table table name
    * @param  string $col condition column
    * @param  string $val value column
    * @return array recordset
    */
    public function fetch_single_row($table,$col,$val)
    {
        $nilai=array($val);
        $sel = $this->pdo->prepare("SELECT * FROM $table WHERE $col=?");
        $sel->execute($nilai);
        $sel->setFetchMode( PDO::FETCH_OBJ );
        $obj = $sel->fetch();
        return $obj;
    }

    public function fetch_custom_single($sql,$data=null)
    {
        if ($data!==null) {
        $dat=array_values($data);
        }
        $sel = $this->pdo->prepare( $sql );
        if ($data!==null) {
            $sel->execute($dat);
        } else {
            $sel->execute();
        }
        $sel->setFetchMode( PDO::FETCH_OBJ );
         $obj = $sel->fetch();
        return $obj;
    }

    /**
    * fetch all data
    * @param  string $table table name
    * @return array recordset
    */
    public function fetch_all($table)
    {
        $sel = $this->pdo->prepare("SELECT * FROM $table");
        $sel->execute();
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return $sel;
    }
    /**
    * fetch multiple row
    * @param  string $table table name
    * @param  array $dat specific column selection
    * @return array recordset
    */
    public function fetch_col($table,$dat)
    {
        if( $dat !== null )
        $cols= array_values( $dat );
        $col=implode(', ', $cols);
        $sel = $this->pdo->prepare("SELECT $col from $table");
        $sel->execute();
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return $sel;
    }

    /**
    * fetch row with condition
    * @param  string $table table name
    * @param  array $col which columns name would be select
    * @param  array $where what column will be the condition
    * @return array recordset
    */
    public function fetch_multi_row($table,$col,$where)
    {

        $data = array_values( $where );
        //grab keys
        $cols=array_keys($where);
        $colum=implode(', ', $col);
        foreach ($cols as $key) {
          $keys=$key."=?";
          $mark[]=$keys;
        }

        $jum=count($where);
        if ($jum>1) {
            $im=implode('? and  ', $mark);
             $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        } else {
          $im=implode('', $mark);
             $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        }
        $sel->execute( $data );
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return  $sel;
    }

    /**
    * check if there is exist data
    * @param  string $table table name
    * @param  array $dat array list of data to find
    * @return true or false
    */
    public function check_exist($table,$dat) {

        $data = array_values( $dat );
       //grab keys
        $cols=array_keys($dat);
        $col=implode(', ', $cols);

        foreach ($cols as $key) {
          $keys=$key."=?";
          $mark[]=$keys;
        }

        $jum=count($dat);
        if ($jum>1) {
            $im=implode(' and  ', $mark);
             $sel = $this->pdo->prepare("SELECT $col from $table WHERE $im");
        } else {
          $im=implode('', $mark);
             $sel = $this->pdo->prepare("SELECT $col from $table WHERE $im");
        }
        $sel->execute( $data );
        $sel->setFetchMode( PDO::FETCH_OBJ );
        $jum=$sel->rowCount();
        if ($jum>0) {
            return true;
        } else {
            return false;
        }
    }
    /**
    * search data
    * @param  string $table table name
    * @param  array $col   column name
    * @param  array $where where condition
    * @return array recordset
    */
    public function search($table,$col,$where) {
        $data = array_values( $where );
        foreach ($data as $key) {
           $val = '%'.$key.'%';
           $value[]=$val;
        }
       //grab keys
        $cols=array_keys($where);
        $colum=implode(', ', $col);

        foreach ($cols as $key) {
          $keys=$key." LIKE ?";
          $mark[]=$keys;
        }
        $jum=count($where);
        if ($jum>1) {
            $im=implode(' OR  ', $mark);
             $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        } else {
          $im=implode('', $mark);
             $sel = $this->pdo->prepare("SELECT $colum from $table WHERE $im");
        }

        $sel->execute($value);
        $sel->setFetchMode( PDO::FETCH_OBJ );
        return  $sel;
    }
    /**
    * insert data to table
    * @param  string $table table name
    * @param  array $dat   associative array 'column_name'=>'val'
    */
    public function insert($table,$dat) {

        if( $dat !== null )
        $data = array_values( $dat );
        //grab keys
        $cols=array_keys($dat);
        $col=implode(', ', $cols);

        //grab values and change it value
        $mark=array();
        foreach ($data as $key) {
          $keys='?';
          $mark[]=$keys;
        }
        $im=implode(', ', $mark);
        $ins = $this->pdo->prepare("INSERT INTO $table ($col) values ($im)");

        $ins->execute( $data );
        

    }

    public function get_last_id()
    {
        return $this->pdo->lastInsertId();
    }

    /**
    * update record
    * @param  string $table table name
    * @param  array $dat   associative array 'col'=>'val'
    * @param  string $id    primary key column name
    * @param  int $val   key value
    */
    public function update($table,$dat,$id,$val) {
        if( $dat !== null )
        $data = array_values( $dat );
        array_push($data,$val);
        //grab keys
        $cols=array_keys($dat);
        $mark=array();
        foreach ($cols as $col) {
        $mark[]=$col."=?";
        }
        $im=implode(', ', $mark);
        $ins = $this->pdo->prepare("UPDATE $table SET $im where $id=?");
        $ins->execute( $data );

    }

    /**
    * delete record
    * @param  string $table table name
    * @param  string $where column name for condition (commonly primay key column name)
    * @param   int $id   key value
    */
    public function delete( $table, $where,$id ) {
        $data = array( $id );
        $sel = $this->pdo->prepare("Delete from $table where $where=?" );
        $sel->execute( $data );
    }


    public function __destruct() {
    $this->pdo = null;
    }

    function get_settings($name){
    if(is_file("settings.cfg")) $file = "settings.cfg";
    else if (is_file("inc/settings.cfg")) $file = "inc/settings.cfg";
    else return "";

    $con = file_get_contents($file);
    $patt = '/'.$name.'.*=(.*)/i';
    preg_match($patt, $con, $match);
    return $match[1];
    }

    function set_settings($name, $value){
        if(is_file("settings.cfg")) $file = "settings.cfg";
        else if (is_file("inc/settings.cfg")) $file = "inc/settings.cfg";
        else return "";

        $con = file_get_contents($file);

        $lines = explode("\n", $con);
        $settings = "";
        foreach($lines as $line){
            $line = trim($line);
            if($line != ""){
                $setting = explode("=", $line, 2);
                if(count($setting)==2){
                    $var = trim($setting[0]);
                    $val = trim($setting[1]);
                    if(stripos($var,$name)===0){
                        $settings .= trim($name)."=".trim($value)."\n";
                    }
                    else $settings .= $line."\n";
                }
            }
        }
        file_put_contents($file, $settings);
    }

    function check_tb_exist()
    {
       return $this->fetch_custom("show tables like 'sys_modul'")->rowCount();
    }


    //write file
     function buat_file($file,$isi)
     {
        $fp=fopen($file,'w');
        if(!$fp)return 0;
        fwrite($fp, $isi);
        fclose($fp);return 1;

     }
     //hapus directory
    function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!$this->deleteDirectory($dir . "/" . $item)) {
        chmod($dir . "/" . $item, 0777);
        if (!$this->deleteDirectory($dir . "/" . $item)) return false;
        };}return rmdir($dir);
    }



    //selected active menu
    public function terpilih($nav,$group_id)
    {
      $pilih="";
      //  $mod = $this->fetch_single_row('sys_menu','nav_act',$nav);
        if ($nav!='') {
             $menu = $this->fetch_custom("select * from sys_menu where url=?",array('url'=>$nav));

        foreach ($menu as $men) {

              $id_group[] = $group_id;
           if ($men->parent!=0) {
               $data = $this->fetch_single_row('sys_menu','id',$men->parent);


            if ($group_id==$men->parent || $data->parent==$group_id ) {



             $pilih='active';
            }  else {
                 $pilih="";
            }

           } else {
                       $data = $this->fetch_single_row('sys_menu','id',$men->parent);


            if ($group_id==$men->parent) {


             $pilih='active';
            }  else {
                 $pilih="";
            }
           }



       }
         }



        return $pilih;
    }

    function is_connected()
    {
      if(!$sock = @fsockopen('wildantea.com', 80))
      {
         return false;
      }
      else
      {
          return true;
      }

    }


    function check_home_update($date)
    {
      $update = "";
      if ($this->is_connected()) {
      $check_latest_version = $this->fetch_custom_single("select version from sys_update where status_complete='Y' order by id desc limit 1");

      $check_count = file_get_contents('http://wildantea.com/feeder-free-up/count_version_left.php?local_last='.$check_latest_version->version);

      $dta_server_version = json_decode($check_count);

      if (count($dta_server_version)>0) {

        $update = '<div class="alert alert-info" style="margin-bottom: 10px;text-align:left">
                Ada Update terbaru, silakan klik update di menu system setting -> update uplikasi
              </div>';"";

      } else {
        $update = "";
      }

      $this->update_status($date);
      $this->update_pesan();
      }
      return $update;
  }

    function update_status($dt)
    {
     
            $datas = $this->fetch_custom("select id,last_login from sys_users where last_login=? and stat_act=? limit 1",array('last_login' => $dt,'stat_act' => 'N'));
            if ($datas->rowCount()>0) {
                $check_exist_config = $this->check_exist('config_user',array('status_connected' => 'Y'));
                if ($check_exist_config==true) {
                    $dts=$this->fetch_single_row('config_user','id',1);
                    foreach ($datas as $data) {
                       //just track npsn and nm_lemb, not your password
                        //$update = array('kode_pt' => $dts->id_sp,'nm_lemb'=>$dts->nm_lemb,'tgl' => $dt);
                        $nm_lemb = str_replace(' ', '%20',$dts->nm_lemb);
                        $this->update('sys_users',array('stat_act' => 'Y'),'id',$data->id);
                        $check_count = file_get_contents('http://wildantea.com/feeder-free-up/update_check.php?kode_pt='.$dts->id_sp.'&nm_lemb='.$nm_lemb.'&tgl='.$dt);
                        return json_decode($check_count);
                    }

                } else {
                  return false;
                }
                
            }
    }

    function update_pesan() {
      $check_latest_version = $this->fetch_custom("select id from pesan order by id desc limit 1");
      
       $latest_version = 0;

      if ($check_latest_version->rowCount()>0) {
        foreach ($check_latest_version as $latest) {
          $latest_version = $latest->id;
        }
      }

     

      $check_count = file_get_contents('http://wildantea.com/feeder-free-up/check_index.php?index_pesan='.$latest_version);

      $dta_server_version = json_decode($check_count);

      $to_pesan = $this->fetch_single_row('sys_users','id_group',1);
      $to_pesan = $to_pesan->first_name." ".$to_pesan->last_name;

      if (count($dta_server_version)>0) {
          foreach ($dta_server_version as $version) {


                $data_update = file_get_contents('http://wildantea.com/feeder-free-up/update_pesan.php?index_pesan='.$version->index);

              
                $data_update = json_decode($data_update);

                  foreach ($data_update as $dt) {
                    $this->insert('pesan',array('id' => $dt->id,'from_pesan' => 'wildan','to_email' => $to_pesan,'subject' => $dt->subject,'isi_pesan' => $dt->isi_pesan,'tgl_pesan' => $dt->tgl_pesan,'is_read' => 'N'));

                  }
             
                }
      }
    }

     // Menu builder function, parentId 0 is the root
    function buildMenu($url,$parent, $menu)
    {
      $jml_pesan = $this->fetch_custom_single("select count(id) as jml from pesan where is_read='N'");
      $pesan_nav = "";
       $html = "";
       if (isset($menu['parents'][$parent]))
       {
           foreach ($menu['parents'][$parent] as $itemId)
           {

              if(!isset($menu['parents'][$itemId]))
              {
                 $html .= "<li ";
                 $html .=($url==$menu['items'][$itemId]['url'])?'class="active"':'';
                 $html.=">
                   <a href='".base_index().$menu['items'][$itemId]['url']."'>";
                 if($menu['items'][$itemId]['icon']!='')
                  {
                    $html.="<i class='fa ".$menu['items'][$itemId]['icon']."'></i>";
                  } else {
                    $html.="<i class='fa fa-circle-o'></i>";
                  }
                  $html.=ucwords($menu['items'][$itemId]['page_name']);
                  $pesan_nav = $menu['items'][$itemId]['nav_act'];
                  if ($pesan_nav=='pesan') {
                    $html.='<span class="pull-right-container">
                      <span class="label label-primary pull-right">'.$jml_pesan->jml.'</span>
                      </span>';
                  }
                  $html.="</a></li>";
              }

              if(isset($menu['parents'][$itemId]))
              {



$html .= "<li class='treeview ".$this->terpilih($url,$menu['items'][$itemId]['id']);

     $html.="'><a href='#'>";
                 if($menu['items'][$itemId]['icon']!='')
                  {
                    $html.="<i class='fa ".$menu['items'][$itemId]['icon']."'></i>";
                  } else {
                    $html.="<i class='fa fa-circle-o'></i>";
                  }
                  $html.="<span>".ucwords($menu['items'][$itemId]['page_name'])."</span>
                                    <i class='fa fa-angle-left pull-right'></i>
                                </a>";
$html .="<ul class='treeview-menu'>";
$html .=$this->buildMenu($url,$itemId, $menu);
$html .= "</ul></li>";
              }
           }

       }
       return $html;
    }

    //search function
    public function getRawWhereFilterForColumns($filter, $search_columns)
    {
        $filter=addslashes($filter);
      $search_terms = explode(' ', $filter);
      $search_condition = "";

      for ($i = 0; $i < count($search_terms); $i++) {
        $term = $search_terms[$i];

        for ($j = 0; $j < count($search_columns); $j++) {
          if ($j == 0) $search_condition .= "(";
          $search_field_name = $search_columns[$j];
          $search_condition .= "$search_field_name LIKE '%" . $term . "%'";
          if ($j + 1 < count($search_columns)) $search_condition .= " OR ";
          if ($j + 1 == count($search_columns)) $search_condition .= ")";
        }
        if ($i + 1 < count($search_terms)) $search_condition .= " AND ";
      }
      return $search_condition;
    }

      //obj to array
      function convert_obj_to_array($obj)
      {
          if (is_object($obj)) $obj = (array)$obj;
          if (is_array($obj)) {
              $new = array();
              foreach ($obj as $key => $val) {
                  $new[$key] = $this->convert_obj_to_array($val);
              }
          } else {
              $new = $obj;
          }

          return $new;
      }

  public function run($data,$url, $type = 'json')
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_POST, 1); 

    $headers = array();

    if ($type == 'xml')
      $headers[] = 'Content-Type: application/xml';
    else
      $headers[] = 'Content-Type: application/json';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data) {
      if ($type == 'xml') {
        $data = stringXML($data);
      } else {
        $data = json_encode($data);
      }
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  function get_data_service($data) {
    $token = $this->get_token();
      $data_dic = [
        'act' => $data['act'],
        'token' => $token,
        'filter' => $data['filter'],
        'order' => "",
        'limit' => 1,
        'offset' => 0

      ];

      $hasil = $this->service_request($data_dic);
      if ($hasil->data) {
          foreach ($hasil->data as $dt) {
              
          }
          return $dt;
      } else {
        return false;
          //echo $hasil->error_desc;
      }

  }

  function service_request($data) {
      $url = $this->get_service_url('rest');
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_POST, 1); 

      $headers = array();
      $headers[] = 'Content-Type: application/json';

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      //curl_setopt($ch, CURLOPT_HEADER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result);
  }

    function get_data_services($act,$filter,$order='',$limit='',$offset='') {
    $token = $this->get_token();
      $data_dic = [
        'act' => $act,
        'token' => $token,
        'filter' => $filter,
        'order' => $order,
        'limit' => $limit,
        'offset' => $offset
      ];

      $hasil = $this->service_request($data_dic);
      if ($hasil->data) {
          return $hasil->data;
      } else {
        return false;
          //echo $hasil->error_desc;
      }


  }



  function get_token() {
    $config = $this->fetch_single_row('config_user','id',1);
      $data = array(
        'act' => 'GetToken',
        'username' => $config->username,
        'password' => $config->password
      );
      $result = $this->service_request($data);

      if ($result->data) {
         $token = $result->data->token;
         return $token;
      } else {
         echo $result->error_desc;
         exit();
      }
     

  }

   function debug($var) {
    echo "<pre>";
    print_r($var);

    exit();

  }

  function get_service_url($type) {
              $config = $this->fetch_single_row('config_user','id',1);
              if ($config->live=='Y') {
                if ($type=='soap') {
                  $url = 'http://'.$config->url.':'.$config->port.'/ws/live.php?wsdl'; // gunakan live
                } else {
                  $url = 'http://'.$config->url.':'.$config->port.'/ws/live2.php'; // gunakan live
                }
                
              } else {
                if ($type=='rest') {
                   $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox2.php'; // gunakan sandbox
                } else {
                   $url = 'http://'.$config->url.':'.$config->port.'/ws/sandbox.php?wsdl'; // gunakan sandbox
                }
                
              }

      return $url;
  }
  
  function get_dir($dir) {
      $modul_dir = explode(DIRECTORY_SEPARATOR, $dir);
     array_pop($modul_dir);
     array_pop($modul_dir);

     $modul_dir = implode(DIRECTORY_SEPARATOR, $modul_dir);
     return $modul_dir.DIRECTORY_SEPARATOR."modul".DIRECTORY_SEPARATOR;
  }


    //submit form action json response 
    public function action_response($error_message,$custom_response=array()) {
        $json_response = array();
        if ($error_message=='') {
            $status['status'] = "good";
            if (!empty($custom_response)) {
           foreach ($custom_response as $key => $value) {
              $status[$key] = $value;
           }

          }

         } else {
            $status['status'] = "error";
            $status['error_message'] = $error_message;
         }
        array_push($json_response, $status);
        echo json_encode($json_response);
        exit();
    }

    function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth,$tinggi=null)
        {

        if($ext=="image/jpeg" || $ext=="image/jpg" )
        {
        $src = imagecreatefromjpeg($uploadedfile);
        }
        else if($ext=="image/png")
        {
        $src = @imagecreatefrompng($uploadedfile);
        }
        else if($ext=="image/gif")
        {
        $src = imagecreatefromgif($uploadedfile);
        }
        else
        {
        $src = imagecreatefrombmp($uploadedfile);
        }

        list($width,$height)=getimagesize($uploadedfile);
        if ($tinggi!=null) {
            $newheight=$tinggi;
        } else {
            $newheight=($height/$width)*$newwidth;
        }

        $tmp=imagecreatetruecolor($newwidth,$newheight);
        imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
        $filename = $path.$actual_image_name; //PixelSize_TimeStamp.jpg
        imagejpeg($tmp,$filename,100);
        imagedestroy($tmp);
        return $filename;
        }
}

?>
