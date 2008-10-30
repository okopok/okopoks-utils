<?php
/**
* ������������� ����� ��� ������� ��������
* @author ���� �������� <asid@mail.ru>
* @since .09.2006
* @version 1.04.03.2008
*
*/

class ImageResizer
{
    protected $src         = false;
    protected $curFile     = false;
    protected $curFileType = false;
    
    public function __construct($file = false)
    {
        if($file) $this->setFile($file);
        define('IMAGE_FLIP_HORIZONTAL', 1);
        define('IMAGE_FLIP_VERTICAL', 2);
        define('IMAGE_FLIP_BOTH', 3);
    }
    
    public function setFile($file)
    {
        if(!file_exists($file) or !is_readable($file))
        {
            throw new Exception("File $file not readable");
        }
        $this->curFile  = $file;
        $file_type      = $this->getSize();
        switch($file_type['mime'])
        {
            case 'image/jpeg': 
                $this->src         = imagecreatefromjpeg($file); 
                $this->curFileType = 'jpg';
                break;
            case 'image/gif':  
                $this->src         = imagecreatefromgif($file); 
                $this->curFileType = 'gif';
                break;
            case 'image/png':  
                $this->src         = imagecreatefrompng($file);  
                $this->curFileType = 'png';
                break;            
            default:
                throw new Exception("Bad file type");
                return false;
        }
        return $this;
    }
    /**
    * ������� �������� ����� ����������
    *
    * @param string $path ����
    */
    public function RecursiveMkdir( $path )
    {
    	if( !file_exists( $path ) )
    	{
    	  $this->RecursiveMkdir( dirname( $path ) );
    	  mkdir( $path );
    	}
    }

    /**
    * ���������� ��� ����� �� mime ����
    *
    * @param string $filename - ���� �� �����
    * @return string
    */
    public function getFileType($filename)
    {
        if(!$this->curFileType)
        {
            throw new Exception("File type not set");
        }
        return $this->curFileType;
    }


    /**
    * ������� � ���� ������� ������ �����.
    * ������ ��������� ���������� ����� � ����� ������ ������
    *
    * @param string $file     - ���� ������ �����
    * @param resourse $source - ������ �����
    * @param int $quality     - �������� ����� �� 0 �� 100
    * @return bool
    */
    public function save($file, $quality = '75')
    {
        $source = $this->getSrc();
        if(eregi('\.jpeg$|\.jpg$', $file)){
            imagejpeg( $source , $file , $quality); 
        }elseif(eregi('\.gif$',         $file)){
            imagegif( $source , $file , $quality);  
        }elseif(eregi('\.png$',         $file)){
            imagepng( $source , $file , $quality);  
        }else{
            throw new Exception('this file format is not supported');
        }
        return $this;
    }

    /**
    * ������� ��������� �������� (�������)
    *
    * @param int $resize_x ������ ��������
    * @param int $resize_y ������ ��������
    * @param bool $proportion - ��������� �� ��������� (true)
    * @param bool $size_check - ��������� �� ������ ������� � �������� �������� (true)
    * @param bool $fill_in_box - ��������� �� � ����� �������� (false)
    * @param string $box_color - ���� ����� (ffffff)
    * @param bool $expand - ��������� �� �������� �������� (false)
    * @return object (this)
    */
    public function resize($resize_x, $resize_y, $proportion = true, $size_check = true,  $fill_in_box = false, $box_color = 'ffffff', $expand = true)
    {
        $source  = $this->getSrc();
        
        $imagesx = imagesx($source);
        $imagesy = imagesy($source);
        
        $last_x  = $resize_x;
        $last_y  = $resize_y;
        
        $dist_x  = 0;
        $dist_y  = 0;
    
    	if($size_check AND $imagesx == $resize_x AND $imagesy == $resize_y)
    	{
            return $source;
    	}
    	if($proportion) // ��������� ���������?
    	{
            if($imagesx > $imagesy)
          	{
                $last_x = $resize_x;
                $last_y = $resize_x / ($imagesx / $imagesy);
                if($last_y > $resize_y)
                {
                    $last_y = $resize_y;
                    $last_x = $last_y * ($imagesx / $imagesy);
                }
          	}else{
                $last_y = $resize_y;
                $last_x = $resize_y / ($imagesy / $imagesx);
                if ($last_x > $resize_x)
                {
                    $last_x = $resize_x;
                    $last_y = $last_x * ($imagesy / $imagesx);
                }
          	}
            $newCanvasSX = $last_x;
            $newCanvasSY = $last_y;
            if(!$expand AND ($imagesx < $resize_x OR $imagesy < $resize_y)) // ���� ��������� �������� �������� ���������, �� ���������� � �������� �������
            {
                $last_x = $imagesx;
                $last_y = $imagesy;
            }
          	if($fill_in_box) // ���� ��������� ���������, �� ��������� �� � ������� ��������?
          	{
                $newCanvasSX = $resize_x;
                $newCanvasSY = $resize_y;
                $dist_x      = ($resize_x - $last_x)/2;
                $dist_y      = ($resize_y - $last_y)/2;
          	}
    	}
    
    	$output = imagecreatetruecolor( $newCanvasSX, $newCanvasSY );
    	if($fill_in_box) imagefill($output, 0,0, $this->getColor($box_color, $output)); // ��������� ���� �� 16������ ������� � ��� � ��������� ���
    	imagecopyresampled( $output, $source, $dist_x, $dist_y, 0, 0, $last_x, $last_y, $imagesx, $imagesy);
    	
    	$this->src = $output;
    	return $this;
    }


    
  public function getCurFile()
  {
      if(!$this->curFile)
      {
          throw new Exception("File Not Set");
      }
      return $this->curFile;
  }

