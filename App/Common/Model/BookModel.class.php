<?php

namespace Common\Model;
use Common\Service\SMSService;
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
		$where_str = '1';

		// id搜素
		$book_id = getArrayVelue($params,'id', -1);
		if($book_id>0){
			$where_str .= ' and b.id = '.intval($book_id);
		}
		// 搜索
		$key_word = trim(addslashes(getArrayVelue($params,'key_word')));
		if($key_word){
			if($key_word === 'xxx已借'){
				$where_str .= ' and b.status = 2';
			}
			elseif($key_word === 'xxx丢失'){
				$where_str .= ' and b.status = 3';
			}else{
				$SMSS = new SMSService();
				if($SMSS->checkIsPhone($key_word)){
					$where_str .= ' and ( b.key_word like \'%'.$key_word.'%\' or (u.phone = \''.$key_word.'\' and b.status in (2,3) ) )';
				}else{
					$where_str .= ' and ( b.key_word like \'%'.$key_word.'%\' )';
				}
			}
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
			->where($where_str)
			->page($page.','.$size)
			->order('b.status asc,b.borrow_time asc,b.id desc')
			->select();

//		echo $this->getLastSql();

		// 数据处理
		if(count($result)){
			$time_now = time();
			foreach($result as $key=>$val){
				if($val['status'] == 2){
					$user_days = intval( ($time_now - strtotime($val['borrow_time'])) / 86400 );
					if($user_days >= 20){
						$result[$key]['status'] = 10;  // 可续借
					}
					$result[$key]['use_days'] = $user_days.'天';
				}

				if($val['status'] == 4){
					$due_date = date('Y-m-d', strtotime($val['borrow_time'])+(86400*60));
					$result[$key]['due_date'] = $due_date;
					if($due_date < date('Y-m-d')){
						$result[$key]['fine'] = intval((time()-strtotime($val['borrow_time']))/86400-60);
					}
				}

			}
		}
		
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