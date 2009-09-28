<?php

/*  ����� Captcha
 *  ����������: ������������� ImageMagick ������ 6.2.5 � ����, ������������ � PHP ������ MagickWand, ������: http://imagemagick.net/script/api.php
 *  �������� (��������):
 *           var $SuccessURL;    //������ ���� ��������������, � ������ ������
 *           var $NotSuccessURL; //������ ���� ��������������, � ������ ��������
 *
 *  ������:
 *           salt_add($string)
 *                    ��������: ��������� ������� - ��������� "����" � ���������� ������
 *                    ���������: ������
 *                    ������������ ��������: "�����������" ������
 *           start_session()
 *                    ��������: ��������� ������
 *                    ���������: --
 *                    ������������ ��������: --
 *           ShowImage()
 *                    ��������: ���������� � ����� ����������� (�������� header("Content-type: imgae/png") ����� Blob ��������)
 *                    ���������: --
 *                    ������������ ��������: --
 *           TestCaptcha($UserInput)
 *                    ��������: ��������� ��������� �� ����� � ������ $UserInput � ������� �� ��������, ��������� ������
 *                    ���������: ����������� ������
 *                    ������������ ��������: TRUE � ������ ������ � FALSE � ����� ��������
 *           TestAndProcess($UserInput)
 *                    ��������: ������� ������ TestCaptcha($UserInput) ������ � ������ ������ �������������� �� $SuccessURL, � ������ �������� �� $NotSuccessURL
 *                    ���������: ����������� ������
 *                    ������������ ��������: --
 *           ShowCaptchaBlock()
 *                    ��������: ������ ���� ������� Capatcha. ������ �������������:
 *                              index.php:
 *                              
 *                              include_once('captcha.php');
 *                              $Cap=new Captcha();
 *                              global $action;
 *                              if($action =='image'){
 *                                      $Cap->ShowImage();
 *                              }else{
 *                                      $Cap->ShowCaptchaBlock();
 *                              }
 *                              
 *                    ���������: --
 *                    ������������ ��������: --
 *
 * ���������: � �����, ��� ���������� ����� ������� ShowImage() � ShowCaptchaBlock() ������ ������������� ����� (��������: fonts) �� �������� (6 ������� � ������� 0.ttf, 1.ttf, ... 5.ttf ��������������)
 */

class capture{
 var $SuccessURL;    //������ ���� ��������������, � ������ ������
 var $NotSuccessURL; //������ ���� ��������������, � ������ ��������


 //����������, ���������� �� ��������� ��������
 //������������� �����
 var $AllColors;
 //���������� ������������ ������
 var $AllColorsCount;
 //������ ��������
 var $width;
 //������ ��������
 var $height;
 //���������� ������������ ������
 var $textposX;
 var $textposY;
 //���������� ������������ �� ����� fonts �������
 var $fontcount;

 var $eff_swirl;
 var $eff_impolde;      //�������� Implode (�� 0 �� 1)
 var $eff_blur2;              //�������� Blur
 var $eff_wave1;            //��������� �����
 var $eff_wave2;          //����� �����
 var $eff_shear1;
 var $eff_shear2;
 //$eff_spread=mt_rand(0, 1);           //�������� spread

 //������ ������
 var $fontsize;
 //����� �������� � ��������
 var $TextLength;

 //��������� ���������� ������������ � �������������� �����
 var $hor_lines_min;
 var $hor_lines_max;
 var $ver_lines_min;
 var $ver_lines_max;


