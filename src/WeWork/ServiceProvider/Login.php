<?php


namespace ChenJiaJing\WeWork\WeWork\ServiceProvider;

use ChenJiaJing\WeWork\Contracts\BaseServiceProvider;

/**登陆
 * Class Oauth
 * @package ChenJiaJing\WeWork
 */
class Login extends BaseServiceProvider
{

    /**构造网页授权链接
     * @param $redirect_url
     * @param string $state
     * @param string $scope 应用授权作用域。snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
     *                                           snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
     * @return string
     */
    public function getOauthRedirect($redirect_url, $state = '', $scope = 'snsapi_base')
    {
        $suite_id     = $this->config->get('suite_id');  //第三方应用id（即ww或wx开头的suite_id）。注意与企业的网页授权登录不同
        $redirect_uri = urlencode($redirect_url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$suite_id}&redirect_uri={$redirect_url}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**获取访问用户身份
     * @param $code
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getUserInfo3rd($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/getuserinfo3rd?suite_access_token=SUITE_ACCESS_TOKEN&code={$code}";
        return $this->callGetApi($url);
    }

    /** 获取访问用户敏感信息
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getUserDetail3rd($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/getuserinfo3rd?suite_access_token=SUITE_ACCESS_TOKEN&code={$code}";
        return $this->callPostApi($url, $data);
    }


}
