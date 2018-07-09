<?php
	class FileUploader
	{
		var $InputName;
		var $FileName, $FileType, $FileSize, $TmpName, $Error ,$BaseFileName;
		
		function FileUploader( $InputName )
		{
			$this->InputName     = $InputName;
			$file                = $_FILES[ $InputName ];
			$this->FileName      = $file[ "name"    ];
			$bfn                 = explode('.',$file[ "name"    ]);
			$this->BaseFileName  = $bfn[0];
			$this->FileType      = $file[ "type"    ];
			$this->FileSize      = $file[ "size"    ];
			$this->TmpName       = $file[ "tmp_name"];
			$this->Error         = $file[ "error"   ];
		}
		
		function IsJpeg()
		{
			$ret = false;
			if ( ( list($width, $height, $type, $attr) = getimagesize( $this->TmpName ) ) !== false ) 
			{
				if( $type == 2 ) $ret = true;
			}
			return $ret;
		}
		
		//primeste ca argument directorul unde vreau sa il uploadez
		function Upload( $upload_dir )
		{
			return $this->UploadWithName( $upload_dir, $this->FileName );
		}
		
		//upload multiplu
		// $files -> fisierele ca array, director, fisier, max_dimension
		// recomand ca primul fisier sa fie mereu al mai mare
		function MultipleResizeUpload( $files )
		{
			for( $i = 0; $i < count( $files ); $i++ )
			{
				$line = $files[$i];
				$dir  = $line[0];
				if( !Util::EndsWith("/", $dir ) ) $dir .= "/";
				$file = $line[1];
				$max  = $line[2];
				if( $i == 0 )
				{
					$this->UploadWithName( $dir, $file );
				}
				else
				{
					$first_file = $files[0];
					$first_dir  = $first_file[0];
					$first_file = $first_file[1];
					if( !Util::EndsWith("/", $first_dir ) ) $first_dir .= "/";
					copy( $first_dir.$first_file, $dir.$file );
				}
				$src  = $dir.$file;
				$size = $this->GetImgPreferedSize( $src, $max );

				if(!$this->ResizeImage($src, $src, $size["width"], $size["height"] ) )
				{
					echo "<br>probleme la resize! Incercati cu o alta imagine.<br>";
				}
			}
		}
		
		//primeste ca argument directorul unde vreau sa il uploadez
		function UploadWithName( $upload_dir, $new_name )
		{
			$ret = true;
			if( !Util::EndsWith( $upload_dir, "/" ) )
				$upload_dir .= "/";
			$uploadfile = $upload_dir.$new_name;
			//echo "upload file:".$uploadfile."<hr>";
			if ( !move_uploaded_file( $this->TmpName, $uploadfile) ) 
			{
				$ret = false;
			}
			
			return $ret;
		}	
		
		
		function GetImgPreferedSize( $img, $max_value )
		{
			$size   = getimagesize( $img );
			$width  = $size[0];
			$height = $size[1];		
			// this means you want to shrink an image that is already shrunken!
			if ($height <= $max_value && $width <= $max_value)
			{
				return array( "width" => $width, "height" => $height);
			}
		
			// check to see if we can shrink it width first
			$Multiplier = $max_value / $width;
			if (($height * $Multiplier) <= $max_value )
			{
				$height = $height * $Multiplier;
				return array( "width" => $max_value, "height" => round($height));
			}
		
			// if we can't get our max width, then use the max height
			$Multiplier = $max_value / $height;
			$width      = $width * $Multiplier;

			return array( "width" => round($width), "height" => $max_value);		
		}
		
		
		//atentie doar pt jpg
		function ResizeImage( $img_src, $img_dest, $width, $height )
		{
		
			shell_exec('convert '.$img_src.' -resize '.$width.'x'.$height.'  '.$img_dest);
			return true;
			/*break;
			$forcedheight= $height;
			$forcedwidth = $width;
			$sourcefile  = $img_src;
			$destfile    = $img_dest;
			$imgcomp     = 0;
			
			$g_imgcomp   = 85 - $imgcomp;
			$g_srcfile   = $sourcefile;
			$g_dstfile   = $destfile;
			$g_fw        = $forcedwidth;
			$g_fh        = $forcedheight;
		
			//echo $g_srcfile;		
			if( file_exists( $g_srcfile ) )
			{

				$g_is     = getimagesize($g_srcfile);
				if(($g_is[0]-$g_fw)>=($g_is[1]-$g_fh))
				{
					$g_iw = $g_fw;
					$g_ih = ($g_fw/$g_is[0])*$g_is[1];
				}
				else
				{
					$g_ih = $g_fh;
					$g_iw = ($g_ih/$g_is[1])*$g_is[0];   
				}
				$img_src  = imagecreatefromjpeg($g_srcfile);
				$img_dst  = imagecreatetruecolor($g_iw,$g_ih);
				imagecopyresampled(
					$img_dst, $img_src, 0, 0, 0, 0, 
					$g_iw, $g_ih, $g_is[0], $g_is[1]);
					
				imagejpeg($img_dst, $g_dstfile, $g_imgcomp);
				imagedestroy($img_dst);
				return true;
			}
			else
				return false;*/
		}
		
	}
?>