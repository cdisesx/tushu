<?php
namespace Home\Controller;

use Common\Model\BookModel;
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
            'book_name'=>sget('book_name'),
            'page'=>sget('page',1),
            'size'=>sget('size',3),
        ];

        // 获取数据
        $bookModel = new BookModel();
        $list = $bookModel->getList($params);
        if($is_ajax){
            $this->getBookHtmlList($list);
            return;
        }

        // 加载
        if($params['id']>0){
            $this->assign('id',$params['id']);
        }
        $this->assign('list',$list);
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
     * 验证码验证
     */
    public function codeCheck(){

    }
    /**
     * 生成并发送验证码
     */
    public function sendCode(){
        $phone = spost('phone');
        $SMS = new SMSService();
        json_output($SMS->sendCodeSMS($phone));
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
}