<?php
include "../../inc/config.php";
include "../../lib/prosesupdate/ProgressUpdater.php";
	$sukses_count = 0;
	$sukses_msg = '';
	$error_count = 0;
	$error = array();
    $data_dic = array(
      'act' => 'GetCountProdi',
      'token' => get_token(),
      'filter' => ""
    );
    $results = service_request($data_dic);

	$total_prodi = $results->data;

	//dump($total_prodi);


	$jumlah = $total_prodi;

		$options = array(
		    'filename' => 'progress.json',
		    'autoCalc' => true,
		    'totalStages' => 1
		);
		$new_pu = new Manticorp\ProgressUpdater($options);


			//let's push first page
			$stageOptions = array(
			    'name' => 'Page $i',
			    'message' => 'Some Message',
			    'totalItems' => $jumlah,
			);

			$new_pu->nextStage($stageOptions);

            $data_param = [
                  'act' => 'GetProdi',
                    'token' => get_token(),
                    'filter' => "",
                    'order' => 'id_prodi desc',
                   // 'limit' => 7,
                    //'offset' => $offset

                ];

            $datas = service_request($data_param);
			$db->query("truncate jurusan");
			
			foreach ($datas->data as $key) {
					$sukses_count++;
                   	$datas = array(
                        "id_sms" => $key->id_prodi,
						"nama_jurusan" => $key->nama_program_studi,
						"kode_jurusan" => $key->kode_program_studi,
						"status" => $key->status,
						"id_jenj_didik" => $key->id_jenjang_pendidikan,
                        "jenjang" => $key->nama_jenjang_pendidikan
                    );  
					$in = $db->insert('jurusan',$datas);
					$new_pu->incrementStageItems(1, true);

		}

		$msg = '';
		if ((!$sukses_count==0) || (!$error_count==0)) {
			$msg =  "<div class=\"alert alert-warning \" role=\"alert\">
					<font color=\"#3c763d\">".$sukses_count." data Jurusan/Prodi berhasil ditambah</font><br />
					<font color=\"#ce4844\" >".$error_count." data tidak bisa ditambahkan </font>";
					
					if (!$error_count==0) {
						$msg .= "<a data-toggle=\"collapse\" href=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Detail error</a>";
					}
					//echo "<br />Total: ".$i." baris data";
					$msg .= "<div class=\"collapse\" id=\"collapseExample\">";
							$i=1;
							foreach ($error as $pesan) {
									$msg .= "<div class=\"bs-callout bs-callout-danger\">".$i.". ".$pesan."</div><br />";
								$i++;
								}
					$msg .= "</div>
				</div>";
		}

		$new_pu->totallyComplete($msg);



