<link href="<?=base_admin();?>assets/plugins/chosen/chosen.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_admin();?>assets/plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>


          <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Data Wilayah
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-wilayah">Data Wilayah</a></li>
                        <li class="active">Data Wilayah List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
<br>
<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal" method="post" action="<?=base_admin();?>modul/data_wilayah/download_data.php">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Provinsi</label>
                        <div class="col-lg-3">
                        <select id="provinsi" name="provinsi" data-placeholder="Pilih Provinsi ..." class="form-control chzn-select" tabindex="2">
                        <option value="all">Semua</option>
               <?php foreach ($db->query("select id_wil,nm_wil from data_wilayah where id_level_wil='1'") as $isi) {
                  echo "<option value='$isi->id_wil'>$isi->nm_wil</option>";
               } ?>
              </select>

 </div>
                      </div><!-- /.form-group -->
                           <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Kabupaten</label>
                        <div class="col-lg-3">
                        <select id="kabupaten" name="kabupaten" data-placeholder="Pilih Kabupaten ..." class="form-control chzn-select" tabindex="2">
                        <option value="all">Semua</option>
              </select>

 </div>
                      </div><!-- /.form-group -->

                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <span id="filter" class="btn btn-primary"><i class="fa fa-refresh"></i> Filter</span>
                          <button type="submit" class="btn btn-success"><i class="fa fa-cloud-download"></i> Download
                        </div>
                      </div><!-- /.form-group -->
                    </form>
            </div>
            <!-- /.box-body -->
          </div>
                                    <table id="dtb_data_wilayah" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>

                          <th>ID Kecamatan</th>
                          <th>Provinsi</th>
                          <th>Kabupaten</th>
                          <th>Kecamatan</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {
 $("#provinsi").chosen();

$('#provinsi').on('change', function() {

 $("#kabupaten").chosen();
    $.ajax({
      url : "<?=base_admin();?>modul/data_wilayah/get_kabupaten.php",
      type: "post",
      data : {provinsi: $(this).val()},
      success:function(data) {
       // console.log(data);
        $("#kabupaten").html(data);
        $("#kabupaten").trigger('chosen:updated');

      }
    })
 });


});



var dataTable = $("#dtb_data_wilayah").dataTable({

           'bProcessing': true,
            'bServerSide': true,
    
            'ajax':{
              url :'<?=base_admin();?>modul/data_wilayah/data_wilayah_data.php',
            type: 'post',  // method  , by default get
          error: function (xhr, error, thrown) {
              console.log(xhr);

            }
          },
          "language": {
             searchPlaceholder: "Cari Nama Kecamatan",
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
          },
        });

$('#filter').on('click', function() {
  dataTable.fnDestroy();
 $("#dtb_data_wilayah").DataTable({

           'bProcessing': true,
            'bServerSide': true,
    
            'ajax':{
              url :'<?=base_admin();?>modul/data_wilayah/data_wilayah_data.php',
            type: 'post',  // method  , by default get
            data : {provinsi : $("#provinsi").val(),kabupaten:$("#kabupaten").val()},
          error: function (xhr, error, thrown) {
              console.log(xhr);

            }
          },
          "language": {
             searchPlaceholder: "Cari Nama Kecamatan",
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
          },

        });

      });

</script>  
            