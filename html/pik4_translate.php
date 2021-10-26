<?php
setlocale(LC_ALL, 'ja_JP.UTF-8');

if(($handle = fopen("pik4_translate_data20201024.csv", "r")) !== false){
        while(($data = fgetcsv($handle))){
                $search = array("\"","\n","\\");
                $replace = array("”","","￥");
                $data[1] = str_replace($search, $replace, $data[1]);
                $data[2] = str_replace($search, $replace, $data[2]);
                echo "\"{$data[0]}\":{<br>\n
                        \"ja\": \"{$data[1]}\",<br>\n
                        \"en\": \"{$data[2]}\"<br>\n
                        },<br>\n
                ";
        }
        fclose($handle);
} else {
        echo "File Open Error";
}