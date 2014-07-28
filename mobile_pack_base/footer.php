<?php

/*
$Id: footer.php 195195 2010-01-19 04:11:37Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/trunk/themes/mobile_pack_base/footer.php $

Copyright (c) 2009 James Pearce & friends, portions mTLD Top Level Domain Limited, ribot, Forum Nokia

Online support: http://wordpress.org/extend/plugins/wordpress-mobile-pack/

This file is part of the WordPress Mobile Pack.

The WordPress Mobile Pack is Licensed under the Apache License, Version 2.0
(the "License"); you may not use this file except in compliance with the
License.

You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed
under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
CONDITIONS OF ANY KIND, either express or implied. See the License for the
specific language governing permissions and limitations under the License.
*/

?>

      <div id="menu" class="nav-main">
        <?php
          global $wpmp_theme_menu_location;
          if (function_exists('wp_nav_menu') && $wpmp_theme_menu_location) {
            wp_nav_menu(array(
              'theme_location'=>$wpmp_theme_menu_location,
              'menu_class'=>'breadcrumbs'
            ));
          } else {
            ?>
              <ul class="breadcrumbs">
                <li><a href="<?php bloginfo('url'); ?>/" title="<?php __('Home', 'wpmp'); ?>"><?php __('Home', 'wpmp'); ?></a></li>
                <?php wp_list_pages('title_li=&depth=1'); ?>
                <li><a href="#header">Top of page &uarr;</a></li>
              </ul>
            <?php
          }
        ?>
      </div>

      <div id="footer">
        <ul class="mobi-social">
            <li><a href="http://www.facebook.com/rapecrisiscapetown" title="Facebook">Facebook</a></li>
            <li><a href="https://twitter.com/rapecrisis" title="Twitter">Twitter</a></li>
            <li><a href="http://mxitapp.com/rapecrisis/signup" title="Mxit">Mxit</a></li>
        </ul>
        <?php wp_footer(); ?>
      </div>
    </div>
  </body>
</html>