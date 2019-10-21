
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Dosen Ajar <?php echo $db->fetch_single_row('jurusan','kode_jurusan',$id_jur)->nama_jurusan;?>
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>dosen-ajar">Dosen Ajar</a></li>
                        <li class="active">Dosen Ajar List</li>
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

          <a href="<?=base_index();?>dosen-ajar/import/<?=$id_jur;?>" class="btn btn-primary btn-flat"><i class="fa fa-cloud-upload"></i> Upload Data Excel</a>
   <button class="btn btn-info btn-flat up_feeder"><i class="fa fa-mail-forward"></i> Impor ke PDDIKTI feeder</button>
                          <?php
                          }
                       }
}
?>

<div id="isi_drop" style="display:none">
<p>&nbsp;</p>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Semester</label>
                        <div class="col-lg-3">
                          <select id="semester" name="semester" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select * from semester order by semester desc") as $isi) {
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
            <button class="btn btn-success btn-flat down_akm_now">
<i class="fa fa-cloud-download"></i> Download Data</button>
            </div>
</div>


</div>
</div>
<div id="hasil_up" style="display:none"></div>
<div id="isi_drop_up" style="display:none">
<p>&nbsp;</p>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Semester</label>
                        <div class="col-lg-3">
                          <select id="semester_up" name="semester_up" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select ajar_dosen.semester,nama_semester from ajar_dosen inner join semester on
 ajar_dosen.semester=semester.semester where kode_jurusan='".$id_jur."' group by ajar_dosen.semester order by ajar_dosen.semester desc") as $isi) {
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
            <button class="btn btn-success btn-flat up_feeder_now">
