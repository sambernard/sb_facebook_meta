Concrete5 Facebook Meta
=======================

This package implements Facebook OpenGraph meta tags in Concrete5.

## Instructions

This plugin adds the following attributes, available when editing
a Page's properties.

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