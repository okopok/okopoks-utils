<?php
/*
 *      MailCheck.class.php
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


class MailCheck{

	var $__rSrc 	= false;
	var $__aErrors	= array();
	var $__sHost	= false;
	var $__sLogin	= false;
	var $__sPass	= false;
	var $__sPort	= false;
	var $__sValues	= false;

	function MailCheck($sHost, $sLogin, $sPass, $sPort = false, $sValues = false){
		if(strlen($sHost) and strlen($sLogin) and strlen($sPass)){
			$this->__sHost 	= $sHost;
			$this->__sLogin = $sLogin;
			$this->__sPass	= $sPass;
		}
		if(strlen($sPort)) 		$this->__sPort 		= $sPort;
		if(strlen($sValues)) 	$this->__sValues 	= $sValues;

		$this->__sConString	 						= $this->__sHost;
		if($this->__sPort) 		$this->__sConString .= ':'.$this->__sPort;
		if($this->__sValues) 	$this->__sConString .= $this->__sValues;
	}

	function open(){

		$this->__rSrc = imap_open("{".$this->__sConString."}INBOX", $this->__sLogin, $this->__sPass);

		if(!is_resource($this->__rSrc)){
			$this->__aErrors[] =  imap_last_error();
			return false;
		}
		return true;
	}
	/**
	 *\\Seen", "\\Answered", "\\Flagged", "\\Deleted", and "\\Draft
	 */
	function clearFlag($id, $sFlag){
		if(imap_clearflag_full($this->__rSrc, $id, $sFlag)){
			$this->__aErrors[] =  imap_last_error();
			return false;
		}
		return true;
	}

	/**
	 *\\Seen", "\\Answered", "\\Flagged", "\\Deleted", and "\\Draft
	 */
	function setFlag($id, $sFlag){
		if(!imap_setflag_full($this->__rSrc, $id, $sFlag)){
			$this->__aErrors[] =  imap_last_error();
			return false;
		}
		return true;
	}

	function getDirs(){
		$list = imap_list($this->__rSrc, "{{$this->__sConString}}", "*");
	}

	/**
	 * @param int $sort_by = sorting by param
	 * @param int $order = ordering param. default = 1 (reverse)
	 * @return array
	 *
	 * ** sorting_param_values **
	 * SORTDATE - message Date
	 * SORTARRIVAL - arrival date
	 * SORTFROM - mailbox in first From address
	 * SORTSUBJECT - message subject
	 * SORTTO - mailbox in first To address
	 * SORTCC - mailbox in first cc address
	 * SORTSIZE - size of message in octets
	 */
	function getMessages($sort_by = SORTARRIVAL, $order = 1){
		$arr = imap_sort($this->__rSrc,  $sort_by, $order);
		if(!is_array($arr)){
			$this->__aErrors[] = imap_last_error();
			return false;
		}
		return $arr;
	}

	function getMessage($id, $bSetUnread = true){

		if($bSetUnread){
			return imap_body($this->__rSrc, $id, FT_PEEK);
		}

		return imap_body($this->__rSrc, $id);
	}

	function getStructure($id){
		return imap_fetchstructure($this->__rSrc, $id);
	}

	function getHeaders($id){
		return imap_headerinfo($this->__rSrc, $id);
	}

	function getOverview($id){
		return imap_fetch_overview($this->__rSrc,$id);
	}

	function close(){
		imap_close($this->__rSrc);
	}

	function getErrors(){
		return $this->__aErrors;
	}

	/**
	 *
	 *  A string, delimited by spaces, in which the following keywords are allowed. Any multi-word arguments (e.g. FROM "joey smith") must be quoted.
	 *
	 * ALL - return all messages matching the rest of the criteria
	 * ANSWERED - match messages with the \\ANSWERED flag set
	 * BCC "string" - match messages with "string" in the Bcc: field
	 * BEFORE "date" - match messages with Date: before "date"
	 * BODY "string" - match messages with "string" in the body of the message
	 * CC "string" - match messages with "string" in the Cc: field
	 * DELETED - match deleted messages
	 * FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
	 * FROM "string" - match messages with "string" in the From: field
	 * KEYWORD "string" - match messages with "string" as a keyword
	 * NEW - match new messages
	 * OLD - match old messages
	 * ON "date" - match messages with Date: matching "date"
	 * RECENT - match messages with the \\RECENT flag set
	 * SEEN - match messages that have been read (the \\SEEN flag is set)
	 * SINCE "date" - match messages with Date: after "date"
	 * SUBJECT "string" - match messages with "string" in the Subject:
	 * TEXT "string" - match messages with text "string"
	 * TO "string" - match messages with "string" in the To:
	 * UNANSWERED - match messages that have not been answered
	 * UNDELETED - match messages that are not deleted
	 * UNFLAGGED - match messages that are not flagged
	 * UNKEYWORD "string" - match messages that do not have the keyword "string"
	 * UNSEEN - match messages which have not been read yet
	 */
	function search($sString){
		$arr = imap_search($this->__rSrc, $sString);
		if(!$arr){
			$this->__aErrors[] = imap_last_error();
			return false;
		}
		return $arr;
	}

	function count(){
		return imap_num_msg($this->__rSrc);
	}

}
