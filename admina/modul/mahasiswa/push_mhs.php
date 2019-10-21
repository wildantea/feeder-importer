<?php
//include "inc/config.php";
include "../../lib/nusoap/nusoap.php";

include "../../inc/config.php";

include "../../lib/prosesupdate/ProgressUpdater.php";

$url = $db->get_service_url('soap');
$token = $db->get_token();
$client = new nusoap_client($url, true);
$proxy = $client->getProxy();
$config = $db->fetch_single_row('config_user','id',1);
//$token = 'acdbbc82c3b29f99e9096dab1d5eafb4';


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



	foreach ($arr_data as $value) {

		$id_sms = $value->id_sms;
		$id_pds = "p.nm_pd='".$value->nm_pd."' and p.tgl_lahir='".$value->tgl_lahir."' and p.nm_ibu_kandung='".$value->nm_ibu_kandung."'";
		$id_pd = $proxy->GetRecord($token,'mahasiswa',$id_pds);
		if (empty($id_pd['result'])) {
			$data_mhs = $db->convert_obj_to_array($value);
        	unset($data_mhs['id']);
        	unset($data_mhs['nipd']);
        	unset($data_mhs['id_jalur_masuk']);
	
			$data_mhs = array_filter($data_mhs, 'myFilter');
	   	$temp_result = $proxy->InsertRecord($token, 'mahasiswa', json_encode($data_mhs));

        	if ($temp_result['result']['error_desc']=="") {
        	  	$id_pd = $temp_result['result']['id_pd'];
			$data_insert_mhs_pt = array(
				  'id_sms' => $id_sms,
                  'id_pd' => $id_pd,
                  'id_sp' => $config->id_sp,
                  'id_jns_daftar' => $value->id_jns_daftar,
                  'nipd' => $value->nipd,
                  'tgl_masuk_sp' => $value->tgl_masuk_sp,
                  'a_pernah_paud' => '1',
                  'a_pernah_tk' => '1',
                  'mulai_smt' => $value->mulai_smt,
                  'id_pembiayaan' => $value->id_pembiayaan,
                  'biaya_masuk_kuliah' => $value->biaya_masuk_kuliah,
                  'id_jalur_masuk' => $value->id_jalur_masuk
                );

         		$insert_mhs_pt =  $proxy->InsertRecord($token, 'mahasiswa_pt', json_encode($data_insert_mhs_pt));

        		if ($insert_mhs_pt['result']['error_desc']==NULL) {
							++$sukses_count;
							$db->update('mhs',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
						} 
						else {
								$hapus = array(     
								'id_pd'=>$id_pd
								);
								$temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
								++$error_count;
								$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error".$insert_mhs_pt['result']['error_desc']),'id',$value->id);
								$error_msg[] = "<b>Error </b>".$insert_mhs_pt['result']['error_desc'];
						}

          } 

          	else {
            	++$error_count;
							$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error".$temp_result['result']['error_desc']),'id',$value->id);
							$error_msg[] = "<b>Error </b>".$temp_result['result']['error_desc'];

            }





        } 
        else {

							$check_nim_exists = "p.id_sp='".$config->id_sp."' and p.id_pd='".$id_pd['result']['id_pd']."'";
							$check_nim_exist = $proxy->GetRecord($token,'mahasiswa_pt',$check_nim_exists);
							if (empty($check_nim_exist['result'])) { 
									$hapus = array(     
										'id_pd'=>$id_pd['result']['id_pd']
									);

									//print_r($hapus);
									$hapus=$proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));

									//print_r($hapus);

								$data_mhs = $db->convert_obj_to_array($value);
					        	unset($data_mhs['id']);
					        	unset($data_mhs['nipd']);
						
								$data_mhs = array_filter($data_mhs, 'myFilter');
						       	$temp_result = $proxy->InsertRecord($token, 'mahasiswa', json_encode($data_mhs));

					        	if ($temp_result['result']['error_desc']=="") {
					        	  	$id_pd = $temp_result['result']['id_pd'];
								$data_insert_mhs_pt = array(
									  'id_sms' => $id_sms,
					                  'id_pd' => $id_pd,
					                  'id_sp' => $config->id_sp,
					                  'id_jns_daftar' => $value->id_jns_daftar,
					                  'nipd' => $value->nipd,
					                  'tgl_masuk_sp' => $value->tgl_masuk_sp,
					                  'a_pernah_paud' => '1',
					                  'a_pernah_tk' => '1',
					                   'id_pembiayaan' => $value->id_pembiayaan,
					                   'biaya_masuk_kuliah' => $value->biaya_masuk_kuliah,
					                  'mulai_smt' => $value->mulai_smt,
					                   'id_jalur_masuk' => $value->id_jalur_masuk
					                );

					         		$insert_mhs_pt =  $proxy->InsertRecord($token, 'mahasiswa_pt', json_encode($data_insert_mhs_pt));

					        		if ($insert_mhs_pt['result']['error_desc']==NULL) {
												++$sukses_count;
												$db->update('mhs',array('status_error'=>1,'keterangan'=>''),'id',$value->id);
											} 
											else {
													$hapus = array(     
													'id_pd'=>$id_pd
													);
													$temp_result = $proxy->DeleteRecord($token, 'mahasiswa', json_encode($hapus));
													++$error_count;
													$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error".$insert_mhs_pt['result']['error_desc']),'id',$value->id);
													$error_msg[] = "<b>Error </b>".$insert_mhs_pt['result']['error_desc'];
											}

					          } 

					          	else {
					            	++$error_count;
												$db->update('mhs',array('status_error' => 2, 'keterangan'=>"Error".$temp_result['result']['error_desc']),'id',$value->id);
												$error_msg[] = "<b>Error </b>".$temp_result['result']['error_desc'];

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


