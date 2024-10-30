<?php 
/*
 * Plugin Name: Kachingle Medallion
 * Version: 1.4
 * Plugin URI: http://kachingle.com
 * Description: Enables use of the <a href="http://www.kachingle.com/">Kachingle Medallion</a> on your blog.
 * Author: Kachingle, Inc.
 * Author URI: http://www.kachingle.com/
 * Text Domain: kachingle-medallion
 * License: GPL2
 */

// Plugin version
define('KACHINGLE_MEDALLION_VERSION', '1.4');
define('KM_PLUGIN_DOMAIN',            'kachingle-medallion');
define("SETTINGS_TITLE",              "Kachingle Medallion Settings");

// Style images
define("KM_IMG_WIDE",                 "http://images.kachingle.net/medallionshots/wide_green_closed.png");
define("KM_IMG_NARROW",               "http://images.kachingle.net/medallionshots/narrow_green_closed.png");
define("KM_IMG_JAZZ",                 "http://images.kachingle.net/medallionshots/mini_green.png");

// Default values
define("DEF_MED_NO",                  "0000");

/**
 * Custom validation for Marketing Message field
 **/
function km_msg_filter($inp) {
  $allowed = array('a' => array(),'b' => array(),'strong' => array(),'i' => array(),'em' => array());
  $prot = array('http','https');
  $inp = stripslashes(wp_kses($inp, $allowed, $prot));
  return $inp;
}

add_action('admin_menu', 'km_create_menu');
function km_create_menu() {
  add_options_page(SETTINGS_TITLE, SETTINGS_TITLE, 'administrator', __FILE__, 'kam_settings_page', plugins_url('/km-icon.jpg', __FILE__));
	add_action( 'admin_init', 'register_kam_settings' );
}

function register_kam_settings() {
  register_setting( 'kam-settings-group', 'author_medallion_ids', 'kam_validate' );
}

function kam_validate($inputs) {
  // just need to check that if a medallion ID was entered it's an integer
  // so no need to run this function when we have the non-user input version of array
  if(isset($inputs[0]['name'])) {
    return $inputs;
  }

  for($i=0; $i < count($inputs); $i++) {
    if(!is_numeric($inputs[$i]['medid'])) {
      $inputs[$i]['medid'] = (preg_match('/\d{4}/', $inputs[$i]->medid)) ? $inputs[$i]->medid : DEF_MED_NO;
    }
  }

  return kam_build_authors_list('validate', $inputs); // $inputs;
}
function kam_build_authors_list($src='unknown', $aMeds=array()) {
  $aSrcs = array('unknown','init','validate');
  if(!in_array($src, $aSrcs)) die($src); // for debugging

  if($src == 'validate') {
    $meds = '';
  } else {
    $existingIds = get_option('author_medallion_ids');
    $meds = ($existingIds == "") ? "" : $existingIds;
  }
  $blogusers = get_users_of_blog();
  $potential_kachinglers = array();

  $i = 0;
  foreach ($blogusers as $bloguser) {
    $u = get_userdata($bloguser->ID);
    // check if user is at least Author level
    if($u->user_level > 0) {
      if(is_array($meds)) {
        $bum = array_search($bloguser->user_id, $meds);
        $bumid = ($bum === false) ? DEF_MED_NO : $bum['med_id'];
      } elseif($src == 'validate') {
        $bumid = $aMeds[$i]['medid'];
      } else {
        $bumid = DEF_MED_NO;
      }
      $potential_kachinglers[] = array('name' => $bloguser->user_login, 'id' => $bloguser->ID, 'medid' => $bumid);
    }
    $i++;
  }
  return $potential_kachinglers;
}