 /* ����������� ������.
  * ��������� ���������: SuccessURL, NotSuccessURL, RootURL (�� ����)
  * �����������:   $SuccessURL='seccess.php'
  *                $NotSuccessURL_='http://192.168.10.41/index.php'
  *                $Complicate='hard' - ��������� �������� 'hard' - ������� 'easy' - �������
  */
 function capture($Complicate='hard', $SuccessURL_='seccess.php', $NotSuccessURL_='http://192.168.10.41/index.php'){
          $this->SuccessURL=$SuccessURL_;
          $this->NotSuccessURL=$NotSuccessURL_;
          switch($Complicate){
           case 'hard':
           //����������, ���������� �� ��������� ��������
            //������������� �����
            $this->AllColors=array('#000000','#0054BB','#0F5E00','#74158F','#546302','#630250','#020563','#176302','#008082','#275D24','#5A5D24','#3F531D','#1D2B53','#4D164B','#4B571A','#AD5500','#488066','#5E0000');
            //���������� ������������ ������
            $this->AllColorsCount=18;
            //������ ��������
            $this->width=130;
            //������ ��������
            $this->height=50;
            //���������� ������������ ������
            $this->textposX=0;
            $this->textposY=0;
            //���������� ������������ �� ����� fonts �������
            $this->fontcount=5;

            $this->eff_swirl=mt_rand(10, 30);
            $this->eff_impolde=mt_rand(0, 20)/100;      //�������� Implode (�� 0 �� 1)
            $this->eff_blur2=mt_rand(0, 1);              //�������� Blur
            $this->eff_wave1=mt_rand(15, 30);            //��������� �����
            $this->eff_wave2=mt_rand(200, 300);          //����� �����
            $this->eff_shear1=mt_rand(0, 40)-20;
            $this->eff_shear2=mt_rand(0, 16)-8;
            //$eff_spread=mt_rand(0, 1);           //�������� spread

            //������ ������
            $this->fontsize=mt_rand(40, 40);
            //����� �������� � ��������
            $this->TextLength=6;

            //��������� ���������� ������������ � �������������� �����
            $this->hor_lines_min=5;
            $this->hor_lines_max=10;
            $this->ver_lines_min=10;
            $this->ver_lines_max=20;
           break;
           case 'easy':
           //����������, ���������� �� ��������� ��������
            //������������� �����
            $this->AllColors=array('#000000','#0054BB','#0F5E00','#74158F','#546302','#630250','#020563','#176302','#008082','#275D24','#5A5D24','#3F531D','#1D2B53','#4D164B','#4B571A','#AD5500','#488066','#5E0000');
            //���������� ������������ ������
            $this->AllColorsCount=18;
            //������ ��������
            $this->width=130;
            //������ ��������
            $this->height=50;
            //���������� ������������ ������
            $this->textposX=0;
            $this->textposY=0;
            //���������� ������������ �� ����� fonts �������
            $this->fontcount=5;

            $this->eff_swirl=mt_rand(8, 10);
            $this->eff_impolde=mt_rand(0, 20)/100;      //�������� Implode (�� 0 �� 1)
            $this->eff_blur2=0;                           //�������� Blur
            $this->eff_wave1=mt_rand(15, 30);            //��������� �����
            $this->eff_wave2=mt_rand(200, 300);          //����� �����
            $this->eff_shear1=0;//mt_rand(0, 40)-20;
            $this->eff_shear2=0;//mt_rand(0, 16)-8;
            //$eff_spread=mt_rand(0, 1);           //�������� spread

            //������ ������
            $this->fontsize=mt_rand(40, 40);
            //����� �������� � ��������
            $this->TextLength=3;

            //��������� ���������� ������������ � �������������� �����
            $this->hor_lines_min=0;
            $this->hor_lines_max=0;
            $this->ver_lines_min=0;
            $this->ver_lines_max=0;
           break;
           }
         }
 //����
 function salt_add($string){
         return "%^s.".$string."&#.$";
        }

 function start_session(){
          session_start();
         }

