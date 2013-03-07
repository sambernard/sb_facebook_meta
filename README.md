Concrete5 Facebook Meta
=======================

This package implements Facebook OpenGraph meta tags in Concrete5.

## Instructions

The og:url, og:title, and og:description tags are generated automatically once the package is installed, although they can be customized by editing the Custom Attributes for a page.

The following Facebook Open Graph meta tags are supported. These are available when editing a Page's custom attributes:

* Facebook Title `og:title` - If left blank, will use the page name
* Facebook Type `og:type - If left blank, will inherit from the home page
* Facebook Description `og:description` - If left blank, will use the "Meta Description". If that is blank, 
it will use the Page Description
* Facebook Share Image `og:image` - If left blank, will inherit from the home page
* Facebook Canonical URL `og:url` - Should be left blank unless you know what you are doing
* Additional Tags - This allows you to specify additional og/meta tags. Each tag should be
on a new line. The tag name and value are separated by a pipe (`|`). Example: 

  fb:app_id|12345678
  fb:admins|34235,12415
  og:video|http://example.com/movie.flv

To check that the meta tags are being generated correctly, test your URL using the [Facebook Debugger](https://developers.facebook.com/tools/debug)

The latest code and documentation can always be found [on Github](https://github.com/shihab-alain/sb_facebook_meta).