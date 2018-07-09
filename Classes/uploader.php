<?php
class Uploader{

	function Upload( $file, $target )
	{
		if( move_uploaded_file( $file['tmp_name'], $target ) )
			return true;
		else
			return false;
	}
	
	function UploadDoorVariation( $file, $todelete = false )
	{
		$finfo  = pathinfo($file['name']);
		$tf     = $finfo['extension'];
		$nume   = date('YmdHis').'_'.$extra.'.'.$tf;
		$target = PROGRAM_PATH.'uploads/door_variation/'.$nume;
		if( Uploader::Upload( $file, $target) )
		{
			return $nume;
		}
		else return false;
	}
	
	function UploadSwf2D( $file, $todelete = false )
	{
		$finfo  = pathinfo($file['name']);
		$tf     = $finfo['extension'];
		$nume   = date('YmdHis').'_swf2d.'.$tf;
		$target = PROGRAM_PATH.'uploads/swf_2d/'.$nume;
		if( Uploader::Upload( $file, $target) )
		{
			return $nume;
		}
		else return false;
	}
	
	function UploadUnitIcon( $file, $todelete = false )
	{
		$finfo  = pathinfo($file['name']);
		$tf     = $finfo['extension'];
		$nume   = 'icon_'.date('YmdHis').'.'.$tf;
		$target = PROGRAM_PATH.'uploads/units/'.$nume;
		if( Uploader::Upload( $file, $target) )
		{
			return $nume;
		}
		else return false;
	}
	
	function UploadWindowVariation( $file, $todelete = false )
	{
		$finfo  = pathinfo($file['name']);
		$tf     = $finfo['extension'];
		$nume   = date('YmdHis').'_'.$extra.'.'.$tf;
		$target = PROGRAM_PATH.'uploads/window_variation/'.$nume;
		if( Uploader::Upload( $file, $target) )
		{
			return $nume;
		}
		else return false;
	}
}
?>