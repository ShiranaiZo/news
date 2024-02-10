<?php

function cut_sentences($text, $maxRow = 2) {
    // Membagi kalimat menjadi baris-baris
    $baris = explode("</p>", $text);

    $potongan = array_slice($baris, 0, $maxRow - 1);
    $hasil = implode("\n", $potongan);

    return $hasil;
}
