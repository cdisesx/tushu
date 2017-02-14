<?php

namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller {
	
	/**
	 * 进入后台后判断动作
	 */
	public function _initialize(){
//		if (empty($_SESSION['admin'])) {
//			$this->redirect('Login/login');
//			exit;
//		}
	}
	
}