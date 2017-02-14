<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 2017/2/13
 * Time: 9:49
 */
namespace Common\Service;

use Common\Model\BookModel;
use Common\Model\HistoryModel;
use Common\Model\UserModel;
use Think\Model;

class BookService {

    /**
     * 借阅书籍
     */
    public function borrowBook($data){

        // 数据检测
        if($error = $this->checkBorrow($data)){
            return ['code'=>1,'msg'=>$error];
        }

        // 获取借阅人id
        $UM = new UserModel();
        $user_data = [
            'name'=>$data['user_name'],
            'phone'=>$data['phone']
        ];
        $user_id = $UM->saveAndGetId($user_data);

        // 判断书籍是否被借阅
        $BM = New BookModel();
        $search_book_data = [
            'id'=>$data['book_id'],
            'status'=>['GT',1]
        ];
        $is_borrowd = $BM->where($search_book_data)->find();
        if($is_borrowd){
            return ['code'=>0,'msg'=>'该书籍已被借阅'];
        }

        // 事物啓動
        M()->startTrans();

        // 修改book表状态
        $time_now = date('Y-m-d H:i:s');
        $book_data = [
            'status'=>2,
            'user_id'=>$user_id,
            'borrow_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

        // 保持記錄
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>$user_id,
            'do_type'=>1,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        if($save_book && $save_history){
//            M()->rollback();
//            return ['code'=>1,'msg'=>'借阅失败'];
            M()->commit();
            return ['code'=>0,'msg'=>'借阅成功'];
        }else{
            M()->rollback();
            return ['code'=>1,'msg'=>'借阅失败'];
        }
    }

    /**
     * 检测借阅书籍信息
     */
    public function checkBorrow($data){

        if(!getArrayVelue($data, 'book_id')){
            return '获取不到书籍信息';
        }
        if(!getArrayVelue($data, 'user_name')){
            return '请输入你的姓名';
        }
        if(!getArrayVelue($data, 'phone')){
            return '请输入你的电话号码';
        }
    }

    /**
     * 归还书籍
     */
    public function returnBook($data){
        // 数据检测
        if($error = $this->checkReturn($data)){
            return ['code'=>1,'msg'=>$error];
        }

        // 检测该手机是否借过本书
        $BM = New BookModel();
        $book_info = $BM->checkHasBorrowed($data);
        if(!$book_info){
            return ['code'=>1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
        }

        // 事物啓動
        M()->startTrans();

        // 修改book表状态
        $time_now = date('Y-m-d H:i:s');
        $book_data = [
            'status'=>1,
            'user_id'=>0,
            'return_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

        // 保持記錄
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>getArrayVelue($book_info['user_id']),
            'do_type'=>2,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        if($save_book && $save_history){
//            M()->rollback();
//            return ['code'=>1,'msg'=>'借阅失败'];
            M()->commit();
            return ['code'=>0,'msg'=>'还书成功'];
        }else{
            M()->rollback();
            return ['code'=>1,'msg'=>'还书失败，可能是系统问题，你可以直接将书还给管理人员'];
        }


    }

    public function checkReturn($data){
        if(!getArrayVelue($data, 'book_id')){
            return '获取不到书籍信息';
        }
        if(!getArrayVelue($data, 'phone')){
            return '请输入你的电话号码';
        }
    }


    /**
     * 书籍报失
     */
    public function loseBook($data){
        // 数据检测
        if($error = $this->checkReturn($data)){
            return ['code'=>1,'msg'=>$error];
        }

        // 检测该手机是否借过本书
        $BM = New BookModel();
        $book_info = $BM->checkHasBorrowed($data);
        if(!$book_info){
            return ['code'=>1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
        }

        // 事物啓動
        M()->startTrans();

        // 修改book表状态
        $time_now = date('Y-m-d H:i:s');
        $book_data = [
            'status'=>3,
            'return_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

        // 保持記錄
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>getArrayVelue($book_info['user_id']),
            'do_type'=>3,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        if($save_book && $save_history){
//            M()->rollback();
//            return ['code'=>1,'msg'=>'借阅失败'];
            M()->commit();
            return ['code'=>0,'msg'=>'挂失成功，如诺找回，可直接点击还书'];
        }else{
            M()->rollback();
            return ['code'=>1,'msg'=>'挂失失败，可能是系统问题，你可以直接联系管理员'];
        }


    }

}