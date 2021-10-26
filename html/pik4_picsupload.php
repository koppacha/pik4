<?php
require_once('_def.php');

date_default_timezone_set('Asia/Tokyo');

$file_tmp  = $_FILES["upFile"]["tmp_name"];

// 正式保存先ファイルパス
$new_file_name = date("Ymd-His").'-'.mt_rand().'.jpg';
if($_SERVER['SERVER_NAME'] != 'localhost'){
        $myfile_new_path = PICS_FOLDER;
} else {
        $myfile_new_path = LOCAL_FOLDER;
}

$file_save = $myfile_new_path . $new_file_name;

// ファイル移動
$result = @move_uploaded_file($file_tmp, $file_save);
if ( $result === true ) {
    echo $new_file_name;
} else {
    echo "UPLOAD NG";
}
