<?php
/**
 * 
 * @package sfAmazonS3Plugin
 * @subpackage Helper
 * @author Joshua Estes <Joshua.Estes@ScenicCityLabs.com>
 * @version $Id$
 */


/**
 * Custom helper function that uses the configured upload read path
 *
 * @param <type> $path
 * @param <type> $absolute
 * @return <type>
 */
function upload_path($path,$absolute = false)
{
  $uploadPath = sfConfig::get('sf_upload_read_dir');

  if (0 === strpos($uploadPath.'/'.$path))
  {
    return $uploadPath.'/'.$path;
  }
  else
  {
    $uploadPath = str_replace(sfConfig::get('sf_web_dir'), '', $uploadPath);

    return public_path($uploadPath.'/'.$path, $absolute);
  }
}