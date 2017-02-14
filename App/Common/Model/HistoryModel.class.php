<?php

namespace Common\Model;
use Think\Model;

class HistoryModel extends Model{
	
	/**
	 * 初始化模型
	 * {@inheritDoc}
	 * @see \Think\Model::_initialize()
	 */
	public function _initialize(){
		$this->__set('tableName', 'history');
	}
	
}