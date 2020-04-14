<?php

namespace ChenJiaJing\WeWork\WeWork\Corp;

use ChenJiaJing\WeWork\Contracts\BaseCorp;

class ExternalContact extends  BaseCorp
{

  public function addMsgTemplate(){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN";
    return $this->callPostApi($url, $data);
  }

    // 成员-客户列表
    public function list($userid){
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->callGetApi($url);
    }

    //
    public function getFollowUserList()
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN";
        return $this->callGetApi($url);
    }

    public function get($external_userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN&external_userid=$external_userid";
        return $this->callGetApi($url);
    }

    public function remark($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url,$data);
    }

}
