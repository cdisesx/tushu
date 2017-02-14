<?php

namespace Common\Model;
use Think\Model;

class CodeModel extends Model{
	
	/**
	 * 初始化模型
	 * {@inheritDoc}
	 * @see \Think\Model::_initialize()
	 */
	public function _initialize(){
		$this->__set('tableName', 'history');
	}

	/**
	 * 检测用户，不存在的话执行保存
	 * 返回用户id
	 */
	public function saveAndGetId($data){

		$info = $this->where(['phone'=>$data['phone']])->find();

		$id = getArrayVelue($info, 'id', -1);


		if($id > 0){
			$this->where(['id'=>$id])->save($data);
			return $id;
		}else{
			$data['num'] = 1;
			$data['send_time'] = $time_now;
			$id = $this->add($data);
			return $id;
		}
	}
	
}