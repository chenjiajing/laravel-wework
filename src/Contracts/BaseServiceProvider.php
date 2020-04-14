<?php


namespace ChenJiaJing\WeWork\Contracts;


use ChenJiaJing\WeWork\BaseWeWork;
use ChenJiaJing\WeWork\Tools\ArrayTools;
use ChenJiaJing\WeWork\Tools\CacheTools;
use ChenJiaJing\WeWork\Tools\HttpTools;
use WeWork\Exceptions\InvalidArgumentException;
use WeWork\Exceptions\InvalidResponseException;
use WeWork\Exceptions\LocalCacheException;

/**第三方应用开发
 * Class WeWorkCorp
 * @package ChenJiaJing\WeWork
 */
class BaseServiceProvider extends BaseWeWork
{
    /**
     * @var
     */
    public $config;

    public $provider_access_token = '';

    /**
     * WeWorkCorp constructor.
     * @param array $options
     */
    public function __construct($secret = null,$corpid = null)
    {
        // 企业id
        if (empty($corpid)) {
            $corpid = config('wework.CORP_ID');
            if (empty($corpid)) {
                throw new \ChenJiaJing\WeWork\Exceptions\InvalidArgumentException("Missing Config -- [corpid]");
            }
        }
        // 默认为通讯录密钥
        if (empty($secret)) {
            $secret = config('wework.CONTACT_SYNC_SECRET');
            if (empty($secret)) {
                throw new InvalidArgumentException("Missing Config -- [secret]");
            }
        }
        $options      = [
            'corpid' => $corpid,
            'secret' => $secret,
        ];
        $this->config = new ArrayTools($options);
        parent::__construct($this->config);
        parent::__construct($type,$corpid,$secret);
    }


    /**
     * @return int|string
     * @throws LocalCacheException
     * @throws InvalidResponseException
     */
    public function getAccessToken()
    {
        if (!empty($this->provider_access_token)) {
            return $this->provider_access_token;
        }
        $cache              = $this->generateCacheName();
        $this->provider_access_token = CacheTools::getCache($cache);
        if (!empty($this->provider_access_token)) {
            return $this->provider_access_token;
        }
        // 如果缓存中没有，则重新获取
        list($corpid, $secret) = [$this->config->get('corpid'), $this->config->get('secret')];
        $url    = " https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token";
        $result = HttpTools::json2arr(HttpTools::post($url,['corpid'=>$corpid,'provider_secret'=>$secret]));
        info_data($result);
        if (!empty($result['access_token'])) {
            CacheTools::setCache($cache, $result['access_token'], 7000);
        }
        return $this->provider_access_token = $result['access_token'];
    }


}
