<?php


namespace ChenJiaJing\WeWork\WeWork\Corp;


use ChenJiaJing\WeWork\Contracts\BaseCorp;
use ChenJiaJing\WeWork\Exceptions\InvalidResponseException;
use ChenJiaJing\WeWork\Exceptions\LocalCacheException;

class Oauth extends BaseCorp
{
    /**
     * Oauth 授权跳转接口
     * @param string $redirect_url 授权后重定向的回调链接地址
     * @param string $state 重定向后会带上state参数，企业可以填写a-zA-Z0-9的参数值，长度不可超过128个字节
     * @param string $scope 应用授权作用域。企业自建应用固定填写：snsapi_base
     * @return string
     */
    public function getOauthRedirect($redirect_url, $state = '', $scope = 'snsapi_base')
    {
        $corp_id      = $this->config->get('corpid');  //企业的CorpID
        $redirect_uri = urlencode($redirect_url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$corp_id}&redirect_uri={$redirect_url}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }


    /**
     * 获取用户userid
     * @param string $openid 用户的唯一标识
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function getUserInfo($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN&code={$code}";
        return $this->callGetApi($url);
    }
}
