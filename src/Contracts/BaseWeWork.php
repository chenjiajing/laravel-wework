<?php


namespace ChenJiaJing\WeWork;


use ChenJiaJing\WeWork\Tools\ArrayTools;
use ChenJiaJing\WeWork\Tools\CacheTools;
use ChenJiaJing\WeWork\Tools\HttpTools;
use WeWork\Exceptions\InvalidArgumentException;
use WeWork\Exceptions\InvalidResponseException;
use WeWork\Exceptions\LocalCacheException;

class BaseWeWork
{
    /**
   * @var
   */
    public $config;

    public $access_token = '';

  /**
   * BaseWeWork constructor.
   * @param array $options
   */
    public function __construct( array  $options)
    {
        if (empty($options['corpid'])) {
          throw new InvalidArgumentException("Missing Config -- [corpid]");
        }

        if (empty($options['corpsecret'])) {
          throw new InvalidArgumentException("Missing Config -- [corpid]");
        }
        $this->config =  new ArrayTools($options);
    }

  /**
   * @return int|string
   * @throws LocalCacheException
   * @throws InvalidResponseException
   */
    public function getAccessToken(){
        if(!empty($this->access_token)){
            return $this->access_token;
        }

        $cache = $this->config->get('corpid').'_access_token';
        $this->access_token = CacheTools::getCache($cache);
        if(!empty($this->access_token)){
           return $this->access_token;
        }
        // 如果缓存中没有，则重新获取
        list($corpid,$corpsecret) = [$this->config->get('corpid'), $this->config->get('corpsecret')];
        $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$corpid}&corpsecret={$corpsecret}";
        $result  = HttpTools::json2arr(HttpTools::get($url));
        if(!empty($result['access_token'])){
            CacheTools::setCache($cache,$result['access_token'],7000);
        }
        return  $this->access_token  =  $result['access_token'];
    }



  /**
   * 以GET获取接口数据并转为数组
   * @param string $url 接口地址
   * @return array
   * @throws InvalidResponseException
   * @throws LocalCacheException
   */
  protected function httpGetForJson($url)
  {
    try {
      return HttpTools::json2arr(HttpTools::get($url));
    } catch (InvalidResponseException $e) {
      if (isset($this->currentMethod['method']) && empty($this->isTry)) {
        if (in_array($e->getCode(), ['40014', '40001', '41001', '42001'])) {
          $this->delAccessToken();
          $this->isTry = true;
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
    return CacheTools::delCache($this->config->get('corpid') . '_access_token');
  }

  /**
   * 以POST获取接口数据并转为数组
   * @param string $url 接口地址
   * @param array $data 请求数据
   * @param bool $buildToJson
   * @return array
   * @throws InvalidResponseException
   * @throws LocalCacheException
   */
  protected function httpPostForJson($url, array $data, $buildToJson = true)
  {
    try {
      return HttpTools::json2arr(HttpTools::post($url, $buildToJson ? HttpTools::arr2json($data) : $data));
    } catch (InvalidResponseException $e) {
      if (!$this->isTry && in_array($e->getCode(), ['40014', '40001', '41001', '42001'])) {
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
    return $url = str_replace('ACCESS_TOKEN', $this->access_token, $url);
  }

  /**
   * 接口通用POST请求方法
   * @param string $url 接口URL
   * @param array $data POST提交接口参数
   * @param bool $isBuildJson
   * @return array
   * @throws InvalidResponseException
   * @throws LocalCacheException
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
   */
  public function callGetApi($url)
  {
    $this->registerApi($url, __FUNCTION__, func_get_args());
    return $this->httpGetForJson($url);
  }

}
