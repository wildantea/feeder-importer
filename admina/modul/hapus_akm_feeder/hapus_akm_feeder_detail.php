                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Hapus AKM Feeder
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>hapus-kelas">Hapus AKM Feeder</a></li>
                        <li class="active">Hapus AKM Feeder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                             
                                <div class="box-body table-responsive">

<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-5">
                        <select id="sem_filter" data-placeholder="Pilih Semester ..." class="form-control chzn-select" tabindex="2">
                        <option value="all">Semua</option>
                <?php foreach ($db->query("select *,left(semester,4) as tahun from semester where right(semester,1) not in (0) order by semester desc") as $isi) {
                                if ($isi->tahun <= date('Y')) {
                                  echo "<option value='$isi->semester'>$isi->nama_semester</option>";
                                }
                                  
                               } ?>
              </select>

 </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                                        <label for="Semester" class="control-label col-lg-2">Program Studi</label>
                                        <div class="col-lg-5">
                                        <select id="jurusan" name="jurusan" data-placeholder="Pilih Semester ..." class="form-control chzn-select" tabindex="2">
                                        
                               <?php 
        $jurusan_sms = "";
        if ($_SESSION['level']!=1) {
              $jurusan_sms = "where id_sms='".$_SESSION['id_sms']."'";
        } else {
           echo '<option value="all">Semua</option>';
        }
                               foreach ($db->query("select * from jurusan $jurusan_sms") as $isi) {
                                  echo "<option value='$isi->kode_jurusan'>$isi->jenjang $isi->nama_jurusan</option>";
                               } ?>
                              </select>

                 </div>
                                      </div><!-- /.form-group -->
 <div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Status Kuliah</label>
                        <div class="col-lg-3">
                         <select name="status_kuliah" id="status_kuliah"  class="form-control chzn-select" tabindex="2" required>
                          <option value="all">Semua</option>
               <option value="A">Aktif</option>
               <option value="C">Cuti</option>
                 <option value="N">Non-aktif</option>

                 <option value="G">Sedang Double Degree</option>

              </select>

                        </div>
                      </div><!-- /.form-group -->
                      
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                          <span id="filter" class="btn btn-primary btn-flat">Submit</span>
                        </div>
                      </div><!-- /.form-group -->
                    </form>
            </div>
            <!-- /.box-body -->
       
          </div>
                                    <table id="dtb_hapus_kelas" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
   <th><input type="checkbox"  id="bulkDelete"  /> <button id="deleteTriger"><i class="fa fa-trash"></i></button></th>
                      
                          <th>NIM</th>
                          <th>Nama Mahasiswa</th>
                          <th>Semester</th>
                          <th>Angkatan</th>
                          <th>IPS</th>
                          <th>IPK</th>
                          <th>SKS Semester</th>
                          <th>SKS Total</th>
                          <th>Status</th>
                          <th>Prodi</th>
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                                      <!-- <div class="row">
         <div class="col-lg-12">
            <div class="pull-right">
                <button type="button" data-id="32" data-uri="<?=base_admin();?>modul/hapus_akm_feeder/hapus.php" class="btn btn-danger" id="hapus_massal"><i class="fa fa-recycle"></i> Hapus Data Massal</button>
            </div>
        </div> 
     
    </div>-->
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
<div class="modal modal-danger" id="mass_info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Hapus Data Massal</h4> </div> <div class="modal-body" style="height: 102px;"> 
<div class="form-group" style="margin-bottom:32px">
                        <label style="padding-top:6px" for="Jurusan" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-10">
                          <select  name="sem_delete" id="sem_delete"  class="form-control " tabindex="2" required>
                           <?php 
                    foreach ($semester['result'] as $isi) {
                  echo "<option value='".$isi['id_smt']."'>".$isi['nm_smt']."</option>";
               } ?>

              </select>
                        </div>
<input type="hidden" id="semester_selected">
                      </div><!-- /.form-group -->
<div class="form-group" style="margin-bottom:32px">
                        <label style="padding-top:6px" for="Jurusan" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-10" style="padding-top: 5px;">
 <select name="status" id="status" class="form-control" tabindex="2" required>
                              <option value="all">Semua</option>
               <option value="A">Aktif</option>
               <option value="C">Cuti</option>
                 <option value="N">Non-aktif</option>

                 <option value="G">Sedang Double Degree</option>

              </select>
                        </div>
