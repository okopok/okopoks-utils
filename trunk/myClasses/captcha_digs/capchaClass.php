<?php
class capcha {
	var $w, $h, $code, $out, $file, $img;

	function capcha($w, $h) {
		session_start();
		if (!$w || !$h || !$_SESSION['captcha_code']) exit;
		define(__root__, $_SERVER['DOCUMENT_ROOT']);
		$this->w = $w;
		$this->h = $h;
		$this->code = $_SESSION['captcha_code'];
	}

	function setImagesDir($path)
	{
	  define('__imagesDir__', __root__.$path);
	}
	function setFontsDir($path)
	{
	  define('__fontsDir__', __root__.$path);
	}

	function show() {
		$this->create();
		ob_start();
		imageGif($this->out);
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Content-type: image/gif");
		ob_end_flush();
		imageDestroy($this->out);
	}

	function toFile() {
	  if(!defined('__imagesDir__')) define('__imagesDir__', dirname(__FILE__).'/images/capcha/');
	  @mkdir(__imagesDir__, 0777, true);
		$this->create();

		$rand = rand(1, 10);
        $this->file = 'capcha_'.$rand.'.gif';
        #$this->file = 'capcha.gif';
        @unlink(__imagesDir__.$this->file);
		imageGif($this->out, __imagesDir__.$this->file);
		imageDestroy($this->out);
	}

	function create() {
    if(!defined('__fontsDir__')) define('__fontsDir__', dirname(__FILE__).'/fonts/');

		$alphabet        = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!
		$allowed_symbols = "0123456789abcdefghijklmnopqrstuvwxyz"; # do not change without changing font files!
		#$allowed_symbols = "23456789abcdeghkmnpqsuvxyz"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)

		$length = strlen($this->code);
		$fluctuation_amplitude = 5;

		$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
		$background_color = array(255, 255, 255);

		$fonts = array();
		$fontsdir = __fontsDir__;
		if ($handle = opendir($fontsdir)) {
			while (false !== ($file = readdir($handle))) {
				if (preg_match('/\.png$/i', $file)) {
					$fonts[]=$fontsdir.'/'.$file;
				}
			}
		    closedir($handle);
		}

		$alphabet_length=strlen($alphabet);

		while(true) {
			// generating random keystring


			$font_file=$fonts[mt_rand(0, count($fonts)-1)];
			$font=imagecreatefrompng($font_file);
			imagealphablending($font, true);
			$fontfile_width=imagesx($font);
			$fontfile_height=imagesy($font)-1;
			$font_metrics=array();
			$symbol=0;
			$reading_symbol=false;

			// loading font
			for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
				$transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

				if(!$reading_symbol && !$transparent){
					$font_metrics[$alphabet{$symbol}]=array('start'=>$i);
					$reading_symbol=true;
					continue;
				}

				if($reading_symbol && $transparent){
					$font_metrics[$alphabet{$symbol}]['end']=$i;
					$reading_symbol=false;
					$symbol++;
					continue;
				}
			}

			$this->img = imagecreatetruecolor($this->w, $this->h);
			imagealphablending($this->img, true);
			$white=imagecolorallocate($this->img, 255, 255, 255);
			$black=imagecolorallocate($this->img, 0, 0, 0);

			imagefilledrectangle($this->img, 0, 0, $this->w-1, $this->h, $white);

			// draw text
			$x=1;
			for($i=0;$i<$length;$i++){
				$m=$font_metrics[$this->code{$i}];

				$y=mt_rand(-$fluctuation_amplitude, $fluctuation_amplitude)+($this->h - $fontfile_height)/2+2;

				if($no_spaces){
					$shift=0;
					if($i>0){
						$shift=1000;
						for($sy=7;$sy<$fontfile_height-20;$sy+=1){

							for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
				        		$rgb=imagecolorat($font, $sx, $sy);
				        		$opacity=$rgb>>24;
								if($opacity<127){
									$left=$sx-$m['start']+$x;
									$py=$sy+$y;
									if($py>$this->h) break;
									for($px=min($left,$this->w-1);$px>$left-1 && $px>=0;$px-=1){
						        		$color=imagecolorat($this->img, $px, $py) & 0xff;
										if($color+$opacity<190){
											if($shift>$left-$px){
												$shift=$left-$px;
											}
											break;
										}
									}
									break;
								}
							}
						}
						if($shift==1000){
							$shift=mt_rand(4,6);
						}

					}
				}else{
					$shift=1;
				}
				imagecopy($this->img, $font, $x-$shift, $y, $m['start'], 1, $m['end']-$m['start'], $fontfile_height);
				$x += $m['end']-$m['start']-$shift;
			}
			if($x<$this->w-1) break; // fit in canvas

		}
		$center=$x/2;

		// credits. To remove, see configuration file
		$this->out = imagecreatetruecolor($this->w, $this->h);
		$foreground=imagecolorallocate($this->out, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
		$background=imagecolorallocate($this->out, $background_color[0], $background_color[1], $background_color[2]);
		imagefilledrectangle($this->out, 0, 0, $this->w, $this->h, $background);
		imagefilledrectangle($this->out, 0, $this->h, $this->w, $this->h, $foreground);

		// periods
		$rand1=mt_rand(750000,1200000)/10000000;
		$rand2=mt_rand(750000,1200000)/10000000;
		$rand3=mt_rand(750000,1200000)/10000000;
		$rand4=mt_rand(750000,1200000)/10000000;
		// phases
		$rand5=mt_rand(0,31415926)/10000000;
		$rand6=mt_rand(0,31415926)/10000000;
		$rand7=mt_rand(0,31415926)/10000000;
		$rand8=mt_rand(0,31415926)/10000000;
		// amplitudes
		$rand9=mt_rand(330,420)/110;
		$rand10=mt_rand(330,450)/110;

		//wave distortion

		for($x=0;$x<$this->w;$x++){
			for($y=0;$y<$this->h;$y++){
				$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$this->w/2+$center+1;
				$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

				if($sx<0 || $sy<0 || $sx>=$this->w-1 || $sy>=$this->h-1){
					continue;
				}else{
					$color=imagecolorat($this->img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($this->img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($this->img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($this->img, $sx+1, $sy+1) & 0xFF;
				}

				if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
					continue;
				}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
					$newred=$foreground_color[0];
					$newgreen=$foreground_color[1];
					$newblue=$foreground_color[2];
				}else{
					$frsx=$sx-floor($sx);
					$frsy=$sy-floor($sy);
					$frsx1=1-$frsx;
					$frsy1=1-$frsy;

					$newcolor=(
						$color*$frsx1*$frsy1+
						$color_x*$frsx*$frsy1+
						$color_y*$frsx1*$frsy+
						$color_xy*$frsx*$frsy);

					if($newcolor>255) $newcolor=255;
					$newcolor=$newcolor/255;
					$newcolor0=1-$newcolor;

					$newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
					$newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
					$newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
				}

				imagesetpixel($this->out, $x, $y, imagecolorallocate($this->out, $newred, $newgreen, $newblue));
			}
		}
	}
}
?>