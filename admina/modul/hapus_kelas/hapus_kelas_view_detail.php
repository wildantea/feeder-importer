<?php
include "lib/nusoap/nusoap.php";
?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Kelas Kuliah <?php echo $db->fetch_single_row('jurusan','id_sms',$id_jur)->nama_jurusan;?>
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>hapus-kelas">Kelas Kuliah</a></li>
                        <li class="active">Kelas Kuliah List</li>
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
                           <?php

                 foreach ($db->query("select *,left(semester,4) as tahun from semester where right(semester,1) not in (0) order by semester desc") as $isi) {
                  
                                if ($isi->tahun <= date('Y')) {
                        if ($isi->tahun==date('Y')-1) {
                          echo "<option value='".$isi->semester."' selected>".$isi->nama_semester."</option>";
                          $smt_selected = $isi->semester;    
                        } else {
                          echo "<option value='".$isi->semester."'>".$isi->nama_semester."</option>";    
                        }
                                }
                                  
                               } ?>
              </select>

 </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Matakuliah</label>
                        <div class="col-lg-5">
                      <select class="form-control  chzn-select" name="matkul" id="matkul">
<?php

    $temp_data_kelas = [
      'act' => 'GetDetailKelasKuliah',
        'token' => get_token(),
        'filter' => "id_semester='$smt_selected' and id_prodi='".$path_id."'",
        'order' => "id_semester DESC",
        'limit' => "",
        'offset' => ""

    ];

    $kelas = service_request($temp_data_kelas);

   // dump($temp_data_kelas);



foreach ($kelas->data as $data_kelas) {
    $array_kode_mk[$data_kelas->id_matkul] = $data_kelas->nama_mata_kuliah;
}
$kode_mk_group = array_unique($array_kode_mk);

echo '<option value="all">Semua</option>';
foreach ($kode_mk_group as $isi => $data) {
echo "<option value='".$isi."'>".$data."</option>";
}
?>
                  </select> </div><img id="img_loader" style="display:none" src="<?=base_admin();?>assets/dist/img/ajax-loader.gif">
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
<div class="alert alert-info">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Fitur Hapus Kelas ini akan menghapus kelas serta krs dan dosen ajar didalamnya</strong>
        </div>
             <table id="dtb_hapus_kelas" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
   <th><input type="checkbox"  id="bulkDelete"  /> <button id="deleteTriger"><i class="fa fa-trash"></i></button></th>
                      
                          <th>Semester</th>
                          <th>Kode Matakuliah</th>
                          <th>Nama Matakuliah</th>
                          <th>Nama Kelas</th>
                          <th>Peserta Kelas</th>
                          <th>Dosen Pengajar</th>
                          <th>Action</th>
                         
                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                                       <div class="row">
        
        <!-- /.col-lg-12 -->
    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
<div class="modal modal-danger" id="mass_info" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> <div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">Hapus Data Massal</h4> </div> <div class="modal-body"> 
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
 </div> <div class="modal-footer"> <button type="button" id="delete" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->
        <?php

      
$del = "<span data-id='+aData[indek]+' data-uri=".base_admin()."modul/hapus_kelas/hapus.php".' class="btn btn-danger hapus_feeder_kelas btn-flat"><i class="fa fa-trash"></i></span>';
  
?>  
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {



var dataTable = $("#dtb_hapus_kelas").DataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var indek = aData.length-1;           
     $('td:eq('+indek+')', nRow).html(' <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
              "searching": false,
               "ordering": false,
                 "columnDefs": [ {
              "targets": [0,4],
              "orderable": false,
              "searchable": false

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/hapus_kelas/hapus_kelas_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                    d.jurusan = "<?=$id_jur;?>";
                    d.semester = $("#sem_filter").val();
                    d.kode_mk = $("#matkul").val();
                  },
          error: function (xhr, error, thrown) {
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
            "language": {
          "processing": "<i class=\"fa fa-spinner fa-spin\"></i> Loading data, please wait..." //add a loading image,simply putting <img src="loader.gif" /> tag.
   },

});

//filter
$('#filter').on('click', function() {
 // alert('why');
  dataTable.ajax.reload();
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
              url: "<?=base_admin();?>modul/hapus_kelas/hapus.php?act=del_massal",
              data: {data_ids:ids_string},
               async: true,
              success: function(result) {
                $("#loadnya").hide();
                dataTable.ajax.reload();
              },
              async:true
            });
          $('#ucing').modal('hide');



        });


          }
        });

  $("#sem_filter").change(function(){
    $("#matkul").html('');
    $("#matkul").chosen();
    $("#loadnya").show();
    $("#img_loader").show();
    
      $.ajax({
          url : "<?=base_admin();?>modul/hapus_kelas/matakuliah.php",
          type : "post",
          data : {jurusan : "<?=$id_jur;?>",semester : $(this).val() },
          success : function(data) {
            $("#loadnya").hide();
            $("#img_loader").hide();
              $("#matkul").html(data);
              $("#matkul").trigger('chosen:updated');

          }

      });
     
  });


});



</script>  
            