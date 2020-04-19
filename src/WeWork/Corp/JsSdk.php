<?php


namespace ChenJiaJing\WeWork\WeWork\Corp;


use ChenJiaJing\WeWork\Contracts\BaseCorp;
use Illuminate\Support\Str;
use ChenJiaJing\WeWork\Exceptions\InvalidResponseException;
use ChenJiaJing\WeWork\Exceptions\LocalCacheException;

class JsSdk extends BaseCorp
{
  /**
   * @return mixed
   * @throws InvalidResponseException
   * @throws LocalCacheException
   */
  public function getTicket()
  {
    try {
      $url           = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN";
      $ticket_result = $this->callGetApi($url);
      if ($ticket_result['errcode'] == 0) {
        return $ticket_result['ticket'];
      }
    } catch (InvalidResponseException $e) {
    }
    throw new InvalidResponseException($e->getMessage(), $e->getCode());
  }

  /**
   * @param $jsdomain
   * @return array
   * @throws InvalidResponseException
   * @throws LocalCacheException
   */
  public function getJsApiTicket($jsdomain, $corpid = null, $agentid = null)
  {
    $jsapi_ticket = $this->getTicket();
    if (empty($corpid)) {
      $corpid = config('wework.CORP_ID');
    }
    if (empty($corpid)) {
      $agentid      = config('wework.APP_ID');
    }
    //随机生成16位字符
    $noncestr = Str::random(16);
    //时间戳
    $time = time();
    //拼接string1
    $jsapiTicketNew = "jsapi_ticket=$jsapi_ticket&noncestr=$noncestr&timestamp=$time&url=$jsdomain";
    //对string1作sha1加密
    $signature = sha1($jsapiTicketNew);
    //存入数据
    $ticket = [
      'corpid'      => $corpid,
      'agentid'     => $agentid,
      'timestamp'   => $time,
      'noncestr'    => $noncestr,
      'signature'   => $signature,
      'jsapiTicket' => $jsapi_ticket,
    ];
    return $ticket;
  }
}