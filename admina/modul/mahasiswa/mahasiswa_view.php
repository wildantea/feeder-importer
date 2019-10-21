
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Mahasiswa
                    </h1>
                        <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>KRS">Mahasiswa</a></li>
                        <li class="active">Mahasiswa List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">

                                <div class="box-body table-responsive">

                                    <table id="dtb_manual" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
                          <th>No</th>
                          <th>Nama Jurusan</th>
                          <th>Jenjang</th>

                          <th>Jumlah Mahasiswa</th>

                        </tr>
                                      </thead>
                                        <tbody>
                                        <?php
$i=1;
if ($_SESSION['level']==1) {
$data = $db->query("select jurusan.nama_jurusan,count(mhs.id) as jumlah_mhs,jurusan.kode_jurusan,jenjang from jurusan left join mhs
on jurusan.kode_jurusan=mhs.kode_jurusan
group by jurusan.kode_jurusan");
} else {
    $data = $db->query("select jurusan.nama_jurusan,count(mhs.id) as jumlah_mhs,jurusan.kode_jurusan,jenjang from jurusan left join mhs
on jurusan.kode_jurusan=mhs.kode_jurusan
 where jurusan.kode_jurusan='".$_SESSION['jurusan']."' group by jurusan.kode_jurusan");
}
                                        foreach ($data as $dt) {
                                          ?>
<tr>
<td><?=$i;?></td>
<td>
<a href='<?=base_index();?>mahasiswa/choose/<?=$dt->kode_jurusan;?>'><?=$dt->nama_jurusan;?></a>
</td>
<td><?=$dt->jenjang;?></td>
<td><?=$dt->jumlah_mhs;?></td>

</tr>
<?php
$i++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
