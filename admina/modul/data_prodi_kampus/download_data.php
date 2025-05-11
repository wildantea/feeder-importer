<?php
include "../../inc/config.php";

require_once '../../lib/Writer.php';

if (isset($_POST['kampus'])) {
    if ($_POST['kampus']=='all') {
        $kampus = '';
        $nama_kampus = "Semua_Kampus";
    } else {
        $kampus = " and satuan_pendidikan.id_sp='".$_POST['kampus']."'";
        $nama_kampus = $db->fetch_single_row("satuan_pendidikan",'id_sp',$_POST['kampus']);
        $nama_kampus = preg_replace("/[[:blank:]]+/"," ",$nama_kampus->nm_lemb);
        $nama_kampus = str_replace(" ","_",$nama_kampus);
    }


        }


$writer = new XLSXWriter();
$style =
        array (
                      array(
              'border' => array(
                'style' => 'thin',
                'color' => '000000'
                ),
            'allfilleddata' => true
            ),
            array(
                'fill' => array(
                    'color' => '00ff00'),
                'cells' => array(
                    'A1',
                    'B1',
                    'C1',
                    'D1',
                    'E1',
                    'F1'
                    ),
                'border' => array(
                    'style' => 'thin',
                    'color' => '000000'),
                'verticalAlign' => 'center',
                'horizontalAlign' => 'center',
                ),
            )
        ;



//column width
$col_width = array(
  1 => 7,
  2 => 50,
  3 => 10,
  4 => 50,
  5 => 10,
  6 => 10
  );
$writer->setColWidth($col_width);


$header = array(
  'No'=>'string',
  'kampus'=>'string',
  'Kode PT' => 'string',
  'Program Studi'=>'string',
  'Jenjang'=>'string',
  'Kode Prodi'=>'string',
);



  
$no=1;
$index = 2;

$data_rec = array();

        $order_by = "order by satuan_pendidikan.nm_lemb ASC";

    
        $temp_rec = $db->fetch_custom("select jenjang_pendidikan.nm_jenj_didik,npsn,sms.nm_lemb as prodi,kode_prodi,satuan_pendidikan.nm_lemb as kampus from sms inner join satuan_pendidikan on sms.id_sp=satuan_pendidikan.id_sp left join jenjang_pendidikan on sms.id_jenj_didik=jenjang_pendidikan.id_jenj_didik where satuan_pendidikan.id_sp is not null $kampus");
                    foreach ($temp_rec as $key) {
          
            $data_rec[] = array($no,$key->kampus,$key->npsn,$key->prodi,$key->nm_jenj_didik,"$key->kode_prodi");

             $no++;
             $index++;

            }


$filename = 'Data_Prodi_'.$nama_kampus.'.xlsx';
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$comments = array(
    'A1' => 'Ket:  status mahasiswa
A : Aktif,
C : Cuti
M : Kampus Merdeka (Pertukaran Pelajar)
N : Non Aktif
G : Sedang Double Degree
U : Menunggu Uji Kompetensi

Info : Wajib Diisi',
    'B1' => 'THIS IS TES COMMENT 2',
    'D1' => 'tes colomn d notes'
);
$writer->setComment($comments);
$writer->writeSheet($data_rec,'Data Prodi', $header, $style);
/*$comment = "This is a comment for cell A1";
$cell = "A1";
$writer->writeComment($cell, $comment);*/

$writer->writeToStdOut();
exit(0);

?>