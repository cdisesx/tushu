<?php

namespace Admin\Controller;
use Think\Controller;
use Common\Model\AdminModel;

class LoginController extends Controller {

	public function index(){
		$this->login();
	}
	
	/**
	 * 登入页面
	 */
	public function login(){
		// 获取错误信息
		$error = I('get.error');
		$error && $this->assign('error', $error);
		
		// 判断是否已经登入
		if(!$_SESSION['admin']){
			// 获取cookie
			$md5_account = cookie('account');

			// 数据库查询存在该md5码的账号并返回到页面
			$AdminModel = new AdminModel();
			$adminArr = $AdminModel->getAccountByMd5($md5_account);
			$account = $adminArr['account'];
			$this->assign('account', $account);
			
			// 未登入加载登入页面
			$this->display('login');
		}else{
			// 已登入直接进入
			$this->redirect('ApiTest/index');
		}
	}

	/**
	 * 执行登入
	 */
	public function doLogin(){
		
		// 获取登入密码
		$account = I('post.account', '');
		$remember_me = I('post.remember_me', '');
		$remember_me && cookie('account', md5($account), 2592000);
		
		// 初始化Model并调用CheckAccount方法
		$AdminModel = new AdminModel();
		$adminArr = $AdminModel->CheckAccount($account);
		
		// 判断账号是否存在
		if($adminArr){
			// 存入Session缓存
			$_SESSION['admin'] = $adminArr;
			// 重定向控制器到Table控制器调用index方法
			$this->redirect('ApiTest/index');
		}else{
			// 清除缓存
			unset($_SESSION['admin']);
			// 跳转回登入页并附加错误信息
			$this->redirect('login', array('error'=>'用户不存在！'));
		}
		
	}

	/**
	 * 退出登入
	 */
	public function doLogout(){
		// 清除缓存
		unset($_SESSION['admin']);
		// 进入登入控制
		$this->login();
	}
}