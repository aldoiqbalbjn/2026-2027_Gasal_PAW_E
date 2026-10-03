<?php
$matkul = ["PTI", "Alpro", "DPW", "Strukdat", "Jarkom", "PAW", "PSBF", "RPL"];
$praktikum = ["Jarkom", "PAW"];
for ($i=0; $i < count($matkul); $i++){
    if($matkul[$i] == $praktikum[0] || $matkul[$i] == $praktikum[1]){
        echo "Saya sedang mengambil matkul ".$matkul[$i]." termasuk praktikumnya";
    }elseif($i == 6 || $i == 7){
        echo "Saya belum mengambil matkul ".$matkul[$i];
    }else{
        echo "Saya sudah mengambil matkul ".$matkul[$i]." Semester lalu";
    }
    echo "<br>";
}
?>