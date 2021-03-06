<?php
/**
 * Installs the SBFacebookMeta Package and hooks events
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 * @package    SB Facebook Meta
 * @author     Sam Bernard <sam@jollyscience.com>
 * @copyright  2012 JollyScience LLC
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1
 * @link       http://pear.php.net/package/PackageName
 */

defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::library('concrete5-package-installer/jollyscience_package', 'sb_facebook_meta');

/**
 * SbFacebookMetaPackage class.
 *
 * @extends JollysciencePackage
 */
class SbFacebookMetaPackage extends JollysciencePackage {


  /**
   * pkgHandle
   *
   * @var string
   * @access protected
   */
  protected $pkgHandle = 'sb_facebook_meta';

  /**
   * appVersionRequired
   *
   * @var string
   * @access protected
   */
  protected $appVersionRequired = '5.6.0';

  /**
   * pkgVersion
   *
   * @var string
   * @access protected
   */
  protected $pkgVersion = '0.9.1';


  /**
   * getPackageName function.
   * 
   * @access public
   * @return void
   */
  public function getPackageName() {
    return t("Facebook OpenGraph Tags");
  }
  
  
  /**
   * getPackageDescription function.
   * 
   * @access public
   * @return void
   */
  public function getPackageDescription() {
    return t("Adds attributes for setting Facebook Open Graph tags. If an attributes isn\'t set, the package will try and create the Open Graph tag using other information, or by inheriting it from the Home Page.");
  }

  public function __construct(){
    parent::__construct();
        
    $this->commonAttributes = array(
        'og_title' => array(
          'name' => t('Facebook Title'),
          'type' => 'text'
        ),
        'og_type' => array(
          'name' => t('Facebook Type'),
          'type' => 'select',
          'selectOptions' => array(
            'article',
            'blog',
            'website',
            'activity',
            'sport',
            'bar',
            'company',
            'cafe',
            'hotel',
            'restaurant',
            'cause',
            'sports_league',
            'sports_team',
            'band',
            'government',
            'non_profit',
            'school',
            'university',
            'actor',
            'athlete',
            'author',
            'director',
            'musician',
            'politician',
            'public_figure',
            'city',
            'country',
            'landmark',
            'state_province',
            'album',
            'book',
            'drink',
            'food',
            'game',
            'product',
            'song',
            'movie',
            'tv_show'
          )
        ),
        'og_description' => array(
          'name' => t('Facebook Description'),
          'type' => 'textarea'
        ),
        'og_image' => array(
          'name' => t('Facebook Share Image'),
          'type' => 'image_file'
        ),
        'og_url' => array(
          'name' => t('Facebook Canonical URL (should not be needed)'),
          'type' => 'text'
        ),
        'og_additional_tags' => array(
          'name' => t('Additional newline separated OG Tags, in the format of og:tagname|value'),
          'type' => 'textarea'
        )
      );
  }

  /**
   * events
   *
   * The meta tags are added in the
   * `on_before_render` event
   *
   * @var mixed
   * @access public
   */
  public $events = array(
    'on_before_render' => array(
      array(
        'class' => 'SbFacebookMetaController',
        'method' => 'loadMeta',
        'path' => 'controllers/sb_facebook_meta.php'
      )
    )
  );
}