<?php
    include("../includes.php");
    //
    $files         = $_FILES;
    $u             = new FileUploader( "Filedata" );

    $u             = new FileUploader( "Filedata" );
    //numele fara extensie
    $file_name     = substr( $u->FileName, 0, strlen( $u->FileName ) - 4 );
    //extensia
    $extension     = substr( $u->FileName,    strlen( $u->FileName ) - 3 );
    //construieste noul fisier adaugand data curenta
    $new_file_name = $file_name.date("d_m_Y_H_i_s").".".$extension;
    //
    $u->MultipleResizeUpload(
		array
		(
			array
			(
				"../../../uploads/door_variation/",
				$new_file_name,
				140
			)
		)
	);
    chmod("../../../uploads/door_variation/".$new_file_name, 0777);
    //aplica watermark
    echo $new_file_name;
?>