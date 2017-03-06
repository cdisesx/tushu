<?php
namespace Home\Controller;

use Common\Model\BookModel;
use Common\Model\CodeModel;
use Common\Service\BookService;
use Common\Service\SMSService;
use Think\Controller;

class BookController extends Controller {

    /**
     * 书籍列表
     */
    public function bookList(){

        // 获取参数
        $is_ajax = sget('is_ajax');
        $params = [
            'id'=>sget('id'),
            'key_word'=>sget('key_word'),
            'page'=>sget('page',1),
            'size'=>sget('size',3),
        ];

        // 获取数据
        if($is_ajax){
            $bookModel = new BookModel();
            $list = $bookModel->getList($params);
            $this->getBookHtmlList($list);
            return;
        }

        // 加载
        if($params['id']>0){
            $this->assign('id',$params['id']);
        }

        $this->assign('params',$params);
        $this->display();
    }

    /**
     * 获取书籍Html列表
     */
    public function getBookHtmlList($list){
        $this->assign('list',$list);
        $this->display('bookListModel');
    }

    /**
     * 生成并发送验证码
     */
    public function sendCode(){

        $params = [
            'phone' => spost('phone'),
            'book_id' => spost('book_id'),
            'cb' => spost('cb')
        ];

        $SMS = new SMSService();
        json_output($SMS->sendCodeSMS($params));
    }

    /**
     * 借阅
     */
    public function borrowBook(){

        // 获取信息
        $data = [
            'book_id'=>spost('id'),
            'user_name'=>spost('user_name'),
            'phone'=>spost('phone')
        ];

        // 保存数据
        $BS = new BookService();
        json_output($BS->borrowBook($data));
    }

    /**
     * 归还
     */
    public function returnBook(){
        // 获取信息
        $data = [
            'book_id'=>spost('id'),
            'phone'=>spost('phone')
        ];

        // 保存数据
        $BS = new BookService();
        json_output($BS->returnBook($data));
    }

    /**
     * 报失
     */
    public function loseBook(){
        // 获取信息
        $data = [
            'book_id'=>spost('id'),
            'phone'=>spost('phone')
        ];

        // 保存数据
        $BS = new BookService();
        json_output($BS->loseBook($data));
    }


    /**
     * 续借
     */
    public function renewBook(){
        // 获取信息
        $data = [
            'book_id'=>spost('id'),
            'phone'=>spost('phone')
        ];

        // 保存数据
        $BS = new BookService();
        json_output($BS->renewBook($data));
    }
}