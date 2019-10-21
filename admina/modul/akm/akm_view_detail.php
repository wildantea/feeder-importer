
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage AKM <?php echo $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->nama_jurusan;?>
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>akm">AKM</a></li>
                        <li class="active">AKM List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">

                                <div class="box-body table-responsive">
 <?php
       foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url) {
                          if ($role_act["insert_act"]=="Y") {
                    ?>

          <a href="<?=base_index();?>akm/import/<?=$id_jur;?>" class="btn btn-primary btn-flat"><i class="fa fa-cloud-upload"></i> Upload Data Excel</a>
     <button class="btn btn-success btn-flat valid_akm"><i class="fa fa-wrench"></i> Validasi AKM</button>
   <button class="btn btn-info btn-flat up_feeder"><i class="fa fa-mail-forward"></i> Import ke PDDIKTI feeder</button>
                          <?php
                          }
                       }
}
?>

<div id="hasil_up" style="display:none"></div>
<div id="isi_drop_up" style="display:none">
<p>&nbsp;</p>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Semester</label>
                        <div class="col-lg-3">
                                 <select id="semester_up" name="semester_up" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select nilai_akm.semester,nama_semester from nilai_akm inner join semester on
 nilai_akm.semester=semester.semester where kode_jurusan='".$id_jur."' group by nilai_akm.semester order by nilai_akm.semester desc") as $isi) {
                  echo "<option value='$isi->semester'>$isi->semester $isi->nama_semester</option>";
               } ?>
              </select>
                       
                        </div>
                      </div><!-- /.form-group -->
</div>
<div class="row">
<p>
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Method</label>
                        <div class="col-lg-3">
                    <select id="method" name="method" class="form-control" tabindex="2" required>
           <option value="in">Insert</option>
           <option value="up">Update</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
</div>
<p>
<div class="row">
<div class="form-group">
           <label for="Jurusan" class="control-label col-lg-1">&nbsp;</label>
            <div class="col-lg-3">
            <button class="btn btn-success btn-flat up_feeder_now">
<i class="fa fa-cloud-download"></i> Upload Data</button>
            </div>
</div>


</div>
</div>

<div id="isi_valid" style="display:none">
<p>&nbsp;</p>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Semester</label>
                        <div class="col-lg-3">
                          <select id="semester_valid" name="semester_valid" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select nilai_akm.semester,nama_semester from nilai_akm inner join semester on
 nilai_akm.semester=semester.semester where kode_jurusan='".$id_jur."' group by nilai_akm.semester order by nilai_akm.semester desc") as $isi) {
                  echo "<option value='$isi->semester'>$isi->semester $isi->nama_semester</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
</div>
<p>
<div class="row">
<div class="form-group">
           <label for="Jurusan" class="control-label col-lg-1">&nbsp;</label>
            <div class="col-lg-3">
            <button class="btn btn-success btn-flat valid_now">
<i class="fa fa-cloud-download"></i> Validasi Data AKM</button>
            </div>
</div>


</div>
</div>

<div class="row" id="progress_nya">
<br>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               
                        <div class="progress hidden" id="script-progress">
                          <div class="progress-bar progress-bar-striped active" id="progress-bar-start" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: ">

                          </div>
                        </div>
                    <div id="script-output"><em></em></div>
                </div>
            </div>

