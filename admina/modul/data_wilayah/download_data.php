<?php
include "../../inc/config.php";

/** PHPExcel */
require_once '../../lib/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once '../../lib/PHPExcel/IOFactory.php';


if (isset($_POST['provinsi'])) {
    if ($_POST['provinsi']=='all') {
        $provinsi = '';
        $nama_provinsi = "";
    } else {
        $provinsi = " and data_wilayah.id_wil='".$_POST['provinsi']."'";
        $nama_provinsi = $db->fetch_single_row("data_wilayah",'id_wil',$_POST['provinsi']);
        $nama_provinsi = preg_replace("/[[:blank:]]+/"," ",$nama_provinsi->nm_wil);
        $nama_provinsi = str_replace(" ","_",$nama_provinsi);
    }

    if ($_POST['kabupaten']=='all') {
      $kabupaten = '';
       $nama_kabupaten = "";
    } else {
      $kabupaten = " and dw.id_wil='".$_POST['kabupaten']."'";
      $nama_kabupaten = $db->fetch_single_row("data_wilayah",'id_wil',$_POST['kabupaten']);
      $nama_kabupaten = preg_replace("/[[:blank:]]+/"," ",$nama_kabupaten->nm_wil);
        $nama_kabupaten = str_replace(" ","_",$nama_kabupaten);
     
    }

        }




// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getDefaultStyle()->getFont()
    ->setName('Arial')
    ->setSize(10);
    //set font size
//page setup 
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);

//set margin 
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.5);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.31);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.31);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(1.6);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.19);

//set width column
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(27);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(19);

//set font
$objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setSize(10);


//$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setTextRotation(-90);
// Set properties
$objPHPExcel->getProperties()->setCreator("Mark Baker")
                             ->setLastModifiedBy("Mark Baker")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO')
            ->setCellValue('B1', 'Provinsi')
            ->setCellValue('C1', 'kabupaten')
            ->setCellValue('D1', 'Kecamatan')
            ->setCellValue('E1', 'Id Kecamatan');


    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        
//horizontal style 
  $objPHPExcel->getActiveSheet()->getStyle('A1'.':E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
  
$no=1;
$index = 2;

$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()->setARGB('00ff00');


 $styleArray = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );


   
        $order_by = "order by kode_mk,nama_kelas ASC";

    
        $temp_rec = $db->query("select dwc.id_wil as id_wil, data_wilayah.nm_wil as provinsi,dw.nm_wil as kab,dwc.nm_wil as kecamatan from data_wilayah
inner join data_wilayah dw on data_wilayah.id_wil=dw.id_induk_wilayah
inner join data_wilayah dwc on dw.id_wil=dwc.id_induk_wilayah
where data_wilayah.id_level_wil='1' $provinsi $kabupaten");
                    foreach ($temp_rec as $key) {
        
              $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);

              $objPHPExcel->getActiveSheet()->getStyle('A1:E'.$index)->applyFromArray($styleArray);


                $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$index, $no)
             ->setCellValue('B'.$index, $key->provinsi)
             ->setCellValue('C'.$index, $key->kab)
             ->setCellValue('D'.$index, $key->kecamatan)
             ->setCellValue('E'.$index, $key->id_wil);
             $no++;
             $index++;

            }


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Data Wilayah'.$nama_provinsi." ".$nama_kabupaten);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
//$sheet->getStyle($column.$style)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Data_Wilayah_'.$nama_provinsi.$nama_kabupaten.'.xlsx"');
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
return $objWriter->save('php://output');
exit;
?>