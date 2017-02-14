<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 2017/2/14
 * Time: 10:46
 */
namespace Common\Service;

use Common\Model\CodeModel;

class SMSService{

    /**
     * 发送短信验证码
     */
    public function sendCodeSMS($phone){

        // 验证是否是手机号码
        if(!$this->checkIsPhone($phone)){
            return ['code' => 1,'msg'=> '请输入手机号码'];
        }

        // 生成验证码
        $code = rand(1111,9999);
//        $this->aliyunSMS($phone,$code);exit;

        // 保存验证码
        $save_result = $this->saveCode($phone,$code);

        // 发送短信
//        if( getArrayVelue($save_result, 'code') == 0 && !$this->aliyunSMS($phone,$code) ){
//            return ['code' => 1,'msg'=> '发送失败，请稍后重试'];
//        }

        return $save_result;
    }

    //定义get函数
    public function curl_get($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $dom = curl_exec($ch);
        curl_close($ch);
        return $dom;
    }

    /**
     * 阿里云短信接口
     */
    public function aliyunSMS($phone, $code){

        $params = [
            'Action'=>'SingleSendSms',
            'SignName'=>'abvc',
            'TemplateCode'=>'SMS_46790152',
            'RecNum'=>$phone,
            'ParamString'=>'{"code":"'.$code.'""}',
            'Format'=>'JSON'
        ];
        p($params);

        $url = 'https://sms.aliyuncs.com/';
        $url_params = http_build_query($params);
        $centent = $url.'?'.$url_params;
        p($centent);exit();

        $result = $this->curl_get();

    }

    /**
     * 来信码  一次0.1元！！
     * @param $phone
     * @param $centent
     * @return bool
     */
    public function laixinma($phone,$centent){

        $accesskey = 5509;
        $secretkey = '6b60cb2b5149f8e55c82094e1cbe32c2067d912f';
        $url = 'http://imlaixin.cn/Api/send/data/json';

        $send_url = $url.'?accesskey='.$accesskey.'&secretkey='.$secretkey.'&mobile='.$phone.'&content='.urlencode($centent);
//        $url = "?accesskey=100&secretkey=d4d5de5fmpuxfraf&mobile=13000008888&content=".urlencode("张三您好，验证码：84757【支付宝】");
        $json = $this->curl_get($send_url);
        $arr = json_decode($json,true); //格式化返回数组
        if($arr['result']=='01'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 保存验证码
     */
    public function saveCode($phone,$code){
        $CM = new CodeModel();
        $data = [
            'phone'=>$phone,
            'code'=>$code,
            'num'=>1,
            'send_time'=>date('Y-m-d H:i:s')
        ];

        // 获取验证码旧数据
        $code_info = $CM->where(['phone'=>$phone])->find();
        $code_id = getArrayVelue($code_info, 'id');

        // 判断短信是否超过10次
        if($code_id > 0){
            $num = getArrayVelue($code_info,'num',0);
            $send_time = getArrayVelue($code_info, 'send_time', '');
            $is_today = ( date('Y-m-d') == substr($send_time,0,10) ) ? true : false;

            if($is_today && $num >= 10){
                return ['code' => 1,'msg'=> '每天只能发送10次短信，请明天再来'];
            }

            // 添加发送短信次数
            $data['num'] = $num + 1;
            $CM->where(['id'=>$code_id])->save($data);
        }

        // 初次发送短信
        else{
            if(!$CM->add($data)){
                return ['code' => 1,'msg'=> '发送失败'];
            }
        }

        // 保存成功
        return ['code' => 0,'msg'=> '发送成功'];

    }

    /**
     * 验证是不是手机号码
     */
    public function checkIsPhone($phone){
        if(preg_match("/^1[34578]{1}\d{9}$/",$phone)){
            return true;
        }
        return false;
    }

}