<?php
/**
* Универсальный класс для ресайза картинок
* @author Саша Молодцов <asid@mail.ru>
* @category External
*
*/

class ImageResizer
{
    protected $src         = false;
    protected $curFile     = false;
    protected $curFileType = false;

    private $errorCodes    = array(
        'IMAGERESIZER_INPUT_FILE_TYPE_BAD'     => 'Input file type is bad!',
        'IMAGERESIZER_INPUT_FILE_TYPE_NOT_SET' => 'Input file type not set',
        'IMAGERESIZER_INPUT_FILE_NOT_SET'      => 'Input file Not Set',
        'IMAGERESIZER_OUTPUT_FILE_TYPE_BAD'    => 'Output file format is bad!',
        'IMAGERESIZER_SRC_NOT_SET'             => 'SRC Not Set',
        'IMAGERESIZER_INPUT_FILE_NOT_READBLE'  => 'Input file not readble'
    );

    private function _error($code)
    {
        throw new Exception($code);
    }

    public function __construct($file = false)
    {
        if($file) $this->setFile($file);
        define('IMAGE_FLIP_HORIZONTAL', 1);
        define('IMAGE_FLIP_VERTICAL', 2);
        define('IMAGE_FLIP_BOTH', 3);
    }

    /**
     * set new file
     *
     * @param string $file
     * @return object (this)
     */
    public function setFile($file)
    {
        if(!file_exists($file) or !is_readable($file))
        {
            throw new Exception("IMAGERESIZER_INPUT_FILE_NOT_READBLE");
        }
        $this->curFile  = $file;
        $file_type      = $this->getFileSize();
        switch($file_type['mime'])
        {
            case 'image/jpeg':
                $this->src         = imagecreatefromjpeg($file);
                $this->curFileType = 'jpg';
                break;
            case 'image/gif':
                $this->src         = imagecreatefromgif($file);
                $this->curFileType = 'gif';
                $this->setAlpha(false, false);
                break;
            case 'image/png':
                $this->src         = imagecreatefrompng($file);
                $this->curFileType = 'png';
                $this->setAlpha(false, true);
                break;
            default:
                throw new Exception("IMAGERESIZER_INPUT_FILE_TYPE_BAD");
                return false;
        }
        return $this;
    }

    /**
     * create new src canvas
     *
     * @param integer $x
     * @param integer $y
     * @return resourse
     */
    function newSrc($x, $y)
    {
        $type = $this->getFileType();
        switch($type)
        {
            case 'png':
                $src  = imagecreatetruecolor($x, $y);
                imagesavealpha($src, true);
                imagealphablending($src, false);
                break;
            case 'gif':
                $src = imagecreate($x,$y);
                imagealphablending($src, false);
                imagecolortransparent($src,$this->getColor('ffffff',127,$src));
                break;
            default:
                $src = imagecreatetruecolor($x, $y);

        }
        return $src;
    }


    /**
    * recursive make dirs
    *
    * @param string $path
    */
    public function recursiveMkdir( $path )
    {
    	if( !file_exists( $path ) )
    	{
    	  $this->recursiveMkdir( dirname( $path ) );
    	  mkdir( $path );
    	}
    }

    /**
    * get image mime-type
    *
    * @return string
    */
    public function getFileType()
    {
        if(!$this->curFileType)
        {
            throw new Exception("IMAGERESIZER_INPUT_FILE_TYPE_NOT_SET");
        }
        return $this->curFileType;
    }


    /**
    * save image to file
    *
    * @param string $file
    * @param int $quality
    * @return object (this)
    */
    public function save($file, $quality = '75')
    {
        $source = $this->getSrc();
        if(!is_dir(dirname($file)))
        {
            $this->recursiveMkdir(dirname($file));
        }
        if(eregi('\.jpeg$|\.jpg$', $file)){
            imagejpeg( $source , $file , $quality);
        }elseif(eregi('\.gif$',         $file)){
            imagegif( $source , $file);
        }elseif(eregi('\.png$',         $file)){
            imagepng( $source , $file);

        }else{
            throw new Exception('IMAGERESIZER_OUTPUT_FILE_TYPE_BAD');
        }
        return $this->setFile($file);
    }

