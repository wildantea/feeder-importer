<!-- Content Header (Page header) -->
                <section class="content-header"><?php
      function is_connected($url,$port)
      {
       
        if(!$sock = @fsockopen($url, $port))
        {
           return false;
        }
        else
        {
            return true;
        }

      }
//include "inc/config.php";
include "lib/nusoap/nusoap.php";


  //    foreach ($dtb as $isi) {

?>
                    <h1>
                        Manage Config Akun Feeder
                    </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>config-akun-feeder">Config Akun Feeder</a></li>
                        <li class="active">Akun Feeder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title">Config Akun Feeder</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
                          <th>Username Feeder</th>
                          <th>URL Feeder</th>
                          <th>PORT</th>
                          <th>Kode PT</th>
                          <th>Status</th>
                          
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                         <?php 
      $dtb=$db->query("select config_user.username,config_user.password,config_user.url,config_user.port,config_user.kode_pt,config_user.live,config_user.id from config_user ");
      $i=1;


function isValidMd5($result)
{
     return preg_match('/^[a-f0-9]{32}$/i', $result);
}

      foreach ($dtb as $isi) {

    

        $url = 'http://'.$isi->url.':'.$isi->port.'/ws/live.php?wsdl'; // gunakan sandbox

     
            $file_headers = @get_headers('http://'.$isi->url.':'.$isi->port.'/ws/mahasiswa.php');

            if (!is_connected($isi->url,$isi->port)) {


              $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';

              $error_server = "Server PDDIKTI tidak aktif";
              $error_url = "";
              $error = "";
         

      

      } else {

                      if($file_headers[0] == 'HTTP/1.1 404 Not Found') {

              $error = "";
              $error_url = "Tidak menemukan PDDIKTI Server/Url Salah";
              $error_server = "";
              $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';

            } else {


        $error_server = "";
   
           //untuk coba-coba
        // $url = 'http://pddikti.uinsgd.ac.id:8082/ws/live.php?wsdl'; // gunakan live bila

        $client = new nusoap_client($url, true);
        $proxy = $client->getProxy();

        # MENDAPATKAN TOKEN
        $username = $isi->username;
        $password = $isi->password;
        $result = "";
        $result = $proxy->GetToken($username, $password);



        if (isValidMd5($result)) {
            $status = '<button type="button" class="btn btn-success btn-xs">Connected</button>';
            $error = "";
        } else {
          $status = '<button type="button" class="btn btn-warning btn-xs">Not Connected</button>';
            $error = $result;
        }
        
        $error_url = "";


            }
      }
        ?><tr id="line_<?=$isi->id;?>">
        <td><?=$isi->username;?></td>
<td><?=$isi->url;?></td>
<td><?=$isi->port;?></td>
<td><?=$isi->kode_pt;?></td>
<td> <?=$status;?> <?=$error_server;?> <?=$error_url;?> <?=$error;?></td>

        <td>
        <?=($role_act["up_act"]=="Y")?'<a href="'.base_index().'config-akun-feeder/edit/'.$isi->id.'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>':"";?>  
        </td>
        </tr>
        <?php
        $i++;
      }

      ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
        
