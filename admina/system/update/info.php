    <!-- Main content -->
    <section class="content">
    <div class="row">

      <div class="col-lg-12">
        <div class="box box-solid box-primary">
          <div class="box-header">
            <h3 class="box-title">Informasi</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-info"></i></button>
            </div>
          </div>
          <div class="box-body">
<section id="advice">
  <h2 class="page-header"><a href="#advice">Salam</a></h2>
  <p class="lead">
   Mohon Maaf Sekali lagi, saya meminta bantuan Bapa - Ibu Sebelum Menggunakan Importer ini, untuk mengisi Survey Untuk Kebutuhan Disertasi Dari Dosen Saya. Survey ini mengenani Penerapan Teknologi di Kampus Bapa - Ibu. Berikut Langkah Untuk Mengisi Surveynya :
  </p>

  <ul>
    <li><b>Silakan Klik Link Berikut <a href="https://wildantea.com/survey/index.php/862193?lang=en" target="_blank">Angket Teknologi</a>.</b></li>
    <li><b>Silakan Bapa - Ibu mengisi Angketnya sampai Selesai, Hanya 5 Menit Max.</b></li>
    <li><b>Jika Telah Selesai Mengisi Angket, Masukan Email yang tadi diisikan di form survey pada Form Dibawah, lalu klik Submit. </b></li>
    <li><b>Data Yang diisikan Saya jamin hanya untuk kebutuhan Disertasi Saja, dan tidak akan digunakan untuk selain Kebutuhan itu.</b></li>
  </ul>
 
</section>
           <div class="alert alert-danger error_data" style="display:none">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <span class="isi_warning"></span>
        </div>
           <div class="alert alert-success sukses_data" style="display:none">
           	<h3>Saya Ucapkan, Terimakasih Banyak Atas Bantuanya</h3>
        </div>
            <form id="input_bee" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>system/update/info_detail.php">
                      
              <div class="form-group">
                <label for="nama" class="control-label col-lg-2">Email <span style="color:#FF0000">*</span></label>
                <div class="col-lg-10">
                  <input type="email" name="email" placeholder="Masukan Email yang diisikan di form Survey" class="form-control" required>
                </div>
              </div><!-- /.form-group -->
              
           
                      
              <div class="form-group">
                <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                <div class="col-lg-5">
           
            <button type="submit" class="btn btn-primary">Submit</button>
           
                </div>
              </div><!-- /.form-group -->

            </form>
  <p class="lead">
   Sekali Lagi Terimakasih Atas Bantuanya
  </p>
          </div>
        </div>
      </div>
    </div>

    </section><!-- /.content -->
   <script src="<?=base_admin();?>assets/login/js/jqueryform.js"></script>
  <script src="<?=base_admin();?>assets/login/js/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

    $("#input_bee").validate({
        errorClass: "help-block",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-success").addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").removeClass(
                "has-error").addClass("has-success");
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("chzn-select")) {
                var id = element.attr("id");
                error.insertAfter("#" + id + "_chosen");
            } else if (element.hasClass("tgl_picker_input")) {
               element.parent().parent().append(error);
            } else if (element.attr("accept") == "image/*") {
                element.parent().parent().parent().append(error);
            }
             else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        rules: {
            
          email: {
          required: true,
          //minlength: 2
          }
        
        },
         messages: {
            
          email: {
          required: "Mohon Isi dengan Email yang disikan Di form Survey",
          //minlength: "Your username must consist of at least 2 characters"
          }
        
        },
    
        submitHandler: function(form) {
            $("#loadnya").show();
            $(form).ajaxSubmit({
                url : $(this).attr("action"),
                dataType: "json",
                type : "post",
                error: function(data ) { 
                  $("#loadnya").hide();
                  console.log(data); 
                },
                success: function(responseText) {
                  $("#loadnya").hide();
                  console.log(responseText);
                      $.each(responseText, function(index) {
                      	if(responseText[index].status=="error") {
                             $(".isi_warning").text(responseText[index].error_message);
                             $(".error_data").focus()
                             $(".error_data").fadeIn();
                      	} else {
                             $(".sukses_data").focus()
                             $(".sukses_data").fadeIn();
                            $(".sukses_data").fadeOut(1000, function() {
                                    location.reload();
                            });
                      	}

                    });
                }

            });
        }
    });
});
</script>
