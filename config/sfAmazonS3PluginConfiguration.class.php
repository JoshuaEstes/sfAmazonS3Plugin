<?php

/**
 * sfAmazonS3Plugin configuration.
 * 
 * @package     sfAmazonS3Plugin
 * @subpackage  config
 * @author      Joshua Estes <Joshua.Estes@ScenicCityLabs.com>
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class sfAmazonS3PluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    /**
     * Zend Autoloader
     */
    ProjectConfiguration::registerZend();
    
    /**
     * configure amazon s3
     */
    $uploadDir = sfConfig::get('sf_upload_dir');
    if (
      sfConfig::get('app_amazon_s3_enabled')
      &&
      $bucket = sfConfig::get('app_amazon_s3_bucket')
    )
    {
      $this->registerAmazonS3Stream();
      $path = str_replace(sfConfig::get('sf_web_dir'), '', $uploadDir);

      sfConfig::add(array(
        'sf_upload_read_dir'  => 'http://'.$bucket.'.s3.amazonaws.com'.$path,
        'sf_upload_write_dir' => 's3://'.$bucket.$path,
      ));
    }
    else
    {
      sfConfig::add(array(
        'sf_upload_read_dir'  => $uploadDir,
        'sf_upload_write_dir' => $uploadDir,
      ));
    }
    /**
     * end amazon s3 config
     */
  }

  /**
   * 
   */
  public function registerAmazonS3Stream()
  {
    $s3 = new sfAmazonS3(
      sfConfig::get('app_amazon_s3_access_key'),
      sfConfig::get('app_amazon_s3_secret_key')
    );
    $s3->setDefaultACL(Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ);
    $s3->registerStreamWrapper('s3');
  }
}
