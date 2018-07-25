<?php
/**
 * 授权系统 v1.0 客户端
 * author：沈唁
 * link：https://qq52o.me
 */
namespace client;

class OauthClient
{
    /**
     * 数组拼接为URL参数形式
     * @param $arr array
     * @return string
     */
    public static function arrayToStr($arr)
    {
        // 字典序排列参数
        ksort($arr);

        $valueArr = [];
        foreach ($arr as $key => $val) {
            $valueArr[] = "$key=$val";
        }
        $keyStr = implode("&", $valueArr);

        return $keyStr;
    }
}