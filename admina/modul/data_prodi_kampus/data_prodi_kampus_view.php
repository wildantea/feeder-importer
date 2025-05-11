
          <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Prodi Kampus
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>data-prodi-kampus">Prodi Kampus</a></li>
                        <li class="active">Prodi Kampus List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
  <button class="btn btn-primary down_kelas" data-jenis="kampus"><i class="fa fa-cloud-download"></i> Download Update Data Prodi Kampus</button>
  <div class="row" id="show_progress" style="display: none">
   <div class="col-md-11">
    Mohon Tunggu sedang Download Data <img src="<?=base_admin();?>assets/dist/img/squares.gif">
    </div>
               <div class="col-md-11">
                        <div class="progress">
                          <div class="progress-bar progress-bar-striped" id="progressbar" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                            10%
                          </div>

                        </div></div><div class='col-md-1' id="message"><span class='current-count'>1</span>/<span class="total-count">13</span></div></div>
                           <div class="alert alert-danger alert-dismissible" id="ada_error" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error! , Contact saya ke wildannudin@gmail.com, screenshoot, kasih tahu saya error dibawah</h4><span class="isi_error"></span>
              </div>
<p>
<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Filter</h3>
            </div>
            <div class="box-body">
           <form class="form-horizontal" method="post" action="<?=base_admin();?>modul/data_prodi_kampus/download_data.php">
                      <div class="form-group">
                        <label for="Semester" class="control-label col-lg-2">Kampus</label>
                        <div class="col-lg-6">
                        <select id="kampus" name="kampus" data-placeholder="Pilih Kampus ..." class="form-control" tabindex="2">
                        <option value="all">Semua</option>
               <?php foreach ($db->fetch_custom("select * from satuan_pendidikan") as $isi) {
                  echo "<option value='$isi->id_sp'>$isi->nm_lemb</option>";
               } ?>
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
                          <th>Kampus</th>
                          <th>Kode PT</th>
                          <th>Prodi</th>
                          <th>Jenjang</th>
                          <th>Kode Prodi</th>
                         
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
<link href="<?=base_admin();?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
 <script src="<?=base_admin();?>assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script type="text/javascript">

$(document).ready(function() {


$( "#kampus" ).select2({
  ajax: {
    url: '<?=base_admin();?>modul/data_prodi_kampus/get_kampus.php',
    dataType: 'json'
    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
  },
  formatInputTooShort: "Cari Nama Kampus",
  width: "100%",
});

});




var dataTable = $("#dtb_data_wilayah").dataTable({

           'bProcessing': true,
            'bServerSide': true,
    
            'ajax':{
              url :'<?=base_admin();?>modul/data_prodi_kampus/data_prodi_kampus_data.php',
            type: 'post',  // method  , by default get
          error: function (xhr, error, thrown) {
              console.log(xhr);

            }
          },
        });

$('#filter').on('click', function() {
  dataTable.fnDestroy();
 $("#dtb_data_wilayah").dataTable({

           'bProcessing': true,
            'bServerSide': true,
    
            'ajax':{
              url :'<?=base_admin();?>modul/data_prodi_kampus/data_prodi_kampus_data.php',
            type: 'post',  // method  , by default get
            data : {kampus : $("#kampus").val()},
          error: function (xhr, error, thrown) {
              console.log(xhr);

            }
          },
        });

      });



$(".down_kelas").click(function(){

  //alert('tes');
          /*$(this).attr("disabled", true);
          var start_time = new Date().getTime();
          $("#show_progress").show();*/
          var jenis = $(this).attr('data-jenis');

          total(jenis);
          /*
          total_data = parseInt(total());

          var bagi = Math.ceil(total_data/100);
          
          getData(bagi,total_data,start_time);*/
          //$("#loadnya").hide();
   
});


$("#ok_info_download").click(function(){
      location.reload();
  });



function millisToMinutesAndSeconds(s) {
  var ms = s % 1000;
  s = (s - ms) / 1000;
  var secs = s % 60;
  s = (s - secs) / 60;
  var mins = s % 60;
  var hrs = (s - mins) / 60;

  return (hrs < 1 ? '' : hrs+' Jam : ') + (mins < 1 ? '' : mins+' Menit : ') + secs + ' detik';
}

 function proses(percent){
   $("#progressbar").css("width",percent+"%");
      $("#progressbar").html(percent+"%");
/*    if(percent>10){
      
     
      } else {
        $("#progressbar").css("width",10+"%");
        $("#progressbar").html(10+"%");
      }*/
    } 

function total(jenis) {
          $("#show_progress").show();
          //$(".down_kelas").attr("disabled", true);
          var start_time = new Date().getTime();
          var totaldata;
             $.ajax({
              url: "<?=base_admin();?>modul/data_prodi_kampus/get_jumlah.php?jenis="+jenis,
              type : "post",
              dataType: 'json',
              //'async':false,
              success: function(data) {
                 totaldata = data.jumlah;
                  total_data = parseInt(totaldata);
                  var bagi = Math.ceil(total_data/101);
                    
                    getData(bagi,total_data,start_time,jenis);
                    //dataTable.draw(false);
              }
            });
}



   
    var counters = 0;
    var persen = 0;
    var progress=101;
    var all_id = "";
    var error_msg = "";
    var token = "";
    var last = "";

    var data_recs = [];

   
   
    
   
    
window.getData=function(bagi,total_data,start_time,jenis)
{
    var start = start_time;


     
 
    if ((bagi*101)==progress) {
      data = {
          error_msg : error_msg,
          total_data : total_data,
          offset : counters,
          token : token,
          last : 'yes'
          }
    } else {
      data = {
            total_data : total_data,
            offset : counters,
            token : token,
            //data_rec : data_rec,
            last : 'no'
          }
    }




    $.ajax({
        /* The whisperingforest.org URL is not longer valid, I found a new one that is similar... */
        url: "<?=base_admin();?>modul/data_prodi_kampus/get_latest.php?jenis="+jenis,
        //async:false,
        data : data,
        type : "post",
        dataType: 'json',
        success:function(data){
          $.each(data, function(index) {
            persen = ((progress/total_data)*100).toFixed(1);
            if (persen>100) {
              persen=100+ "%";
              progress = total_data;
            } else {
              persen=persen+ "%";
              progress = progress;
            }

            //data_rec.push(data[index].data_rec);
           
            $(".current-count").html(progress);
            $(".total-count").html(total_data);
            persen = parseInt(persen);
            proses(persen);
              
              counters+=101;
              progress+=101;
              token = data[index].token;

              //console.log(data[index].offset);
               if (counters < total_data) {
                  getData(bagi,total_data,start,jenis);
                } else {
                 $("#loadnya").hide();
                  var end_time = new Date().getTime();
                  waktu = "Total Waktu Generate : "+millisToMinutesAndSeconds(end_time-start);
                  alert('Generate File Download Selesai');
                  $("#isi_informasi_download").html(data[index].last_notif.concat(waktu));
                  $('#informasi_download').modal('show');
                  //console.log('done');
                } 
              });

        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert('oops ada error');
        $("#loadnya").hide();
         $("#ada_error").show();
        $(".isi_error").html(xhr.responseText);
        
        }

    });
}
</script>  
            