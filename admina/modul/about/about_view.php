
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        About
                    </h1>
                      
                </section>
<section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                        <div class="box box-primary">

            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Sebelum Digunakan, Feeder Importer Harus di Konekan Ke Feeder Dikti</h3>


            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list ui-sortable">
                <li>
               
                  <!-- todo text -->
                  <span class="text">1. Silakan Masuk Menu Master Data -> config akun feeder, lalu klik Edit, kemudian isi dengan akun pddikti anda, Lalu Simpan.</span>
                  <!-- Emphasis label -->

                </li>
                <li>
                      
                
                  <span class="text">2. Masuk Menu Master Data -> Jurusan, Lalu klik Download Data Jurusan</span>
               
                </li>
              </ul>
            </div>



                <div class="box-body" style="line-height: 2em">

                Feeder Importer adalah tool gratis untuk import data ke feeder dikti. <p></p>

                TIPS : <p></p>
                1. Buka C:\xampp\apache\conf\httpd.conf , lalu tambah perintah berikut di baris terahir
                <pre style="font-weight: 600;">  AcceptFilter http none
  AcceptFilter https none</pre>
                2. Supaya process execution lebih dari 30 detik atau jika mengalami error <span style="color:#f00">Maximum execution time of 30 seconds exceeded</span> Maka langkah yang harus dilakukan adalah merubah file php.ini yang ada di directory c:/xampp/php/php.ini. cari <span style="color:#f00">
                <pre style="font-weight: 600;">  max_execution_time=30</pre>
</span> 
Kemudian ubah 30 jadi 3600 (berarti anda merubah process menjadi 3000 detik atau 1 jam)
                <br>
                3. Jika mengalami error <span style="color:#f00">PHP: Fatal Error: Allowed Memory Size</span> , Maka yang harus dilakukan sama, rubah php.ini kemudian cari <span style="color:#f00">memory_limit=</span> tinggal di perbesar memory misal jadi 
                <pre style="font-weight: 600;">memory_limit=128M</pre>
(isian diatas berarti anda set memory 128 megabyte) <br>
<pre style="font-weight: 600;">
PERLU DIPERHATIKAN ISIAN MEMORY DIUSAHAKAN MAXIMAL 1/4 DARI TOTAL MEMORY KOMPUTER SUPAYA TIDAK MEMBEBANI KOMPUTER
</pre>
                4. Jangan Lupa Restart Apache
                <p></p>
                 
                  <p>Jika Punya pertanyaan Bisa Langsung hubungi saya</p>
                  Email : wildannudin@gmail.com<br>
                  Call/SMS/WA : 081395070845<br>
                  Web : <a target="_blank" href='https://feeder-importer.com'>https://feeder-importer.com</a><br>
                  <b style="color:#f00">Jika Tertarik dengan Importer yang lebih Banyak Fitur dan Support Full dari Saya Bisa klik Link Berikut <a target="_blank" href="https://feeder-importer.com/premium">Klik Disini</a></b>

                  <p>Terimakasih telah mencoba feeder importer ini. 


                </p></div><!-- /.box-body -->
              </div>
                        </div>
                    </div>
         <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-code"></i> Change Log Aplikasi</h3>
            </div>
            <div class="box-body" style="height: 500px;overflow-y: scroll;">
                  <pre style="font-weight: 600;">
                  <?php
                  $dta = $db->query("select * from sys_update order by version desc");
                  foreach ($dta as $key) {
                      echo "<p>Version ".$key->version."<br>";
                      echo str_replace("<p>", "", str_replace("</p>", "", $key->perubahan));
                  }
                  ?>
                  </pre>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div> 
                </section>