    /**
    * resize image to new params
    *
    * @param int $newWidth
    * @param int $newHeight
    * @param bool $proportion - keep propotions
    * @param bool $size_check - check size. If image sizes and new sizes is equal, then stop resizing
    * @param bool $fill_in_box - set color box to image
    * @param string $box_color - boxColor
    * @param bool $expand - expands original image to bigger size
    * @return this
    */
    public function resize($newWidth, $newHeight, $proportion = true, $size_check = true,  $fill_in_box = false, $box_color = 'ffffff', $expand = true)
    {
        $source  = $this->getSrc();

        $imagesx = imagesx($source);
        $imagesy = imagesy($source);

        $last_x  = $newWidth;
        $last_y  = $newHeight;

        $dist_x  = 0;
        $dist_y  = 0;

    	if($size_check AND $imagesx == $newWidth AND $imagesy == $newHeight)
    	{
            return $source;
    	}
    	if($proportion) // сохраняем пропорции?
    	{
            if($imagesx > $imagesy)
          	{
                $last_x = $newWidth;
                $last_y = $newWidth / ($imagesx / $imagesy);
                if($last_y > $newHeight)
                {
                    $last_y = $newHeight;
                    $last_x = $last_y * ($imagesx / $imagesy);
                }
          	}else{
                $last_y = $newHeight;
                $last_x = $newHeight / ($imagesy / $imagesx);
                if ($last_x > $newWidth)
                {
                    $last_x = $newWidth;
                    $last_y = $last_x * ($imagesy / $imagesx);
                }
          	}
            $newCanvasSX = $last_x;
            $newCanvasSY = $last_y;
            if(!$expand) // если расширять исходную картинку запрещено, то возвращаем её исходные размеры
            {
            	if(($imagesx > $imagesy && $imagesx < $newWidth) || ($imagesx < $imagesy && $imagesy < $newHeight))
            	{
	                $last_x = $imagesx;
	                $last_y = $imagesy;
            	}
            }
          	if($fill_in_box) // если сохраняем пропорции, то вписываем ли в коробку картинку?
          	{
                $newCanvasSX = $newWidth;
                $newCanvasSY = $newHeight;
                $dist_x      = ($newWidth - $last_x)/2;
                $dist_y      = ($newHeight - $last_y)/2;
          	}
    	}

    	$output = $this->newSrc( $newCanvasSX, $newCanvasSY );
    	if($fill_in_box) imagefill($output, 0,0, $this->getColor($box_color, 0, $output)); // вычисляем цвет из 16ричной системы в РГБ и заполняем фон
    	imagecopyresampled( $output, $source, $dist_x, $dist_y, 0, 0, $last_x, $last_y, $imagesx, $imagesy);

    	$this->src = $output;
    	return $this;
    }


  /**
   * get current file
   *
   * @return string
   */
  public function getCurFile()
  {
      if(!$this->curFile)
      {
          throw new Exception("IMAGERESIZER_INPUT_FILE_NOT_SET");
      }
      return $this->curFile;
  }

  /**
   * get currenr image resourse
   *
   * @return string
   */
  public function getSrc()
  {
      if(!is_resource($this->src))
      {
          throw new Exception("IMAGERESIZER_SRC_NOT_SET");
      }
      return $this->src;
  }
  /**
   * get image sizes
   *
   * @return array
   */
  public function getSize()
  {
    if(!is_resource($this->src))
    {
      throw new Exception("IMAGERESIZER_SRC_NOT_SET");
    }
    return array(imagesx($this->getSrc()), imagesy($this->getSrc()));
  }

  /**
   * get image file size
   *
   * @return unknown
   */
  function getFileSize()
  {
    return getimagesize($this->getCurFile());
  }

