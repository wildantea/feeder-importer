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
      $isi=$db->fetch_custom_single("select config_user.username,config_user.password,config_user.url,config_user.port,config_user.kode_pt,config_user.live,config_user.id from config_user ");

      //dump($isi);

      $i=1;
      $token = check_token();

     //dump($token);


        if ($token['status']=='1') {
            $status = '<button type="button" class="btn btn-success btn-xs">Connected</button>';
        } else {
          $status = '<button type="button" class="btn btn-danger btn-xs">'.$token['error'].'</button>';
        }

           
        ?><tr id="line_<?=$isi->id;?>">
        <td><?=dec_data($isi->username);?></td>
<td><?=$isi->url;?></td>
<td><?=$isi->port;?></td>
<td><?=$isi->kode_pt;?></td>
<td> <?=$status;?></td>

        <td>
        <?=($role_act["up_act"]=="Y")?'<a href="'.base_index().'config-akun-feeder/edit/'.$isi->id.'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>':"";?>  
        </td>
        </tr>
        <?php
        $i++;
      

      ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
        
