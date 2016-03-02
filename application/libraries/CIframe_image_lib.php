<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package    Sframe_Image_lib Class
 * @author     Makoto Haba <m-haba@sanyo.oni.co.jp>
 * @copyright  Copyright (c) 2010 Makoto Haba <m-haba@sanyo.oni.co.jp>
 * @copyright  Copyright (c) 2010 The Sanyo Shimbun <media@sanyo.oni.co.jp>
 * @license    New BSD License
 */

require_once(BASEPATH.'libraries/Image_lib.php');

class CIframe_image_lib extends CI_Image_lib {

	private $CI;
	
	
	/**
	 * Constructor
	 *
	 * @access  public
	 * @param   string
	 * @return  void
	 */
	public function __construct($params = array())
	{
		parent::__construct();

		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		
		//$this->CI =& get_instance();

		//log_message('debug', "Image Lib Class Initialized");
	}

	// --------------------------------------------------------------------



	/**
	 * 指定のフィールド名のファイルがアップロードされているかどうかを返却
	 * @params  string  field name
	 * @params  bool	TRUE or FALSE
	 *
	 */
	public function is_upload($full_path)
	{
		//if ($this->CI->upload->is_uploaded($name))
		if (file_exists($full_path))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 保存ディレクトリが存在しているかを調査する
	 *
	 *
	 */
	private function _path($path)
	{
		if (is_dir($path))
		{
			if (is_writable($path) !== TRUE)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	

	/**
	 * 画像を複指定したサイズを長辺でコンバートする。
	 * オリジナル画像を保存する場合は、リネームして新しく保存する
	 * @params  array ファイルアップロードクラスのアップロードデータ
	 * @params  int  convert size
	 * @params  string  出力パス
	 * @params  string  出力ファイルネーム
	 * @params  bool   オリジナル画像を残すかどうか
	 *
	 */
	public function convert_image_uploaded($upload_data,$convert_size='',$out_path='',$out_filename='', $deleted = FALSE)
	{
		
		if ( !$upload_data["file_name"])
		{
			return FALSE;
		}
		
		if(!$out_path)
		{
			$out_path = $upload_data["file_path"];
		}
		
		
		if(!preg_match("/.+\/$/", $out_path))
		{
			$out_path = $out_path."/";
		}
		
		if(!$this->_path($upload_data["file_path"]) or !$this->_path($out_path))
		{
			return FALSE;
		}
		
		
		
		if(!$this->is_upload($out_path))
		{
			return FALSE;
		}
		
		
		if(!$out_filename)
		{
			$out_filename = $upload_data["file_name"];
		}
		
		
		
		//サイズが指定されていない場合は、ファイルそのものをコピーする
		if ( !$convert_size)
		{
			if ( ! copy($upload_data['full_path'], $out_path.$out_filename.$upload_data['file_ext']))
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			//画像操作
			$img_conf=array();
			
			$img_conf['image_library']  = 'gd2';
			$img_conf['source_image']   = $upload_data['full_path'];
			$img_conf['create_thumb']   = FALSE;
			$img_conf['maintain_ratio'] = TRUE;
			$img_conf['new_image']	  = $out_path.$out_filename.$upload_data['file_ext'];
			
			
			
			if($upload_data['image_width'] > $upload_data['image_height']){
				$new_width = $convert_size;
				$rate = $new_width / $upload_data['image_width']; //圧縮比
				$new_height = $rate * $upload_data['image_height'];
			}
			else
			{
				$new_height = $convert_size;
				$rate = $new_height / $upload_data['image_height']; //圧縮比
				$new_width = $rate * $upload_data['image_width'];
			}
			$img_conf['width'] = $new_width;
			$img_conf['height'] = $new_height;
			
			
			$this->initialize($img_conf);
			if(!$this->resize())
			{
 				#$error_message = $this->display_errors();]
 				$this->clear();
				return FALSE;
			}
			
			$this->clear();
		}
		
		
		if ($deleted)
		{
			unlink($upload_data['full_path']);
		}
		
		
		return TRUE;
	}








	/**
	 * 画像を指定したサイズを長辺でコンバートする。
	 * オリジナル画像を保存する場合は、リネームして新しく保存する
	 * @params  変換元のファイル（フルパスでファイル名も含める）
	 * @params  string  出力パス（フルパスでファイル名も含める）
	 * @params  int  convert size
	 * @params  bool   オリジナル画像を残すかどうか
	 *
	 */
	public function convert_jpg($image_file,$out_filename,$convert_size='',$deleted = FALSE)
	{
		
		if (!file_exists($image_file))
		{
			return FALSE;
		}
		
		
		//サイズが指定されていない場合は、ファイルそのものをコピーする
		if ( !$convert_size)
		{
			if ( ! copy($image_file, $out_filename))
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			//画像操作
			$img_conf=array();
			
			$img_conf['image_library']  = 'gd2';
			$img_conf['source_image']   = $image_file;
			$img_conf['create_thumb']   = FALSE;
			$img_conf['maintain_ratio'] = TRUE;
			$img_conf['new_image']	  = $out_filename;
			
			
			$image = ImageCreateFromJPEG("$image_file"); //JPEGファイルを読み込む
			$width = ImageSX($image); //横幅（ピクセル）
			$height = ImageSY($image); //縦幅（ピクセル）
			
			if(!$width or !$height)
			{
				return FALSE;
			}
			
			if($width > $height){
				$new_width = $convert_size;
				$rate = $new_width / $width; //圧縮比
				$new_height = $rate * $height;
			}
			else
			{
				$new_height = $convert_size;
				$rate = $new_height / $height; //圧縮比
				$new_width = $rate * $width;
			}
			
			$img_conf['width'] = $new_width;
			$img_conf['height'] = $new_height;
			
			$this->initialize($img_conf);
			if(!$this->resize())
			{
 				$this->clear();
				return FALSE;
			}
			
			$this->clear();
		}
		
		
		if ($deleted)
		{
			unlink($image_file);
		}
		
		
		return TRUE;
	}
}