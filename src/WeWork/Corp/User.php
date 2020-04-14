<?php


namespace ChenJiaJing\WeWork\WeWork\Corp;

use ChenJiaJing\WeWork\Contracts\BaseCorp;

/**成员管理
 * Class User
 * @package ChenJiaJing\WeWork\Corp
 */
class User extends BaseCorp
{

    /**
     * @param array $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function create($data = [])
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**
     * @param string $SIZE_TYPE
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getJoinQrCode($SIZE_TYPE = '')
    {
        $url = " https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN&size_type={$SIZE_TYPE}";
        return $this->callGetApi($url);
    }

    public function get($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->callGetApi($url);
    }

    public function simpleList($department_id = null, $fetch_child = null)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token=ACCESS_TOKEN&department_id={$department_id}&fetch_child={$fetch_child}";
        return $this->callGetApi($url);
    }

    public function list($department_id = null, $fetch_child = null)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token=ACCESS_TOKEN&department_id={$department_id}&fetch_child={$fetch_child}";
        return $this->callGetApi($url);
    }

    public function convertToOpenid($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_openid?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url,$data);
    }

    public function convertToUserId($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/convert_to_userid?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url,$data);
    }

}
