
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Menu
                    </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>menu">Menu</a></li>
                        <li class="active">Menu List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title">List Menu</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="dtb_manual" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
                          <th>Nama Menu</th>
                          <th>Icon</th>
                          <th>Parent</th>
                          <th>Urutan Menu</th>
                          <th>Type Menu</th>
                          <th>Tampil</th>
                          
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                         <?php 
      $dtb=$db->query("select * from sys_menu ");
    
      foreach ($dtb as $isi) {
        ?><tr id="line_<?=$isi->id;?>">
<td><?=$isi->page_name;?></td>
<td><i class="fa <?=$isi->icon;?>"></i></td>
<td><?php
if ($isi->parent==0) {
  echo "none";
} else {
  echo $db->fetch_single_row('sys_menu','id',$isi->parent)->page_name;
}
  ?>
</td>
<td><?=$isi->urutan_menu;?></td>
<td><?=$isi->type_menu;?></td>
<td><?=$isi->tampil;?></td>

        <td>
     
       <a href="<?=base_index();?>page/edit/<?=$isi->id;?>" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>
      <button class="btn btn-danger hapus btn-flat" data-uri="<?=base_admin();?>system/page/page_action.php" data-id="<?=$isi->id;?>"><i class="fa fa-trash-o"></i></button>
        </td>
        </tr>
        <?php
      
      }
      ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
       <a href="<?=base_index();?>page/tambah" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                </section><!-- /.content -->
        
