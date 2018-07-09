<?php
	if ( ! function_exists( 'exif_imagetype' ) ) 
	{
		function exif_imagetype ( $filename ) 
		{
			if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) 
			{
				return $type;
			}
			return false;
		}
	}
	/*
		v 1.0 - first release
		v 1.1 - added function for overlaying multiple images
	*/
    class NeoImageResizer
    {
        var $CachingFolder = "";        //caching folder
        var $UseCaching    = false;     //use caching for rapid display in url
        var $Rotate        = 0;         //angle to rotate
        var $Image         = null;      //gd image
        var $File          = "";        //file loaded
        var $Type          = "";        //file loaded type
        var $Quality       = 85 ;       //image quality

        //mime types
        var $MimeTypes     = array( "JPG" => "image/jpeg", "GIF" => "image/gif", "PNG" => "image/png");
        //image types
        var $ImgTypes      = array( IMAGETYPE_JPEG => "JPG", IMAGETYPE_PNG => "PNG", IMAGETYPE_GIF => "GIF" );
        //image effects
        var $ImgEffects    = array
        (
            "negate"        => IMG_FILTER_NEGATE,
            "gray"          => IMG_FILTER_GRAYSCALE,
            "brightness"    => IMG_FILTER_BRIGHTNESS,
            "contrast"      => IMG_FILTER_CONTRAST,
            "colorize"      => IMG_FILTER_COLORIZE,
            "edge"          => IMG_FILTER_EDGEDETECT,
            "emboss"        => IMG_FILTER_EMBOSS,
            "gaussian_blur" => IMG_FILTER_GAUSSIAN_BLUR,
            "selective_blur"=> IMG_FILTER_SELECTIVE_BLUR,
            "sketchy"       => IMG_FILTER_MEAN_REMOVAL,
            "smooth"        => IMG_FILTER_SMOOTH
        );

        function NeoImageResizer( $file = "")
        {
			if( $file != "" ) $this->LoadImage($file);
        }


        //sets the cache folder
        function SetCacheFolder($path)
        {
            if(file_exists($path) )
                if( is_writable($path) )
                {
                    $this->CachingFolder = $path;
                    $this->UseCaching    = true;
                }
                else
                    die("ERROR: Caching folder not writeable!");
            else
                die("ERROR: Folder path is incorrect.");
        }

        //returns the file type - JPG, PNG or GIF for now, null for other
        function GetImageType( $file )
        {
            $ret  = null;
            $type = @exif_imagetype($file);
            //search for the type
            if( isset ($this->ImgTypes[$type]) ) $ret = $this->ImgTypes[$type];
            //returns the type
            return $ret;
        }

        //returns the image object from a file or null if it's not an image file
        function LoadImage( $file )
        {
            $type        = $this->GetImageType($file);
            $this->File  = $file;
            $this->Type  = $type;

			//create the image object
			if( $type != null )
			{
				if( $type == "JPG" ) $this->Image = imagecreatefromjpeg ($file);
				if( $type == "GIF" ) $this->Image = imagecreatefromgif  ($file);
				if( $type == "PNG" ) $this->Image = imagecreatefrompng  ($file);
				// create an empty truecolor container
				$width       = $this->getWidth();
				$height      = $this->getHeight();
				$new_image   = imagecreatetruecolor($width, $height);
				imageAntiAlias      ($new_image, true );
				imagealphablending  ($new_image, false);
				imagesavealpha      ($new_image, true );
				//
				$transparent_index = imagecolortransparent($this->Image);
				if ($transparent_index >= 0)
				{
					imagepalettecopy($this->Image, $new_image);
					imagefill($new_image, 0, 0, $transparent_index);
					imagecolortransparent($new_image, $transparent_index);
					imagetruecolortopalette($new_image, true, 256);
				}
				//
				imagecopyresampled($new_image, $this->Image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
				$this->Image = $new_image;
				
				imagealphablending  ($this->Image, false);
				imagesavealpha      ($this->Image, true );
			}
            
        }
		

        //returns the width of the image object
        function getWidth()
        {
            $ret = -1;
            if( $this->Image != null ) $ret = imagesx($this->Image);
            return $ret;
        }

        //returns the height of the image object
        function getHeight()
        {
            $ret = -1;
            if( $this->Image != null )  $ret =imagesy($this->Image);
            return $ret;
        }
		
		//$x $y   = rectangle x y
		//$cx $cy = rectangle end x y
		//$rad    = circle radius
		//$color  = inner color
		function DrawRoundedRectangle( $image, $x, $y, $cx, $cy, $rad, $color )
		{
			imagefilledrectangle($image, $x      ,$y+$rad,$cx     ,$cy-$rad,$color);
			imagefilledrectangle($image, $x +$rad,$y     ,$cx-$rad,$cy     ,$color);
			$dia = $rad * 2; //diameter
			// Now fill in the rounded corners
			imagefilledellipse($image, $x+$rad , $y + $rad, $rad*2, $dia, $color);
			imagefilledellipse($image, $x+$rad , $cy- $rad, $rad*2, $dia, $color);
			imagefilledellipse($image, $cx-$rad, $cy- $rad, $rad*2, $dia, $color);
			imagefilledellipse($image, $cx-$rad, $y + $rad, $rad*2, $dia, $color);
			return $image;
		}
		
		function DrawRoundedBorders( $radius )
		{
			$width  		= $this->getWidth();
			$height 	 	= $this->getHeight();
			$image  	 	= imagecreatetruecolor( $width, $height );
			//settings
			imageAlphaBlending($image, false);
			//background color = white
			$white       	= imagecolorallocate	  ($image, 255,255,255 );
			$transparent 	= imageColorAllocateAlpha ($image, 0, 0, 0, 127);
			$color1 		= imagecolorallocate	  ($image, 19, 58, 127 );
			$color2 		= imagecolorallocate      ($image, 93,122, 187 );
			imagefill( $image, 0,0, $white );
			$image  		= $this->DrawRoundedRectangle( $image, 0, 0  , $width     , $height     , $radius, $color1 );
			//with 10 px difference, draw another rounded rectangle with $color2
			$line_width		= min($width,$height) * 0.04;
			$image  		= $this->DrawRoundedRectangle( $image, $line_width, $line_width, $width - $line_width, $height - $line_width, $radius, $color2 );
			//with 10 px difference, draw another rounded rectangle with white
			$line_width	   += $line_width;
			$image  		= $this->DrawRoundedRectangle( $image, $line_width, $line_width, $width - $line_width, $height - $line_width, $radius, $white  );
			//remove all white pixels and make them transparent
			//
			for( $x = 0; $x < $width; $x++ )
			{
				for( $y = 0; $y < $height; $y++ )
				{
					$c = imagecolorat( $image, $x, $y );
					if( $c == $white){ imagesetpixel( $image, $x, $y, $transparent ); }
				}
			}
			
			//apply this over the real image
			imageAlphaBlending($image, true);
			imageAlphaBlending($this->Image, true);			
			imagecopy( $this->Image, $image, 0, 0, 0, 0, $width, $height );
		}
		
		function DrawLightBall()
		{
			$width  		= $this->getWidth();
			$height 	 	= $this->getHeight();
			$image  	 	= $this->Image;
			//
			
			imageAlphaBlending( $image, true );
			for( $i = 1; $i < floor($width*0.85); $i+=10 )
			{
				$whitetransparent = imageColorAllocateAlpha($image, 255, 255, 255, 126);
				$radius			  = $i;
				imagefilledellipse( $image, $width/2, $height, $radius, $radius, $whitetransparent );
			}
			imageantialias	  ( $image, true );
		}
		
		
		
		function GlossyEffect( )
		{
			//create rectangle with rounded corners
			$width    = $this->getWidth();
			$height   = $this->getHeight();
			$rc_image = imagecreatetruecolor( $width, $height );
			$radius   = min($height,$width)/6;
			//background color = white
			$white    = imagecolorallocate( $rc_image, 255,255,255 );
			imagefill( $rc_image, 0, 0, $white );
			//rounded rectangle
			$green	  = imagecolorallocate( $rc_image, 0, 255, 100 );
			$rc_image = $this->DrawRoundedRectangle( $rc_image, 0, 0, $width, $height, $radius, $green );
			//select all the white pixels
			$white_pixels = array();
			for( $x = 0; $x < $width; $x++ )
			{
				for( $y = 0; $y < $height; $y++ )
				{
					$c = imagecolorat( $rc_image, $x, $y );
					if( $c == $white) array_push( $white_pixels, array("x" => $x, "y" => $y) );
				}
			}
			//put transparnet pixels over the real image
			$rc_image    = $this->Image;
			imageSaveAlpha    ($rc_image, true );
			imageAlphaBlending($rc_image, false);
			//
			$transparent = imageColorAllocateAlpha($rc_image, 0, 0, 0, 127);
			foreach( $white_pixels as $p )
			{
				imagesetpixel( $rc_image, $p["x"], $p["y"], $transparent );
			}
			//apply the nice borders
			//blur mic

			$this->DrawRoundedBorders( $radius );
			//apply the alpha-blended white ellipse on top
			imageAlphaBlending($rc_image, true);
			$whitetransparent = imageColorAllocateAlpha($rc_image, 255, 255, 255, 100);
			imagefilledellipse( $rc_image, $width/2, 0, $width*1.5, $height*0.85, $whitetransparent );
			imageantialias	  ($rc_image, true);
			//
			$this->DrawLightBall();
			
			//
			$this->Type  = "PNG";
			$this->Image =  $rc_image;
		}
		
        //function that applies an filter/effect to the inner class image
        function ApplyFilter( $filter, $arg1 = null, $arg2 = null, $arg3 = null, $arg4  = null )
        {
            switch( $filter )
            {
                case IMG_FILTER_NEGATE:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_GRAYSCALE:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_BRIGHTNESS:
                    imagefilter($this->Image, $filter, $arg1); break;

                case IMG_FILTER_CONTRAST:
                    imagefilter($this->Image, $filter, $arg1); break;

                case IMG_FILTER_COLORIZE:
                    imagefilter($this->Image, $filter, $arg1, $arg2, $arg3, $arg4); break;

                case IMG_FILTER_EDGEDETECT:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_EMBOSS:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_GAUSSIAN_BLUR:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_SELECTIVE_BLUR:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_MEAN_REMOVAL:
                    imagefilter($this->Image, $filter); break;

                case IMG_FILTER_SMOOTH:
                    imagefilter($this->Image, $filter, $arg1); break;

                case IMG_FILTER_PIXELATE:
                    imagefilter($this->Image, $filter, $arg1, $arg2); break;
            }
            
        }
		
		//functie statica care stie sa iti intoarca fundalul va fi transparent si pozele vor 
		//poti addauga numai PNG-uri
		function OverlayAdd( $pics, $width, $height, $position )
		{
			$ret 		 = imagecreatetruecolor( $width, $height );
			//settings
			imageAntiAlias      ($ret, true );
            imagealphablending  ($ret, false);
            imagesavealpha      ($ret, true );
			$transparent_index = imagecolortransparent($ret);
			imagefill($ret, 0, 0, $transparent_index);
			imagealphablending  ($ret, true);
			//
			foreach( $pics as $p )
			{
				if( file_exists( $p ) )
				{
					$pic        = imagecreatefrompng($p);
					//
					$pic_width  = imagesx( $pic );
					$pic_height = imagesy( $pic );
					
					//
					//calculate position
					$dest_x = 0;
					$dest_y = 0;
					switch( strtoupper($position) )
					{
						case "TOP":
							$dest_x = ( $width  / 2 ) - ( $pic_width / 2 );
							$dest_y = 0;
							break;
						case "TOPLEFT":
							$dest_x = 0;
							$dest_y = 0;
							break;
						case "TOPRIGHT":
							$dest_x = $width - $pic_width;
							$dest_y = 0;
							break;
						case "TOPCENTER":
							$dest_x = ($width - $pic_width)/2;
							$dest_y = 0;
							break;
						case "RIGHT":
							$dest_x = $width - $pic_width ;
							$dest_y = ( $height / 2 )  -( $pic_height/ 2 );
							break;
						case "BOTTOMRIGHT":
							$dest_x = $width  - $pic_width ;
							$dest_y = $height - $pic_height;
							break;
						case "BOTTOM":
							$dest_x = ( $width  / 2 ) - ( $pic_width / 2 );
							$dest_y = $height - $pic_height;
							break;
						case "BOTTOMLEFT":
							$dest_x = 0;
							$dest_y = $height - $pic_height;
							break;
						case "LEFT":
							$dest_x = 0;
							$dest_y = ( $height / 2 ) - ( $pic_height/ 2 );
							break;
						case "CENTER":
							$dest_x = ( $width  / 2 ) - ( $pic_width / 2 );
							$dest_y = ( $height / 2 ) - ( $pic_height/ 2 );
							break;
					}
					//
					imagesavealpha      ($pic, true );
					imagecopy( $ret, $pic, $dest_x, $dest_y, 0, 0, $pic_width, $pic_height);
					//
				}
			}
			return $ret;
		}
		
		//functie statica care stie sa overlay-uiasca mai multe imagini si sa le salveze undeva
		//SALVEAZA NUMAI CA PNG
		function OverlayAddAndSave( $arr_pics, $width, $height, $position, $quality, $output )
		{
			$pngQuality = ($quality - 100) / 11.111111;
            $pngQuality = round(abs($pngQuality));
			$image      = $this->OverlayAdd( $arr_pics, $width, $height, $position );
			imagepng  ( $image, $output, $pngQuality );
		}

        //rotate the image with angle $angle
        function Rotate ($angle)
        {
                $this->Resize( $this->getWidth(), $this->getHeight() );
                $transparent = imagecolortransparent($this->Image);
                $this->Image = imagerotate($this->Image, $angle, $transparent, false);
                //keep transparency
                imageAntiAlias      ($this->Image, true );
                imagealphablending  ($this->Image, false);
                imagesavealpha      ($this->Image, true );
           
        }

        //resize the inner image object
        function Resize( $width, $height)
        {
            $new_image   = imagecreatetruecolor($width, $height);
            //keep transparency
            imageAntiAlias      ($new_image, true );
            imagealphablending  ($new_image, false);
            imagesavealpha      ($new_image, true );
            //resize
            imagecopyresampled($new_image, $this->Image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
            $this->Image = $new_image;
        }

		//crop position -> start, center, end
        function CropResize( $width, $height, $position = "center" )
        {
			$position    = strtolower( $position );
            $img_width   = $this->getWidth();
            $img_height  = $this->getHeight();
            //
            if( $img_width  < $width  ) $width  = $img_width;
            if( $img_height < $height ) $height = $img_height;
            //
            $new_image   = imagecreatetruecolor($width, $height);
			//
			$crop_x		 = 0;
			$crop_y		 = 0;
			if( ($img_width / $width ) < ( $img_height / $height ) )
			{
				//scad din width 
				$this->RatioResizeToWidth ( $width  );
				if( $position == "center" ) $crop_y = ( $this->getHeight() / 2 ) - ( $height / 2 );
				if( $position == "end"    ) $crop_y = $this->getHeight() - $height;
			}
			else
			{
				$this->RatioResizeToHeight( $height );
				if( $position == "center" ) $crop_x = ( $this->getWidth() / 2 ) - ( $width / 2 );
				if( $position == "end"    ) $crop_x = $this->getWidth() - $width;
			}
            //keep transparency
            imageAntiAlias      ($new_image, true );
            imagealphablending  ($new_image, false);
            imagesavealpha      ($new_image, true );
            //crop
            imagecopyresampled($new_image, $this->Image, 0, 0, $crop_x, $crop_y, $width, $height, $width, $height);
            $this->Image = $new_image;
        }

        //returns the new image object, with resize applied
        function RatioResizeToWidth( $width )
        {
            $cur_width  = $this->getWidth();
            if( $cur_width > $width )
            {
                $ratio 		= $width / $cur_width;
                $height     = $this->getHeight() * $ratio;
                //resize
                $this->Resize($width,$height);
            }
        }

        //returns the new image object, with resize applied
        function RatioResizeToHeight( $height )
        {
            $cur_height = $this->getHeight();
            if( $cur_height > $height )
            {
                $ratio 		= $height / $cur_height;
                $width      = $this->getWidth() * $ratio;
                //resize
                $this->Resize($width,$height);
            }
        }

        //scale image
        function Scale($scale)
        {
            $width  = $this->getWidth()  * $scale/100;
            $height = $this->getheight() * $scale/100;
            $this->Resize($width,$height);
        }

        //resize specifying the maximum width height
        function RatioResize( $max_width, $max_height )
        {
            if( $max_width > $max_height )
            {
                $this->RatioResizeToWidth ( $max_width  );
                $this->RatioResizeToHeight( $max_height );
            }
            else
            {
                $this->RatioResizeToHeight( $max_height );
                $this->RatioResizeToWidth ( $max_width  );
            }
        }

        

        //set the image quality
        function SetQuality( $quality )
        {
            $this->Quality = $quality;
        }

        function GetQualityForPng()
        {
            $pngQuality = ($this->Quality - 100) / 11.111111;
            return round(abs($pngQuality));
        }

        //add a png file as a watermark over the image
        //wm_position = TopLeft, Top, TopRight, Right, BottomRight, Bottom, BottomLeft, Left, Center
        function AddPngWatermark( $watermark_file, $wm_position = "center" )
        {
            if( $this->GetImageType($watermark_file) == "PNG")
            {
                $img_width          = $this->getWidth();
                $img_height         = $this->getHeight();
                $this->Resize($img_width, $img_height);
                //
                $watermark          = imagecreatefrompng($watermark_file);
                imagealphablending  ($this->Image, true);
                //
                $watermark_width    = imagesx($watermark);
                $watermark_height   = imagesy($watermark);
                //TODO: calculate position
                $dest_x = 0;
                $dest_y = 0;
                switch( strtoupper($wm_position) )
                {
                    case "TOP":
                        $dest_x = ( $img_width  / 2 ) - ( $watermark_width / 2 );
                        $dest_y = 0;
                        break;
                    case "TOPRIGHT":
                        $dest_x = $img_width - $watermark_width ;
                        $dest_y = 0;
                        break;
                    case "RIGHT":
                        $dest_x = $img_width - $watermark_width ;
                        $dest_y = ( $img_height / 2 )  -( $watermark_height/ 2 );
                        break;
                    case "BOTTOMRIGHT":
                        $dest_x = $img_width  - $watermark_width ;
                        $dest_y = $img_height - $watermark_height;
                        break;
                    case "BOTTOM":
                        $dest_x = ( $img_width  / 2 ) - ( $watermark_width / 2 );
                        $dest_y = $img_height - $watermark_height;
                        break;
                    case "BOTTOMLEFT":
                        $dest_x = 0;
                        $dest_y = $img_height - $watermark_height;
                        break;
                    case "LEFT":
                        $dest_x = 0;
                        $dest_y = ( $img_height / 2 )  -( $watermark_height/ 2 );
                        break;
                    case "CENTER":
                        $dest_x = ( $img_width  / 2 ) - ( $watermark_width / 2 );
                        $dest_y = ( $img_height / 2 )  -( $watermark_height/ 2 );
                        break;
                }
                //
                imagecopy( $this->Image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
            }
        }

    

        //save as a new file
        function Save( $file_name )
        {
            if( $this->Type == "JPG" )
                imagejpeg ( $this->Image, $file_name, $this->Quality );
            else if( $this->Type == "PNG" || $this->Type == "GIF" )
                imagepng  ( $this->Image, $file_name, $this->GetQualityForPng() );
        }

        //uses GD to show image directly
        function Show()
        {
            //verify CACHING
            $mime           = $this->MimeTypes[ $this->Type ];
            $last_modified  = date('D, d M Y H:i:s');
            $file_name      = basename($this->File);
            //header info
            header('Content-type: $mime');
            
            if( $this->UseCaching )
            {
                //verify if file is cached
                $cache_filename = urlencode($this->File);
                $full_path_file = $this->CachingFolder.$cache_filename;
                //
                if(file_exists( $full_path_file ) )
                {  
                    readfile($full_path_file);
                }
                else
                {
                    //cache file
                    $this->Save($full_path_file);
                    //show file now
                   
                        if( $this->Type == "JPG" )
                            imagejpeg ( $this->Image, null, $this->Quality );
                        else
                            imagepng  ( $this->Image, null, $this->GetQualityForPng() );
                    
                }
            }
            else
            {
                if( $this->Type != null )
                {
                    
                        if( $this->Type == "JPG" )
                            imagejpeg ( $this->Image, null, $this->Quality );
                        else
                            imagepng  ( $this->Image, null, $this->GetQualityForPng() );
                   
                }
                else
                {
                    die ("ERROR: On loading image! Please use a valid JPEG, PNG or GIF file.");
                }
            }
        }

        function ParseUrl()
        {
            //commands:
            //load                  => f   = file.jpg
            //resize                => r   = 200x300
            //cropresize            => cr  = 200x300
            //ratioresize           => rs  = 200x200
            //addpngwatermark       => w   = file.png|position
            //setquality            => q   = 24
            //ratioresizetowidth    => rsw = 200
            //ratioresizetoheight   => rsh = 200
            //scale                 => s   = 150
            //rotate                => rt  = 45
            //cachingfolder         => cf  = images/cache/
            //filter                => filter = name & arg1= & arg2= etc
            //print_r($_GET);
            foreach( $_GET as $key => $val )
            {
                if( $key == "f" ) $this->LoadImage ( $val );
                if( $key == "r" )
                {
                    $parts = explode("x", $val);
                    if( count($parts) == 2 )
                        $this->Resize($parts[0], $parts[1]);
                    else
                        die("ERROR: Wrong use of resize function.");
                }
                if( $key == "cr" )
                {
                    $parts = explode("x", $val);
                    if( count($parts) >= 2 )
					{
						$position = "center";
						if( count( $parts ) == 3 ) $position = $parts[2];
                        $this->CropResize($parts[0], $parts[1], $position);
					}
                    else
                        die("ERROR: Wrong use of crop resize function.");
                }
                if( $key == "rs" )
                {
                    $parts = explode("x", $val);
                    if( count($parts) == 2 )
                        $this->RatioResize ($parts[0], $parts[1]);
                    else
                        die("ERROR: Wrong use of ratio-resize function.");
                }
                if( $key == "w"     )
                {
                    $parts = explode("|",$val);
                    if( count($parts) > 1)
                        $this->AddPngWatermark    ( $parts[0], $parts[1] );
                    else
                        $this->AddPngWatermark    ( $val );
                }
                if( $key == "q"     ) $this->SetQuality         ( $val );
                if( $key == "rsw"   ) $this->RatioResizeToWidth ( $val );
                if( $key == "rsh"   ) $this->RatioResizeToHeight( $val );
				if( $key == "glossy") $this->GlossyEffect		();
                if( $key == "s"     ) $this->Scale              ( $val );
                if( $key == "rt"    ) $this->Rotate             ( $val );
                if( $key == "cf"    ) $this->SetCacheFolder     ( $val );
                if( $key == "filter" )
                {
                    ( empty($_GET["arg1"]) )? ( $arg1=null) : ( $arg1=$_GET["arg1"] );
                    ( empty($_GET["arg2"]) )? ( $arg2=null) : ( $arg2=$_GET["arg2"] );
                    ( empty($_GET["arg3"]) )? ( $arg3=null) : ( $arg3=$_GET["arg3"] );
                    ( empty($_GET["arg4"]) )? ( $arg4=null) : ( $arg4=$_GET["arg4"] );
                    $this->ApplyFilter( $this->ImgEffects[$val], $arg1, $arg2, $arg3, $arg4);
                }
            }
            $this->Show();
        }

    }


    //use this class in realtime mode:
    if( !empty($_GET["f"]))
    {
        $nir = new NeoImageResizer();
        $nir->ParseUrl();
    }
	if( !empty( $_GET["test"] ) )
	{
		//test zone:
		$nir = new NeoImageResizer();
		$nir->OverlayAddAndSave
		( 
			array  //imaginile ce trebuie suprapuse
			(
				"../images/test/test1.png",
				"../images/test/test2.png",
				"../images/test/test3.png"
			),
			640,480,   	//dimensiunea imaginii finale
			"CENTER",  	//pozitionarea
			85, 		//quality
			"../images/branduri/mici/test.png" //output
		);
	}
?>
