<?php
defined('C5_EXECUTE') or die("Access Denied.");


/**
 * SbFacebookMetaController class.
 * 
 * This class handles inserting the meta
 * tags into the document head
 *
 * @extends Controller
 */
class SbFacebookMetaController extends Controller {


  /**
   * og_tags
   *
   * These are the text-based inputs
   * that are iterated over when creating
   * meta tags. Other tags (such as og:image)
   * have to be handled manually since they may
   * be objects or arrays
   * 
   * @var mixed
   * @access public
   * @static
   */
  public static $og_tags = array(
    'og:title',
    'og:type',
    'og:url',
    'og:site_name',
    'og:description'
  );


  /**
   * loadMeta function.
   * 
   * Creates the meta tags and inserts them
   * into the page head. Some values, if not set,
   * will inherit from other attributes or the home
   * page attributes.
   *
   * Inheritance is as follows:
   *
   * * Facebook Title `og:title` - If left blank, will use the page name
   * * Facebook Type `og:type - If left blank, will inherit from the home page
   * * Facebook Description `og:description` - If left blank, will use the "Meta Description". If that is blank, 
   * it will use the Page Description
   * * Facebook Share Image `og:image` - If left blank, will inherit from the home page
   * * Facebook Canonical URL `og:url` - Should be left blank unless you know what you are doing
   * * Additional Tags - This allows you to specify additional og/meta tags. Each tag should be
   * on a new line. The tag name and value are separated by a pipe (`|`). Example: 
   *
   * @access public
   * @param mixed $v
   * @return void
   */
  public function loadMeta($v){
      $tagsToPrint = array();
      
      $c = Page::getCurrentPage();
      
      foreach(self::$og_tags as $tag){
        $tagValue = $c->getAttribute(str_replace(':', '_', $tag));
        
        if(!empty($tagValue)){
          $tagsToPrint[$tag]= $tagValue;
        } else {
          switch($tag){
            case 'og:title':
              $tagsToPrint[$tag]= $c->getCollectionName();  
            break;
            case 'og:description':
              $description = $c->getAttribute('meta_description');
              
              if(!empty($description)){
                $tagsToPrint[$tag]= $description;
              } else {
                $tagsToPrint[$tag]= $c->getCollectionDescription();
              }
            break;
            case 'og:url':
              $cPath = $c->getCollectionPath(); 
              $canonicalURL = BASE_URL.$c->getCollectionPath(); 
              $tagsToPrint['og:url'] = $canonicalURL;
              $v->addHeaderItem(sprintf('<link rel="canonical" href="%s" />', $canonicalURL));            
            break;
            default:
              $root = Page::getByID(1);
              $value = $root->getAttribute(str_replace(':', '_', $tag));
              if(!empty($value)){
                $tagsToPrint[$tag]= $value;
              }
          }
        }
      }
      
      $image = $c->getAttribute('og_image');
      
      if(!is_object($image)){
        $root = Page::getByID(1);
        $image = $root->getAttribute('og_image'); 
      }
      
      if(is_object($image)){
        $tagsToPrint['og:image'] = BASE_URL . $image->getRelativePath();
      }
      
      $additionalTags = explode("\n", $c->getAttribute('og_additional_tags'));
      
      foreach($additionalTags as $additionalTag){
        $additionalTag = str_replace('"', '\"', $additionalTag);
        $tag = explode('|', $additionalTag);
        
        if(count($tag) == 2){
          $tagsToPrint[$tag[0]] = $tag[1]; 
        }
      }
            
      if(!empty($tagsToPrint)){
        foreach($tagsToPrint as $key => $value){          
          $v->addHeaderItem(sprintf('<meta property="%s" content="%s"/>', $key, t(str_replace('"', '\"', $value))));
        }
      }
  }
}