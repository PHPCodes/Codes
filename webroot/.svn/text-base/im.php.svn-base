<?php
/**
 * @package printeable
 * 
 * sample download tool 
 *
 */
 
	
 class tool {
 	
 	public static function subdir ($s) {
 		$s .= '';
 		$f0 = ''; $f1=''; $_s = '';
 		if (strlen($s)<=2) {
 			$f0 = substr($s,0,2);
 		};
 		 
 		if (strlen($s)>2) {
 			$f0 = substr($s,0,2);
 			$f1 = substr($s,2,2);
 		}
 		 
 		if ($f1!='') {
 			$_s = $f0 . '/' . $f1 . '/';
 		} else {
 			$_s = $f0 . '/';
 		}
 	
 		return $_s;
 	}
 	
 	public static function request($k) {
       $v = $_GET[$k]; if (!isset($v)) $v = $_POST[$v]; // prefered GET, if not POST 
       return $v;  		
 	}
 	
 	public static function escape ($f) {
 		$f = str_replace ("..","",$f); // for security
 		return $f;
 	}
 	
 	public static function ext ($s) {
 		$_s = explode (".",$s);
 		if (!is_array($_s)) return '';
 		$ext = $_s[count($_s)-1];
 		return $ext;
 	}
 	
 	public static function httpheader ($fname) {
 		if ($length=='') $length=filesize ($fname);
 		$type = self::ext ($fname);
 		 
 		switch( strtolower ($type) ){
 			case "pdf": $ctype="application/pdf";                break;
 			case "exe": $ctype="application/octet-stream";       break;
 			case "zip": $ctype="application/zip";                break;
 			case "doc": $ctype="application/msword";             break;
 			case "xls": $ctype="application/vnd.ms-excel";       break;
 			case "ppt": $ctype="application/vnd.ms-powerpoint";  break;
 			case "gif": $ctype="image/gif";                      break;
 			case "png": $ctype="image/png";                      break;
 			case "jpg": $ctype="image/jpg";                      break;
 			case "htm": $ctype="application";                    break;
 			case "txt": $ctype="application";                    break;
 			case "swf": $ctype="application/x-shockwave-flash";  break;
 			default:    $ctype="application/force-download";
 		};
 	
 		
 		header ("Content-Disposition: inline; filename=".basename($fname).";" );
 		header ("Content-type: $ctype; name=\"". basename($fname) . "\"");
 		header ("Content-Transfer-Encoding: binary");
 		header ("Content-Length: $length");
 		header ("Content-Description: Generated Data" );
 	    
 		return true;
 	}
 	
 	
 }
 
 class manip_gd { 
 	
 	public static function &load ($fname) {
 		if (!file_exists($fname)) throw new Exception ('file not found');
 		
 		$params = self::size($fname);
 		$mime = $params['mime'];
 		 
 		switch ($mime) {
 			case 'image/jpeg':  $im = imageCreateFromJpeg($fname); $type='jpg'; break;
 			case 'image/gif':   $im = imageCreateFromGif($fname);  $type='gif'; break;
 			case 'image/png':   $im = imageCreateFromPNG($fname);  $type='png'; break;
 			case 'image/bmp':   $im = imagecreatefromwbmp($fname); $type='bmp'; break;
 			default:
 				throw new Exception ('image format not supported');
 		}
 		 
 		imagealphablending($im, true);
 		imagesavealpha($im, true);
 		 
 		return $im;
 	}
 	
 	public static function ratio ($sw, $sh, $dw, $dh, $t='') {
 		if ($dw==0 || $dh==0) return array ($sw,$sh);   // si no se pasan nuevos parámetros, se queda como está.
 		if ($dw>$sw && $dh>$sh) return array ($sw,$sh); // si es más pequeña la imagen, se queda como está.
 		 
 		$r = $sw/$sh;
 		if ($r>1) {
 			$dh=$dw*(1/$r);
 		} else {
 			$dw=$dh*$r;
 		}
 		return array (floor($dw),floor($dh));
 	}
 	
 	public static function &size ($fname, &$im='') {
 		if (!file_exists($fname)) return false;
 		return getimagesize($fname);
 	}
 	

 	/**
 	 * @Param w width of cut
 	 * @Param h high cutout
 	 * @Param x coord left. sup. horiz.
 	 * @Param y coord left. sup. vert.
 	 */
 	public static function &crop (&$im, $w, $h, $x=0, $y=0) {
 		$wo = imagesx ($im);
 		$ho = imagesy ($im);
 		 
 		$im2 = imagecreatetruecolor ($w, $h);
 		imagecopy ($im2, $im, 0, 0, $x, $y, $w, $h);
 		imagedestroy ($im);
 		return $im2;
 	}
 	
 	
 	public static function &resize (&$im, $w, $h) {
 		$wo = imagesx ($im);
 		$ho = imagesy ($im);
 		list ($nw,$nh) = self::ratio ($wo,$ho,$w,$h);
 		$im2 = imagecreatetruecolor  ($nw,$nh);
 		imagecopyresampled ($im2, $im, 0, 0, 0, 0, $nw, $nh, $wo, $ho);
 		return @$im2;
 	}
 	
 	
 	public static function &cropThumbnail (&$im, $w, $h) {
 		$wo = imagesx ($im);
 		$ho = imagesy ($im);
 		$ro = $wo/$ho;
 		
 		$nw = $ro / $w;
 		$nh = $ro * $h;
 			
 		if ($nw<$w)  { $nw = $w; $nh = $nw / $ro; };
 		if ($nh<$h)  { $nh = $h; $nw = $nh * $ro; };
 		
 		$im = self::resize ($im, $nw, $nh);
 		
 		$wo = imagesx ($im);
 		$ho = imagesy ($im);
 		$xf = 0; $hf = 0;
 		if ($wo>$w) $xf = abs(($wo-$w) /2);
 		if ($ho>$h) $hf = abs(($ho-$h) /2);
 		
 		$im = self::crop ($im, $w, $h, $xf, $hf);
 		
 		
 		return @$im;
 	}
 	
 	

 	/**
 	 * Resize and rounded corners, "iconizes" image.
 	 */
 	public static function &icon (&$im, $w, $h, $r) {
 		$im = self::crop ($im, $w, $h);
 		$im = self::resize ($im, $w, $h);
 		if ($w>40 && $h>40) $im = self::filter ($im);
 		return $im;
 	}
 	
 	
 	public static function &filter (&$im) {
 		$x = imagesx($im);
 		$y = imagesy($im);
 		if ($x>80) {
 			$r = 16;
 		} else {
 			$r = 8;
 		}
 		$im2 = imagecreatetruecolor ($x,$y);
 		$im2 = $this->round_corners ($im2, $r);
 			
 		$im3 = imagecreatetruecolor ($x,$y);
 		$imb = imagecolorallocatealpha  ($im3, 0, 0, 0, 127);
 		$imb2 = imagecolorallocate      ($im3, 1, 1, 1);
 		imagefill ($im3, 0,0, $imb);
 		imagecolortransparent ($im3, $imb);
 			
 		for ($i=0;$i<$x;$i++) {
 			for ($j=0;$j<$y;$j++) {
 				$imc1 = imagecolorat($im,  $i, $j);
 				$imc2 = imagecolorat($im2, $i, $j);
 	
 				$r  = ( $imc2 >> 16 ) & 0xFF;  $g = ( $imc2 >> 8 ) & 0xFF;  $b = $imc2 & 0xFF;
 				$r2 = ( $imc1 >> 16 ) & 0xFF;  $g2 = ( $imc2 >> 8 ) & 0xFF;  $b2 = $imc1 & 0xFF;
 				if ($r2==0 && $g2==0 && $b2==0) {
 					imagesetpixel  ($im3, $i, $j, $imb2);
 				} else if ($r==0 && $g==0 && $b==0) {
 					imagesetpixel  ($im3, $i, $j, $imc1);
 				}
 	
 			}
 		}
 			
 		imagedestroy ($im2);
 		imagedestroy ($im);
 		return $im3;
 	}

 	public static function show (&$im, $mime=null, $fname='') {
 		$ext = 'unknow';
 		if ($fname=='') $fname='img';
 		if ($mime=='')  $mime = 'image/jpeg';
 		switch ($mime) {
 			case 'image/jpeg': case 'jpeg': case 'jpg': $ext='.jpg'; break;
 			case 'image/gif':  case 'gif':  $ext='.gif'; break;
 			case 'image/png':  case 'png':  $ext='.png'; break;
 			default:           $ext='.jpg'; break;
 		}
 			
 		header ("Content-type: $mime");
 		header ("Content-Transfer-Encoding: binary");
 		header ("Content-Description: Generated Data" );
 		 
 		switch ($mime) {
 			case 'image/jpeg':  imagejpeg ($im); break;
 			case 'image/gif':   imagegif ($im);  break;
 			case 'image/png':   imagepng ($im);  break;
 			default:            imagejpeg ($im); break;
 		}
 		 
 	}
 	
 	public static function save (&$im, $outfile) {
 		$ext = self::extension ($outfile);
 		switch ($ext) {
 			case 'jpeg': case'jpg': case 'JPG': imagejpeg ($im, $outfile, 100); break;
 			case 'gif':  case 'GIF':            imagegif ($im, $outfile);  break;
 			case 'png':  case 'PNG':            imagepng ($im, $outfile);  break;
 			default:                            imagejpeg ($im, $outfile, 100); break;
 		}
 	}
 	
 	
 }
 
 class manip {
 	
 	public static function &load ($fname) {
 		$im = new Imagick($fname);
 		return $im;
 	}
 	
 	public static function &size ($fname, &$im='') {
 		if ($im=='') $im = new Imagick ($fname);
 		$size = $im->getImageGeometry ();
 		$im->destroy ();
 		return $size;
 	}
 	
 	/**
 	 * @Param w width of cut
     * @Param h high cutout
     * @Param x coord left. sup. horiz.
     * @Param y coord left. sup. vert.
 	 */
 	public static function &crop (&$im, $w, $h, $x=0, $y=0) {
 		$im->cropImage ($w, $h, $x, $y);
 		return $im;
 	}
 	
 	public static function &resize (&$im, $w, $h) {
 		if ($w=='' || $h=='') return $im;
 		$im->resizeImage ($w, $h, Imagick::FILTER_LANCZOS,1);
 		$im->unsharpMaskImage(2 , 0.5 , 1 , 0.5);
 		$im->normalizeImage();
 		$im->enhanceImage ();
 		return $im;
 	}
 	
 	/**
 	 * Resize and rounded corners, "iconizes" image.
 	 */
 	public static function &icon (&$im, $w, $h, $r) {
 		$im->thumbnailImage($w, $h);
 		$im->roundCorners ($r);
 		return $im;
 	}
 	
 	public static function cropThumbnail (&$im, $w, $h) {
 		$geo = $im->getImageGeometry();
 		$im->setCompression(Imagick::COMPRESSION_LZW);
 		 
 		if(($geo['width']/$w) < ($geo['height']/$h))  {
 			$im->cropImage($geo['width'], floor($h*$geo['width']/$w), 0, (($geo['height']-($h*$geo['width']/$w))/2));
 	
 		} else {
 			$im->cropImage(ceil($w*$geo['height']/$h), $geo['height'], (($geo['width']-($w*$geo['height']/$h))/2), 0);
 		}
 		 
 		$im->ThumbnailImage($w,$h,true);
 	}

 	
 /**
  * Cut an image, clipping data are relative to a size of
  * Image rw, rh.
  * @Param fname location of the image file
  * @Param w width of cut
  * @Param h high cutout
  * @Param x coord. left
  * @Param y coord. sup
  * @Param rw relative width of the image
  * @Param high rh on image
  */ 	
  public static function &crop_relative (&$im, $w, $h, $x, $y, $rw, $rh) {
 		try {
 			if ($w<=0 || $h<=0) return false;
 			if ($w==$rw && $h==$rh) return self::crop ($im, $w, $h, $x, $y);
 			$size = $im->getImageGeometry ();
 			$sw = $size['width'];
 			$sh = $size['height'];
 				
 			$dw = ($sw/$rw) * $w;
 			$dh = ($sh/$rh) * $h;
 				
 			$dx  = ($sw/$rw) * $x;
 			$dy  = ($sh/$rh) * $y;
 	
 			$im->cropImage ($dw, $dh, $dx, $dy);
 	
 			return $im;
 		} catch (Exception $e) {
 			return false;
 		}
 	}
 	
 	public static function show (&$im, $mime=null, $fname='') {
 		$ext = 'unknow';
 		if ($fname=='') $fname='img';
 			
 		if ($mime=='')  $mime = 'image/jpeg';
 		switch ($mime) {
 			case 'image/jpeg': case 'jpeg': case 'jpg': $ext='.jpg'; break;
 			case 'image/gif':  case 'gif':  $ext='.gif'; break;
 			case 'image/png':  case 'png':  $ext='.png'; break;
 			default:            $ext='.jpg'; break;
 		}
 	
 		header ("Content-type: $mime");
 		header ("Content-Transfer-Encoding: binary");
 		header ("Content-Description: Generated Data" );
 		echo $im;
 	}
 	
 	public static function save    (&$im, $outfile) {
 		$p = dirname ($outfile);
 		if (!is_dir($p)) return false;
 		return file_put_contents ($outfile, $im);
 	}
 	
 	
 }
 
 class down { 

   public static $default  = 'default.jpg';
   public static $w=0,$h=0;
   public static $dirbase  = '/img/data/';
   public static $fcache   = '';
   public static $library  = 'imagick';
   
   // only for development/test  
   //public static $db = array ('host'=>'loc', 'user'=>'bptable', 'pass'=>'bptable593', 'database'=>'beta2_printeable');
   
   public static function from_cache ($f, $w, $h) {
   	  $k = md5 ($f.$w.$h);
   	  $ext = tool::ext($f);
   	  $d = self::$dirbase.'/cache/'.tool::subdir($k);
   	  $p = $d. $k.'.'.$ext;
   	  if (!is_dir($d)) mkdir ($d, 0777, true);
   	  self::$fcache = $p;
   	  //echo $p;die;
   	  if (!file_exists($p)) return false;
   	  $m1 = filemtime ($p);
   	  $m2 = filemtime ($f);
   	  if ($m2>$m1) return false;
   	  
   	  switch ($ext) {
   	  	case 'image/jpeg': case 'jpeg': case 'jpg': $ext='.jpg'; break;
   	  	case 'image/gif':  case 'gif':  $ext='.gif'; break;
   	  	case 'image/png':  case 'png':  $ext='.png'; break;
   	  	default:            $ext='.jpg'; break;
   	  }
   	  
   	  header ("Content-type: $mime");
   	  header ("Content-Transfer-Encoding: binary");
   	  header ("Content-Description: Generated Data" );
   	  
   	  readfile ($p);
   	  return true;
   }
   
  
   
   public static function resize ($f, $w, $h) {
   	  if (self::from_cache ($f, $w, $h)) return true;
   	  
   	  if (self::$library=='imagick') {
   	   $im = manip::load ($f);
   	   manip::cropThumbnail ($im, $w, $h);
   	   manip::show ($im);
   	   file_put_contents (self::$fcache, $im);
   	   
   	  } else {
   	   $im = manip_gd::load ($f);
   	   // $im = manip_gd::resize ($im, $w, $h);
   	   $im = manip_gd::cropThumbnail ($im, $w, $h);
   	   manip_gd::show ($im);
   	   manip_gd:save ($im, self::$fcache);
   	  }
   	  
   }
   

   // only for development/test 
   public static function remap ($f) {
   	
     $db = array ('host'=>'192.168.1.252', 'user'=>'pluto', 'pass'=>'pluto', 'database'=>'cybercoupon');
   	  $dblink = mysql_connect($db['host'], $db['user'], $db['pass']);
   	  if (!$dblink) return false;
   	  mysql_select_db ($db['database']);   	  
   	  
   	  /*$dblink = mysql_connect (self::$db['host'], self::$db['user'], self::$db['pass']);
   	  if (!$dblink) return false;
   	  mysql_select_db (self::$db['database']);*/
   	 
   	  $elems = explode ("/",$f);
   	  //echo "<pre>";print_r($elems);die;
   	  if(!is_array($elems) || count($elems)<=0) return false;
   	  $end_elems=count($elems)-1;
   	  switch ($elems[0]) {
   	  		
   	  	  case 'sliders':
   	  		$_f = $elems[count($elems)-1];
   	  		$slider_img=explode('_',$_f);
   	  		$slider_id=$slider_img[1];
   	  		if ($slider_id!='') {
   	  			$id = $slider_id;
   	  			$p = 'sliders/'.tool::subdir($id).$_f;
   	  			return $p;
   	  		}
   	  		break;
   	  
   	  		case 'deals':
   	  		$_f = $elems[count($elems)-1];
   	  		$slider_img=explode('_',$_f);
   	  		$slider_id=$slider_img[1];
   	  		if ($slider_id!='') {
   	  			$id = $slider_id;
   	  			$p = 'deals/'.tool::subdir($id).$_f;
   	  			return $p;
   	  		}
   	  		break;
   	  		
   	  		case 'CMS':
   	  		$_f = $elems[count($elems)-1];
   	  		$slider_img=explode('_',$_f);
   	  		$slider_id=$slider_img[1];
   	  		if ($slider_id!='') {
   	  			$id = $slider_id;
   	  			$p = 'CMS/'.tool::subdir($id).$_f;
   	  			return $p;
   	  		}
   	  		break;
   	  		
   	  		case 'first_step_approval':
   	  		$_f = $elems[count($elems)-1];
   	  		$slider_img=explode('_',$_f);
   	  		$slider_id=$slider_img[1];
   	  		if ($slider_id!='') {
   	  			$id = $slider_id;
   	  			$p = 'first_step_approval/'.tool::subdir($id).$_f;
   	  			return $p;
   	  		}
   	  		break;
   	  		
   	  		case 'admin':
   	      $_f = $elems[count($elems)-1];
   	  		if (preg_match ("/(\d*)/",$_f,$regs)) {
   	  			$id = $regs[1];
   	  			$p = 'admin/'.tool::subdir($id).$_f;
   	  			return $p;
   	  		}
   	  		break;
   	  		
   	  	
   	  		
           case 'temp':
   	  		 $_f = $elems[count($elems)-1];
   	  			$p = 'temp/'.$_f;
   	  			return $p;
   	  		break;
   	  		
   	  		default:
   	  		   	  	$p = 'default.jpg';
   	  			    return $p;	
   	  		
   	  }
   	  
   	  return false;
   }
   
   public static function load () {
    ini_set("memory_limit","64M");
    error_reporting (E_ALL ^E_NOTICE);
    $dirbase  = realpath (dirname(__FILE__). '/img/data/');
    self::$dirbase = $dirbase;
    //echo $dirbase;die;
    // $f =  base64_decode (tool::request('f')); // base64 encode file name and path
    $f  =  tool::request('f');
    $l  =  tool::request('l');
    $_f = self::remap($f);
    if ($_f!=false) $f = $_f;
    $fname = $dirbase . '/' . tool::escape($f);
    //echo $fname;die;
    if (self::$w!=0) { $w = self::$w; } else { $w = tool::request('w'); };    // image prefered with 
    if (self::$h!=0) { $h = self::$h; } else { $h = tool::request('h'); };   // image prefered height
    if ($l!='' && ($l=='imagick' || $l=='gd')) { self::$library=$l;  };
    $t = tool::request('t');    // transform operation (scaling, maintain proportion, circunscribe, etc, .. )
    $c = tool::request('c');    // use cache yes/no 

    if (!file_exists($fname) || is_dir($fname)) $fname = $dirbase . '/' . self::$default;
    
    if (!file_exists($fname) || is_dir($fname)) {
      echo $fname. "\n";
 	  echo  ' file not found .. ';
 	  die ();
    }
    
    if ($w>0 && $h>0) {
    	return self::resize ($fname, $w, $h);
    }
    
    // code for image manipulation if needed .. 
    // code for download
    tool::httpheader($fname);
    readfile ($fname);
    
  }
  
 };
 
 down::load();
 
 
 
 




