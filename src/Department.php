<?php


namespace ChenJiaJing\WeWork;

/**部门管理
 * Class Department
 * @package ChenJiaJing\WeWork
 */
class Department extends  BaseWeWork
{

  /** 获取部门列表
   * @param string $id
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
  public function list($id = ''){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN&ID={$id}";
    $this->registerApi($url, __FUNCTION__, func_get_args());
    return $this->httpGetForJson($url);
  }

  /**获取部门列表
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
  public function create($data){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=ACCESS_TOKEN";
    $this->registerApi($url, __FUNCTION__, func_get_args());
    return $this->httpPostForJson($url,$data);
  }
}