<br>
<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Semester</label>
                        <div class="col-lg-3">
                        <select id="sem_filter" data-placeholder="Pilih Semester ..." class="form-control chzn-select" tabindex="2">
                        <option value="all">Semua</option>
               <?php foreach ($db->query("select nilai_akm.semester,nama_semester from nilai_akm inner join semester on
 nilai_akm.semester=semester.semester where kode_jurusan='".$id_jur."' group by nilai_akm.semester order by nilai_akm.semester desc") as $isi) {
                  echo "<option value='$isi->semester'>$isi->semester $isi->nama_semester</option>";
               } ?>
              </select>

 </div>
  </div><!-- /.form-group -->
 <div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Status Kuliah</label>
                        <div class="col-lg-3">
                          <select name="status_kuliah" id="status_kuliah"  class="form-control" tabindex="2" required>
               <option value="all">Semua</option>
               <option value="A">Aktif</option>
               <option value="C">Cuti</option>
               <option value="D">Drop Out</option>
                <option value="K">Keluar</option>
                 <option value="L">Lulus</option>
                 <option value="N">Non-aktif</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Valid</label>
                        <div class="col-lg-3">
                       <select class="form-control" name="status" id="valid_status">
                    <option value="all">Semua</option>
                    <option value="0">Belum Di Validasi</option>
                    <option value="1">Valid</option>
                    <option value="2">Error</option>
                  </select> </div>
                      </div><!-- /.form-group -->           
<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-3">
                       <select class="form-control" name="status" id="status_filter">
                    <option value="all">Semua</option>
                    <option value="0">Belum Di proses</option>
                    <option value="1">Sukses</option>
                    <option value="2">Error</option>
                  </select> </div>
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
                                    <table id="dtb_akm" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>

                          <th><input type="checkbox"  id="bulkDelete"  /> <button id="deleteTriger"><i class="fa fa-trash"></i></button></th>
                          <th>Semester</th>
                          <th>NIM</th>
                          <th>Nama</th>
                          <th>Status Kuliah</th>
                          <th>IP Semester</th>
                          <th>IPK</th>
                          <th>SKS Semester</th>
                          <th>SKS Total</th>
                          <th>Valid&nbsp;</th>
                          <th>Status</th>
                         


                          <th>Action</th>

                        </tr>
                                      </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
<div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <!-- <button type="button" class="btn btn-success" id="down_data_erro">
                <i class="fa fa-file-excel-o"></i> Download data error</button> -->
                <button type="button" data-id="<?=$id_jur;?>" data-uri="<?=base_admin();?>modul/akm/akm_action.php"  class="btn btn-danger" id="hapus_data_error"><i class="fa fa-info-circle"></i> hapus data error</button>
                <button type="button" data-id="<?=$id_jur;?>" data-uri="<?=base_admin();?>modul/akm/akm_action.php" class="btn btn-danger" id="hapus_massal"><i class="fa fa-recycle"></i> Hapus data massal</button>
            </div>
        </div>
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
<option value="all">Semua Semester</option>
<?php foreach ($db->query("select nilai_akm.semester,nama_semester from nilai_akm inner join semester on
 nilai_akm.semester=semester.semester where kode_jurusan='".$id_jur."' group by nilai_akm.semester") as $isi) {
 echo "<option value='$isi->semester'>$isi->semester $isi->nama_semester</option>";
               } ?>
              </select>
                        </div>
<input type="hidden" id="semester_selected">
                      </div><!-- /.form-group -->
 </div> <div class="modal-footer"> <button type="button" id="delete" class="btn btn-danger">Delete</button> <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> </div> </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div><!-- /.modal -->

        <?php
       foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url) {
                          if ($role_act["insert_act"]=="Y") {
                    ?>
          <a href="<?=base_index();?>akm/tambah/<?=$id_jur;?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>

       <!--     <span data-id="akm" data-uri="<?=base_admin();?>modul/akm/akm_action.php?act=remove" class="btn btn-danger hapus btn-flat"><i class="fa fa-recycle"></i>kosongkan data</span> -->
                          <?php
                          }
                       }
}

  foreach ($db->fetch_all("sys_menu") as $isi) {

  //jika url = url dari table menu
  if ($path_url==$isi->url) {
    //check edit permission
  if ($role_act["up_act"]=="Y") {
  $edit = '<a href="'.base_index()."akm/edit/'+aData[indek]+'/$id_jur".'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>';
  } else {
    $edit ="";
  }
  if ($role_act['del_act']=='Y') {
   $del = "<span data-id='+aData[indek]+' data-uri=".base_admin()."modul/akm/akm_action.php".' class="btn btn-danger hapus btn-flat"><i class="fa fa-trash"></i></span>';
  } else {
    $del="";
  }
                   }
  }

