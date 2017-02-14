<?php

use Think\Upload;
use Think\Image;

/**
 * 用于ajax返回结尾
 * @param any $data
 */
function json_output($data){
	echo json_encode($data);
	exit;
}

/**
 * 打印函数
 */
function p($data){
	echo '<pre>';
		print_r($data);
	echo '</pre>';
}

/**
 * var_dump格式打印
 */
function vp($data){
	echo '<pre>';
		var_dump($data);
	echo '</pre>';
}

//获取数组中数据
function getArrayVelue($array, $key_name, $default=null){
	if(is_array($array)){
		if (isset($array[$key_name])){
			return $array[$key_name];
		}
	}
	elseif(is_object($array)){
		if (isset($array->$key_name)){
			return $array->$key_name;
		}
	}
	return $default;
}

/**
 * 获取get数据
 */
function sget($key_name, $default = null){
	return getArrayVelue($_GET,$key_name,$default);
}

/**
 * 获取post数据
 */
function spost($key_name, $default = null){
	return getArrayVelue($_POST,$key_name,$default);
}

function sub_string($string,$length,$end_str='…',$is_strip=0)
{
	if($is_strip)
	{
		$string = strip_tags($string);
	}
	if(mb_strlen($string,"UTF-8")<=$length)
	{
		return $string;
	}else{
		return mb_substr($string,0,$length,'UTF-8').$end_str;
	}
}

/**
 * 用于获取上传的图片
 */
function getUploadImg(){
	$upload = new Upload();
	$upload->maxSize = 3145728;
	$upload->exts = array('jpg','gif','png','jpeg');
	$upload->rootPath = './Public/Pic/menu/';
	$upload->savePath = '';
	$upload->autoSub = false;
	$upload->saveName = array('setMenuName');
	
	$info = $upload->upload();
	
	$data['info'] = $info;
	$data['error'] = $upload->getError();
	
	return $data;
}
/**
 * 定义上传菜单文件名
 */
function setMenuName(){
	return 'menu'.md5(time().rand(0,999));
}
/**
 * 菜单图片处理
 */
function setMenuPic($picName, $width, $height){
	$img = new Image();
	$img->open('./Public/Pic/menu/'.$picName);
	$img->thumb($width, $height, \Think\Image::IMAGE_THUMB_FIXED)->save('./Public/Pic/menu/'.$picName);
}
/**
 * 获取上传图片并处理图片
 */
function getMenuPic($picName){
	$picInfo = getUploadImg();
	if($picInfo['info']){
		setMenuPic($picInfo['info'][$picName]['savename'], 330,220);
		$picInfo['info'] = $picInfo['info'][$picName];
	}
	return $picInfo;
}