<i class="fa fa-cloud-download"></i> Upload Data</button>
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
               <?php foreach ($db->query("select ajar_dosen.semester,nama_semester from ajar_dosen inner join semester on
 ajar_dosen.semester=semester.semester where kode_jurusan='".$id_jur."' group by ajar_dosen.semester order by ajar_dosen.semester desc") as $isi) {
                  echo "<option value='$isi->semester'>$isi->semester $isi->nama_semester</option>";
               } ?>
              </select>

 </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Matakuliah</label>
                        <div class="col-lg-4">
                       <select class="form-control" name="matkul" id="matkul">
                         <option value="all">Semua</option>
            
              </select>
                  </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Kode Matakuliah" class="control-label col-lg-2">Status</label>
                        <div class="col-lg-4">
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
                                    <table id="dtb_dosen_ajar" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
    <th><input type="checkbox"  id="bulkDelete"  /> <button id="deleteTriger"><i class="fa fa-trash"></i></button></th>
                     
                          <th>Semester</th>
													<th>NIDN</th>
													<th>Nama Dosen</th>
													<th>Kode Matakuliah</th>
													<th>Nama Kelas</th>
                          <th>Tatap Muka</th>
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
                <button type="button" data-id="<?=$id_jur;?>" data-uri="<?=base_admin();?>modul/dosen_ajar/dosen_ajar_action.php"  class="btn btn-danger" id="hapus_data_error"><i class="fa fa-info-circle"></i> hapus data error</button>
                <button type="button" data-id="<?=$id_jur;?>" data-uri="<?=base_admin();?>modul/dosen_ajar/dosen_ajar_action.php" class="btn btn-danger" id="kosongkan_data"><i class="fa fa-recycle"></i> kosongkan data</button>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
        <?php
       foreach ($db->fetch_all("sys_menu") as $isi) {
                      if ($path_url==$isi->url) {
                          if ($role_act["insert_act"]=="Y") {
                    ?>
          <a href="<?=base_index();?>dosen-ajar/tambah/<?=$id_jur;?>" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                          <?php
                          } 
                       } 
}
      
  foreach ($db->fetch_all("sys_menu") as $isi) {

  //jika url = url dari table menu
  if ($path_url==$isi->url) {
    //check edit permission
  if ($role_act["up_act"]=="Y") {
  $edit = '<a href="'.base_index()."dosen-ajar/edit/'+aData[indek]+'/$id_jur".'" class="btn btn-primary btn-flat"><i class="fa fa-pencil"></i></a>';
  } else {
    $edit ="";
  }
  if ($role_act['del_act']=='Y') {
   $del = "<span data-id='+aData[indek]+' data-uri=".base_admin()."modul/dosen_ajar/dosen_ajar_action.php".' class="btn btn-danger hapus btn-flat"><i class="fa fa-trash"></i></span>';
  } else {
    $del="";
  }
                   } 
  }
  
?>  
                </section><!-- /.content -->
        <script type="text/javascript">
$(document).ready(function() {

  $("#sem_filter").change(function(){
    $("#matkul").chosen();
      $.ajax({
          url : "<?=base_admin();?>modul/dosen_ajar/matkul.php",
          type : "post",
          data : {jurusan : "<?=$id_jur;?>",semester : $(this).val() },
          success : function(data) {
              $("#matkul").html(data);
              $("#matkul").trigger('chosen:updated');

          }

      });
     
  });

 var dataTable = $("#dtb_dosen_ajar").dataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var indek = aData.length-1;           
     $('td:eq('+indek+')', nRow).html(' <?=$edit;?> <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
        "columnDefs": [ {
              "targets": [0,8],
              "orderable": false,
              "searchable": false

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/dosen_ajar/dosen_ajar_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                      d.jurusan = "<?=$id_jur;?>";
                  },
          error: function (xhr, error, thrown) {
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
              "language": {
            "infoPostFix":"<br><b>Jumlah :</b> <br> Belum diproses(0): <b>_BELUM_</b> <br>Sukses(1): <b>_SUKSES_</b> <br> Error(2): <b> _ANEH_ </b>"
        },

      //  'sAjaxSource': '<?=base_admin();?>modul/akm/akm_data.php',

        });

   $.ajax({
     url: '<?=base_admin();?>modul/dosen_ajar/create_json.php?jurusan='+<?=$id_jur;?>,
      });

$('#filter').on('click', function() {
  dataTable.fnDestroy();
  $("#dtb_dosen_ajar").dataTable({
           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
            var indek = aData.length-1;           
     $('td:eq('+indek+')', nRow).html('<?=$edit;?> <?=$del;?>');
       $(nRow).attr('id', 'line_'+aData[indek]);
   },
           'bProcessing': true,
            'bServerSide': true,
        "columnDefs": [ {
              "targets": [0,8],
              "orderable": false,
              "searchable": false

            } ],
            "ajax":{
              url :"<?=base_admin();?>modul/dosen_ajar/dosen_ajar_data.php",
            type: "post",  // method  , by default get
            data: function ( d ) {
                      d.jurusan = "<?=$id_jur;?>";
                      d.semester = $("#sem_filter").val();
                      d.kode_mk = $("#matkul").val();
                      d.status_filter = $("#status_filter").val();
                  },
          error: function (xhr, error, thrown) {
            console.log(xhr);
              $(".dtb_akm-error").html("");
              $("#dtb_akm").append('<tbody class="dtb_akm-error"><tr><th colspan="6">No data found in the server</th></tr></tbody>');
              $("#dtb_akm_processing").css("display","none");

            }
          },
              "language": {
            "infoPostFix":"<br><b>Jumlah :</b> <br> Belum diproses(0): <b>_BELUM_</b> <br>Sukses(1): <b>_SUKSES_</b> <br> Error(2): <b> _ANEH_ </b>"
        },

      //  'sAjaxSource': '<?=base_admin();?>modul/akm/akm_data.php',

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
              url: "<?=base_admin();?>modul/dosen_ajar/dosen_ajar_action.php?act=del_massal",
              data: {data_ids:ids_string},
              success: function(result) {
                window.location.reload();
              },
              //async:false
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


$('.up_feeder').on('click', function() {

  if ($('#isi_drop_up').is(":visible")){
    $("#isi_drop_up").hide();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  } else {
    $("#isi_drop_up").show();
    $("#isi_drop").hide();
    $("hasil_up").hide();
  }


});

$('.up_feeder_now').on('click', function() {

//$("#loadnya").show();
//$(".text-wait-up").show();
// $("#isi_drop_up").hide();
 
window.finished = false;
        $.getJSON('<?=base_admin();?>modul/dosen_ajar/push_dosen_ajar.php?sem='+$("#semester_up").val()+"&jurusan="+<?=$id_jur;?>,
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
                    //$("#loadnya").hide();
                   // $(".text-wait-up").hide();
                    $("#isi_drop_up").hide();
                    $("#progress_nya").hide();
                    $("#isi_informasi").html(data.message);
                    $('#informasi').modal('show');
                    
                   // window.location.reload();
                }
            }
        ).error(function(data){
            window.hasError = true;
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
    url = "<?=base_admin();?>modul/dosen_ajar/<?=$id_jur;?>_progress.json";

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
</script>  
            