<input type="hidden" id="semester_selected">
                      </div><!-- /.form-group -->
 </div> <div class="modal-footer"> <button type="button" id="delete_akm_massal" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->
        <?php
      
      
  foreach ($db->fetch_all("sys_menu") as $isi) {

  //jika url = url dari table menu
  if ($path_url==$isi->url) {

  if ($role_act['del_act']=='Y') {
   $del = "<span data-id='+aData[indek]+' data-uri=".base_admin()."modul/hapus_akm_feeder/hapus.php".' class="btn btn-danger hapus_akm_feeder btn-flat"><i class="fa fa-trash"></i></span>';
  } else {
    $del="";
  }
                   } 
  }
  
?>  
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {





var dataTable = $("#dtb_hapus_kelas").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
               var indek = aData.length-1; 
     $('td:eq('+indek+')', nRow).html('<?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
           // "searching": false,
               "ordering": false,
                 "columnDefs": [ {
              "targets": [0,4],
              "orderable": false,
             

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/hapus_akm_feeder/hapus_akm_feeder_data.php",
            type: "post",  // method  , by default get
               <?php
            if ($_SESSION['level']!=1) {
              ?>
             data: function ( d ) {
              d.id_sms_user = "<?=$_SESSION['id_sms'];?>"
              },
              <?php
            }
            ?>
          error: function (xhr, error, thrown) {
            console.log(error);
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
          "language": {
             searchPlaceholder: "Pencarian dengan NIM atau Nama",
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
   },

        });


$('#filter').on('click', function() {
dataTable = $("#dtb_hapus_kelas").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var indek = aData.length-1;           
     $('td:eq('+indek+')', nRow).html(' <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
     destroy: true,
           'bProcessing': true,
            'bServerSide': true,
               "ordering": false,
               // "searching": false,
                 "columnDefs": [ {
              "targets": [0,4],
              "orderable": false,
              

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/hapus_akm_feeder/hapus_akm_feeder_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                    d.jurusan = $("#jurusan").val();
                    d.semester = $("#sem_filter").val();
                    d.status = $("#status_kuliah").val();
                  },
          error: function (xhr, error, thrown) {
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
          "language": {
             searchPlaceholder: "Pencarian dengan NIM atau Nama",
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
   },

        });

      });


$("#bulkDelete").on('click',function() { // bulk checked
          var status = this.checked;
          $(".deleteRow").each( function() {
            $(this).prop("checked",status);
          });
        });

$('#deleteTriger').on("click", function(event){
          if( $('.deleteRow:checked').length > 0 ){
            event.preventDefault();


            var ids = [];
            $('.deleteRow').each(function(){
              if($(this).is(':checked')) {
                ids.push($(this).val());
              }
            });
            var ids_string = ids.toString();


            $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

          $("#loadnya").show();
          $.ajax({
              type: "POST",
              url: "<?=base_admin();?>modul/hapus_akm_feeder/hapus.php?act=del_massal",
              data: {data_ids:ids_string},
               async: true,
              success: function(result) {
                $("#loadnya").hide();
                //console.log(result);
                dataTable.draw(false);
              },
              async:true
            });
          $('#ucing').modal('hide');



        });


          }
        });

    $(".table").on('click','.hapus_akm_feeder',function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id'); 
    

    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {
        $("#loadnya").show();
                $.ajax({
          type: "POST",
          url: uri+"?act=delete&id="+id,
          success: function(data){
             $("#loadnya").hide();
              console.log(data);
              dataTable.draw(false);
          }
          });
          $('#ucing').modal('hide');

        });

  });
/*$('#delete_akm_massal').on("click", function(event){
  event.preventDefault();
   $('#mass_info').modal('hide');
    $("#loadnya").show();

          $.ajax({
              type: "POST",
              url: "<?=base_admin();?>modul/hapus_akm_feeder/hapus.php?act=delete_all",
              data: {semester:$("#sem_delete").val(),jurusan: "<?=$id_jur;?>",status:$("#status").val()},
               async: true,
              success: function(result) {
               console.log(result);
                $("#loadnya").hide();
                //window.location.reload();
              },
              async:true
            });
        });*/


});



</script>  
            