?>
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {

   $.ajax({
     url: '<?=base_admin();?>modul/akm/create_json.php?jurusan='+<?=$id_jur;?>,
      });

  var table =  $("#dtb_akm").dataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           // console.log(aData);
            var indek = aData.length-1;
     $('td:eq('+indek+')', nRow).html('<?=$edit;?> <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
            "columnDefs": [ {
              "targets": [0,11],
              "orderable": false,
              "searchable": false

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/akm/akm_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                      d.jurusan = "<?=$id_jur;?>";
                  },
          error: function (xhr, error, thrown) {
            console.log(thrown);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="9">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
               "language": {
            "infoPostFix":"<br><b>Jumlah :</b> <br> Belum diproses(0): <b>_BELUM_</b> <br>Sukses(1): <b>_SUKSES_</b> <br> Error(2): <b> _ANEH_ </b>"
        },

      //  'sAjaxSource': '<?=base_admin();?>modul/akm/akm_data.php',

        });
$('#filter').on('click', function() {
  table.fnDestroy();
  $("#dtb_akm").dataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
           // console.log(aData);
            var indek = aData.length-1;
     $('td:eq('+indek+')', nRow).html(' <?=$edit;?> <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
        "columnDefs": [ {
              "targets": [0,11],
              "orderable": false,
              "searchable": false

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/akm/akm_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                      d.jurusan = "<?=$id_jur;?>";
                      d.semester = $("#sem_filter").val();
                      d.status_kuliah = $("#status_kuliah").val();
                      d.valid = $("#valid_status").val();
                      d.status_filter = $("#status_filter").val();
                  },
          error: function (xhr, error, thrown) {
              console.log(xhr);
              $(".dtb_krs-error").html("");
              $("#dtb_krs").append('<tbody class="dtb_krs-error"><tr><th colspan="7">No data found in the server</th></tr></tbody>');
              $("#dtb_krs_processing").css("display","none");

            },
      
          },
          "language": {
            "infoPostFix":"<br><b>Jumlah :</b> <br> Belum diproses(0): <b>_BELUM_</b> <br>Sukses(1): <b>_SUKSES_</b> <br> Error(2): <b> _ANEH_ </b>"
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
              url: "<?=base_admin();?>modul/akm/akm_action.php?act=del_massal",
              data: {data_ids:ids_string},
              success: function(result) {
                window.location.reload();
              },
            });
          $('#ucing').modal('hide');



        });


          }
        });

});


window.progressInterval;
window.prevpc;
window.hasError = false;
window.finished = false;
window.pollingPeriod = 1000;
window.updatePeriod  = 250;
window.lastData = null;
window.lastUpdate;


