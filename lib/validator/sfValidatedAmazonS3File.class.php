<?php
/**
 * @package sfAmazonS3Plugin
 * @subpackage Validator
 * @author Joshua Estes <Joshua.Estes@ScenicCityLabs.com>
 * @version $Id$
 */

/**
 * How to use this file, in your form create a widget, this is used as part of the
 * validator.
 *
 * [code]
 * $this->widgetSchema['image'] = new sfWidgetFormInputFile();
 * $this->validatorSchema[image'] = new sfValidatorFile(array(
 *   'mime_types' => 'web_images',
 *   'path' => sfConfig::get('sf_upload_write_dir').'/direcory',
 *   'validated_file_class' => 'sfValidatedAmazonS3File'
 * ));
 * [/code]
 */

/**
 *
 */
class sfValidatedAmazonS3File extends sfValidatedFile
{
  /**
   *
   * @param  string $file      The file path to save the file
   * @param  int    $fileMode  The octal mode to use for the new file
   * @param  bool   $create    Indicates that we should make the directory before moving the file
   * @param  int    $dirMode   The octal mode to use when creating the directory
   *
   * @return string The filename without the $this->path prefix
   *
   * @throws Exception
   */
  public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    if (null === $file)
    {
      $file = $this->generateFilename();
    }

    if (0 !== strpos($file,'/'))
    {
      if (null === $this->path)
      {
        throw new RuntimeException('You must give a "path" when you give a relative file name.');
      }

      $file = $this->path.'/'.$file;
    }

    $directory = dirname($file);

    @mkdir($directory, $dirMode, true);
    @chmod($directory, $dirMode);

    copy($this->getTempName(), $file);
    @chmod($file, $fileMode);

    $this->savedName = $file;

    return null === $this->path ? $file : str_replace($this->path.'/', '', $file);
  }
}