<?php
/**
 * @author liuyanqiang
 * 功能：php生成缩略图片的类
 * @example 
 * $resizeimage=new ImageFile('20131204110320_11895.jpg', '130', '130', '0', 'com_130_130.jpg');
*/
namespace Org\Util;
class ImageFile {
	public $type; // 图片类型
	public $width; // 实际宽度
	public $height; // 实际高度
	public $resize_width; // 改变后的宽度
	public $resize_height; // 改变后的高度
	public $cut; // 是否裁图
	public $srcimg; // 源图象
	public $dstimg; // 目标图象地址
	public $im; // 临时创建的图象
	public $quality; // 图片质量
	public $imageFunction;
	public $header;

	
	function __construct($img, $wid, $hei, $c, $dstpath,$quality = 100) {
		$this->srcimg = $img;
		$imageInfo= @getimagesize($img);
		$this->resize_width = $wid;
		$this->resize_height = $hei;
		$this->cut = $c;
		$this->quality = $quality;
		//$this->type = strtolower ( substr ( strrchr ( $this->srcimg, '.' ), 1 ) ); // 图片的类型
		$this->type=$imageInfo[2];
		$this->initi_img (); // 初始化图象
		$this->dst_img ( $dstpath ); // 目标图象地址
		@$this->width = imagesx ( $this->im );
		@$this->height = imagesy ( $this->im );
		$this->newimg (); // 生成图象
		@ImageDestroy ( $this->im );
	}
	function newimg() {
		$resize_ratio = ($this->resize_width) / ($this->resize_height); // 改变后的图象的比例
		@$ratio = ($this->width) / ($this->height); // 实际图象的比例
		
		if (($this->cut) == '1') { // 裁图
			if ($ratio >= $resize_ratio) { // 高度优先
				$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
				imagecopyresampled ( $newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, (($this->height) * $resize_ratio), $this->height );
				imagejpeg ( $newimg, $this->dstimg, $this->quality );
			}
			if ($ratio < $resize_ratio) { // 宽度优先
				$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
				imagecopyresampled ( $newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, (($this->width) / $resize_ratio) );
				imagejpeg ( $newimg, $this->dstimg, $this->quality );
			}
		} else { // 不裁图
			//if ($ratio >= $resize_ratio) {
				//$newimg = imagecreatetruecolor ( $this->resize_width, ($this->resize_width) / $ratio );
				//imagecopyresampled ( $newimg, $this->im, 0, 0, 0, 0, $this->resize_width, ($this->resize_width) / $ratio, $this->width, $this->height );
				//imagejpeg ( $newimg, $this->dstimg, $this->quality );
			//}
			//if ($ratio < $resize_ratio) {
				//@$newimg = imagecreatetruecolor ( ($this->resize_height) * $ratio, $this->resize_height );
				//@imagecopyresampled ( $newimg, $this->im, 0, 0, 0, 0, ($this->resize_height) * $ratio, $this->resize_height, $this->width, $this->height );
				//@imagejpeg ( $newimg, $this->dstimg, $this->quality );
			//}
			
			@$newimg = imagecreatetruecolor ( $this->resize_width, $this->resize_height );
			imagealphablending($newimg, false);
			@imagecopyresampled ( $newimg, $this->im, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, $this->height );
			$func = $this->imageFunction;
			if($this->type==2){
			imagejpeg( $newimg, $this->dstimg, $this->quality );
			}else{

				$transparent = imagecolorallocatealpha( $newimg, 255, 255, 255, 127 );
				imagefill( $newimg, 0, 0, $transparent );
				imagealphablending($newimg, true);
				imagesavealpha($newimg,true);
		
			$func( $newimg, $this->dstimg);
			}
		 }
	}
	function initi_img() { // 初始化图象
		if ($this->type == 'jpg' || $this->type == 'jpeg'||$this->type==2) {
			$this->im = imagecreatefromjpeg ( $this->srcimg );
			$this->imageFunction = 'imagejpeg';
			
		}
		if ($this->type == 'gif'||$this->type==1) {
			$this->im = imagecreatefromgif ( $this->srcimg );
			$this->imageFunction = 'imagegif';
		}
		if ($this->type == 'png'||$this->type==3) {
			$this->im = imagecreatefrompng ( $this->srcimg );
			$this->imageFunction = 'imagepng';
		}
		if ($this->type == 'wbm'||$this->type==15) {
			@$this->im = imagecreatefromwbmp ( $this->srcimg );
			$this->imageFunction = 'imagewbmp';
		}
		if ($this->type == 'bmp'||$this->type==6) {
			$this->im = $this->ImageCreateFromBMP ( $this->srcimg );
			//这块不做处理
			$this->imageFunction = 'imagejpeg';
		}
	}
	function dst_img($dstpath) { // 图象目标地址
		$full_length = strlen ( $this->srcimg );
		$type_length = strlen ( $this->type );
		$name_length = $full_length - $type_length;
		$name = substr ( $this->srcimg, 0, $name_length - 1 );
		$this->dstimg = $dstpath;
		// echo $this->dstimg;
	}
	function ImageCreateFromBMP($filename) { // 自定义函数处理bmp图片
		if (! $f1 = fopen ( $filename, "rb" ))
			return FALSE;
		$FILE = unpack ( "vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread ( $f1, 14 ) );
		if ($FILE ['file_type'] != 19778)
			return FALSE;
		$BMP = unpack ( 'Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' . '/Vcompression/Vsize_bitmap/Vhoriz_resolution' . '/Vvert_resolution/Vcolors_used/Vcolors_important', fread ( $f1, 40 ) );
		$BMP ['colors'] = pow ( 2, $BMP ['bits_per_pixel'] );
		if ($BMP ['size_bitmap'] == 0)
			$BMP ['size_bitmap'] = $FILE ['file_size'] - $FILE ['bitmap_offset'];
		$BMP ['bytes_per_pixel'] = $BMP ['bits_per_pixel'] / 8;
		$BMP ['bytes_per_pixel2'] = ceil ( $BMP ['bytes_per_pixel'] );
		$BMP ['decal'] = ($BMP ['width'] * $BMP ['bytes_per_pixel'] / 4);
		$BMP ['decal'] -= floor ( $BMP ['width'] * $BMP ['bytes_per_pixel'] / 4 );
		$BMP ['decal'] = 4 - (4 * $BMP ['decal']);
		if ($BMP ['decal'] == 4)
			$BMP ['decal'] = 0;
		$PALETTE = array ();
		if ($BMP ['colors'] < 16777216) {
			$PALETTE = unpack ( 'V' . $BMP ['colors'], fread ( $f1, $BMP ['colors'] * 4 ) );
		}
		$IMG = fread ( $f1, $BMP ['size_bitmap'] );
		$VIDE = chr ( 0 );
		$res = imagecreatetruecolor ( $BMP ['width'], $BMP ['height'] );
		$P = 0;
		$Y = $BMP ['height'] - 1;
		while ( $Y >= 0 ) {
			$X = 0;
			while ( $X < $BMP ['width'] ) {
				if ($BMP ['bits_per_pixel'] == 24)
					$COLOR = unpack ( "V", substr ( $IMG, $P, 3 ) . $VIDE );
				elseif ($BMP ['bits_per_pixel'] == 16) {
					$COLOR = unpack ( "n", substr ( $IMG, $P, 2 ) );
					$COLOR [1] = $PALETTE [$COLOR [1] + 1];
				} elseif ($BMP ['bits_per_pixel'] == 8) {
					$COLOR = unpack ( "n", $VIDE . substr ( $IMG, $P, 1 ) );
					$COLOR [1] = $PALETTE [$COLOR [1] + 1];
				} elseif ($BMP ['bits_per_pixel'] == 4) {
					$COLOR = unpack ( "n", $VIDE . substr ( $IMG, floor ( $P ), 1 ) );
					if (($P * 2) % 2 == 0)
						$COLOR [1] = ($COLOR [1] >> 4);
					else
						$COLOR [1] = ($COLOR [1] & 0x0F);
					$COLOR [1] = $PALETTE [$COLOR [1] + 1];
				} elseif ($BMP ['bits_per_pixel'] == 1) {
					$COLOR = unpack ( "n", $VIDE . substr ( $IMG, floor ( $P ), 1 ) );
					if (($P * 8) % 8 == 0)
						$COLOR [1] = $COLOR [1] >> 7;
					elseif (($P * 8) % 8 == 1)
						$COLOR [1] = ($COLOR [1] & 0x40) >> 6;
					elseif (($P * 8) % 8 == 2)
						$COLOR [1] = ($COLOR [1] & 0x20) >> 5;
					elseif (($P * 8) % 8 == 3)
						$COLOR [1] = ($COLOR [1] & 0x10) >> 4;
					elseif (($P * 8) % 8 == 4)
						$COLOR [1] = ($COLOR [1] & 0x8) >> 3;
					elseif (($P * 8) % 8 == 5)
						$COLOR [1] = ($COLOR [1] & 0x4) >> 2;
					elseif (($P * 8) % 8 == 6)
						$COLOR [1] = ($COLOR [1] & 0x2) >> 1;
					elseif (($P * 8) % 8 == 7)
						$COLOR [1] = ($COLOR [1] & 0x1);
					$COLOR [1] = $PALETTE [$COLOR [1] + 1];
				} else
					return FALSE;
				imagesetpixel ( $res, $X, $Y, $COLOR [1] );
				$X ++;
				$P += $BMP ['bytes_per_pixel'];
			}
			$Y --;
			$P += $BMP ['decal'];
		}
		fclose ( $f1 );
		return $res;
	}
}
