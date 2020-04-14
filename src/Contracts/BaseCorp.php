<?php


namespace ChenJiaJing\WeWork\Contracts;


use ChenJiaJing\WeWork\BaseWeWork;
use ChenJiaJing\WeWork\Exceptions\InvalidArgumentException;
use ChenJiaJing\WeWork\Tools\ArrayTools;
use ChenJiaJing\WeWork\Tools\CacheTools;
use ChenJiaJing\WeWork\Tools\HttpTools;

/**企业内部开发
 * Class WeWorkCorp
 * @package ChenJiaJing\WeWork
 */
class BaseCorp extends BaseWeWork
{
    /**
     * @var
     */
    public $config;

    public $access_token = '';


    /**
     * BaseCorp constructor.
     * @param null $secret
     * @param null $corpid
     */
    public function __construct($secret = null,$corpid = null)
    {
        // 企业id
        if (empty($corpid)) {
            $corpid = config('wework.CORP_ID');
            if (empty($corpid)) {
                throw new InvalidArgumentException("Missing Config -- [corpid]");
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
    }

    /**
     * @return int|string
     * @throws LocalCacheException
     * @throws InvalidResponseException
     */
    public function getAccessToken()
    {
        if (!empty($this->access_token)) {
            return $this->access_token;
        }
        $cache              = $this->generateCacheName();
        $this->access_token = CacheTools::getCache($cache);
        if (!empty($this->access_token)) {
            return $this->access_token;
        }
        // 如果缓存中没有，则重新获取
        list($corpid, $secret) = [$this->config->get('corpid'), $this->config->get('secret')];
        $url    = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$corpid}&corpsecret={$secret}";
        $result = HttpTools::json2arr(HttpTools::get($url));
        info_data($result);
        if (!empty($result['access_token'])) {
            CacheTools::setCache($cache, $result['access_token'], 7000);
        }
        return $this->access_token = $result['access_token'];
    }

}
