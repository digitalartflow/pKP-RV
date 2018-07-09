<?php
    include '../includes.php';

    $uh = new DbUnitHandle();
    $uh["IdUnit"   ] = $_POST["id_unit"];
    $uh["PriceDiff"] = $_POST["price_diff"];
    $uh["IdHandle"] = $_POST["handleid"];
    $uh["Image0"   ] = $_POST["img0"];
    $uh["Image90"  ] = $_POST["img1"];
    $uh["Image180" ] = $_POST["img2"];
    $uh["Image270" ] = $_POST["img3"];
    echo $uh->getNextId();
    $uh->CreateNew();
?>
