<?php
/**
 * Created by PhpStorm.
 * User: Justin
 * Date: 2017/2/14
 * Time: 10:46
 */
namespace Common\Service;

use Common\Model\BookModel;
use Common\Model\CodeModel;

class SMSService{


    /**
     * aliyun config
     */
    // Access Key ID
    private $AccessKeyID = 'LTAIZw44tlaZzF7Y';
    // Access Key Secret
    private $AccessKeySecret = 'YXXaqOlMuAjhtRr4anryvAEsFtchQU';




    /**
     * 发送短信验证码
     */
    public function sendCodeSMS($params){

        $phone = getArrayVelue($params, 'phone');
        $cb = getArrayVelue($params, 'cb');

        if($cb > 0){
            $BM = new BookModel();
            if(!$BM->checkHasBorrowed($params)){
                return ['code'=>-1,'msg'=>'借用该书籍的手机号码与你填写的不相符，请重新输入'];
            }
        }

        // 验证是否是手机号码
        if(!$this->checkIsPhone($phone)){
            return ['code' => 1,'msg'=> '请输入手机号码'];
        }

        // 生成验证码
        $code = rand(1111,9999);
        $params['code'] = $code;

        // 保存验证码
        $save_result = $this->saveCode($params);

        // 发送短信
        if( getArrayVelue($save_result, 'code') == 0 && !$this->aliyunSMS($phone,$code) ){
            return ['code' => 1,'msg'=> '发送失败，请稍后重试'];
        }

        return $save_result;
    }

    /**
     * 阿里云短信发送接口
     */
    public function aliyunSMS($phone, $code){

        $params = array (
            // 公共参数
            'SignName' => '小小副短信',
            'Format' => 'JSON',
            'Version' => '2016-09-27',
            'AccessKeyId' => $this->AccessKeyID,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => rand(0,9999),
            'Timestamp' => gmdate ( 'Y-m-d\TH:i:s\Z' ),

            // 接口参数
            'Action' => 'SingleSendSms',
            'TemplateCode' => 'SMS_46745097',
            'RecNum' => $phone,
            'ParamString' => '{"code":"' . $code . '"}'
        );

        $params['Signature'] =  $this->computeSignature($params);
        $url_params = http_build_query($params);

        $centent = 'https://sms.aliyuncs.com/?'.$url_params;
        $result = $this->curl_get($centent);
        $result = json_decode($result,true);
        if(!$result || getArrayVelue($result, 'Code') || getArrayVelue($result, 'Message')){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 阿里云签名前格式转换
     * @param $string
     * @return mixed|string
     */
    private function percentEncode($string) {
        $string = urlencode ( $string );
        $string = preg_replace ( '/\+/', '%20', $string );
        $string = preg_replace ( '/\*/', '%2A', $string );
        $string = preg_replace ( '/%7E/', '~', $string );
        return $string;
    }

    /**
     * 阿里云签名
     */
    private function computeSignature($parameters) {
        $accessKeySecret = $this->AccessKeySecret;
        ksort ( $parameters );
        $canonicalizedQueryString = '';
        foreach ( $parameters as $key => $value ) {
            $canonicalizedQueryString .= '&' . $this->percentEncode ( $key ) . '=' . $this->percentEncode ( $value );
        }
        $stringToSign = 'GET&%2F&' . $this->percentencode ( substr ( $canonicalizedQueryString, 1 ) );
        $signature = base64_encode ( hash_hmac ( 'sha1', $stringToSign, $accessKeySecret . '&', true ) );
        return $signature;
    }

    /**
     * CURL信息发送
     * @param $url
     * @return mixed
     */
    public function curl_get($url){
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    /**
     * 保存验证码
     */
    public function saveCode($params){

        $phone = getArrayVelue($params, 'phone');

        $CM = new CodeModel();
        $data = [
            'phone'=>$phone,
            'code'=>getArrayVelue($params, 'code'),
            'num'=>1,
            'send_time'=>date('Y-m-d H:i:s'),
            'type'=>getArrayVelue($params, 'cb')
        ];

        // 获取验证码旧数据
        $code_info = $CM->where(['phone'=>$phone])->find();
        $code_id = getArrayVelue($code_info, 'id');

        // 判断短信是否超过上限次数
        if($code_id > 0){
            $num = getArrayVelue($code_info,'num',0);
            $send_time = getArrayVelue($code_info, 'send_time', '');
            $is_today = ( date('Y-m-d') == substr($send_time,0,10) ) ? true : false;

            $time = 10;
            if($is_today && $num >= $time){
                return ['code' => -1,'msg'=> '每天只能发送'.$time.'次短信，请明天再来'];
            }

            // 添加发送短信次数
            if($is_today){
                $data['num'] = $num + 1;

            }else{
                $data['num'] = 1;
            }
            // 执行编辑
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

    /**
     * 验证码验证
     */
    public function codeCheck(){
        $CM = new CodeModel();
        $search_data = [
            'phone'=>spost('phone'),
            'code'=>spost('code'),
            'type'=>spost('cb'),
            'send_time'=>['gt',  date("Y-m-d H:i:s",time()-60)]
        ];

        $code = $CM->where($search_data)->find();
        if(!$code){
            return false;
        }

        return true;
    }

}