<?php
$matkul = ["PTI", "Alpro", "DPW", "Strukdat", "Jarkom", "PAW", "PSBF", "RPL"];
foreach ($matkul as $suka){
    switch($suka){
        case 'PTI':
            echo 'Saya Suka PTI';
            break;
        case 'Alpro':
            echo 'Saya Suka Alpro';
            break;
        case 'DPW':
            echo 'Saya Suka DPW';
            break;
        case 'Strukdat':
            echo 'Saya Suka Strukdat';
            break;
        case 'Jarkom':
            echo 'Saya Suka Jarkom';
            break;
        case 'PAW':
            echo 'Saya Suka PAW';
            break;
        default:
            echo 'Saya tidak Mengambil Matkul '.$suka;
            break;
    }
    echo "<br>";
}