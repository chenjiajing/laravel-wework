<?php


namespace ChenJiaJing\WeWork\WeWork\Corp;

use ChenJiaJing\WeWork\Contracts\BaseCorp;
use ChenJiaJing\WeWork\Contracts\WeWorkCorp;

/**客户群管理
 * Class GroupChat
 * @package ChenJiaJing\WeWork
 */
class GroupChat extends BaseCorp
{

    //获取客户群列表
    public function list($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url,$data);
    }


    //获取客户群详情
    public function get($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url,$data);
    }

}