 function ShowImage($txt=''){
          $this->start_session();
		  if($txt=='')
		  	{
			  for($i=0; $i<$this->TextLength; $i++)
				  $txt=$txt.chr(mt_rand(97,122));
			  session_register('cap_text');
	          $_SESSION['cap_text']=md5($this->salt_add($txt));
			}
          $fntname=mt_rand(0, $this->fontcount);
          $textcolor=$this->AllColors[mt_rand(0, $this->AllColorsCount)];
          $backcolor='#ffffff';

          $hor_lines_count=mt_rand($this->hor_lines_min, $this->hor_lines_max);
          $ver_lines_count=mt_rand($this->ver_lines_min, $this->ver_lines_max);


          //������������� ������������
          $mg_w = NewMagickWand();
          $dr_w = NewDrawingWand();

          //��������� ����� ������
          DrawSetFillColor($dr_w, $textcolor);
          //������ ������
          DrawSetFontSize($dr_w, $this->fontsize);
          //�����
          DrawSetFont($dr_w, './fonts/'.$fntname.'.ttf');
          //��������� ������
          DrawSetGravity($dr_w, MW_CenterGravity);

          //���������� ������ ������
          DrawAnnotation($dr_w, $this->textposX, $this->textposY, $txt);


          //�������� �����������
          MagickNewImage($mg_w, $this->width, $this->height, "#ffffff");

          //���������� ������
          MagickDrawImage($mg_w, $dr_w);

          //��������� ��������
            //MagickMotionBlurImage($mg_w, 2, 5, 0);
            //MagickOilPaintImage($mg_w, 1);
            //MagickRadialBlurImage($mg_w, 10);
            //MagickReduceNoiseImage($mg_w, 0.10); //���
            //MagickSolarizeImage($mg_w, 23);
            //MagickChopImage($mg_w, 30, 30, 0, 0);
            //MagickEmbossImage($mg_w, 2, 1);

          //+Swirl
          MagickSwirlImage($mg_w, $this->eff_swirl);
           //+Wave
          MagickWaveImage($mg_w, $this->eff_wave1, $this->eff_wave2);
          //+Spread
          //MagickSpreadImage($mg_w, $eff_spread);
          //+Implode
          MagickImplodeImage($mg_w, $this->eff_impolde);
          //+Blur
          MagickBlurImage($mg_w, 0, $this->eff_blur2);
          //+Shear
          MagickShearImage($mg_w, $backcolor, $this->eff_shear1, $this->eff_shear2);

          //������� �� ������ ��������
          //MagickResizeImage($mg_w, $width, $height, MW_PointFilter, 1);
          MagickScaleImage($mg_w, $this->width, $this->height);


            //����
           ClearDrawingWand($dr_w);
           //DrawSetGravity($dr_w, MW_CenterGravity);
		   DrawSetStrokeWidth($dr_w, 15);
           for($i=0; $i<$hor_lines_count; $i++){
               $startline_y=mt_rand(0, $this->height-1);
               $finishline_y=mt_rand(0, $this->height-1);
                //��������� ����� ������
               DrawSetFillColor($dr_w, "white");//$AllColors[mt_rand(0, $AllColorsCount)]);
               DrawLine($dr_w, 0, $startline_y, $this->width, $finishline_y);
           }
           for($i=0; $i<$ver_lines_count; $i++){
               $startline_x=mt_rand(0, $this->width-1);
               $finishline_x=mt_rand(0, $this->width-1);
                //��������� ����� ������
               DrawSetFillColor($dr_w, "white");//$AllColors[mt_rand(0, $AllColorsCount)]);
               DrawLine($dr_w, $startline_x, 0, $finishline_x, $this->height);
           }
          //���������� �����
          MagickDrawImage($mg_w, $dr_w);


          //��������� �������
          MagickSetImageFormat( $mg_w, 'PNG' );
          //����������� ����������� ��� blob
          //header('Content-Type: ' . MagickGetMimeType($mg_w));
          header('Content-Type: image/png');
          MagickEchoImageBlob($mg_w);

          //������
          DestroyMagickWand($mg_w);
          DestroyDrawingWand($dr_w);
        }


 function TestCaptcha($UserInput){
          $UserInput=strtolower($UserInput);
          $this->start_session();
          if(session_is_registered('cap_text')){
              if(md5($this->salt_add($UserInput))==$_SESSION['cap_text']){
                      session_unregister('cap_text');
                      return true;
              }
              else{
                      session_unregister('cap_text');
                      return false;
              }
          }else
               return false;
          //���� ������� ������ �� �����, ������� ��
          session_destroy();
         }

 function TestAndProcess($UserInput){
          $TestResult=$this->TestCaptcha($UserInput);
          if($TestResult)
             header("Location: ".$SuccessURL);
          else
             header("Location: ".$NotSuccessURL);
         }

 function ShowCaptchaBlock(){

          return "<style type=\"text/css\">
            .CaptchaText{font-size:13px; font-family:monospace;}
            .CaptchaForm{height: 22px; width: 130px; font-size: 13px; border: 1px solid #000000;}
            .CaptchaFormActive{background-color: #7DBADD; height: 22px; width: 130px; font-size: 13px; border: 1px solid #000000;}
           </style>
           <table border=0>
             <td valign=top><img border=1 src=\"?action=image\" name=\"captcha\"></td>
             <td valign=top>
               <form action=\"test.php\">
                <font class=\"CaptchaText\">������� �������, ���������� �� ������� (��� ����� ��������).</font><br>
                <input type=text name=UserInput class=\"CaptchaForm\">
                <input type=submit class=\"CaptchaForm\" onmouseover=\"this.className='CaptchaFormActive'\" onmouseout=\"this.className='CaptchaForm'\">
                <br><br>
                <font class=\"CaptchaText\">���� � ��� �� ���������� ��������� �����, </font><font style=\"font-size:13px;font-family:monospace;color:#007DC5;cursor:pointer;\" onclick=\"document.captcha.src='?action=image'\">������� ����</font>
               </form>
             </td>
           </table>
           <br>";
          }
}
session_start();
$_SESSION['capture_text'] = substr(md5(microtime().time()), 0, 5);
if(!isset($_SESSION['capture_text']))
	die();
	
$cap=new capture('easy');
$cap->ShowImage($_SESSION['capture_text']);

?>