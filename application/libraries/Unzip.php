<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * UnZip Class
 *
 * This class is based on a library I found at PHPClasses:
 * http://phpclasses.org/package/2495-PHP-Pack-and-unpack-files-packed-in-ZIP-archives.html
 *
 * The original library is a little rough around the edges so I
 * refactored it and added several additional methods -- Phil Sturgeon
 *
 * This class requires extension ZLib Enabled.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Encryption
 * @author		Alexandre Tedeschi
 * @author		Phil Sturgeon
 * @link		http://bitbucket.org/philsturgeon/codeigniter-unzip
 * @license        http://www.gnu.org/licenses/lgpl.html
 * @version     1.0.0
 */

class Unzip
{
	var $compressedList    = array(); // You will problably use only this one!
	var $centralDirList    = array(); // Central dir list... It's a kind of 'extra attributes' for a set of files
	var $endOfCentral      = array(); // End of central dir, contains ZIP Comments
	var $info              = array();
	var $error             = array();

	private $_zip_file          = '';
	private $_target_dir         = FALSE;
	private $apply_chmod        = 0777;
	private $fh;

	private $zipSignature = "\x50\x4b\x03\x04"; // local file header signature
	private $dirSignature = "\x50\x4b\x01\x02"; // central dir header signature
	private $dirSignatureE= "\x50\x4b\x05\x06"; // end of central dir signature

