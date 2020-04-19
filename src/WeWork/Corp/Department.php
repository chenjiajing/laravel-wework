<?php


namespace ChenJiaJing\WeWork\WeWork\Corp;

use ChenJiaJing\WeWork\Contracts\BaseCorp;

/**部门管理
 * Class Department
 * @package ChenJiaJing\WeWork
 */
class Department extends  BaseCorp
{

  /** 获取部门列表
   * @param string $id
   * @return array
   */
  public function list($id = null){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN&ID={$id}";
    return $this->callGetApi($url);
  }

  /**创建部门
   * @return array
   */
  public function create($data){
    $url = "https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=ACCESS_TOKEN";
    return $this->callPostApi($url,$data);
  }
}
