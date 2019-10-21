                 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                     Mahasiswa
                    </h1>
                           <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>mahasiswa">Mahasiswa</a></li>
                        <li class="active">Tambah Mahasiswa</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
<div class="row">
    <div class="col-lg-12"> 
        <div class="box box-solid box-primary">
                                 <div class="box-header">
                                    <h3 class="box-title">Tambah Mahasiswa</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>

                  <div class="box-body">
                     <form id="input_mhs" method="post" class="form-horizontal foto_banyak" action="<?=base_admin();?>modul/mahasiswa/mahasiswa_action.php?act=in">
                     <div class="form-group">
                        <label for="NIM" class="control-label col-lg-2">NIM</label>
                        <div class="col-lg-10">
                          <input type="text" name="nipd" placeholder="NIM" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
                      <div class="form-group">
                        <label for="Nama" class="control-label col-lg-2">Nama</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_pd" placeholder="Nama" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Kelamin" class="control-label col-lg-2">Jenis Kelamin</label>
                        <div class="col-lg-10">
            <select name="jk" data-placeholder="Pilih Jenis Kelamin ..." class="form-control chzn-select" tabindex="2" >
               <option value="L">Laki - Laki</option>
               <option value="P">Perempuan</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">NIK Mahasiswa</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" required="" name="nik" placeholder="Nomor KTP" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">NISN</label>
                        <div class="col-lg-10">
                          <input type="text" name="nisn" placeholder="NISN" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">NPWP</label>
                        <div class="col-lg-10">
                          <input type="text" name="npwp" placeholder="NPWP" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Jalur Masuk</label>
                        <div class="col-lg-10">
                          <select name="id_jalur_masuk" data-placeholder="Pilih Jalur Masuk..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jalur_masuk") as $isi) {
                    echo "<option value='$isi->id'>$isi->jalur</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Kewarganegaraan</label>
                        <div class="col-lg-10">
                          <select name="kewarganegaraan" id="kewarganegaraan" data-placeholder="Kewarganegaraan..." class="form-control chzn-select" tabindex="2" >
               <?php foreach ($db->fetch_all("kewarganegaraan") as $isi) {
                    if ($isi->kewarganegaraan=='ID') {
                      echo "<option value='$isi->kewarganegaraan' selected>$isi->nm_wil</option>";
                    } else {
                      echo "<option value='$isi->kewarganegaraan'>$isi->nm_wil</option>";
                    }
                    
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Tempat Lahir" class="control-label col-lg-2">Tempat Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" name="tmpt_lahir" placeholder="Tempat Lahir" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir" class="control-label col-lg-2">Tanggal Lahir</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl1" data-rule-date="true" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Agama" class="control-label col-lg-2">Agama</label>
                        <div class="col-lg-10">
                          <select required="" name="id_agama" id="id_agama" data-placeholder="Pilih Agama ..." class="form-control chzn-select" tabindex="2" required>
               <option value=""></option>
               <?php foreach ($db->fetch_all("agama") as $isi) {
                  echo "<option value='$isi->id_agama'>$isi->nm_agama</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jalan" class="control-label col-lg-2">Jalan</label>
                        <div class="col-lg-10">
                          <input type="text" name="jln" placeholder="Jalan" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RT" class="control-label col-lg-2">RT</label>
                        <div class="col-lg-10">
                          <input type="text" name="rt" placeholder="RT" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="RW" class="control-label col-lg-2">RW</label>
                        <div class="col-lg-10">
                          <input type="text" name="rw" placeholder="RW" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Dusun" class="control-label col-lg-2">Dusun</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_dsn" placeholder="Dusun" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kelurahan" class="control-label col-lg-2">Kelurahan</label>
                        <div class="col-lg-10">
                          <input type="text" name="ds_kel" placeholder="Kelurahan" class="form-control" required=""> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Kodepos" class="control-label col-lg-2">Kodepos</label>
                        <div class="col-lg-10">
                          <input type="text" name="kode_pos" placeholder="Kodepos" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Kecamatan</label>
                        <div class="col-lg-10">
                          <select name="id_wil" id="id_wil" data-placeholder="Kecamatan ..." class="form-control chzn-select" tabindex="2" required="">
               <option value=""></option>
               <?php foreach ($db->query("select dwc.id_wil as id_wil, data_wilayah.nm_wil as provinsi,dw.nm_wil as kab,dwc.nm_wil as kecamatan from data_wilayah
inner join data_wilayah dw on data_wilayah.id_wil=dw.id_induk_wilayah
inner join data_wilayah dwc on dw.id_wil=dwc.id_induk_wilayah
where data_wilayah.id_level_wil='1'") as $isi) {
                  echo "<option value='$isi->id_wil'>$isi->kecamatan - $isi->kab - $isi->provinsi</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Jenis Tinggal</label>
                        <div class="col-lg-10">
                          <select name="id_jns_tinggal" id="id_jns_tinggal" data-placeholder="Pilih Jenis Tinggal ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_tinggal") as $isi) {
                  echo "<option value='$isi->id_jns_tinggal'>$isi->nm_jns_tinggal</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Tinggal" class="control-label col-lg-2">Alat Transportasi</label>
                        <div class="col-lg-10">
                          <select name="id_alat_transport" id="id_alat_transport" data-placeholder="Pilih Alat Transportasi ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("data_transportasi") as $isi) {
                  echo "<option value='$isi->id_alat_transport'>$isi->nm_alat_transport</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Telepon" class="control-label col-lg-2">Telepon</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="no_tel_rmh" placeholder="Telepon" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="HP" class="control-label col-lg-2">HP</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="no_hp" placeholder="HP" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">Email</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-email="true" name="email" placeholder="Email" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Kelamin" class="control-label col-lg-2">Penerima KPS ?</label>
                        <div class="col-lg-10">
            <select name="a_terima_kps" data-placeholder="Penerima KPS ? ..." class="form-control chzn-select" tabindex="2" >
               <option value="0">Tidak</option>
               <option value="1">Ya</option>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Email" class="control-label col-lg-2">No KPS</label>
                        <div class="col-lg-10">
                          <input type="text" name="no_kps" placeholder="no_kps" class="form-control"> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenis Pendaftaran" class="control-label col-lg-2">Jenis Pendaftaran</label>
                        <div class="col-lg-10">
                          <select required="" name="id_jns_daftar" id="id_jns_daftar" data-placeholder="Pilih Jenis Pendaftaran ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenis_pendaftaran") as $isi) {
                  echo "<option value='$isi->id_jns_daftar'>$isi->nm_jns_daftar</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Masuk Kuliah" class="control-label col-lg-2">Tanggal Masuk Kuliah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl3" data-rule-date="true" name="tgl_masuk_sp" placeholder="Tanggal Masuk Kuliah" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Mulai Semester" class="control-label col-lg-2">Mulai Semester</label>
                        <div class="col-lg-10">
                          <input type="text" name="mulai_smt" placeholder="contoh (20091)" class="form-control" required="" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">NIK Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nik_ayah" placeholder="Nomor KTP Ayah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->

<div class="form-group">
                        <label for="Nama Ayah" class="control-label col-lg-2">Nama Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ayah" placeholder="Nama Ayah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ayah" class="control-label col-lg-2">Tanggal Lahir Ayah</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl5" name="tgl_lahir_ayah" placeholder="Tanggal Lahir Ayah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ayah" class="control-label col-lg-2">Pendidikan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ayah" data-placeholder="Pilih Pendidikan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ayah" class="control-label col-lg-2">Pekerjaan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ayah" data-placeholder="Pilih Pekerjaan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ayah" class="control-label col-lg-2">Penghasilan Ayah</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ayah" data-placeholder="Pilih Penghasilan Ayah ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nomor KTP" class="control-label col-lg-2">NIK Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" data-rule-number="true" name="nik_ibu" placeholder="Nomor KTP Ibu" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Nama Ibu" class="control-label col-lg-2">Nama Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_ibu_kandung" placeholder="Nama Ibu" class="form-control" required> 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Ibu" class="control-label col-lg-2">Tanggal Lahir Ibu</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl2" data-rule-date="true" name="tgl_lahir_ibu" placeholder="Tanggal Lahir Ibu" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pendidikan Ibu" class="control-label col-lg-2">Pendidikan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_ibu" data-placeholder="Pilih Pendidikan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan Ibu" class="control-label col-lg-2">Penghasilan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_ibu" data-placeholder="Pilih Penghasilan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan Ibu" class="control-label col-lg-2">Pekerjaan Ibu</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_ibu" data-placeholder="Pilih Pekerjaan Ibu ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="nm_wali" class="control-label col-lg-2">Nama Wali</label>
                        <div class="col-lg-10">
                          <input type="text" name="nm_wali" placeholder="Nama Wali" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Tanggal Lahir Wali" class="control-label col-lg-2">Tanggal Lahir Wali</label>
                        <div class="col-lg-10">
                          <input type="text" id="tgl4" data-rule-date="true" name="tgl_lahir_wali" placeholder="Tanggal Lahir Wali" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jenjang Pendidikan" class="control-label col-lg-2">Jenjang Pendidikan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_jenjang_pendidikan_wali" data-placeholder="Pilih Jenjang Pendidikan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("jenjang_pendidikan") as $isi) {
                  echo "<option value='$isi->id_jenj_didik'>$isi->nm_jenj_didik</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Pekerjaan" class="control-label col-lg-2">Pekerjaan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_pekerjaan_wali" data-placeholder="Pilih Pekerjaan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pekerjaan") as $isi) {
                  echo "<option value='$isi->id_pekerjaan'>$isi->nm_pekerjaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Penghasilan Wali</label>
                        <div class="col-lg-10">
                          <select name="id_penghasilan_wali" data-placeholder="Pilih Penghasilan ..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("penghasilan") as $isi) {
                  echo "<option value='$isi->id_penghasilan'>$isi->nm_penghasilan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Penghasilan" class="control-label col-lg-2">Jenis Pembiayaan</label>
                        <div class="col-lg-10">
                          <select name="id_pembiayaan" data-placeholder="Jenis Pembiayaan..." class="form-control chzn-select" tabindex="2" >
               <option value=""></option>
               <?php foreach ($db->fetch_all("pembiayaan") as $isi) {
echo "<option value='$isi->id_pembiayaan'>$isi->nm_pembiayaan</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="biaya_masuk_kuliah" class="control-label col-lg-2">Biaya Masuk Kuliah</label>
                        <div class="col-lg-10">
                          <input type="number" name="biaya_masuk_kuliah" class="form-control" > 
                        </div>
                      </div><!-- /.form-group -->
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-2">Jurusan</label>
                        <div class="col-lg-10">
                          <select name="kode_jurusan" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php 
  $jur = $db->query("select * from jurusan where kode_jurusan=?",array('jur' => $path_four));
foreach ( $jur as $isi) {
                  echo "<option value='$isi->kode_jurusan'>$isi->jenjang $isi->nama_jurusan</option>";
                  
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->

                      
                      <div class="form-group">
                        <label for="tags" class="control-label col-lg-2">&nbsp;</label>
                        <div class="col-lg-10">
                         <a onclick="window.history.back(-1)" class="btn btn-success btn-flat"><i class="fa fa-step-backward"></i> Kembali</a>
           <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button> </div>
             
                        </div>
                      </div><!-- /.form-group -->
                    </form>
          
                  </div>
                  </div>
              </div>
</div>
                  
                </section><!-- /.content -->

<script type="text/javascript">
    $(document).ready(function() {
     
    $('select').on('change', function() {
    $(this).valid();
});
    
    $("#input_mhs").validate({
       ignore: ":hidden:not(select)",
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
            } else if (element.attr("type") == "checkbox") {
                element.parent().parent().append(error);
            } else if (element.attr("type") == "radio") {
                element.parent().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        
        submitHandler: function(form) {
            $("#loadnya").show();
            $(form).ajaxSubmit({
                type: "post",
                url: $(this).attr("action"),
                data: $("#input_semester").serialize(),
                success: function(data) {
                    console.log(data);
                    $("#loadnya").hide();
                    if (data == "good") {
                        $(".notif_top").fadeIn(1000);
                        $(".notif_top").fadeOut(1000, function() {
                                window.history.back();
                            });
                    } else {
                        alert(data);
                    }
                    $("#loadnya").hide();
                }
            });
        }
    });
});
</script>