function kam_settings_page() {
  $author_medallion_ids = get_option('author_medallion_ids'); 
  if(!isset($author_medallion_ids[0]['name'])) {
    $author_medallion_ids = kam_build_authors_list('init');
  }
  $user_count = count($author_medallion_ids);
  if($user_count == 0) {
    // This should not be possible. But just in case...
    echo '<div class="wrap"><h2>'. SETTINGS_TITLE .'</h2>';
    echo '<h2>No users on this blog have Author or higher capability roles</h2><p>This should not be possible.</p></div>';
    return;
  }
  ?>
  
  <div class="wrap">
    <h2><?php echo SETTINGS_TITLE; ?></h2>

    <form method="post" action="options.php">
        <?php settings_fields( 'kam-settings-group' ); ?>
        <table class="form-table">
          <tr valign='top'>
          <th style='font-weight: bold; width: 20%;'>Author</th><th style='font-weight: bold;'>Medallion No.</th>
          </tr>
          <?php for($i=0; $i < $user_count; $i++) { ?>
            <tr valign="top">
              <th scope="row">User ID <?php echo $author_medallion_ids[$i]['id'] ?>: <?php echo $author_medallion_ids[$i]['name'] ?></th>
              <td><input type="text" name="author_medallion_ids[<?php echo $i; ?>][medid]" value="<?php echo $author_medallion_ids[$i]['medid'] ?>" /></td>
            </tr>
          <?php } ?>
        </table>

        <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
        </p>

    </form>

    <div id='help-text' style='width: 70%;'>
    <h2>Medallion Styles and Sizes</h2>
    <p>The Kachingle Medallion is available in three styles:</p>
    <ul style='list-style: disc inside;'>
      <li><strong>Neoclassical:</strong> 160 x 75 pixels<br/><img src='<?php echo KM_IMG_NARROW ;?>' style='padding: 10px 12px 0px;' alt='' title= '' /></li>
      <li><strong>Classical:</strong> 234 x 73 pixels<br/><img src='<?php echo KM_IMG_WIDE ;?>' style='padding: 10px 12px 0px;' alt='' title= '' /></li>
      <li><strong>Jazz:</strong> 61 x 61 pixels<br/><img src='<?php echo KM_IMG_JAZZ ;?>' style='padding: 10px 12px 0px;' alt='' title= '' /></li>
    </ul>
    
    <h2>Using the Template Tags and Shortcodes</h2>
    <p>You can use separate Kachingle Medallions for each author in addition to one for the entire site, enabling readers to support authors individually. To do this, enter the individual Medallion Numbers above (after creating their Medallions at Kachingle.com), and use the either the custom template tags in your template or the shortcodes in posts and pages. The rest of the page lists sample code for using both.</p>
    <h3>Template tag for your Site-wide Medallion</h3>
    <ul>
     <li>Specify Medallion Number (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)<br>
     <pre>&lt;?php show_kachingle_medallion('1', '&lt;b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love', 'classical'); ?></pre></li>
     <li>Specify Medallion Number and style, no message so pass empty string<br>
     <pre>&lt;?php show_kachingle_medallion('1', '', 'jazz'); ?></pre></li>
     <li>Specify Medallion Number only (neoclassical style, no message)<br>
     <pre>&lt;?php show_kachingle_medallion('1'); ?></pre></li>
     <li>Specify Medallion Number (required), style defaults to neoclassical and brief marketing message<br>
     <pre>&lt;?php show_kachingle_medallion('1', '&lt;b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love'); ?></pre></li>
    </ul>

    <h3>Shortcode for your Site-wide Medallion</h3>
    <ul>
     <li>Specify Medallion Number (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)<br>
     <pre>[kachingle_medallion medallion_no='1' stylename='jazz' msg='&lt;b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love']</pre></li>
     <li>Specify Medallion Number and style, no message<br>
     <pre>[kachingle_medallion medallion_no='1' stylename='classical']</pre></li>
     <li>Specify Medallion Number (required), style defaults to neoclassical and brief marketing message<br>
     <pre>[kachingle_medallion medallion_no='1' msg='&lt;b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love']</pre></li>
    </ul>

    <h3>Template Tag for Author Medallions</h3>

    <p><strong>Note:</strong> to use this in posts or pages and have WordPress determine the author ID, use the WordPress function get_the_author_meta( 'ID' ) rather than passing a specific author ID.</p>
    <ul>
     <li>Specify Author ID (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)<br>
     <pre>&lt;?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '&lt;b>Support This Author&lt;/b> Kachingle is a great, simple way to show support for this author', 'classical'); ?></pre></li>
     <li>Specify Author ID and style, no message so pass empty string<br>
     <pre>&lt;?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '', 'jazz'); ?></pre></li>
     <li>Specify Author ID only (neoclassical style, no message)<br>
     <pre>&lt;?php show_kachingle_author_medallion(get_the_author_meta( 'ID' )); ?></pre></li>
     <li>Specify Author ID (required), style defaults to neoclassical and brief marketing message<br>
     <pre>&lt;?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '&lt;b>Support the Author&lt;/b> Kachingle is a great, simple way to show support for this author'); ?></pre></li>
    </ul>

    <h3>Shortcode for Author Medallions</h3>
    <p><strong>Note:</strong> You must supply the actual Author ID, it cannot be determined dynamically.</p>
    <ul>
     <li>Specify Author ID (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)<br>
     <pre>[ka_medallion author_id='1' stylename='neoclassical' msg='&lt;b>Support This Author&lt;/b> Kachingle is a simple way to support this author and site and other sites you love']</pre></li>
     <li>Specify Author ID and style, no message<br>
     <pre>[ka_medallion author_id='1' stylename='jazz']</pre></li>
     <li>Specify Author ID (required), style defaults to neoclassical and brief marketing message<br>
     <pre>[ka_medallion author_id='1' msg='&lt;b>Support This Author&lt;/b> Kachingle is a simple way to support this author and site and other sites you love']</pre></li>
    </ul></div>
  </div>
  <?php
}