  /**
   * set transporent
   *
   * @param bool $ImageAlphaBlending = If blendmode is TRUE, then blending mode is enabled, otherwise disabled.
   * @param bool $imagesavealpha = if false alphablending is unset (in PNG ONLY)
   * @param int $imagecolortransparent = color to be the transparent color, any regions of the image in that color that were drawn previously will be transparent.
   * @return this
   */
  public function setAlpha($ImageAlphaBlending = false, $ImageSaveAlpha = true, $ImageColorTransparent = false )
  {
    $src = $this->getSrc();
    ImageAlphaBlending($src,    $ImageAlphaBlending);
    ImageSaveAlpha($src,        $ImageSaveAlpha);
    if($ImageColorTransparent)  ImageColorTransparent($src, $ImageColorTransparent);
    $this->src = $src;
    return $this;
  }


  /**
   * Flips image
   *
   * @param int $type = 1 - IMAGE_FLIP_HORIZONTAL; 2 - IMAGE_FLIP_VERTICAL; 3 - IMAGE_FLIP_BOTH;
   * @return this
   */
  public function flip($type)
  {
    $imgsrc   = $this->getSrc();
    $width    = imagesx($imgsrc);
    $height   = imagesy($imgsrc);
    $imgdest  = $this->newSrc($width, $height);

    switch( $type )
    {
    // mirror wzgl. osi
    case 1: // IMAGE_FLIP_HORIZONTAL
      for( $y=0 ; $y<$height ; $y++ )
      {
        imagecopy($imgdest, $imgsrc, 0, $height-$y-1, 0, $y, $width, 1);
      }
      break;

    case 2: // IMAGE_FLIP_VERTICAL
      for( $x=0 ; $x<$width ; $x++ )
      {
        imagecopy($imgdest, $imgsrc, $width-$x-1, 0, $x, 0, 1, $height);
      }
      break;

    case 3: // IMAGE_FLIP_BOTH
      for( $x=0 ; $x<$width ; $x++ )
      {
        imagecopy($imgdest, $imgsrc, $width-$x-1, 0, $x, 0, 1, $height);
      }
      $rowBuffer = $this->newSrc($width, 1);
      for( $y=0 ; $y<($height/2) ; $y++ )
      {
        imagecopy($rowBuffer, $imgdest  , 0, 0, 0, $height-$y-1, $width, 1);
        imagecopy($imgdest  , $imgdest  , 0, $height-$y-1, 0, $y, $width, 1);
        imagecopy($imgdest  , $rowBuffer, 0, $y, 0, 0, $width, 1);
      }

      imagedestroy( $rowBuffer );
      break;
    }
    $this->src = $imgdest;
    return $this;
  }



  /**
   * crop image
   *
   * @param int $top            - crop from top (px)
   * @param int $bottom         - crop from bottom (px)
   * @param int $left           - crop from left (px)
   * @param int $right          - crop from right (px)
   * @return object (this)
   */
  public function crop($top = 0, $bottom = 0, $left = 0, $right = 0)
  {
    $sourceSRC  = $this->getSrc();
    $sizeX      = imagesx($sourceSRC);
    $sizeY      = imagesy($sourceSRC);
    $destin     = $this->newSrc( $sizeX,  $sizeY );
    $output     = $this->newSrc( $sizeX - $left - $right,  $sizeY - $top - $bottom );
    imagecopyresampled( $destin,  $sourceSRC, 0, 0, $left, $top, $sizeX,  $sizeY, $sizeX,  $sizeY);
    imagecopyresampled( $output, $destin, 0, 0, 0, 0, $sizeX,  $sizeY, $sizeX,  $sizeY);
    $this->src  = $output;
    return $this;
  }


  /**
   * get coord for new start point (top left x and bottom right y) by text phrase
   *
   * @param string $place     - (top-left, top-right, top, top-center, middle-left, left, middle, center, middle-right, center-right, right, bottom-left, bottom-right, bottom-center, bottom)
   * @param int $sizeX        - width canvas
   * @param int $sizeY        - height canvas
   * @param int $sizeXL       - width layer
   * @param int $sizeYL       - height layer
   * @param int $marginTop    - margin top
   * @param int $marginBottom - margin bottom
   * @param int $marginLeft   - margin left
   * @param int $marginRight  - mergin right
   *
   * @return array [x] - top left Х. [y] - bottom right y
   */