	private $_skip_dirs = array('__MACOSX');
	private $_allow_extensions = NULL; // What is allowed out of the zip? NULL = all

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access    Public
	 * @param     string
	 * @return    none
	 */
	function __construct()
	{
		log_message('debug', "Unzip Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Unzip all files in archive.
	 *
	 * @access    Public
	 * @param     none
	 * @return    none
	 */

	public function extract($zip_file, $target_dir = null, $preserve_filepath = TRUE)
	{
		$this->_zip_file = $zip_file;
		$this->_target_dir = $target_dir ? $target_dir : dirname($this->_zip_file);

		$lista = $this->_list_files();
		if(!sizeof($lista))
		{
			$this->set_error('ZIP folder was empty.');
			return FALSE;
		}

		foreach($lista as $file=>$trash)
		{
			$dirname  = pathinfo($file, PATHINFO_DIRNAME);
			$extension  = pathinfo($file, PATHINFO_EXTENSION);

			$folders = explode("/", $dirname);
			$outDN    = $this->_target_dir."/".$dirname;

			// Skip stuff in stupid folders
			if(in_array(current($folders), $this->_skip_dirs))
			{
				continue;
			}

			if(is_array($this->_allow_extensions) && $extension && !in_array($extension, $this->_allow_extensions))
			{
				continue;
			}

			if(!is_dir($outDN) && $preserve_filepath)
			{
				$str = "";
				foreach($folders as $folder)
				{
					$str = $str ? $str."/".$folder : $folder;
					if (!is_dir($this->_target_dir."/".$str))
					{
						$this->set_debug("Creating folder: ".$this->_target_dir."/".$str);

						if (!@mkdir($this->_target_dir."/".$str))
						{
							$this->set_error('Desitnation path is not writable.');
							return FALSE;
						}

						// Apply chmod if configured to do so
						$this->apply_chmod && chmod($this->_target_dir."/".$str, $this->apply_chmod);
					}
				}
			}

			if(substr($file, -1, 1) == "/")
			{
				continue;
			}

			$preserve_filepath
				? $this->_extract_file($file, $this->_target_dir."/".$file)
				: $this->_extract_file($file, $this->_target_dir."/".basename($file));
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * What extensions do we want out of this ZIP
	 *
	 * @access    Public
	 * @param     none
	 * @return    none
	 */

	public function allow($ext = NULL)
	{
		$this->_allow_extensions = $ext;
	}

	// --------------------------------------------------------------------

	/**
	 * Show error messages
	 *
	 * @access    public
	 * @param    string
	 * @return    string
	 */
	public function error_string($open = '<p>', $close = '</p>')
	{
		return $open . implode($close.$open, $this->error) . $close;
	}

	// --------------------------------------------------------------------

	/**
	 * Show debug messages
	 *
	 * @access    public
	 * @param    string
	 * @return    string
	 */
	public function debug_string($open = '<p>', $close = '</p>')
	{
		return $open . implode($close.$open, $this->info) . $close;
	}

	// --------------------------------------------------------------------

	/**
	 * Save errors
	 *
	 * @access    Private
	 * @param    string
	 * @return    none
	 */

	function set_error($string)
	{
			$this->error[] = $string;
	}

	// --------------------------------------------------------------------

	/**
	 * Save debug data
	 *
	 * @access    Private
	 * @param    string
	 * @return    none
	 */

	function set_debug($string)
	{
			$this->info[] = $string;
	}

	// --------------------------------------------------------------------

	/**
	 * List all files in archive.
	 *
	 * @access    Public
	 * @param     boolean
	 * @return    mixed
	 */
	private function _list_files($stopOnFile=FALSE)
	{
		if(sizeof($this->compressedList))
		{
			$this->set_debug("Returning already loaded file list.");
			return $this->compressedList;
		}

		// Open file, and set file handler
		$fh = fopen($this->_zip_file, "r");
		$this->fh = &$fh;
		if(!$fh)
		{
			$this->set_error("Failed to load file: ".$this->_zip_file);
			return FALSE;
		}

		$this->set_debug("Loading list from 'End of Central Dir' index list...");
		if(!$this->_loadFileListByEOF($fh, $stopOnFile))
		{
			$this->set_debug("Failed! Trying to load list looking for signatures...");
			if(!$this->_loadFileListBySignatures($fh, $stopOnFile))
			{
				$this->set_debug("Failed! Could not find any valid header.");
				$this->set_error("ZIP File is corrupted or empty");
				return FALSE;
			}
		}
		return $this->compressedList;
	}

	// --------------------------------------------------------------------

	/**
	 * Unzip file in archive.
	 *
	 * @access    Public
	 * @param     string, boolean
	 * @return    Unziped file.
	 */
	private function _extract_file($compressedFileName, $targetFileName=FALSE)
	{
		if(!sizeof($this->compressedList))
		{
			$this->set_debug("Trying to unzip before loading file list... Loading it!");
			$this->_list_files(FALSE, $compressedFileName);
		}

		$fdetails = &$this->compressedList[$compressedFileName];

		if(!isset($this->compressedList[$compressedFileName]))
		{
			$this->set_error("File '<b>$compressedFileName</b>' is not compressed in the zip.");
			return FALSE;
		}

		if(substr($compressedFileName, -1) == "/")
		{
			$this->set_error("Trying to unzip a folder name '<b>$compressedFileName</b>'.");
			return FALSE;
		}

		if(!$fdetails['uncompressed_size'])
		{
			$this->set_debug("File '<b>$compressedFileName</b>' is empty.");
			return $targetFileName
				? file_put_contents($targetFileName, "")
				: '';
		}

		fseek($this->fh, $fdetails['contents-startOffset']);
		$ret = $this->_uncompress(
			fread($this->fh, $fdetails['compressed_size']),
			$fdetails['compression_method'],
			$fdetails['uncompressed_size'],
			$targetFileName
		);

		if($this->apply_chmod && $targetFileName)
		{
			chmod($targetFileName, 0644);
		}

		return $ret;
	}

	// --------------------------------------------------------------------

	/**
	 * Free the file resource.
	 *
	 * @access    Public
	 * @param     none
	 * @return    none
	 */

	public function close()
	{
		// Free the file resource
		if($this->fh)
		{
			fclose($this->fh);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Free the file resource Automatic destroy.
	 *
	 * @access    Public
	 * @param     none
	 * @return    none
	 */

	public function __destroy()
	{
		$this->close();
	}

	// --------------------------------------------------------------------

	/**
	 * Uncompress file. And save it to the targetFile.
	 *
	 * @access    Private
	 * @param     Filecontent, int, int, boolean
	 * @return    none
	 */
	private function _uncompress($content, $mode, $uncompressedSize, $targetFileName=FALSE)
	{
		switch($mode)
		{
			case 0:
				return $targetFileName?file_put_contents($targetFileName, $content):$content;
			case 1:
				$this->set_error("Shrunk mode is not supported... yet?");
				return FALSE;
			case 2:
			case 3:
			case 4:
			case 5:
				$this->set_error("Compression factor ".($mode-1)." is not supported... yet?");
				return FALSE;
			case 6:
				$this->set_error("Implode is not supported... yet?");
				return FALSE;
			case 7:
				$this->set_error("Tokenizing compression algorithm is not supported... yet?");
				return FALSE;
			case 8:
			// Deflate
				return $targetFileName?
						file_put_contents($targetFileName, gzinflate($content, $uncompressedSize)):
						gzinflate($content, $uncompressedSize);
			case 9:
				$this->set_error("Enhanced Deflating is not supported... yet?");
				return FALSE;
			case 10:
				$this->set_error("PKWARE Date Compression Library Impoloding is not supported... yet?");
				return FALSE;
			case 12:
			// Bzip2
				return $targetFileName?
						file_put_contents($targetFileName, bzdecompress($content)):
						bzdecompress($content);
			case 18:
				$this->set_error("IBM TERSE is not supported... yet?");
				return FALSE;
			default:
				$this->set_error("Unknown uncompress method: $mode");
				return FALSE;
		}
	}

	private function _loadFileListByEOF(&$fh, $stopOnFile=FALSE)
	{
		// Check if there's a valid Central Dir signature.
		// Let's consider a file comment smaller than 1024 characters...
		// Actually, it length can be 65536.. But we're not going to support it.

		for($x = 0; $x < 1024; $x++)
		{
			fseek($fh, -22-$x, SEEK_END);

			$signature = fread($fh, 4);
			if($signature == $this->dirSignatureE)
			{
				// If found EOF Central Dir
				$eodir['disk_number_this']   = unpack("v", fread($fh, 2)); // number of this disk
				$eodir['disk_number']        = unpack("v", fread($fh, 2)); // number of the disk with the start of the central directory
				$eodir['total_entries_this'] = unpack("v", fread($fh, 2)); // total number of entries in the central dir on this disk
				$eodir['total_entries']      = unpack("v", fread($fh, 2)); // total number of entries in
				$eodir['size_of_cd']         = unpack("V", fread($fh, 4)); // size of the central directory
				$eodir['offset_start_cd']    = unpack("V", fread($fh, 4)); // offset of start of central directory with respect to the starting disk number
				$zipFileCommentLenght        = unpack("v", fread($fh, 2)); // zipfile comment length
				$eodir['zipfile_comment']    = $zipFileCommentLenght[1]?fread($fh, $zipFileCommentLenght[1]):''; // zipfile comment
				$this->endOfCentral = Array(
						'disk_number_this'=>$eodir['disk_number_this'][1],
						'disk_number'=>$eodir['disk_number'][1],
						'total_entries_this'=>$eodir['total_entries_this'][1],
						'total_entries'=>$eodir['total_entries'][1],
						'size_of_cd'=>$eodir['size_of_cd'][1],
						'offset_start_cd'=>$eodir['offset_start_cd'][1],
						'zipfile_comment'=>$eodir['zipfile_comment'],
				);

				// Then, load file list
				fseek($fh, $this->endOfCentral['offset_start_cd']);
				$signature = fread($fh, 4);

				while($signature == $this->dirSignature)
				{
					$dir['version_madeby']      = unpack("v", fread($fh, 2)); // version made by
					$dir['version_needed']      = unpack("v", fread($fh, 2)); // version needed to extract
					$dir['general_bit_flag']    = unpack("v", fread($fh, 2)); // general purpose bit flag
					$dir['compression_method']  = unpack("v", fread($fh, 2)); // compression method
					$dir['lastmod_time']        = unpack("v", fread($fh, 2)); // last mod file time
					$dir['lastmod_date']        = unpack("v", fread($fh, 2)); // last mod file date
					$dir['crc-32']              = fread($fh, 4);              // crc-32
					$dir['compressed_size']     = unpack("V", fread($fh, 4)); // compressed size
					$dir['uncompressed_size']   = unpack("V", fread($fh, 4)); // uncompressed size
					$zip_fileLength             = unpack("v", fread($fh, 2)); // filename length
					$extraFieldLength           = unpack("v", fread($fh, 2)); // extra field length
					$fileCommentLength          = unpack("v", fread($fh, 2)); // file comment length
					$dir['disk_number_start']   = unpack("v", fread($fh, 2)); // disk number start
					$dir['internal_attributes'] = unpack("v", fread($fh, 2)); // internal file attributes-byte1
					$dir['external_attributes1']= unpack("v", fread($fh, 2)); // external file attributes-byte2
					$dir['external_attributes2']= unpack("v", fread($fh, 2)); // external file attributes
					$dir['relative_offset']     = unpack("V", fread($fh, 4)); // relative offset of local header
					$dir['file_name']           = fread($fh, $zip_fileLength[1]);                             // filename
					$dir['extra_field']         = $extraFieldLength[1] ?fread($fh, $extraFieldLength[1]) :''; // extra field
					$dir['file_comment']        = $fileCommentLength[1]?fread($fh, $fileCommentLength[1]):''; // file comment

					// Convert the date and time, from MS-DOS format to UNIX Timestamp
					$BINlastmod_date = str_pad(decbin($dir['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
					$BINlastmod_time = str_pad(decbin($dir['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
					$lastmod_dateY = bindec(substr($BINlastmod_date,  0, 7))+1980;
					$lastmod_dateM = bindec(substr($BINlastmod_date,  7, 4));
					$lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
					$lastmod_timeH = bindec(substr($BINlastmod_time,   0, 5));
					$lastmod_timeM = bindec(substr($BINlastmod_time,   5, 6));
					$lastmod_timeS = bindec(substr($BINlastmod_time,  11, 5));

					$this->centralDirList[$dir['file_name']] = Array(
							'version_madeby'=>$dir['version_madeby'][1],
							'version_needed'=>$dir['version_needed'][1],
							'general_bit_flag'=>str_pad(decbin($dir['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
							'compression_method'=>$dir['compression_method'][1],
							'lastmod_datetime'  =>mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
							'crc-32'            =>str_pad(dechex(ord($dir['crc-32'][3])), 2, '0', STR_PAD_LEFT).
									str_pad(dechex(ord($dir['crc-32'][2])), 2, '0', STR_PAD_LEFT).
									str_pad(dechex(ord($dir['crc-32'][1])), 2, '0', STR_PAD_LEFT).
									str_pad(dechex(ord($dir['crc-32'][0])), 2, '0', STR_PAD_LEFT),
							'compressed_size'=>$dir['compressed_size'][1],
							'uncompressed_size'=>$dir['uncompressed_size'][1],
							'disk_number_start'=>$dir['disk_number_start'][1],
							'internal_attributes'=>$dir['internal_attributes'][1],
							'external_attributes1'=>$dir['external_attributes1'][1],
							'external_attributes2'=>$dir['external_attributes2'][1],
							'relative_offset'=>$dir['relative_offset'][1],
							'file_name'=>$dir['file_name'],
							'extra_field'=>$dir['extra_field'],
							'file_comment'=>$dir['file_comment'],
					);
					$signature = fread($fh, 4);
				}

				// If loaded centralDirs, then try to identify the offsetPosition of the compressed data.
				if($this->centralDirList) foreach($this->centralDirList as $filename=>$details)
				{
					$i = $this->_getFileHeaderInformation($fh, $details['relative_offset']);
					$this->compressedList[$filename]['file_name']          = $filename;
					$this->compressedList[$filename]['compression_method'] = $details['compression_method'];
					$this->compressedList[$filename]['version_needed']     = $details['version_needed'];
					$this->compressedList[$filename]['lastmod_datetime']   = $details['lastmod_datetime'];
					$this->compressedList[$filename]['crc-32']             = $details['crc-32'];
					$this->compressedList[$filename]['compressed_size']    = $details['compressed_size'];
					$this->compressedList[$filename]['uncompressed_size']  = $details['uncompressed_size'];
					$this->compressedList[$filename]['lastmod_datetime']   = $details['lastmod_datetime'];
					$this->compressedList[$filename]['extra_field']        = $i['extra_field'];
					$this->compressedList[$filename]['contents-startOffset']=$i['contents-startOffset'];
					if(strtolower($stopOnFile) == strtolower($filename))
					{
						break;
					}
				}
				return true;
			}
		}
		return FALSE;
	}

	private function _loadFileListBySignatures(&$fh, $stopOnFile=FALSE)
	{
		fseek($fh, 0);

		$return = FALSE;
		for(;;)
		{
			$details = $this->_getFileHeaderInformation($fh);
			if(!$details)
			{
				$this->set_debug("Invalid signature. Trying to verify if is old style Data Descriptor...");
				fseek($fh, 12 - 4, SEEK_CUR); // 12: Data descriptor - 4: Signature (that will be read again)
				$details = $this->_getFileHeaderInformation($fh);
			}
			if(!$details)
			{
				$this->set_debug("Still invalid signature. Probably reached the end of the file.");
				break;
			}
			$filename = $details['file_name'];
			$this->compressedList[$filename] = $details;
			$return = true;
			if(strtolower($stopOnFile) == strtolower($filename))
				break;
		}

		return $return;
	}

	private function _getFileHeaderInformation(&$fh, $startOffset=FALSE)
	{
		if($startOffset !== FALSE)
			fseek($fh, $startOffset);

		$signature = fread($fh, 4);
		if($signature == $this->zipSignature)
		{

			// Get information about the zipped file
			$file['version_needed']     = unpack("v", fread($fh, 2)); // version needed to extract
			$file['general_bit_flag']   = unpack("v", fread($fh, 2)); // general purpose bit flag
			$file['compression_method'] = unpack("v", fread($fh, 2)); // compression method
			$file['lastmod_time']       = unpack("v", fread($fh, 2)); // last mod file time
			$file['lastmod_date']       = unpack("v", fread($fh, 2)); // last mod file date
			$file['crc-32']             = fread($fh, 4);              // crc-32
			$file['compressed_size']    = unpack("V", fread($fh, 4)); // compressed size
			$file['uncompressed_size']  = unpack("V", fread($fh, 4)); // uncompressed size
			$zip_fileLength             = unpack("v", fread($fh, 2)); // filename length
			$extraFieldLength           = unpack("v", fread($fh, 2)); // extra field length
			$file['file_name']          = fread($fh, $zip_fileLength[1]); // filename
			$file['extra_field']        = $extraFieldLength[1]?fread($fh, $extraFieldLength[1]):''; // extra field
			$file['contents-startOffset']= ftell($fh);

			// Bypass the whole compressed contents, and look for the next file
			fseek($fh, $file['compressed_size'][1], SEEK_CUR);

			// Convert the date and time, from MS-DOS format to UNIX Timestamp
			$BINlastmod_date = str_pad(decbin($file['lastmod_date'][1]), 16, '0', STR_PAD_LEFT);
			$BINlastmod_time = str_pad(decbin($file['lastmod_time'][1]), 16, '0', STR_PAD_LEFT);
			$lastmod_dateY = bindec(substr($BINlastmod_date,  0, 7))+1980;
			$lastmod_dateM = bindec(substr($BINlastmod_date,  7, 4));
			$lastmod_dateD = bindec(substr($BINlastmod_date, 11, 5));
			$lastmod_timeH = bindec(substr($BINlastmod_time,   0, 5));
			$lastmod_timeM = bindec(substr($BINlastmod_time,   5, 6));
			$lastmod_timeS = bindec(substr($BINlastmod_time,  11, 5));

			// Mount file table
			$i = Array(
					'file_name'         =>$file['file_name'],
					'compression_method'=>$file['compression_method'][1],
					'version_needed'    =>$file['version_needed'][1],
					'lastmod_datetime'  =>mktime($lastmod_timeH, $lastmod_timeM, $lastmod_timeS, $lastmod_dateM, $lastmod_dateD, $lastmod_dateY),
					'crc-32'            =>str_pad(dechex(ord($file['crc-32'][3])), 2, '0', STR_PAD_LEFT).
							str_pad(dechex(ord($file['crc-32'][2])), 2, '0', STR_PAD_LEFT).
							str_pad(dechex(ord($file['crc-32'][1])), 2, '0', STR_PAD_LEFT).
							str_pad(dechex(ord($file['crc-32'][0])), 2, '0', STR_PAD_LEFT),
					'compressed_size'   =>$file['compressed_size'][1],
					'uncompressed_size' =>$file['uncompressed_size'][1],
					'extra_field'       =>$file['extra_field'],
					'general_bit_flag'  =>str_pad(decbin($file['general_bit_flag'][1]), 8, '0', STR_PAD_LEFT),
					'contents-startOffset'=>$file['contents-startOffset']
			);
			return $i;
		}
		return FALSE;
	}
}