function get_post_author($aut, $this_post='') {
  if($this_post == '') {
    global $post;
    $this_post = $post;
  }
  $post_auth = get_post_meta($post->ID, '_edit_last', true);
  return ($aut['id'] == $post_auth);
}

// returns current author medallion ID or NONE if no author medallion ID
function author_med_id() {
  global $post;
  if(!$post->ID) {
    $qs = preg_split('/=/',$_SERVER['QUERY_STRING']);
    if($qs[0] == 'p') { // post
      $this_post = get_post($qs[1]);
    } else {
      return 'NONE';
    }
  }
  $aIds = get_option('author_medallion_ids');
  $aAut = array_filter($aIds, 'get_post_author');
  return (is_array($aAut[0]) ? $aAut[0]['medid'] : 'NONE');
}

/**
 * Builds the Medallion code
 **/
function build_km_string($medallion_no, $m_style, $msg) {
  $m_style = strtolower($m_style);
  $style_height = get_style_height($m_style);
  $r  = "<!-- Kachingle Medallion " . KACHINGLE_MEDALLION_VERSION . ": http://kachingle.com -->\n";
  $r .= (strlen($msg) > 0) ? '<br/>' . $msg . '<br/><br/>' : ($m_style == 'jazz') ? '' : '<br />';
  $r .= "<!-- BEGIN KACHINGLE MEDALLION --><script type=\"text/javascript\">if (!window.kachingle_loaded) {var _protocol = 'http'+(window.location.protocol == 'https:' ? 's' : '');document.writeln(unescape(\"%3Cscript type='text/javascript' src='\"+_protocol+\"://medallion.kachingle.com/kachingle_controls_revb.js'>%3C/script>\"));}</script><div class='kmedallioncontainer' style='height:" . $style_height . ";'><iframe site='" . $medallion_no . "' stylename='" . $m_style ."' style='display:none;' scrolling='no' frameborder='0'></iframe></div><!-- END KACHINGLE MEDALLION -->";
  return $r;
}

/**
 * Get the Medallion height for desired style
 **/
function get_style_height($m_style) {
  if($m_style == 'classical' || $m_style == 'wide') {
    $sh = 73;
  } elseif($m_style == 'jazz') {
    $sh = 61;
  } else { // neoclassical / narrow is default style
    $sh = 75;
  }
  return $sh . 'px';
  
}