  public function getCoords($place, $sizeX,$sizeY,$sizeXL,$sizeYL, $marginTop = 0, $marginBottom = 0, $marginLeft = 0, $marginRight = 0){

    switch($place){
      case 'top-left':      return array('x'=>$marginLeft,'y'=>$marginTop);                                           break;
      case 'top-right':     return array('x'=>$marginRight + $sizeX - $sizeXL,'y'=>$marginTop);                       break;
      case 'top':
      case 'top-center':    return array('x'=>($sizeX - $sizeXL)/2,'y'=>$marginTop);                                  break;
      case 'middle-left':
      case 'center-left':
      case 'left':          return array('x'=>$marginLeft,'y'=>($sizeY-$sizeYL)/2);                                   break;
      case 'middle':
      case 'center':        return array('x'=>($sizeX - $sizeXL)/2,'y'=>($sizeY - $sizeYL) / 2);                      break;
      case 'middle-right':
      case 'center-right':
      case 'right':         return array('x'=>$marginRight + $sizeX-$sizeXL,'y'=>($sizeY-$sizeYL)/2);                 break;
      case 'bottom-left':   return array('x'=>0,'y'=>$marginBottom + $sizeY - $sizeYL);                               break;
      case 'bottom-right':  return array('x'=>$marginRight + $sizeX - $sizeXL,'y'=>$marginBottom + $sizeY - $sizeYL);          break;
      case 'bottom-center':
      case 'bottom':        return array('x'=>($sizeX - $sizeXL) / 2,'y'=>$marginBottom + $sizeY - $sizeYL);          break;
      default:              return array('x'=>0,'y'=>0);                                                              break;
    }
  }


  /**
   * Add layer
   *
   * @param resourse $layerSRC    - SRC of new layer (must be smaller then bottom layer)
   * @param string $place
   * @param int    $marginTop
   * @param int    $marginBottom
   * @param int    $marginLeft
   * @param int    $marginRight
   * @param int    $alpha         - transparency 0 до 100
   * @param int    $quality_num   - quality
   * @return object (this)
   */
  public function addLayer($layerSRC, $place = 'top-left', $marginTop = 0, $marginBottom = 0, $marginLeft = 0, $marginRight = 0, $alpha = 0, $quality_num = 75 )
  {
    //ImageAlphaBlending($sourceSRC, true);
    $sourceSRC        = $this->getSrc();
    $this->setAlpha(true, true, false);
    $sizeX            = imagesx($sourceSRC);
    $sizeY            = imagesy($sourceSRC);
    $sizeXL           = imagesx($layerSRC);
    $sizeYL           = imagesy($layerSRC);
    $coords           = $this->getCoords($place,$sizeX,$sizeY,$sizeXL,$sizeYL, $marginTop, $marginBottom, $marginLeft, $marginRight);
    if($alpha > 0){
      imagecopymerge($sourceSRC, $layerSRC, $coords['x'], $coords['y'], 0, 0, $sizeXL, $sizeYL, $alpha);
    }else{
      ImageCopy($sourceSRC, $layerSRC, $coords['x'], $coords['y'], 0, 0, $sizeXL, $sizeYL);
    }
    $this->src    = $sourceSRC;
    return $this;
  }

  /**
   * get color
   *
   * @param 16 bit color $color
   * @param int $alpha - (0) from 0 to 127. 127 - is a full transparent
   * @param resource $src
   * @return resourse color RGB
   */
  public function getColor($color = 'FFFFFF',$alpha = 0, $src = false)
  {
    if(!$src) $src = $this->getSrc();
    sscanf($color, "%2x%2x%2x", $red, $green, $blue);
    return imagecolorallocatealpha($src, $red, $green, $blue, $alpha);
  }

}


?>