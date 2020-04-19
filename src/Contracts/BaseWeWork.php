<?php


namespace ChenJiaJing\WeWork;


use ChenJiaJing\WeWork\Tools\ArrayTools;
use ChenJiaJing\WeWork\Tools\CacheTools;
use ChenJiaJing\WeWork\Tools\HttpTools;
use ChenJiaJing\WeWork\Exceptions\InvalidArgumentException;
use  ChenJiaJing\WeWork\Exceptions\InvalidResponseException;
use  ChenJiaJing\WeWork\Exceptions\LocalCacheException;

class BaseWeWork
{
    /**
     * @var
     */
    private $config;
    public $access_token = '';


    public function __construct($config)
    {
        $this->config = $config;
    }

  /**
   *     /**
   * 以GET获取接口数据并转为数组
   * @param string $url 接口地址
   * @return array|mixed
   * @throws InvalidResponseException
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
    protected function httpGetForJson($url)
    {
        try {
            return HttpTools::json2arr(HttpTools::get($url));
        } catch (InvalidResponseException $e) {
            if (isset($this->currentMethod['method']) && empty($this->isTry)) {
                if (in_array($e->getCode(), ['40014', '40001', '41001', '42001'])) {
                    $this->delAccessToken();
                    return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
                }
            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 清理删除 AccessToken
     * @return bool
     */
    public function delAccessToken()
    {
        $this->access_token = '';
        return CacheTools::delCache($this->generateCacheName());
    }

    /**
     * 以POST获取接口数据并转为数组
     * @param string $url 接口地址
     * @param array $data 请求数据
     * @param bool $buildToJson
     * @return array
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    protected function httpPostForJson($url, array $data, $buildToJson = true)
    {
        try {
            return HttpTools::json2arr(HttpTools::post($url, $buildToJson ? HttpTools::arr2json($data) : $data));
        } catch (InvalidResponseException $e) {
            if (in_array($e->getCode(), ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * 注册当前请求接口
     * @param string $url 接口地址
     * @param string $method 当前接口方法
     * @param array $arguments 请求参数
     * @return mixed
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    protected function registerApi(&$url, $method, $arguments = [])
    {
        $this->currentMethod = ['method' => $method, 'arguments' => $arguments];
        if (empty($this->access_token)) {
            $this->access_token = $this->getAccessToken();
        }
        switch (true) {
            case strpos($url, "SUITE_ACCESS_TOKEN"):
                $token_type = "SUITE_ACCESS_TOKEN";
                break;
            case strpos($url, "PROVIDER_ACCESS_TOKEN"):
                $token_type = "PROVIDER_ACCESS_TOKEN";
                break;
            case strpos($url, "ACCESS_TOKEN"):
                $token_type = "ACCESS_TOKEN";
                break;
            default:
                $token_type = "NO_TOKEN";
                break;
        }
        return $url = str_replace($token_type, $this->access_token, $url);
    }


  /**
   * 接口通用POST请求方法
   * @param string $url 接口URL
   * @param array $data POST提交接口参数
   * @param bool $isBuildJson
   * @throws InvalidResponseException
   * @throws LocalCacheException
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
    public function callPostApi($url, array $data, $isBuildJson = true)
    {
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data, $isBuildJson);
    }

    /**
     * 接口通用GET请求方法
     * @param string $url 接口URL
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     * @throws \WeWork\Exceptions\InvalidResponseException
     * @throws \WeWork\Exceptions\LocalCacheException
     */
    public function callGetApi($url)
    {
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 生成CacheName
     *
     */
    public function generateCacheName()
    {
        $corpid = $this->config->get('corpid');
        $secret = $this->config->get('secret');
        return md5($corpid . $secret) . '_access_token';
    }

}
