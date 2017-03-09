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

        // 短信验证码认证
        $SMS = new SMSService();
        if(!$SMS->codeCheck()){
            return ['code'=>1,'msg'=>'验证码错误，请重新输入'];
        }

        // 获取借阅人id
        $UM = new UserModel();
        $user_data = [
            'name'=>$data['user_name'],
            'phone'=>$data['phone']
        ];
        $user_id = $UM->saveAndGetId($user_data);

        // 判断书籍是否被借阅获取其他异常状态
        $can_borrowed = $this->checkBorrowBookInfo($data['book_id'], $user_id);
        if($can_borrowed !== true){
            return $can_borrowed;
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
        $BM = New BookModel();
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
            M()->commit();
            return ['code'=>0,'msg'=>'借阅成功'];
        }else{
            M()->rollback();
            return ['code'=>1,'msg'=>'借阅失败'];
        }
    }

    /**
     * 借阅书籍 检测书籍信息
     */
    public function checkBorrowBookInfo($book_id, $user_id = 0){
        $BM = New BookModel();
        $book_info = $BM->where(['id'=>$book_id])->find();

        if($book_info){
            $status = getArrayVelue($book_info, 'status');

            if($status == 2){
                return ['code'=>0,'msg'=>'该书籍已被借阅'];
            }

            if($status == 3){
                return ['code'=>0,'msg'=>'该书籍已丢失'];
            }

            $return_time = date('Y-m-d', strtotime(getArrayVelue($book_info, 'return_time')));
            if($status == 1 && $return_time == date('Y-m-d') && $user_id > 0){
                $HM = new HistoryModel();
                $where = ['book_id'=>$book_id,'do_type'=>2,'user_id'=>$user_id];
                $history_info = $HM->where($where)->order('do_time desc')->find();
                $return_time = date('Y-m-d', strtotime(getArrayVelue($history_info, 'do_time')));
                if($return_time == date('Y-m-d')){
                    return ['code'=>1,'msg'=>'无法借阅你当日所归还书籍，请明天再来。'];
                }

            }
        }else{
            return ['code'=>0,'msg'=>'不存在该书籍'];
        }

        return true;
    }

    /**
     * 借阅书籍 检测传参信息
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

        // 短信验证码认证
        $SMS = new SMSService();
        if(!$SMS->codeCheck()){
            return ['code'=>1,'msg'=>'验证码错误，请重新输入'];
        }

        // 检测该手机是否借过本书
        $BM = New BookModel();
        $book_info = $BM->checkHasBorrowed($data);
        if(!$book_info){
            return ['code'=>1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
        }

        // 事物啓動
        M()->startTrans();

        // 保持記錄
        $time_now = date('Y-m-d H:i:s');
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>getArrayVelue($book_info, 'user_id'),
            'do_type'=>2,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        // 修改book表状态
        $book_data = [
            'status'=>1,
            'return_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

        if($save_book && $save_history){
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

        // 短信验证码认证
        $SMS = new SMSService();
        if(!$SMS->codeCheck()){
            return ['code'=>1,'msg'=>'验证码错误，请重新输入'];
        }

        // 检测该手机是否借过本书
        $BM = New BookModel();
        $book_info = $BM->checkHasBorrowed($data);
        if(!$book_info){
            return ['code'=>1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
        }

        // 事物啓動
        M()->startTrans();

        // 保持記錄
        $time_now = date('Y-m-d H:i:s');
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>getArrayVelue($book_info, 'user_id'),
            'do_type'=>3,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        // 修改book表状态
        $book_data = [
            'status'=>3,
            'lose_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

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


    /**
     * 书籍续借
     */
    public function renewBook($data){
        // 数据检测
        if($error = $this->checkReturn($data)){
            return ['code'=>1,'msg'=>$error];
        }

        // 短信验证码认证
        $SMS = new SMSService();
        if(!$SMS->codeCheck()){
            return ['code'=>1,'msg'=>'验证码错误，请重新输入'];
        }

        // 检测该手机是否借过本书
        $BM = New BookModel();
        $book_info = $BM->checkHasBorrowed($data);
        if(!$book_info){
            return ['code'=>1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
        }

        // 检测该书借阅时间
        $use_days = intval( (time() - strtotime(getArrayVelue($book_info, 'borrow_time'))) / 86400 );
        if($use_days < 20){
            return ['code'=>1,'msg'=>'借阅天数未超过20天，无法续借'];
        }

        // 事物啓動
        M()->startTrans();

        // 保持記錄
        $time_now = date('Y-m-d H:i:s');
        $HM = new HistoryModel();
        $history_data = [
            'book_id'=>$data['book_id'],
            'user_id'=>getArrayVelue($book_info, 'user_id'),
            'do_type'=>4,
            'do_time'=>$time_now
        ];
        $save_history = $HM->add($history_data);

        // 修改book表状态
        $book_data = [
            'status'=>4,
            'renew_time'=>$time_now
        ];
        $save_book = $BM->where(['id'=>$data['book_id']])->save($book_data);

        if($save_book && $save_history){
//            M()->rollback();
//            return ['code'=>1,'msg'=>'借阅失败'];
            M()->commit();
            return ['code'=>0,'msg'=>'续借成功，请注意还书时间，逾期将以每天1元罚金补充团队管理经费'];
        }else{
            M()->rollback();
            return ['code'=>1,'msg'=>'续借失败，可能是系统问题，你可以直接联系管理员'];
        }


    }


    /**
     * 罚金计算
     */
    public function getFine(&$book_info){
        if(!is_array($book_info)){
            return [];
        }

        $result = [];
        $time_now = time();

        // 已借用时间
        $use_days = intval( ($time_now - strtotime($book_info['borrow_time'])) / 86400 );
        $due_date = 0;      // 超时时间
        $fine = 0;          // 罚款
        $status = $book_info['status'];

        // 已借 未续借
        if($book_info['status'] == 2){
            $due_date = date('Y-m-d', strtotime($book_info['borrow_time'])+(86400*30));
            if($use_days >= 20 && $use_days<=30){
                $status = 10;  // 可续借
            }
            elseif($use_days > 30){
                $fine = intval((time()-strtotime($book_info['borrow_time']))/86400-30);
            }

        }

        // 已经续借
        if($book_info['status'] == 4){
            $due_date = date('Y-m-d', strtotime($book_info['borrow_time'])+(86400*60));
            if($due_date < date('Y-m-d')){
                $fine = intval((time()-strtotime($book_info['borrow_time']))/86400-60);
            }
        }


        // 已经丢失
        if($book_info['status'] == 3){
            $fine = intval(getArrayVelue($book_info, 'before_lose_fine', 0));
            $due_date = date('Y-m-d', strtotime($book_info['borrow_time'])+(86400*60));
            if($fine > 0){
                $fine = $fine + intval(($time_now - strtotime($book_info['lose_time']))/86400);
            }else{
                $fine = intval((time()-strtotime($book_info['borrow_time']))/86400-60);
            }
        }

        //添加数据
        $book_info['status'] = $status;
        $book_info['due_date'] = $due_date;
        $book_info['fine'] = $fine;
        $book_info['use_days'] = $use_days;

        return $book_info;

    }

}