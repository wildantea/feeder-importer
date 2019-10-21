<?php

?>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Matakuliah</label>
                        <div class="col-lg-3">
                          <select id="semester_up" name="semester_up" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select * from krs where kode_jurusan='".$id_jur."' and semester='$semester' group by krs.kode_mk order by krs.nama_mk asc") as $isi) {
                  echo "<option value='$isi->kode_mk'>$isi->kode_mk $isi->nama_mk </option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
</div>
<div class="row">
<div class="form-group">
                        <label for="Jurusan" class="control-label col-lg-1">Kelas</label>
                        <div class="col-lg-3">
                          <select id="semester_up" name="semester_up" data-placeholder="Pilih Jurusan ..." class="form-control chzn-select" tabindex="2" required>
               <?php foreach ($db->query("select * from krs where kode_jurusan='".$id_jur."' and semester='$semester' and kode_mk='$kode_mk' group by krs.nama_kelas order by krs.nama_kelas asc") as $isi) {
                  echo "<option value='$isi->nama_kelas'>$isi->nama_kelas</option>";
               } ?>
              </select>
                        </div>
                      </div><!-- /.form-group -->
</div>