/**
 * Template tag for the Medallion code
 * Examples: 
 *  Specify Medallion Number (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)
 *  <?php show_kachingle_medallion('1', '<b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love', 'classical'); ?>
 *  Specify Medallion Number and style, no message so pass empty string
 *  <?php show_kachingle_medallion('1', '', 'jazz'); ?>
 *  Specify Medallion Number only (neoclassical style, no message)
 *  <?php show_kachingle_medallion('1'); ?>
 *  Specify Medallion Number (required), style defaults to neoclassical and brief marketing message
 *  <?php show_kachingle_medallion('1', '<b>Regular Reader?&lt;/b> Kachingle is a simple way to support my site and other sites you love'); ?>
 **/
function show_kachingle_medallion($medallion_no, $msg='', $style='neoclassical') {
	if ( $medallion_no != DEF_MED_NO ) {
  	echo build_km_string($medallion_no, $style, $msg);
  } else { // end if $medallion_no test
		echo "<!-- Kachingle Medallion template tag / should never get here -->\n";
	}
}

/**
 * Template tag for the Author Medallion code
 *
 * Note: to use this in posts or pages and have WordPress determine the author ID,
 *   use the WordPress function get_the_author_meta( 'ID' ) rather than passing a 
 *   specific author ID
 *
 * Examples: 
 *  Specify Author ID (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)
 *  <?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '&lt;b>Support This Author</b> Kachingle is a simple way to support this author and site and other sites you love', 'classical'); ?>
 *  Specify Author ID and style, no message so pass empty string
 *  <?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '', 'classical'); ?>
 *  Specify Author ID only (neoclassical style, no message)
 *  <?php show_kachingle_author_medallion(get_the_author_meta( 'ID' )); ?>
 *  Specify Author ID (required), style defaults to neoclassical and brief marketing message
 *  <?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), ''&lt;b>Support This Author</b> Kachingle is a simple way to support this author and site and other sites you love'); ?>
 **/
function show_kachingle_author_medallion($author_id, $msg='', $style='neoclassical') {
  $medallion_no = get_author_medallion($author_id);
	if ( $medallion_no != 'NONE' && $medallion_no != DEF_MED_NO ) {
  	echo build_km_string($medallion_no, $style, $msg);
  } else { // end if $medallion_no test
		echo "<!-- Kachingle Author Medallion tempalte tag / should never get here -->\n";
	}
}

function get_author_medallion($author_id) {
  $aIds = get_option('author_medallion_ids');
  foreach($aIds as $auth) {
    if($auth['id'] == $author_id) {
      return $auth['medid'];
    }
  }
  return 'NONE';
}

/**
 * Shortcode version of the Medallion code
 * Examples: 
 *  Specify Medallion Number (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)
 *  [kachingle_medallion medallion_no='1' stylename='neoclassical' msg='<b>Regular Reader?</b> Kachingle is a simple way to support my site and other sites you love']
 *  Specify Medallion Number and style, no message
 *  [kachingle_medallion medallion_no='1' stylename='classical']
 *  Specify Medallion Number (required), style defaults to neoclassical and brief marketing message
 *  [kachingle_medallion medallion_no='1' msg='<b>Regular Reader?</b> Kachingle is a simple way to support my site and other sites you love']
 **/
function km_shortcode($atts, $content = null, $code="") {
	extract(shortcode_atts(array('medallion_no' => '0000', 'stylename' => "neoclassical", 'msg' => ''), $atts));
	if ( $medallion_no != DEF_MED_NO ) {
  	$r = build_km_string($medallion_no, $stylename, $msg);
  } else { // end if $medallion_no test
  	$r = "<!-- Kachingle Medallion shortcode / $medallion_no / should never get here -->\n";
  }
  return $r;
}
add_shortcode('kachingle_medallion', 'km_shortcode');