$(document).ready(function() {



$('.valid_akm').on('click', function() {

  if ($('#isi_drop_up').is(":visible")){
    $("#isi_valid").hide();
    $("#isi_drop_up").hide();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  } else {
    $("#isi_valid").show();
    $("#isi_drop_up").hide();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  }


});

$('.valid_now').on('click', function() {

    $("#loadnya").show();
    $.ajax({
        url: "<?=base_admin();?>modul/akm/akm_action.php?act=validasi",
        type : "post",
        data : {jurusan:"<?=$id_jur;?>",sem:$("#semester_valid").val()},
        success: function(data) {
          $("#loadnya").hide();
          console.log(data);
          window.location.reload();
        }
    });

});

$('.up_feeder').on('click', function() {

  if ($('#isi_drop_up').is(":visible")){
    $("#isi_valid").hide();
    $("#isi_drop_up").hide();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  } else {
    $("#isi_valid").hide();
    $("#isi_drop_up").show();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  }


});



$('.up_feeder_now').on('click', function() {
   
$("#loadnya").show();
$(".text-wait-up").show();
 $("#isi_drop_up").hide();

window.finished = false;
        $.getJSON('<?=base_admin();?>modul/akm/push_akm.php?sem='+$("#semester_up").val()+"&jurusan="+<?=$id_jur;?>+"&method="+$("#method").val(),
            function(data){
             //   console.log("ALL DONE", data);
                clearInterval(window.progressInterval);
                window.finished = true;
                if(typeof data.error == 'undefined' || data.error === true){
                    displayError(data);
                } else {
                    checkProgress();
                    $('.tertiary-status').remove();
                    if(!$('#script-progress').hasClass('hidden')){
                        $('#script-progress').fadeOut(200,function(){$('#script-progress').addClass('hidden');});
                    }
                    alert('Upload Data Selesai');
                    $("#loadnya").hide();
                    $(".text-wait-up").hide();
                    
                    $("#isi_drop_up").hide();
                    $("#hasil_up").show();
                    $("#progress_nya").hide();
                     $("#isi_informasi").html(data.message);
                    $('#informasi').modal('show');
                    
                   // window.location.reload();
                }
            }
        ).error(function(data){
            window.hasError = true;
            $("#loadnya").hide();
            $(".text-wait-up").hide();
            console.log("ERROR", data);
            displayError(data);
        });
        window.progressInterval = setInterval(checkProgress, window.updatePeriod);


});


});


function displayError(data){
    clearInterval(window.progressInterval);
    console.log(data);
    var msg = 'No Message';
    if(typeof data.message !== 'undefined') msg = data.message;
    if(typeof data.responseText !== 'undefined') msg = data.responseText;
    $output = $('<div class="alert alert-danger" role="alert"><strong>Oh no!</strong> Something went wrong, please try again.</div><p>Server message: <pre><code>'+msg+'</code></pre></p>');
    $('#script-output').html($output);
    return true;
}

function createAndInsertStatusBars(num){
    var statusBars = Array;
    var statuses = [
        'progress-bar-success',
        'progress-bar-info',
        'progress-bar-warning',
        'progress-bar-danger'
    ];
    for(i=0; i<num; i++){
        var newStatus = statuses[i%4];
        var $bar = $('#progress-bar-start').clone();
        $bar.addClass('tertiary-status')
            .addClass(newStatus)
            .attr('id', 'tertiary-status-' + i)
            .attr('aria-valuenow', 0)
            .attr('aria-valuemin', 0)
            .attr('aria-valuemax', 100)
            .css('width', '0%');
        $('#script-progress').append($bar);
    }
    return statusBars;
}

function checkProgress(createStatusBars){
    if(typeof createStatusBars === "undefined") createStatusBars = false;
    if(window.finished === true) return;
     url = "<?=base_admin();?>modul/akm/<?=$id_jur;?>_progress.json";

    var d = new Date();
    var n = d.getTime();

    if((n - window.lastUpdate) > window.pollingPeriod || window.lastData == null){

        $.getJSON(url, function(data){

            var d = new Date();
            window.lastUpdate = d.getTime();
            window.lastData = data;

            updateDisplay(data);
            return null;
        }).fail(function(){
            clearInterval(window.progressInterval);
        });
    } else {
        var data = $.extend({},window.lastData);
        data.stage.completeItems = Math.min((data.stage.completeItems + Math.floor(((new Date().getTime()/1000)-data.stage.curTime)*data.stage.rate*0.5)), data.stage.totalItems);
        data.stage.pcComplete = Math.min(((data.stage.completeItems)/data.stage.totalItems),1);
        data.stage.timeRemaining = (data.stage.totalItems - data.stage.completeItems)/data.stage.rate;
        updateDisplay(data);
    }
}

