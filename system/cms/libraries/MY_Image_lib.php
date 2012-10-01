<?php
/**
 * MY_Image_lib
 * Fix for losing image transparency
 * @TODO See if this needs to still be extended.
 *
 * @package 	PyroCMS\Core\Libraries
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class MY_Image_lib extends CI_Image_lib
{
	/**
	 * Image Process Using GD/GD2
	 *
	 * This function will resize or crop
	 *
	 * @param	string
	 * @return	bool
	 */
	public function image_process_gd($action = 'resize')
	{
		$v2_override = false;

		// If the target width/height match the source, AND if the new file name is not equal to the old file name
		// we'll simply make a copy of the original with the new name... assuming dynamic rendering is off.
		if ($this->dynamic_output === false)
		{
			if ($this->orig_width == $this->width and $this->orig_height == $this->height)
			{
 				if ($this->source_image != $this->new_image)
 				{
					if (@copy($this->full_src_path, $this->full_dst_path))
					{
						@chmod($this->full_dst_path, DIR_WRITE_MODE);
					}
				}

				return true;
			}
		}

		// Let's set up our values based on the action
		if ($action == 'crop')
		{
			//  Reassign the source width/height if cropping
			$this->orig_width  = $this->width;
			$this->orig_height = $this->height;

			// GD 2.0 has a cropping bug so we'll test for it
			if ($this->gd_version() !== false)
			{
				$gd_version = str_replace('0', '', $this->gd_version());
				$v2_override = ($gd_version == 2) ? true : false;
			}
		}
		else
		{
			// If resizing the x/y axis must be zero
			$this->x_axis = 0;
			$this->y_axis = 0;
		}

		//  Create the image handle
		if ( ! ($src_img = $this->image_create_gd()))
		{
			return false;
		}

 		//  Create The Image
		//
		//  old conditional which users report cause problems with shared GD libs who report themselves as "2.0 or greater"
		//  it appears that this is no longer the issue that it was in 2004, so we've removed it, retaining it in the comment
		//  below should that ever prove inaccurate.
		//
		//  if ($this->image_library == 'gd2' and function_exists('imagecreatetruecolor') and $v2_override == false)		
 		if ($this->image_library == 'gd2' and function_exists('imagecreatetruecolor'))
		{
			$create	= 'imagecreatetruecolor';
			$copy	= 'imagecopyresampled';
		}
		else
		{
			$create	= 'imagecreate';
			$copy	= 'imagecopyresized';
		}

		$dst_img = $create($this->width, $this->height);
		
		// Fix image transparency. Taken from http://codeigniter.com/forums/viewthread/150527/
		if ( $this->image_library == 'gd2' )
        {
            $transparencyIndex = imagecolortransparent($src_img);
            $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);

            if ( $transparencyIndex >= 0 )
			{
                $transparencyColor    = imagecolorsforindex($src_img, $transparencyIndex);
            }

            $transparencyIndex    = imagecolorallocate($dst_img, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
            imagefill($dst_img, 0, 0, $transparencyIndex);
            imagecolortransparent($dst_img, $transparencyIndex);
        }
		
		$copy($dst_img, $src_img, 0, 0, $this->x_axis, $this->y_axis, $this->width, $this->height, $this->orig_width, $this->orig_height);

		//  Show the image
		if ($this->dynamic_output == true)
		{
			$this->image_display_gd($dst_img);
		}
		else
		{
			// Or save it
			if ( ! $this->image_save_gd($dst_img))
			{
				return false;
			}
		}

		//  Kill the file handles
		imagedestroy($dst_img);
		imagedestroy($src_img);

		// Set the file to 777
		@chmod($this->full_dst_path, DIR_WRITE_MODE);

		return true;
	}
}