<?php

namespace Common\Model;
use Think\Model;

class BookModel extends Model{

	/**
	 * 初始化模型
	 * {@inheritDoc}
	 * @see \Think\Model::_initialize()
	 */
	public function _initialize(){
		$this->__set('tableName', 'book');
	}


	/**
	 * 获取列表
	 */
	public function getList($params){

		$page = getArrayVelue($params, 'page', 1);
		$size = getArrayVelue($params, 'size', 20);
		$where = [];

		// id搜素
		$book_id = getArrayVelue($params,'id', -1);
		if($book_id>0){
			$where['b.id'] = $book_id;
		}
		// 搜索
		$book_name = getArrayVelue($params,'book_name');
		if($book_name){
			$where['b.name'] = ['LIKE','%'.$book_name.'%'];
		}

		$field = [
			'b.*',
			'u.name'=>'user_name'
		];

		// 获取数据
		$result = $this
			->alias('b')
			->field($field)
			->join('left join `user` as u on u.id = b.user_id')
			->where($where)
			->page($page.','.$size)
			->order('b.status asc')
			->select();

//		echo $this->getLastSql();

		return $result;
	}


	/**
	 * 检测该电话号码是否借过书
	 */
	public function checkHasBorrowed($params){

		$where = [
			'b.id'=>getArrayVelue($params,'book_id', -1),
			'u.phone'=>getArrayVelue($params,'phone')
		];

		$field = [
			'b.*',
			'u.name'=>'user_name'
		];

		// 获取数据
		$result = $this
			->alias('b')
			->field($field)
			->join('left join `user` as u on u.id = b.user_id')
			->where($where)
			->find();

		return $result;
	}


}