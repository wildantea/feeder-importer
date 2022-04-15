<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
$token = get_token();
//config feeder
$config_feeder = $db->fetch_single_row('config_user','id',1);
$id_sp = $config_feeder->id_sp;
	$id_sms = '';
	$id_mk = '';
	$id_reg_ptk = '';
	$nidn = '';
	$id_ptk = '';
	$sks_mk = '';
	$sks_tm = '';
	$sks_prak = '';
	$sks_prak_lap = '';
	$sks_sim = '';
	$temp_data = array();
	$sukses_count = 0;
	$id_pd = "";
	$sukses_msg = '';
	$error_count = 0;
	$error_msg = array();
	$temp_result = array();


	$arr_data = $db->query("select mhs.*,jurusan.id_sms,jurusan.id_jenj_didik from mhs inner join jurusan on mhs.kode_jurusan=jurusan.kode_jurusan where mhs.kode_jurusan='".$_GET['jurusan']."' and mulai_smt='".$_GET['sem']."' and status_error!=1");

$options = array(
    'filename' => $_GET['jurusan'].'_progress.json',
    'autoCalc' => true,
    'totalStages' => 1
);
$pu = new Manticorp\ProgressUpdater($options);



$stageOptions = array(
    'name' => 'This AJAX process takes a long time',
    'message' => 'But this will keep the user updated on it\'s actual progress!',
    'totalItems' => $arr_data->rowCount(),
);


$pu->nextStage($stageOptions);



$i=1;

		function myFilter($var){
			  return ($var !== NULL && $var !== FALSE && $var !== '');
			}

