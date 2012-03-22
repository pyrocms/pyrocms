<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Image_Moo library
 *
 * Written due to image_lib not being so nice when you have to do multiple things to a single image!
 *
 * @license		MIT License
 * @author		Matthew Augier, aka Mat-Moo
 * @link		http://www.dps.uk.com
 * @docu		http://todo :)
 * @email		matthew@dps.uk.com
 *
 * @file		image_moo.php
 * @version		1.0.1
 * @date		2010 Dec 13
 *
 * Copyright (c) 2010 Matthew Augier
 *
 * Requires PHP 5 and GD2!
 *
 * Example usage
 *    $this->image_moo->load("file")->resize(64,40)->save("thumb")->resize(640,480)->save("medium");
 *    if ($this->image_moo->errors) print $this->image_moo->display_errors();
 *
 * COLOURS!
 * Any function that can take a colour as a parameter can take "#RGB", "#RRGGBB" or an array(R,G,B)
 *
 * image manipulation functions
 * -----------------------------------------------------------------------------
 * load($x) - Loads an image file specified by $x - JPG, PNG, GIF supported
 * save($x) - Saved the manipulated image (if applicable) to file $x - JPG, PNG, GIF supported
 * save_pa($prepend="", $append="", $overwrite=FALSE) - Saves using the original image name but with prepend and append text, e.g. load('moo.jpg')->save_pa('pre_','_app') would save as filename pre_moo_app.jpg
 * save_dynamic($filename="") - Saves as a stream output, use filename to return png/jpg/gif etc., default is jpeg
 * resize($x,$y,$pad=FALSE) - Proportioanlly resize original image using the bounds $x and $y, if padding is set return image is as defined centralised using BG colour
 * resize_crop($x,$y) - Proportioanlly resize original image using the bounds $x and $y but cropped to fill dimensions
 * stretch($x,$y) - Take the original image and stretch it to fill new dimensions $x $y
 * crop($x1,$y1,$x2,$y2) - Crop the original image using Top left, $x1,$y1 to bottom right $x2,y2. New image size =$x2-x1 x $y2-y1
 * rotate($angle) - Rotates the work image by X degrees, normally 90,180,270 can be any angle.Excess filled with background colour
 * load_watermark($filename, $transparent_x=0, $transparent_y=0) - Loads the specified file as the watermark file, if using PNG32/24 use x,y to specify direct positions of colour to use as index
 * make_watermark_text($text, $fontfile, $size=16, $colour="#ffffff", $angle=0) - Creates a text watermark
 * watermark($position, $offset=8, $abs=FALSE) - Use the loaded watermark, or created text to place a watermark. $position works like NUM PAD key layout, e.g. 7=Top left, 3=Bottom right $offset is the padding/indentation, if $abs is true then use $positiona and $offset as direct values to watermark placement
 * border($width,$colour="#000") - Draw a border around the output image X pixels wide in colour specified
 * border_3d($width,$rot=0,$opacity=30) - Draw a 3d border (opaque) around the current image $width wise in 0-3 rot positions, $opacity allows you to change how much it effects the picture
 * filter($function, $arg1=NULL, $arg2=NULL, $arg3=NULL, $arg4=NULL) -Runs the standard imagefilter GD2 command, see http://www.php.net/manual/en/function.imagefilter.php for details
 * round($radius,$invert=FALSE,$corners(array[top left, top right, bottom right, bottom left of true or False)="") default is all on and normal rounding
 * shadow($size=4, $direction=3, $colour="#444") - Size in pixels, note that the image will increase by this size, so resize(400,400)->shadoe(4) will give an image 404 pixels in size, Direction works on teh keypad basis like the watermark, so 3 is bottom right, $color if the colour of the shadow.
 * -----------------------------------------------------------------------------
 * image helper functions
 * display_errors($open = '<p>', $close = '</p>') - Display errors as Ci standard style
 * set_jpeg_quality($x) - quality to wrte jpeg files in for save, default 75 (1-100)
 * set_watermark_transparency($x) - the opacity of the watermark 1-100, 1-just about see, 100=solid
 * check_gd() - Run to see if you server can use this library
 * clear_temp() - Call to clear the temp changes using the master image again
 * clear() - Clears all images in memory
 * -----------------------------------------------------------------------------
 *
 * KNOWN BUGS
 * make_watermark_text does not deal with rotation angle correctly, box is cropped
 *
 * TO DO
 *
 * THANKS
 * Matjaž for poiting out the save_pa bug (should of tested it!)
 * Cahva for posting yet another bug in the save_pa (Man I can be silly sometimes!)
 * Cole spotting the resize flaw and providing a fix
 *
 */

class Image_moo
{
	// image vars
	private $main_image="";
 	private $watermark_image;
	private $temp_image;
	private $jpeg_quality=75;
	private $background_colour="#ffffff";
	private $watermark_method;

	// other
	private $filename="";

	// watermark stuff, opacity
	private $watermark_transparency=50;

	// reported errors
	public $errors=FALSE;
	private $error_msg = array();

	// image info
	public $width=0;
	public $height=0;

	function Image_moo()
	//----------------------------------------------------------------------------------------------------------
	// create stuff here as needed
	//----------------------------------------------------------------------------------------------------------
	{
		log_message('debug', "Image Moo Class Initialized");
	}

	private function _clear_errors()
	//----------------------------------------------------------------------------------------------------------
	// load a resource
	//----------------------------------------------------------------------------------------------------------
	{
		$this->error_msg = array();
	}

	private function set_error($msg)
	//----------------------------------------------------------------------------------------------------------
	// Set an error message
	//----------------------------------------------------------------------------------------------------------
	{
		$this->errors = TRUE;
		$this->error_msg[] = $msg;
	}

	public function display_errors($open = '<p>', $close = '</p>')
	//----------------------------------------------------------------------------------------------------------
	// returns the errors formatted as needed, same as CI doed
	//----------------------------------------------------------------------------------------------------------
	{
		$str = '';
		foreach ($this->error_msg as $val)
		{
			$str .= $open.$val.$close;
		}
		return $str;
	}

	public function check_gd()
	//----------------------------------------------------------------------------------------------------------
	// verification util to see if you can use image_moo
	//----------------------------------------------------------------------------------------------------------
	{
		if ( ! extension_loaded('gd'))
		{
			if ( ! dl('gd.so'))
			{
				$this->set_error('GD library does not appear to be loaded');
				return FALSE;
			}
		}
		if (function_exists('gd_info'))
		{
			$gdarray = @gd_info();
			$versiontxt = ereg_replace('[[:alpha:][:space:]()]+', '', $gdarray['GD Version']);
			$versionparts=explode('.',$versiontxt);
			if ($versionparts[0]=="2")
			{
				return TRUE;
			}
			else
			{
				$this->set_error('Requires GD2, this reported as '.$versiontxt);
				return FALSE;
			}
		}
		else
		{
			$this->set_error('Could not verify GD version');
			return FALSE;
		}
	}

	private function _check_image()
	//----------------------------------------------------------------------------------------------------------
	// checks that we have an image loaded
	//----------------------------------------------------------------------------------------------------------
	{
		if (!is_resource($this->main_image))
		{
			$this->set_error("No main image loaded!");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function save_dynamic($filename="")
	//----------------------------------------------------------------------------------------------------------
	// Saves the temp image as a dynamic image
	// e.g. direct output to the browser
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// ok, lets go!
		if ($filename=="") $filename=rand(1000,999999).".jpg";					// send as jpeg
		$ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
		header("Content-disposition: filename=$filename;");
		header('Content-transfer-Encoding: binary');
		header('Last-modified: '.gmdate('D, d M Y H:i:s'));
		switch ($ext)
		{
			case "GIF"  :
				header("Content-type: image/gif");
				imagegif($this->temp_image);
				return $this;
				break;
			case "JPG" :
			case "JPEG" :
				header("Content-type: image/jpeg");
				imagejpeg($this->temp_image, NULL, $this->jpeg_quality);
				return $this;
				break;
			case "PNG" :
				header("Content-type: image/png");
				imagepng($this->temp_image);
				return $this;
				break;
		}
		$this->set_error('Unable to save, extension not GIF/JPEG/JPG/PNG');
		return $this;
	}

	function save_pa($prepend="", $append="", $overwrite=FALSE)
	//----------------------------------------------------------------------------------------------------------
	// Saves the temp image as the filename specified,
	// overwrite = true of false
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// get current file parts
		$parts=pathinfo($this->filename);

		// save
		$this->save($parts["dirname"].'/'.$prepend.$parts['filename'].$append.'.'.$parts["extension"], $overwrite);

		return $this;
	}

	function save($filename,$overwrite=FALSE)
	//----------------------------------------------------------------------------------------------------------
	// Saves the temp image as the filename specified,
	// overwrite = true of false
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// check if it already exists
		if (!$overwrite)
		{
			// don't overwrite, so check for file
			if (file_exists($filename))
			{
				$this->set_error('File exists, overwrite is FALSE, could not save over file '.$filename);
				return $this;
			}
		}

		// find out the type of file to save
		$ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
		switch ($ext)
		{
			case "GIF"  :
				imagegif($this->temp_image, $filename);
				return $this;
				break;
			case "JPG" :
			case "JPEG" :
				imagejpeg($this->temp_image, $filename, $this->jpeg_quality);
				return $this;
				break;
			case "PNG" :
				imagepng($this->temp_image, $filename);
				return $this;
				break;
		}

		// invalid filetype?!
		$this->set_error('Do no know what '.$ext.' filetype is in filename '.$filename);
		return $this;
	}

	private function _load_image($filename)
	//----------------------------------------------------------------------------------------------------------
	// private function to load a resource
	//----------------------------------------------------------------------------------------------------------
	{
		// check the request file can be located
		if (!file_exists($filename))
		{
			$this->set_error('Could not locate file '.$filename);
			return FALSE;
		}

		// get image info about this file
		$image_info=getimagesize($filename);

		// load file depending on mimetype
		switch ($image_info["mime"])
		{
			case "image/gif"  :
				return imagecreatefromgif($filename);
				break;
			case "image/jpeg" :
				return imagecreatefromjpeg($filename);
				break;
			case "image/png" :
 		        return imagecreatefrompng($filename);
				break;
		}

		// invalid filetype?!
		$this->set_error('Unable to load '.$filename.' filetype '.$image_info["mime"].'not recognised');
		return FALSE;
	}

	public function load($filename)
	//----------------------------------------------------------------------------------------------------------
	// Load an image, public function
	//----------------------------------------------------------------------------------------------------------
	{
		// new image, reset error messages
		$this->_clear_errors();

		// remove temporary image stored
		$this->clear_temp();

		// save filename
		$this->filename=$filename;

		// reset width and height
		$this->width = 0;
		$this->height = 0;

		// load it
		$this->main_image = $this->_load_image($filename);

		// no error, then get the dminesions set
		if ($this->main_image <> FALSE)
		{
			$this->width = imageSX($this->main_image);
			$this->height = imageSY($this->main_image);
		}

		// return the object
		return $this;
	}

	public function load_watermark($filename, $transparent_x=NULL, $transparent_y=NULL)
	//----------------------------------------------------------------------------------------------------------
	// Load an image, public function
	//----------------------------------------------------------------------------------------------------------
	{
		if(is_resource($this->watermark_image)) imagedestroy($this->watermark_image);
		$this->watermark_image = $this->_load_image($filename);

		if(is_resource($this->watermark_image))
		{
			$this->watermark_method = 1;
			if(($transparent_x <> NULL) AND ($transparent_y <> NULL))
			{
				// get the top left corner colour allocation
				$tpcolour = imagecolorat($this->watermark_image, $transparent_x, $transparent_y);

				// set this as the transparent colour
				imagecolortransparent($this->watermark_image, $tpcolour);

				// $set diff method
				$this->watermark_method = 2;
			}
		}

		// return this object
		return $this;
	}

	public function set_watermark_transparency($transparency=50)
	//----------------------------------------------------------------------------------------------------------
	// Sets the quality that jpeg will be saved at
	//----------------------------------------------------------------------------------------------------------
	{
		$this->watermark_transparency = $transparency;
		return $this;
	}

	public function set_background_colour($colour="#ffffff")
	//----------------------------------------------------------------------------------------------------------
	// Sets teh background colour to use on rotation and padding for resize
	//----------------------------------------------------------------------------------------------------------
	{
		$this->background_colour = $this->_html2rgb($colour);
		return $this;
	}

	public function set_jpeg_quality($quality=75)
	//----------------------------------------------------------------------------------------------------------
	// Sets the quality that jpeg will be saved at
	//----------------------------------------------------------------------------------------------------------
	{
		$this->jpeg_quality = $quality;
		return $this;
	}

	private function _copy_to_temp_if_needed()
	//----------------------------------------------------------------------------------------------------------
	// If temp image is empty, e.g. not resized or done anything then just copy main image
	//----------------------------------------------------------------------------------------------------------
	{
		if (!is_resource($this->temp_image))
		{
			// create a temp based on new dimensions
			$this->temp_image = imagecreatetruecolor($this->width, $this->height);

			// check it
			if(!is_resource($this->temp_image))
			{
				$this->set_error('Unable to create temp image sized '.$this->width.' x '.$this->height);
				return FALSE;
			}

			// copy image to temp workspace
			imagecopy($this->temp_image, $this->main_image, 0, 0, 0, 0, $this->width, $this->height);
		}
	}

	public function clear()
	//----------------------------------------------------------------------------------------------------------
	// clear everything!
	//----------------------------------------------------------------------------------------------------------
	{
		if(is_resource($this->main_image)) imagedestroy($this->main_image);
		if(is_resource($this->watermark_image)) imagedestroy($this->watermark_image);
		if(is_resource($this->temp_image)) imagedestroy($this->temp_image);
		return $this;
	}

	public function clear_temp()
	//----------------------------------------------------------------------------------------------------------
	// you may want to revert back to teh original image to work on, e.g. watermark, this clears temp
	//----------------------------------------------------------------------------------------------------------
	{
		if(is_resource($this->temp_image)) imagedestroy($this->temp_image);
		return $this;
	}

	public function resize_crop($mw,$mh)
	//----------------------------------------------------------------------------------------------------------
	// take main image and resize to tempimage using EXACT boundaries mw,mh (max width and max height)
	// this is proportional and crops the image centrally to fit
	//----------------------------------------------------------------------------------------------------------
	{
		if (!$this->_check_image()) return $this;

		// clear temp image
		$this->clear_temp();

		// create a temp based on new dimensions
		$this->temp_image = imagecreatetruecolor($mw,$mh);

		// check it
		if(!is_resource($this->temp_image))
		{
			$this->set_error('Unable to create temp image sized '.$mw.' x '.$mh);
			return $this;
		}

		// work out best positions for copy
		$wx=$this->width / $mw;
		$wy=$this->height / $mh;
		if ($wx >= $wy)
		{
			// use full height
			$sy = 0;
			$sy2 = $this->height;

			// calcs
			$calc_width = $mw * $wy;
			$sx = ($this->width - $calc_width) / 2;
			$sx2 = $calc_width;
		}
		else
		{
			// use full width
			$sx = 0;
			$sx2 = $this->width;

			// calcs
			$calc_height = $mh * $wx;
			$sy = ($this->height - $calc_height) / 2;
			$sy2 = $calc_height;
		}

		// copy section
		imagecopyresampled($this->temp_image, $this->main_image, 0, 0, $sx, $sy, $mw, $mh, $sx2, $sy2);
		return $this;
	}

	public function resize($mw, $mh, $pad=FALSE)
	//----------------------------------------------------------------------------------------------------------
	// take main image and resize to tempimage using boundaries mw,mh (max width or max height)
	// this is proportional, pad to true will set it in the middle of area size
	//----------------------------------------------------------------------------------------------------------
	{
		if (!$this->_check_image()) return $this;

		// calc new dimensions
		if( $this->width > $mw || $this->height > $mh ) {
//		    if( $this->width > $this->height ) { could calc wronf - Cole Thorsen swapped to his suggestion
			if( ($this->width / $this->height) > ($mw / $mh) ) {
		        $tnw = $mw;
		        $tnh = $tnw * $this->height / $this->width;
		    } else {
		        $tnh = $mh;
		        $tnw = $tnh * $this->width / $this->height;
		    }
		} else {
		    $tnw = $this->width;
		    $tnh = $this->height;
		}
		// clear temp image
		$this->clear_temp();

		// create a temp based on new dimensions
		if ($pad)
		{
			$tx = $mw;
			$ty = $mh;
			$px = ($mw - $tnw) / 2;
			$py = ($mh - $tnh) / 2;
		}
		else
		{
			$tx = $tnw;
			$ty = $tnh;
			$px = 0;
			$py = 0;
		}
		$this->temp_image = imagecreatetruecolor($tx,$ty);

		// check it
		if(!is_resource($this->temp_image))
		{
			$this->set_error('Unable to create temp image sized '.$tx.' x '.$ty);
			return $this;
		}

		// if padding, fill background
		if ($pad)
		{
			$col = $this->_html2rgb($this->background_colour);
			$bg = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);
			imagefilledrectangle($this->temp_image, 0, 0, $tx, $ty, $bg);
		}

		// copy resized
		imagecopyresampled($this->temp_image, $this->main_image, $px, $py, 0, 0, $tnw, $tnh, $this->width, $this->height);
		return $this;
	}

	public function stretch($mw,$mh)
	//----------------------------------------------------------------------------------------------------------
	// take main image and resize to tempimage using boundaries mw,mh (max width or max height)
	// does not retain proportions
	//----------------------------------------------------------------------------------------------------------
	{
		if (!$this->_check_image()) return $this;

		// clear temp image
		$this->clear_temp();

		// create a temp based on new dimensions
		$this->temp_image = imagecreatetruecolor($mw, $mh);

		// check it
		if(!is_resource($this->temp_image))
		{
			$this->set_error('Unable to create temp image sized '.$mh.' x '.$mw);
			return $this;
		}

		// copy resized (stethced, proportions not kept);
		imagecopyresampled($this->temp_image, $this->main_image, 0, 0, 0, 0, $mw, $mh, $this->width, $this->height);
		return $this;
	}

	public function crop($x1, $y1, $x2, $y2)
	//----------------------------------------------------------------------------------------------------------
	// crop the main image to temp image using coords
	//----------------------------------------------------------------------------------------------------------
	{
		if (!$this->_check_image()) return $this;

		// clear temp image
		$this->clear_temp();

		// check dimensions
		if ($x1 < 0 || $y1 < 0 || $x2 - $x1 > $this->width || $y2 - $y1 > $this->height)
		{
			$this->set_error('Invalid crop dimensions, either - passed or width/heigh too large '.$x1.'/'.$y1.' x '.$x2.'/'.$y2);
			return $this;
		}

		// create a temp based on new dimensions
		$this->temp_image = imagecreatetruecolor($x2-$x1, $y2-$y1);

		// check it
		if(!is_resource($this->temp_image))
		{
			$this->set_error('Unable to create temp image sized '.$x2-$x1.' x '.$y2-$y1);
			return $this;
		}

		// copy cropped portion
		imagecopy($this->temp_image, $this->main_image, 0, 0, $x1, $y1, $x2 - $x1, $y2 - $y1);
		return $this;
	}

	private function _html2rgb($colour)
	//----------------------------------------------------------------------------------------------------------
	// convert #aa0011 to a php colour array
	//----------------------------------------------------------------------------------------------------------
    {
    	if (is_array($colour))
		{
			if (count($colour)==3) return $colour;								// rgb sent as an array so use it
			$this->set_error('Colour error, array sent not 3 elements, expected array(r,g,b)');
			return false;
		}
        if ($colour[0] == '#')
            $colour = substr($colour, 1);

        if (strlen($colour) == 6)
		{
            list($r, $g, $b) = array($colour[0].$colour[1],
                                     $colour[2].$colour[3],
                                     $colour[4].$colour[5]);
		}
        elseif (strlen($colour) == 3)
		{
            list($r, $g, $b) = array($colour[0].$colour[0], $colour[1].$colour[1], $colour[2].$colour[2]);
		}
        else
		{
			$this->set_error('Colour error, value sent not #RRGGBB or RRGGBB, and not array(r,g,b)');
            return false;
		}

        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

        return array($r, $g, $b);
    }

	public function rotate($angle)
	//----------------------------------------------------------------------------------------------------------
	// rotate an image bu 0 / 90 / 180 / 270 degrees
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// set the colour
		$col = $this->_html2rgb($$this->background_colour);
		$bg = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);

		// rotate as needed
		$this->temp_image = imagerotate($this->temp_image, $angle, $bg);
		return $this;
	}

	public function make_watermark_text($text, $fontfile, $size=16, $colour="#ffffff", $angle=0)
	//----------------------------------------------------------------------------------------------------------
	// create an image from text that can be applied as a watermark
	// text is the text to write, $fontile is a ttf file that will be used $size=font size, $colour is the colour of text
	//----------------------------------------------------------------------------------------------------------
	{
		// check font file can be found
		if (!file_exists($fontfile))
		{
			$this->set_error('Could not locate font file "'.$fontfile.'"');
			return $this;
		}

		// validate we loaded a main image
		if (!$this->_check_image())
		{
			$remove = TRUE;
			// no image loaded so make temp image to use
			$this->main_image = imagecreatetruecolor(1000,1000);
		}
		else
		{
			$remove = FALSE;
		}

		// work out text dimensions
		$bbox = imageftbbox($size, $angle, $fontfile, $text);
		$bw = abs($bbox[4] - $bbox[0]) + 1;
		$bh = abs($bbox[1] - $bbox[5]) + 1;
		$bl = $bbox[1];

		// use this to create watermark image
		if(is_resource($this->watermark_image)) imagedestroy($this->watermark_image);
		$this->watermark_image = imagecreatetruecolor($bw, $bh);

		// set colours
		$col = $this->_html2rgb($colour);
		$font_col = imagecolorallocate($this->watermark_image, $col[0], $col[1], $col[2]);
		$bg_col = imagecolorallocate($this->watermark_image, 127, 128, 126);

		// set method to use
		$this->watermark_method = 2;

		// create bg
		imagecolortransparent($this->watermark_image, $bg_col);
		imagefilledrectangle($this->watermark_image, 0,0, $bw, $bh, $bg_col);

		// write text to watermark
		imagefttext($this->watermark_image, $size, $angle, 0, $bh-$bl, $font_col, $fontfile, $text);

		if ($remove) imagedestroy($this->main_image);
		return $this;
	}

	public function watermark($position, $offset=8, $abs=FALSE)
	//----------------------------------------------------------------------------------------------------------
	// add a watermark to the image
	// position works like a keypad e.g.
	// 7 8 9
	// 4 5 6
	// 1 2 3
	// offset moves image inwards by x pixels
	// if abs is set then $position, $offset = direct placement coords
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// validate we have a watermark
		if(!is_resource($this->watermark_image))
		{
			$this->set_error("Can't watermark image, no watermark loaded/created");
			return $this;
		}

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// get watermark width
		$wm_w = imageSX($this->watermark_image);
		$wm_h = imageSY($this->watermark_image);

		// get temp widths
		$temp_w = imageSX($this->temp_image);
		$temp_h = imageSY($this->temp_image);

		// check watermark will fit!
		if ($wm_w > $temp_w || $wm_h > $temp_h)
		{
			$this->set_error("Watermark is larger than image. WM: $wm_w x $wm_h Temp image: $temp_w x $temp_h");
			return $this;
		}

		if ($abs)
		{
			// direct placement
			$dest_x = $position;
			$dest_y = $offset;
		}
		else
		{
			// do X position
			switch ($position)
			{
				// x left
				case "7":
				case "4":
				case "1":
					$dest_x = $offset;
					break;
				// x middle
				case "8":
				case "5":
				case "2":
					$dest_x = ($temp_w - $wm_w) /2 ;
					break;
				// x right
				case "9":
				case "6":
				case "3":
					$dest_x = $temp_w - $offset - $wm_w;
					break;
				default:
					$dest_x = $offset;
					$this->set_error("Watermark position $position not in vlaid range 7,8,9 - 4,5,6 - 1,2,3");
			}
			// do y position
			switch ($position)
			{
				// y top
				case "7":
				case "8":
				case "9":
					$dest_y = $offset;
					break;
				// y middle
				case "4":
				case "5":
				case "6":
					$dest_y = ($temp_h - $wm_h) /2 ;
					break;
				// y bottom
				case "1":
				case "2":
				case "3":
					$dest_y = $temp_h - $offset - $wm_h;
					break;
				default:
					$dest_y = $offset;
					$this->set_error("Watermark position $position not in vlaid range 7,8,9 - 4,5,6 - 1,2,3");
			}

		}

		// copy over temp image to desired location
		if ($this->watermark_method == 1)
		{
			// use back methods to do this, taken from php help files
			//$this->imagecopymerge_alpha($this->temp_image, $this->watermark_image, $dest_x, $dest_y, 0, 0, $wm_w, $wm_h, $this->watermark_transparency);

	        $opacity=$this->watermark_transparency;

	        // creating a cut resource
	        $cut = imagecreatetruecolor($wm_w, $wm_h);

	        // copying that section of the background to the cut
	        imagecopy($cut, $this->temp_image, 0, 0, $dest_x, $dest_y, $wm_w, $wm_h);

	        // inverting the opacity
	        $opacity = 100 - $opacity;

	        // placing the watermark now
	        imagecopy($cut, $this->watermark_image, 0, 0, 0, 0, $wm_w, $wm_h);
	        imagecopymerge($this->temp_image, $cut, $dest_x, $dest_y, 0, 0, $wm_w, $wm_h, $opacity);

		}
		else
		{
			// use normal with selected transparency colour
			imagecopymerge($this->temp_image, $this->watermark_image, $dest_x, $dest_y, 0, 0, $wm_w, $wm_h, $this->watermark_transparency);
		}

        return $this;
	}

	public function border($width=5,$colour="#000")
	//----------------------------------------------------------------------------------------------------------
	// add a solidborder  frame, coloured $colour to the image
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// get colour set for temp image
		$col = $this->_html2rgb($colour);
		$border_col = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);

		// get temp widths
		$temp_w = imageSX($this->temp_image);
		$temp_h = imageSY($this->temp_image);

		// do border
		for($x=0;$x<$width;$x++)
		{
			imagerectangle($this->temp_image, $x, $x, $temp_w-$x-1, $temp_h-$x-1, $border_col);
		}

		// return object
		return $this;
	}

	public function border_3d($width=5,$rot=0,$opacity=30)
	//----------------------------------------------------------------------------------------------------------
	// overlay a black white border to make it look 3d
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// get temp widths
		$temp_w = imageSX($this->temp_image);
		$temp_h = imageSY($this->temp_image);

		// create temp canvas to merge
		$border_image = imagecreatetruecolor($temp_w, $temp_h);

		// create colours
		$black = imagecolorallocate($border_image, 0, 0, 0);
		$white = imagecolorallocate($border_image, 255, 255, 255);
		switch ($rot)
		{
			case 1 :
				$cols=array($white,$black,$white,$black);
				break;
			case 2 :
				$cols=array($black,$black,$white,$white);
				break;
			case 3 :
				$cols=array($black,$white,$black,$white);
				break;
			default :
				$cols=array($white,$white,$black,$black);
		}
		$bg_col = imagecolorallocate($border_image, 127, 128, 126);

		// create bg
		imagecolortransparent($border_image, $bg_col);
		imagefilledrectangle($border_image, 0,0, $temp_w, $temp_h, $bg_col);

		// do border
		for($x=0;$x<$width;$x++)
		{
			// top
			imageline($border_image, $x, $x, $temp_w-$x-1, $x, $cols[0]);
			// left
			imageline($border_image, $x, $x, $x, $temp_w-$x-1, $cols[1]);
			// bottom
			imageline($border_image, $x, $temp_h-$x-1, $temp_w-1-$x, $temp_h-$x-1, $cols[3]);
			// right
			imageline($border_image, $temp_w-$x-1, $x, $temp_w-$x-1, $temp_h-$x-1, $cols[2]);
		}

		// merg with temp image
		imagecopymerge($this->temp_image, $border_image, 0, 0, 0, 0, $temp_w, $temp_h, $opacity);

		// clean up
		imagedestroy($border_image);

		// return object
		return $this;
	}

	public function shadow($size=4, $direction=3, $colour="#444")
	//----------------------------------------------------------------------------------------------------------
	// add a shadow to an image, this will INCREASE the size of the image
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// get the current size
		$sx = imagesx($this->temp_image);
		$sy = imagesy($this->temp_image);

		// new image
		$bu_image = imagecreatetruecolor($sx, $sy);

		// check it
		if(!is_resource($bu_image))
		{
			$this->set_error('Unable to create shadow temp image sized '.$this->width.' x '.$this->height);
			return FALSE;
		}

		// copy the current image to memory
		imagecopy($bu_image, $this->temp_image, 0, 0, 0, 0, $sx, $sy);

		imagedestroy($this->temp_image);
		$this->temp_image = imagecreatetruecolor($sx+$size, $sy+$size);

		// fill background colour
		$col = $this->_html2rgb($this->background_colour);
		$bg = imagecolorallocate($this->temp_image, $col[0], $col[1], $col[2]);
		imagefilledrectangle($this->temp_image, 0, 0, $sx+$size, $sy+$size, $bg);

		// work out position
		// do X position
		switch ($direction)
		{
			// x left
			case "7":
			case "4":
			case "1":
				$sh_x = 0;
				$pic_x = $size;
				break;
			// x middle
			case "8":
			case "5":
			case "2":
				$sh_x = $size / 2;
				$pic_x = $size / 2;
				break;
			// x right
			case "9":
			case "6":
			case "3":
				$sh_x = $size;
				$pic_x = 0;
				break;
			default:
				$sh_x = $size;
				$pic_x = 0;
				$this->set_error("Shadow position $position not in vlaid range 7,8,9 - 4,5,6 - 1,2,3");
		}
		// do y position
		switch ($direction)
		{
			// y top
			case "7":
			case "8":
			case "9":
				$sh_y = 0;
				$pic_y = $size;
				break;
			// y middle
			case "4":
			case "5":
			case "6":
				$sh_y = $size / 2;
				$pic_y = $size / 2;
				break;
			// y bottom
			case "1":
			case "2":
			case "3":
				$sh_y = $size;
				$pic_y = 0;
				break;
			default:
				$sh_y = $size;
				$pic_y = 0;
				$this->set_error("Shadow position $position not in vlaid range 7,8,9 - 4,5,6 - 1,2,3");
		}

		// create the shadow
		$shadowcolour = $this->_html2rgb($colour);
		$shadow = imagecolorallocate($this->temp_image, $shadowcolour[0], $shadowcolour[1], $shadowcolour[2]);
		imagefilledrectangle($this->temp_image, $sh_x, $sh_y, $sh_x+$sx-1, $sh_y+$sy-1, $shadow);

		// copy current image to correct location
		imagecopy($this->temp_image, $bu_image, $pic_x, $pic_y, 0, 0, $sx, $sy);

		// clean up and desstroy temp image
		imagedestroy($bu_image);

		//return object
		return $this;
	}

	public function filter($function, $arg1=NULL, $arg2=NULL, $arg3=NULL, $arg4=NULL)
	//----------------------------------------------------------------------------------------------------------
	// allows you to use the inbulit gd2 image filters
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		if (!imagefilter($this->temp_image, $function, $arg1, $arg2, $arg3, $arg4))
		{
			$this->set_error("Filter $function failed");
		}

		// return object
		return $this;
	}

	public function round($radius=5,$invert=False,$corners="")
	//----------------------------------------------------------------------------------------------------------
	// adds rounded corners to the output
	// using a quarter and rotating as you can end up with odd roudning if you draw a whole and use parts
	//----------------------------------------------------------------------------------------------------------
	{
		// validate we loaded a main image
		if (!$this->_check_image()) return $this;

		// if no operations, copy it for temp save
		$this->_copy_to_temp_if_needed();

		// check input
		if ($corners=="") $corners=array(True,True,True,True);
		if (!is_array($corners) || count($corners)<>4)
		{
			$this->set_error("Round failed, expected an array of 4 items round(radius,tl,tr,br,bl)");
			return $this;
		}

		// create corner
		$corner = imagecreatetruecolor($radius, $radius);

		// turn on aa make it nicer
		imageantialias($corner, true);
		$col = $this->_html2rgb($this->background_colour);

		// use bg col for corners
		$bg = imagecolorallocate($corner, $col[0], $col[1], $col[2]);

		// create our transparent colour
		$xparent = imagecolorallocate($corner, 127, 128, 126);
		imagecolortransparent($corner, $xparent);
		if ($invert)
		{
			// fill and clear bits
			imagefilledrectangle($corner, 0, 0, $radius, $radius, $xparent);
			imagefilledellipse($corner, 0, 0, ($radius * 2)-1, ($radius * 2)-1, $bg);
		}
		else
		{
			// fill and clear bits
			imagefilledrectangle($corner, 0, 0, $radius, $radius, $bg);
			imagefilledellipse($corner, $radius, $radius, ($radius * 2) , ($radius * 2) , $xparent);
		}

		// get temp widths
		$temp_w = imageSX($this->temp_image);
		$temp_h = imageSY($this->temp_image);

		// do corners
		if ($corners[0]) imagecopymerge($this->temp_image, $corner, 0, 0, 0, 0, $radius, $radius, 100);
		$corner = imagerotate($corner, 270, 0);
		if ($corners[1]) imagecopymerge($this->temp_image, $corner, $temp_w-$radius, 0, 0, 0, $radius, $radius, 100);
		$corner = imagerotate($corner, 270, 0);
		if ($corners[2]) imagecopymerge($this->temp_image, $corner, $temp_w-$radius, $temp_h-$radius, 0, 0, $radius, $radius, 100);
		$corner = imagerotate($corner, 270, 0);
		if ($corners[3]) imagecopymerge($this->temp_image, $corner, 0, $temp_h-$radius, 0, 0, $radius, $radius, 100);

		// return object
		return $this;
	}


}
/* End of file image_moo.php */
/* Location: .system/application/libraries/image_moo.php */