/**
 * Shortcode version of the Author Medallion code
 * Examples: 
 *  Specify Author ID (required), style (jazz, classical or neoclassical, defaults to neoclassical) and brief marketing message (optional)
 *  [ka_medallion author_id='1' stylename='neoclassical' msg='<b>Support This Author</b> Kachingle is a simple way to support this author and site and other sites you love']
 *  Specify Author ID and style, no message
 *  [ka_medallion author_id='1' stylename='jazz']
 *  Specify Author ID (required), style defaults to neoclassical and brief marketing message
 *  [ka_medallion author_id='1' msg='<b>Support This Author</b> Kachingle is a simple way to support this author and site and other sites you love']
 **/
function km_author_shortcode($atts, $content = null, $code="") {
	extract(shortcode_atts(array('author_id' => 'NONE', 'stylename' => "neoclassical", 'msg' => ''), $atts));
  $medallion_no = get_author_medallion($author_id);
	if ( $medallion_no != 'NONE' && $medallion_no != DEF_MED_NO ) {
  	$r = build_km_string($medallion_no, $stylename, $msg);
  } else { // end if $medallion_no test
  	$r = "<!-- Kachingle Medallion shortcode / $medallion_no / should never get here -->\n";
  }
  return $r;
}
add_shortcode('ka_medallion', 'km_author_shortcode');

class KachingleMedallionWidget extends WP_Widget {
  var $def_heading;
  var $def_message;
  var $i_title;
  var $i_medno;
  var $i_messg;
  var $i_style;
  
  /**
   * Constructor
   **/
  function KachingleMedallionWidget() {
    $this->def_heading = __("Support This Site");
    $this->def_message = __('<b>Regular Reader?</b> Kachingle is a simple way to support my site and other sites you love');
    
    $widget_ops = array('classname' => 'widget_kachingle_medallion', 'description' => __( 'Add your Kachingle Medallions') );
    $this->WP_Widget('KachingleMedallion', __('Kachingle Medallions'), $widget_ops);
  }

  function _curvalues($instance) {
		if(isset($instance["KM_MEDALLION_NO"])) {
		  $this->i_medno = $instance["KM_MEDALLION_NO"];
      $this->i_title = isset($instance["KM_HEADING"]) ? $instance["KM_HEADING"] : '';
      $this->i_messg = isset($instance["KM_MARKETING_MESSAGE"]) ? $instance["KM_MARKETING_MESSAGE"] : '';
      $this->i_style = isset($instance["KM_STYLE"]) ? strtolower( $instance["KM_STYLE"] ) : "neoclassical";
    } else {
      $this->i_title = $this->def_heading;
      $this->i_medno = DEF_MED_NO;
      $this->i_messg = $this->def_message;
      $this->i_style = "neoclassical";
    }
  }
  
  /**
   * Output Medallion Widget
   **/
  function widget($args, $instance) {
    extract($args);
		$this->_curvalues($instance);

  	if ($this->i_medno == DEF_MED_NO || $this->i_medno == "") {
  		echo "<!-- Kachingle Medallion / No Medallion number found / should never get here -->\n";
  	} else {
      // Main codeline
	    $medallion_no = $instance["KM_MEDALLION_NO"];

      $title = apply_filters('widget_title', empty($instance["KM_HEADING"]) ? '' : $instance["KM_HEADING"], $instance, $this->id_base);
      echo $before_widget;
      if ( $title )
        echo $before_title . $title . $after_title;
  		echo build_km_string($medallion_no, $instance["KM_STYLE"], $instance["KM_MARKETING_MESSAGE"]);
      echo $after_widget;
    }
  }

  /**
   * Save widget data to db
   **/
  function update($new_instance, $old_instance) {				
	  $instance = $old_instance;
    if(!$this->author_med) {
	    $instance["KM_MEDALLION_NO"] = strip_tags($new_instance["KM_MEDALLION_NO"]);
    }
	  $instance["KM_HEADING"] = stripslashes(strip_tags($new_instance["KM_HEADING"]));
	  $instance["KM_MARKETING_MESSAGE"] = km_msg_filter($new_instance["KM_MARKETING_MESSAGE"]);
	  $instance["KM_STYLE"] = $new_instance["KM_STYLE"];
    return $instance;
  }

