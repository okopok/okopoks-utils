<?php
/*
 *      csv.parser.php
 *
 *      Copyright 2009 Alex Molodtsov <user@molodtsov>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


/**
 * if csv has not all escaped strings, this function can help
 * @since 09.07.2009
 * @author Molodtsov Sasha <a.molodcov@chronopay.com>
 * @param string $sString
 * @param string $sSeparator
 * @param string $sEscaper
 * @param string $sLinesSeparator
 * @return array
 */
function badCsvExploder($sString, $sSeparator = ',',$sEscaper = '"', $sLinesSeparator = "\n"){
	$aOutput = array();
	foreach(explode($sLinesSeparator, $sString) as $line){
		if(preg_match('/'.$sEscaper.'/',$line)){
			preg_match_all('/('.$sEscaper.'.*?'.$sEscaper.')/is',$line, $matches,PREG_OFFSET_CAPTURE);
			$i = 0;
			$out = array();
			foreach($matches[0] as $match){
				if($i < $match[1]){
					$out = array_merge($out, explode($sSeparator,trim(substr($line, $i, ($match[1]-$i)),$sSeparator.' ')));
				}
				$i = $match[1]+strlen($match[0])+1;
				$out[] = trim($match[0],$sEscaper.' ');
			}
		}else{
			$out = explode($sSeparator,$line);
		}
		$aOutput[] = $out;
	}
	return $aOutput;
}
