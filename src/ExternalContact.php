<?php

namespace ChenJiaJing\WeWork;

class ExternalContact extends  BaseWeWork
{
  public function create($data = []){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN";
    $this->registerApi($url, __FUNCTION__, func_get_args());
    return $this->httpPostForJson($url, $data);
  }

  public function addMsgTemplate(){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN";
    $this->registerApi($url, __FUNCTION__, func_get_args());
    return $this->httpPostForJson($url, $data);
  }

}