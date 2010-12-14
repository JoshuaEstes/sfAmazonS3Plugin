<?php
/**
 * @package sfAmazonS3Plugin
 * @subpackage sfAmazonS3
 * @author Joshua Estes <Joshua.Estes@ScenicCityLabs.com>
 * @version $Id$
 */

/**
 * 
 */
class sfAmazonS3 extends Zend_Service_Amazon_S3
{
  /**
   *
   * @var <type>
   */
  protected
    $defaultAcl = null;

  /**
   *
   * @param <type> $acl
   */
  public function setDefaultACL($acl)
  {
    $this->defaultAcl = $acl;
  }

  /**
   *
   * @param <type> $method
   * @param <type> $path
   * @param <type> $params
   * @param <type> $headers
   * @param <type> $data
   * @return <type> 
   */
  public function _makeRequest($method, $path='',$params=null,$headers=array(),$data=null)
  {
    if ('PUT' == $method && $this->defaultAcl)
    {
      $headers = array_merge(array(
        self::S3_ACL_HEADER => $this->defaultAcl,
      ), $headers);
    }

    return parent::_makeRequest($method,$path,$params,$headers,$data);
  }
}
