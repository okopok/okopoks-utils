<?php

class My_Logger{

	private static $__hPath 			= array();
	private static $__aTags				= array();
	private static $__sTimestampFormat 	= 'r';
	private static $__bTimestampEnabled = true;

	public function __construct(){


	}

	public static function log($sString, $sTag = false){
		if(!$sTag and count(self::$__aTags)){
			$sTag = end(self::$__aTags);
		}
		if( !isset(self::$__hPath[$sTag]) ){
			throw new Exception('Tag "'.$sTag.'" is not set');
		}
		$rF = fopen(self::$__hPath[$sTag], 'a+');
		if(is_resource($rF)){
			fwrite($rF,(self::$__bTimestampEnabled?'['.date(self::$__sTimestampFormat).'] ':'').$sString."\n");
			fclose($rF);
		}else{
			throw new Exception('Cannot write to file "'.self::$__hPath[$sTag].'"');
		}
		return $sString;
	}

	public static function setConfig($hConfig){
		if(isset($hConfig['dirs'])){
			foreach($hConfig['dirs'] as $sTag => $sDir){
				self::setDir($sTag, $sDir);
			}
		}
		if(isset($hConfig['timestamp'])){
			self::$__bTimestampEnabled = $hConfig['timestamp'];
		}
		if(isset($hConfig['timestampFormat'])){
			self::$__sTimestampFormat = $hConfig['timestampFormat'];
		}
	}

	public static function setDir($sTag, $sPath){
		if(!is_dir(dirname($sPath))){
			throw new Exception('Dir "'.$sPath.'" is not exists');
		}
		self::$__hPath[$sTag] = $sPath;
	}

	public static function startTag($sTag){
		self::$__aTags[] = $sTag;
	}

	public static function endTag($sTag = false){
		if($sTag and in_array($sTag, self::$__aTags)){
			foreach(array_reverse(self::$__aTags, true) as $key=>$value){
				unset(self::$__aTags[$key]);
				if($sTag == $value){
					break;
				}
			}
		}else{
			array_pop(self::$__aTags);
		}
	}




}
