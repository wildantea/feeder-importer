<?php
//$myfile = fopen($_GET['prodi']."_progress.json", "w");
$myfile = fopen($_GET['jurusan'].'_progress.json', "w");
fwrite($myfile, '{"message":null,"totalStages":16,"remaining":15,"error":false,"complete":false,"stage":{"name":"Page $i","message":"Some Message","stageNum":1,"totalItems":501,"completeItems":65,"pcComplete":0.12974051896208,"rate":28.28588408328,"startTime":1453022701.1987,"curTime":1453022703.4967,"timeRemaining":15.414048884465,"exceptions":[],"warnings":[]}}');
fclose($myfile);
?>