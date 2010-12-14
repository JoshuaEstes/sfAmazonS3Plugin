<?php
/**
 * @package sfAmazonS3Plugin
 * @subpackage test
 * @author Joshua.Estes <Joshua.Estes@ScenicCityLabs.com>
 * @version $Id$
 */

/**
 * Test file
 */
require_once dirname(__FILE__) . '/../../../../../config/ProjectConfiguration.class.php';
ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

include dirname(__FILE__) . '/../../../../../test/bootstrap/unit.php';

$t = new lime_test(1);
$t->diag('Trying to save a file. It will be stored at the location');
$t->diag(sfConfig::get('sf_upload_write_dir'));

$validator = new sfValidatedAmazonS3File('symfony.gif', 'gif', dirname(__FILE__).'/../../fixtures/symfony.gif', '532',  sfConfig::get('sf_upload_write_dir'));
$t->is($validator->save('symfony.gif'),'symfony.gif');
