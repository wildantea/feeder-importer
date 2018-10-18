
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Pesan
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>pesan">Pesan</a></li>
                        <li class="active">Pesan List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                  <div class="row">
<div class="col-md-3">
        
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Folders</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
              <?php
              $jml_pesan = $db->fetch_custom_single("select count(id) as jml from pesan where is_read='N'");
              ?>
                <li class="active"><a href="<?=base_index();?>pesan"><i class="fa fa-inbox"></i> Inbox
                  <span class="label label-primary pull-right"><?=$jml_pesan->jml;?></span></a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Baca Pesan</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?=$data_edit->subject;?></h3>
                <h5>From: <?=$data_edit->from_pesan;?>
                  <span class="mailbox-read-time pull-right"><?=$data_edit->tgl_pesan;?></span></h5>
              </div>

              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <p>Hello <?=$data_edit->to_email;?>,</p>

               <?=$data_edit->isi_pesan;?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>

            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
                </section><!-- /.content -->

