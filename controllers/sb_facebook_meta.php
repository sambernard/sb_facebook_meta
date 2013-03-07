<?php
defined('C5_EXECUTE') or die("Access Denied.");
class SbFacebookMetaController extends Controller {

  public static $og_tags = array(
    'og:title',
    'og:type',
    'og:url',
    'og:site_name',
    'fb:admins',
    'og:description',
  );

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