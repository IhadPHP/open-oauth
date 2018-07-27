<?php
/**
 * 授权系统 v1.0 服务端
 * author：沈唁
 * link：https://qq52o.me
 */
namespace oauth;

class OauthServer
{

    /**
     * 请求服务端接口 获取code
     * @param $clientId 申请应用时分配的AppId
     * @param $redirectUri 授权回调地址
     * @param string $responseType 返回类型，默认值为code
     * @param string $state 用于防止CSRF攻击，成功授权后回调时会原样带回
     */
    public function authorize($clientId,$redirectUri,$responseType = 'code',$state = '')
    {
        static $clientIdModel ; // 此处应为根据clientId从数据库中查到的数据

        if(empty($clientId)){
            return ['code'=>'100001','msg'=>'缺少参数client_id'];
        }elseif (empty($clientIdModel)){
            // 数据库查出来的数据为空，传递的参数和数据库中的不一致，则返回不存在
            return ['code'=>'100008','msg'=>'该appid不存在'];
        }elseif($redirectUri != $clientIdModel['redirect_uri']){
            //加强授权回调域验证
            return ['code'=>'100010','msg'=>'回调地址不合法'];
        }elseif ($responseType != 'code'){
            return ['code'=>'100000','msg'=>'缺少参数response_type或response_type非法'];
        }
    }

    public function setCode()
    {

    }

    /**
     * 生成AppId：应用的唯一标识
     * @param string $prefix 前缀
     * @param $num $num的值最大为9 结果为15个数字
     * @return string
     */
    public static function setAppId($num,$prefix = "")
    {
        $max = pow(10, $num) - 1;
        $min = pow(10, $num - 1);
        $code = date('Ym') . mt_rand($min, $max);
        // 年月+随机数
        // 201807766967323
        $string = $prefix.$code;
        return $string;
    }

    /**
     * 生成AppKey：公钥
     * @return string
     */
    public static function setAppKey()
    {
        $data = time();
        return hash_hmac('md5', $data, 'server');
    }

    /**
     * 生成AppSecret：私钥
     * @return string
     */
    public static function setAppSecret()
    {
        // 生成uuid
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8) . '-';
        $uuid .= substr($str, 8, 4) . '-';
        $uuid .= substr($str, 12, 4) . '-';
        $uuid .= substr($str, 16, 4) . '-';
        $uuid .= substr($str, 20, 12);
        //MD5加密
        $string = md5($uuid);
        return $string;
    }

}