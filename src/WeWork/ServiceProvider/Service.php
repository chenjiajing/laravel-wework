<?php


namespace ChenJiaJing\WeWork\WeWork\ServiceProvider;

use ChenJiaJing\WeWork\Contracts\BaseServiceProvider;

/**服务商
 * Class Department
 * @package ChenJiaJing\WeWork
 */
class Service extends BaseServiceProvider
{

    /**获取第三方应用凭证
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getSuiteToken($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token";
        return $this->httpGetForJson($url);
    }

    /**获取预授权码
     * @param $suite_access_token
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getPreAuthCode($suite_access_token)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callGetApi($url);
    }

    /**设置授权配置
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function setSessionInfo($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**获取企业永久授权码
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getPermanentCode($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_permanent_code?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**获取企业授权信息
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getAuthInfo($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_auth_info?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**获取企业凭证
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getCorpToken()
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**获取应用的管理员列表
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getAdminList($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=SUITE_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

    /**获取注册码
     * @param $data
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function getRegisterCode($data)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_register_code?provider_access_token=PROVIDER_ACCESS_TOKEN";
        return $this->callPostApi($url, $data);
    }

}