function updateDisplay(data){
    if(typeof data.totalStages !== 'undefined' && $('.tertiary-status').length < 1 ){
        console.log("Created Status Bars");
        createAndInsertStatusBars(data.totalStages);
    }
    var $output;
    if(typeof data.message == 'undefined' || data.error === true || data.stage.stageNum === -1){
        return displayError(data);
    }
    $output = data.message;

    if($('#script-progress').hasClass('hidden')){
        $('#script-progress').hide().removeClass('hidden').fadeIn(200);
    }

    if(window.prevpc === data.stage.pcComplete & data.stage.rate !== null){
        data.stage.completeItems = Math.min((data.stage.completeItems + Math.floor(((new Date().getTime()/1000)-data.stage.curTime)*data.stage.rate)), data.stage.totalItems);
        data.stage.pcComplete = Math.min(((data.stage.completeItems)/data.stage.totalItems),1);
        data.stage.timeRemaining = (data.stage.totalItems - data.stage.completeItems)/data.stage.rate;
    } else {
        window.prevpc = data.stage.pcComplete;
    }

    $output = $('<div>');
   /* $output.append($('<h4>'+Math.ceil( ( ((data.stage.stageNum-1)*100)/(data.totalStages) ) + (data.stage.pcComplete*100/(data.totalStages)) )+'% complete</h4>'));*/
    /*if(data.stage.name!==null)
        $output.append($('<h4>Stage: '+data.stage.name+'</h4>'));*/
    /*if(data.stage.message!==null)
        $output.append($('<p>Server message: <pre><code>'+data.stage.message+'</code></pre></p>'));*/
    if(data.stage.totalItems!==null)
        $output.append($('<p>' + data.stage.completeItems+ ' of ' + data.stage.totalItems + ' processed.</p>'));
    if(data.stage.timeRemaining!==null)
        $output.append($('<p>Remaining time: ' + Math.ceil(data.stage.timeRemaining*10)/10 + ' seconds (est)</p>'));
    /*if(data.stage.rate!==null)
        $output.append($('<p>Currently processing at ' + Math.ceil(data.stage.rate*10)/10 + ' /second</p>'));*/



    for(i = (data.stage.stageNum-1); i > 0; i--){
        $('#tertiary-status-'+(i))
            .attr('aria-valuenow', (1/(data.totalStages))*100)
            .css('width', (1/(data.totalStages))*100+"%");
    }

    var percentOfTotal = (((1/(data.totalStages))*data.stage.pcComplete)*100);

    $(".tertiary-status").text(Math.floor(percentOfTotal)+"%");



    $('#tertiary-status-'+(data.stage.stageNum-1))
        .attr('aria-valuenow', percentOfTotal)
        .css('width', percentOfTotal+"%");
    $('#tertiary-status-' + (data.stage.stageNum-1) +' span').text(Math.ceil(percentOfTotal*100)+"%");

    $('#script-output').html($output);
}


/*function ajax_stream(sem){
   if (!window.XMLHttpRequest){
                alert("Your browser does not support the native XMLHttpRequest object.");
                return;
            }
            try{
                var xhr = new XMLHttpRequest();
                xhr.previous_text = '';

                xhr.onerror = function() { alert("[XHR] Fatal Error."); };
                xhr.onreadystatechange = function() {
                    try{
                        if (xhr.readyState == 4){
                            alert('Download Data Selesai');
                            window.location.reload();
                        }
                        else if (xhr.readyState > 2){
                            var new_response = xhr.responseText.substring(xhr.previous_text.length);
                            var result = JSON.parse( new_response );

                            document.getElementById("divProgress").innerHTML = result.message + '<br />';

                            document.getElementById('proses').style.width = result.progress + "%";
                            $('#proses').html(result.progress + "%");

                            xhr.previous_text = xhr.responseText;
                        }
                    }
                    catch (e){
                        alert("[XHR STATECHANGE] Exception: " + e);
                    }
                };
                xhr.open("GET", "<?=base_admin();?>stream/akm_stream.php", true);
                xhr.send();
            }
            catch (e){
                alert("[XHR REQUEST] Exception: " + e);
            }

          }*/
</script>