  public function getSrc()
  {
      if(!is_resource($this->src))
      {
          throw new Exception("SRC Not Set");          
      }
      return $this->src;
  }
  /**
   * �������� ������ ����������
   *
   * @param string $filename - ���� �� ����������
   * @return array           - ������ � ��������� � ������� � ��������
   */
  public function getSize()
  {      
    return getimagesize($this->getCurFile());
  }

  /**
   * ������������� ������������
   *
   * @param resourse $src
   * @param bool $ImageAlphaBlending = If blendmode is TRUE, then blending mode is enabled, otherwise disabled.
   * @param bool $imagesavealpha = if false alphablending is unset (in PNG ONLY)
   * @param int $imagecolortransparent = color to be the transparent color, any regions of the image in that color that were drawn previously will be transparent.
   * @return resourse
   */
  public function setAlpha($ImageAlphaBlending = false, $imagesavealpha = true, $imagecolortransparent = false )
  {
    $src = $this->getSrc();
    ImageAlphaBlending($src,    $ImageAlphaBlending);
    imagesavealpha($src,        $imagesavealpha);
    imagecolortransparent($src, $imagecolortransparent);
    $this->src = $src;
    return $this;
  }

  
  /**
   * Flips image
   *
   * @param resource $imgsrc
   * @param int $type = 1 - IMAGE_FLIP_HORIZONTAL; 2 - IMAGE_FLIP_VERTICAL; 3 - IMAGE_FLIP_BOTH;
   * @return resource
   */
  public function flip($type)
  {
    $imgsrc   = $this->getSrc();
    $width    = imagesx($imgsrc);
    $height   = imagesy($imgsrc);
    $imgdest  = imagecreatetruecolor($width, $height);

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
      $rowBuffer = imagecreatetruecolor($width, 1);
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
   * �������� �� ������ �������� �������� ���-�� ��������
   *
   * @param resourse $sourceSRC - �������� ����
   * @param int $top            - ������� ������ ������
   * @param int $bottom         - ������� ������ �����
   * @param int $left           - ������� ������ �����
   * @param int $right          - ������� ������ ������
   * @param int $quality_num    - �������� ��������
   * @return resourse
   */
  public function crop($top = 0, $bottom = 0, $left = 0, $right = 0)
  {
    $sourceSRC  = $this->getSrc();
    $sizeX      = imagesx($sourceSRC);
    $sizeY      = imagesy($sourceSRC);
    $destin     = imagecreatetruecolor( $sizeX,  $sizeY );
    $output     = imagecreatetruecolor( $sizeX - $left - $right,  $sizeY - $top - $bottom );
    imagecopyresampled( $destin,  $sourceSRC, 0, 0, $left, $top, $sizeX,  $sizeY, $sizeX,  $sizeY);
    imagecopyresampled( $output, $destin, 0, 0, 0, 0, $sizeX,  $sizeY, $sizeX,  $sizeY);
    $this->src  = $output;
    return $this;
  }


  /**
   * �������� ���������� ��� ���������� �� �������� �����
   *
   * @param string $place     - ����� ��� ��������� ��������� ������������� ��������� �����.
   * top-left, top-right, top, top-center, middle-left, left, middle, center, middle-right, center-right, right, bottom-left, bottom-right, bottom-center, bottom
   * @param int $sizeX        - ������ ������� ��������
   * @param int $sizeY        - ������ ������� ���������
   * @param int $sizeXL       - ������ ������ ����
   * @param int $sizeYL       - ������ ������ ����
   * @param int $marginTop    - ������ ������
   * @param int $marginBottom - ������ �����
   * @param int $marginLeft   - ������ �����
   * @param int $marginRight  - ������ ������
   *
   * @return array [x] - ���������� �� ��� �. [y] - ���������� �� ��� y
   */

  public function getCoords($place,$sizeX,$sizeY,$sizeXL,$sizeYL, $marginTop = 0, $marginBottom = 0, $marginLeft = 0, $marginRight = 0){

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
   * ����������� ���� �������� �� ������.
   *
   * @param resourse $sourceSRC     - SRC ���
   * @param resourse $layerSRC      - SRC �� ��� ����������� (������ ���� ������ ��� ���)
   * @param string $place         - ����� ��� ���������
   * @param int    $marginTop     - ������ ������
   * @param int    $marginBottom  - ������ �����
   * @param int    $marginLeft    - ������ �����
   * @param int    $marginRight   - ������ ������
   * @param int    $alpha         - ������� ������������ �� 0 �� 100
   * @param int    $quality_num   - ��������
   * @return resourse
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
   * ��������
   *
   * @param resource $src
   * @param 16 bit color $color
   * @return unknown
   */
  public function getColor($color = 'FFFFFF',$src)
  {
    if(!$src) $src = $this->getSrc();
    sscanf($color, "%2x%2x%2x", $red, $green, $blue);
    return imagecolorallocate($src, $red, $green, $blue);
  }






}


?>