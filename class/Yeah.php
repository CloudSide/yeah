<?php

/**
* $Id$
*
* Copyright (c) 2015, Cloud Mario.  All rights reserved.
* @author Bruce Chen <smcz@qq.com>
* @link http://weibo.com/smcz
*/

class YeahException extends Exception {}


/**
* Cmd Tool class
*
* @link http://weibo.com/smcz
* @version 0.1.0-dev
*/

class Yeah {

	protected $_process = null;
	protected $_pipes = null;
	protected $_status = null;
	protected $_exitstatus = null;

	public function __construct($cmd, $cwd = null, $env = null) {
	
		$descriptorspec = array(
		
			0 => array("pipe", "r"),  // stdin
			1 => array("pipe", "w"),  // stdout
			2 => array("pipe", "w")   // stderr
		);
		
		if ( isset($cwd) ) {
		
			$cwd = realpath($cwd);
		}
		
		$this->_process = proc_open($cmd, $descriptorspec, $this->_pipes, $cwd, $env);
		$this->status();
		
		if ( $this->_process === false ) {
		
			throw new YeahException("proc_open error");
		}
	}
	
	public function __destruct() {
		
		$this->close();
	}
	

	// getter

	public function pid() {
	
		$st = $this->status();
		return $st["pid"];
	}

	public function stdin() {
	
		return $this->_pipes[0];
	}

	public function stdout() {
	
		return $this->_pipes[1];
	}

	public function stderr() {
	
		return $this->_pipes[2];
	}


	// instance methost

	public function status() {
	
		if ( is_resource($this->_process) ) {
		
			$this->_status = proc_get_status($this->_process);
		}
		
		return $this->_status;
	}

	public function close() {
	
		if ( is_resource($this->_pipes[0]) ) {
	
			fclose($this->_pipes[0]);
		}
	
		if ( is_resource($this->_pipes[1]) ) {
	
			fclose($this->_pipes[1]);
		}
	
		if ( is_resource($this->_pipes[2]) ) {
	
			fclose($this->_pipes[2]);
		}
	
		if ( is_resource($this->_process) ) {
	
			$this->status();
			proc_close($this->_process);
		}
	
		return $this->status();
	}

	public function nice($increment) {
	
		if ( is_resource($this->_process) ) {
		
			return proc_nice($this->_process, $increment);
		}
		
		return false;
	}

	public function terminate($signal = 15) {
	
		if ( is_resource($this->_process) ) {
		
			return proc_terminate($this->_process, $signal);
		}
		
		return true;
	}


	// static

	public static function yeah($cmd, $block, $cwd = null, $env = null) {
	
		if ( !is_callable($block) ) {
		
			throw new YeahException("block is not callable");
		}
	
		$p = new self($cmd, $cwd, $env);
		$block($p->pid(), $p->stdin(), $p->stdout(), $p->stderr());
		
		return $p->close();
	}
}
