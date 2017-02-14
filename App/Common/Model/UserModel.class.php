<?php

namespace Common\Model;
use Think\Model;

class UserModel extends Model{

	/**
	 * 初始化模型
	 * {@inheritDoc}
	 * @see \Think\Model::_initialize()
	 */
	public function _initialize(){
		$this->__set('tableName', 'user');
	}

	/**
	 * 检测用户，不存在的话执行保存
	 * 返回用户id
	 */
	public function saveAndGetId($data){

		$user = $this->where(['phone'=>$data['phone']])->find();

		$id = getArrayVelue($user, 'id', -1);

		if($id > 0){
			if($user['name'] != $data['name']){
				$this->where(['id'=>$id])->save($data);
			}
			return $id;
		}else{
			$id = $this->add($data);
			return $id;
		}
	}

}