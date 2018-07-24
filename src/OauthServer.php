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
     * 生成AppKey：公钥（相当于账号）
     * @return string
     */
    public static function setAppKey()
    {
        $data = time();
        return hash_hmac('md5', $data, 'server');
    }

    /**
     * 生成AppSecret：私钥（相当于密码）
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