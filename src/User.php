<?php


namespace ChenJiaJing\WeWork;

/**成员管理
 * Class User
 * @package ChenJiaJing\WeWork
 */
class User extends  BaseWeWork
{

  /**
   * @param array $data
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
    public function create($data = []){
      $url = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=ACCESS_TOKEN";
      $this->registerApi($url, __FUNCTION__, func_get_args());
      return $this->httpPostForJson($url, $data);
    }

  /**
   * @param string $SIZE_TYPE
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
    public function getJoinQrCode($SIZE_TYPE =''){
      $url = " https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN&size_type={$SIZE_TYPE}";
      $this->registerApi($url, __FUNCTION__, func_get_args());
      return $this->httpGetForJson($url);
    }
}