  /**
   * Widget admin form
   **/
  function form($instance) {
		$this->_curvalues($instance);

    ?>
      <p>
        <label for="<?php echo $this->get_field_id("KM_HEADING"); ?>"><?php _e('Title:'); ?> 
          <input class="widefat" id="<?php echo $this->get_field_id("KM_HEADING"); ?>" name="<?php echo $this->get_field_name("KM_HEADING"); ?>" type="text" value="<?php echo $this->i_title; ?>" />
        </label>
      </p>
      <?php if(!$this->author_med) { // no need to solicit medallion ID for author widget ?>
      <p>
        <label for="<?php echo $this->get_field_id("KM_MEDALLION_NO"); ?>"><?php _e('Medallion Number:'); ?> 
          <input class="widefat" id="<?php echo $this->get_field_id("KM_MEDALLION_NO"); ?>" name="<?php echo $this->get_field_name("KM_MEDALLION_NO"); ?>" type="text" value="<?php echo $this->i_medno; ?>" />
        </label>
      </p>
      <?php } ?>
      <p>
        <label for="<?php echo $this->get_field_id("KM_MARKETING_MESSAGE"); ?>"><?php _e('Marketing Message:'); ?> 
          <input class="widefat" id="<?php echo $this->get_field_id("KM_MARKETING_MESSAGE"); ?>" name="<?php echo $this->get_field_name("KM_MARKETING_MESSAGE"); ?>" type="text" value="<?php echo $this->i_messg; ?>" />
        </label>
      </p>
			<p>
				<label for="<?php echo $this->get_field_id("KM_STYLE"); ?>"><?php _e('Style'); ?>:</label>
				<?php
				echo "<select name='".$this->get_field_name("KM_STYLE")."' id='".$this->get_field_id("KM_STYLE")."'>\n";
				echo "<option";
				if($this->i_style == "wide" || $this->i_style == "classical")
					echo " selected='selected'";
				echo ">" . __("Classical") . "</option>\n";
				echo "<option";
				if($this->i_style == "narrow" || $this->i_style == "neoclassical")
					echo " selected='selected'";
				echo ">" . __("Neoclassical") . "</option>\n";
				echo "<option";
				if($this->i_style == "jazz")
					echo " selected='selected'";
				echo ">" . __("Jazz") . "</option>\n";
				echo "</select>\n";
				?>
			</p>
    <?php 
  }
}

class WhosKachinglingWhomWidget extends WP_Widget {
  function WhosKachinglingWhomWidget() {
    $widget_ops = array('classname' => 'widget_kachingle_wkw', 'description' => __( "Add Kachingle's Who's Kachingling Whom widget to your sidebar") );
    $this->WP_Widget('WhosKachinglingWhom', __("Kachingle Who's Kachingling Whom"), $widget_ops);
  }
  
  /**
   * Output Medallion Widget
   **/
  function widget($args, $instance) {
    extract($args);
    // $medallion_no = $instance["KM_MEDALLION_NO"];

    echo $before_widget;
		echo $this->build();
    echo $after_widget;
  }

  function build() {
    return '<iframe frameborder="0" scrolling="no" width="220" height="370" src="http://kachingle.com/widgets/whos_kachingling_whom.php"></iframe>';
  }
}

/**
 * Initializer
 **/

function km_widgets_init() {
  if ( !is_blog_installed() )
    return;

  register_widget('KachingleMedallionWidget');
  register_widget('WhosKachinglingWhomWidget');
}
add_action('widgets_init', 'km_widgets_init', 1);

// FOR FUTURE USE
// add_filter( "the_content", "km_inject_rss" );
// 
// function km_inject_rss($cnt) {
//   return $cnt;
// }

/*	Copyright 2010	Kachingle, Inc.	(email : info@kachingle.com)

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License, version 2, as 
		published by the Free Software Foundation.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA	02110-1301	USA
*/
?>