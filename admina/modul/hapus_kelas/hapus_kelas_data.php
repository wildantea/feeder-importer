<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$semester = '';
$kode_mk = '';
$requestData= $_REQUEST;

$sSearch = $requestData['search']['value'];

$iStart = $requestData['start'];
$iLength = $requestData['length'];

$temp_limit = $iLength;
$temp_offset = $iStart?$iStart : 0;
if (isset($_POST['semester'])) {
  
  if ($_POST['semester']=='all') {
    $semester = '';
  } else {
    $semester = "and id_semester='".$_POST['semester']."'";
  }

  if ($_POST['kode_mk']=='all') {
    $kode_mk = '';
  } else {
    $kode_mk = "and id_matkul='".$_POST['kode_mk']."'";
  }

  $jurusan = "id_prodi='".$_POST['jurusan']."'";
}

$filter_kelas = "$jurusan $semester $kode_mk";

$token = get_token();
	if ($sSearch) {
		$filter_kelas .= "and kode_mata_kuliah like '%".$sSearch."%'";
}

$filter_kelas = trim($filter_kelas);



		//$totalData = $temp_total['result'];

		if ($semester!='') {
			$order_by = "nama_kelas_kuliah ASC";
		} else {
			$order_by = "id_semester DESC";
		}


		
		$temp_data_kelas = [
			'act' => 'GetDetailKelasKuliah',
		    'token' => $token,
		    'filter' => $filter_kelas,
		    'order' => '',
		    'limit' => $temp_limit,
		    'offset' => $temp_offset

		];
		$temp_rec = service_request($temp_data_kelas);
		//print_r($temp_rec);

		$dosen_name = array();
		$jml_siswa = array();
		if ($temp_rec->data) {
					foreach ($temp_rec->data as $dt) {
				  $id_kelas[] = $dt->id_kelas_kuliah;
				}


				$in_id_kelas = "'" . implode("','", $id_kelas) . "'";
				//jumlah pengajar
				$count_kelas = [
					'act' => 'ExportDataMengajarDosen',
				    'token' => $token,
				    'filter' => "id_kelas_kuliah in($in_id_kelas)",
				];
				$temp_recs = service_request($count_kelas);
				if ($temp_recs->data) {
					foreach ($temp_recs->data as $count) {
				    	$dosen_name[$count->id_kelas_kuliah] = '- '.$count->nama_dosen."<br>";
					}
				}

				//jumlah mahasiswa kelas
				$count_kelas_mhs = [
					'act' => 'GetKRSMahasiswa',
				    'token' => $token,
				    'filter' => "id_kelas in($in_id_kelas)",
				];
				/*dump($count_kelas_mhs);
				exit();*/
				$temp_recs_mhs = service_request($count_kelas_mhs);
			    foreach ($temp_recs_mhs->data as $key => $dt) {
			      $data[$dt->id_kelas][] = $dt;
			      $jml_siswa[$dt->id_kelas] = count($data[$dt->id_kelas]);
			    }
		}




		        $temp_count_mk = [
              'act' => 'GetCountKelasKuliah',
                'token' => $token,
                'filter' => $filter_kelas
            ];
        $temp_count = service_request($temp_count_mk);
        $jumlah = 0;
       // dump($temp_count);
        if(!empty($temp_count->data)) {
          $jumlah = $temp_count->data;
        }

		//print_r($count_kelas);

		$totalData = $jumlah;
		$totalFiltered = $totalData;


			$temp_data = array();
			$i=0;
							foreach ($temp_rec->data as $key) {

				$temps = array();

				$temps[] = ++$i+$temp_offset." <input type='checkbox'  class='deleteRow' value='".$key->id_kelas_kuliah."'/>";
				$temps[] = $key->id_semester;
				$temps[] = $key->kode_mata_kuliah;
				$temps[] = $key->nama_mata_kuliah;
				$temps[] = $key->nama_kelas_kuliah;
				if (in_array($key->id_kelas_kuliah, array_keys($jml_siswa))) {
					$temps[] = $jml_siswa[$key->id_kelas_kuliah];
				} else {
					$temps[] = 0;
				}
				if (in_array($key->id_kelas_kuliah, array_keys($dosen_name))) {
					$temps[] = $dosen_name[$key->id_kelas_kuliah];
				} else {
					$temps[] = '';
				}
				$temps[] = $key->id_kelas_kuliah;
				
				$temp_data[] = $temps;
			}
			$temp_output = array(
									'draw' => intval($requestData['draw']),
									'recordsTotal' => intval( $totalData ),
									'recordsFiltered' => intval( $totalFiltered ),
									'data' => $temp_data
				);
			echo json_encode($temp_output);
