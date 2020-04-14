<?php


namespace ChenJiaJing\WeWork\WeWork\ServiceProvider;

use ChenJiaJing\WeWork\Contracts\BaseServiceProvider;

/**部门管理
 * Class Department
 * @package ChenJiaJing\WeWork\WeWork\ServiceProvider
 */
class Department extends  BaseServiceProvider
{

  /** 获取部门列表
   * @param string $id
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
  public function list($id = null){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN&id={$id}";
    return $this->callGetApi($url);
  }

  /**创建部门
   * @return array
   * @throws \WeWork\Exceptions\InvalidResponseException
   * @throws \WeWork\Exceptions\LocalCacheException
   */
  public function create($data){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=ACCESS_TOKEN";
    return $this->callPostApi($url,$data);
  }
}