function insertBiodataArray($biodata)
{
    $biodatas = [
        "nama_mahasiswa" => $biodata->nm_pd,
        "jenis_kelamin" => $biodata->jk,
        "tempat_lahir" => $biodata->tmpt_lahir,
        "tanggal_lahir" => $biodata->tgl_lahir,
        "id_agama" => $biodata->id_agama,
        "nik" => $biodata->nik,
        "nisn" => $biodata->nisn,
        "kewarganegaraan" => $biodata->kewarganegaraan,
        "jalan" => $biodata->jln,
        "dusun" => $biodata->nm_dsn,
        "rt" => $biodata->rt,
        "rw" => $biodata->rw,
        "kelurahan" => $biodata->ds_kel,
        "kode_pos" => $biodata->kode_pos,
        "id_wilayah" => $biodata->id_wil,
        "id_jenis_tinggal" => $biodata->id_jns_tinggal,
        "id_alat_transportasi" => $biodata->id_alat_transport,
        "telepon" => $biodata->no_tel_rmh,
        "handphone" => $biodata->no_hp,
        "email" => $biodata->email,
        "penerima_kps" => $biodata->a_terima_kps,
        "nomor_kps" => $biodata->no_kps,
        "nik_ayah" => $biodata->nik_ayah,
        "nama_ayah" => $biodata->nm_ayah,
        "tanggal_lahir_ayah" => $biodata->tgl_lahir_ayah,
        "id_pendidikan_ayah" => $biodata->id_jenjang_pendidikan_ayah,
        "id_pekerjaan_ayah" => $biodata->id_pekerjaan_ayah,
        "id_penghasilan_ayah" => $biodata->id_penghasilan_ayah,
        "nik_ibu" => $biodata->nik_ibu,
        "nama_ibu_kandung" => $biodata->nm_ibu_kandung,
        "id_pendidikan_ibu" => $biodata->id_jenjang_pendidikan_ibu,
        "id_pekerjaan_ibu" => $biodata->id_pekerjaan_ibu,
        "id_penghasilan_ibu" => $biodata->id_penghasilan_ibu,
        "npwp" => $biodata->npwp,
        "nama_wali" => $biodata->nm_wali,
        "tanggal_lahir_wali" => $biodata->tgl_lahir_wali,
        "id_pendidikan_wali" => $biodata->id_jenjang_pendidikan_wali,
        "id_pekerjaan_wali" => $biodata->id_pekerjaan_wali,
        "id_penghasilan_wali" => $biodata->id_penghasilan_wali,
        "id_kebutuhan_khusus_mahasiswa" => 0,
        "id_kebutuhan_khusus_ayah" => 0,
        "id_kebutuhan_khusus_ibu" => 0
    ];
    return $biodatas;
}
function insertRegPdArray($biodata,$additional_data)
{
    global $id_sp;
    global $id_pt_array;
    global $id_prodi_array;
    $biodatas = [
        "id_mahasiswa" => $additional_data['id_mahasiswa'],
        "nim" => $biodata->nipd,
        "id_jenis_daftar" => $biodata->id_jns_daftar,
        "id_jalur_daftar" => $biodata->id_jalur_masuk,
        "id_periode_masuk" => $biodata->mulai_smt,
        "tanggal_daftar" => $biodata->tgl_masuk_sp,
        "id_perguruan_tinggi" => $id_sp,
        "id_prodi" => $biodata->id_sms, 
        "id_bidang_minat" => null,
        "id_pembiayaan" => $biodata->id_pembiayaan,
        "biaya_masuk"  => $biodata->biaya_masuk_kuliah
    ];

    if ($biodata->id_jns_daftar!='1') {
        $array_pindah = array(
            "sks_diakui" => $biodata->sks_diakui,
            "id_perguruan_tinggi_asal" => $additional_data['id_sp']
        );
       	$array_pindah["id_prodi_asal"] = $additional_data['id_sms'];
        $biodatas = array_merge($biodatas,$array_pindah);
    }
    return $biodatas;
}

    $id_pt_array = array();
    if (!empty($check_array_kode_pt)) {

    }
	foreach ($arr_data as $value) {
		$id_pt = "";
		$id_prodi = "";

		$id_sms = $value->id_sms;

		if ($value->id_jns_daftar!='1') {
	            $param = [
	                'act' => 'GetAllPT',
	                'token' => $token,
	                'filter' => "kode_perguruan_tinggi='$value->kode_pt_asal'"
	            ];
	        $check_exist = service_request($param);
	        if (!empty($check_exist->data)) {
	                $id_pt = $check_exist->data[0]->id_perguruan_tinggi;
	        }

		    if ($id_pt!='') { 
	            $param = [
	                'act' => 'GetAllProdi',
	                'token' => $token,
	                'filter' => "kode_perguruan_tinggi='$value->kode_pt_asal' and kode_program_studi='$value->kode_prodi_asal'",
	                'order' => "",
	                'limit' => "",
	                'offset' => ""
	            ];
		        $check_exist = service_request($param);
		        if (!empty($check_exist->data)) {
		                $id_prodi = $check_exist->data[0]->id_prodi;
		        }
		    }
		}
		$filter_pd = "nama_mahasiswa='" . trim(strtoupper($value->nm_pd)) . "' and tanggal_lahir='".tgl_indo_angka($value->tgl_lahir)."' and nama_ibu_kandung='".$value->nm_ibu_kandung."'";
		$data_param = array(
			'act' => 'GetBiodataMahasiswa',
			'token' => get_token(),
			'filter' => $filter_pd
		);
		$id_pd = service_request($data_param);

		if (empty($id_pd->data)) {
        	$data_mhs = insertBiodataArray($value);
		    $data_dic = [
		        "act" => "InsertBiodataMahasiswa",
		        "token" => $token,
		        "record" => $data_mhs
		    ];
			$temp_result = service_request($data_dic);
        	if ($temp_result->error_desc=="") {
        		$id_mahasiswa = $temp_result->data->id_mahasiswa;
        	  	$data_insert_mhs_pt = insertRegPdArray($value,array('id_sp' => $id_pt,'id_sms' => $id_prodi,'id_mahasiswa' => $id_mahasiswa));
			    $data_dic = [
			        "act" => "InsertRiwayatPendidikanMahasiswa",
			        "token" => $token,
			        "record" => $data_insert_mhs_pt
			    ];
				$insert_mhs_pt = service_request($data_dic);
        		if ($insert_mhs_pt->error_desc=='') {
					++$sukses_count;
					$db->update('mhs',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
				} else {
					++$error_count;
					$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error, ".$insert_mhs_pt->error_desc),'id',$value->id);
					$error_msg[] = "<b>Error </b>".$insert_mhs_pt->error_desc;
				}
          	} else {
            	++$error_count;
				$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error, ".$temp_result->error_desc),'id',$value->id);
				$error_msg[] = "<b>Error </b>".$temp_result->error_desc;

            }

        } else {
			$filter_nim = "id_mahasiswa='".$id_pd->data[0]->id_mahasiswa."' and nim='".$value->nipd."'";
			$data_param = array(
				'act' => 'GetListRiwayatPendidikanMahasiswa',
				'token' => get_token(),
				'filter' => $filter_nim
			);
			$check_nim_exist = service_request($data_param);
			if (empty($check_nim_exist->data)) { 
	        	$id_mahasiswa = $id_pd->data[0]->id_mahasiswa;
				$data_insert_mhs_pt = insertRegPdArray($value,array('id_sp' => $id_pt,'id_sms' => $id_prodi,'id_mahasiswa' => $id_mahasiswa));
			    $data_dic = [
			        "act" => "InsertRiwayatPendidikanMahasiswa",
			        "token" => $token,
			        "record" => $data_insert_mhs_pt
			    ];
				$insert_mhs_pt = service_request($data_dic);
				//dump($data_dic);
				//dump($insert_mhs_pt);
        		if ($insert_mhs_pt->error_desc=='') {
					++$sukses_count;
					$db->update('mhs',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
				} else {
					++$error_count;
					$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error, ".$insert_mhs_pt->error_desc),'id',$value->id);
					$error_msg[] = "<b>Error </b>".$insert_mhs_pt->error_desc;
				}
			} else {
					++$error_count;
					$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error, Mahasiswa Ini Sudah Ada di Feeder"),'id',$value->id);
					$error_msg[] = "<b>Error </b>Mahasiswa Ini Sudah Ada di Feeder";
			}
		}

 	$pu->incrementStageItems(1, true);
	}
	


$msg = '';
	$msg =  "<div class=\"alert alert-warning\" role=\"alert\">
			<font color=\"#3c763d\">".$sukses_count." data Mahasiswa baru berhasil ditambah</font><br />
			<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
			if (!$error_count==0) {
				$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
			}
			//echo "<br />Total: ".$i." baris data";
			$msg .= "<div class=\"collapse\" id=\"collapseExample\">";
					$i=1;
					foreach ($error_msg as $pesan) {
							$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
						$i++;
						}
			$msg .= "</div>
		</div>";


//echo $msg;

$pu->totallyComplete($msg);


