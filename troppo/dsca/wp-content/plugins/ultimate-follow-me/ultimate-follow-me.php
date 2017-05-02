<?php
/*
Plugin Name: Ultimate Follow Me Plugin by Free Blog Factory
Plugin URI: http://FreeBlogFactory.com
Description: We were tired of confusing and bulky "follow me" plugins for wordpress so we decided to make our own. Showcase any or all of your facebook, twitter, linkedin, youtube, and buzz profiles with your choice of button design.
Version: 1.3.3
Author: Free Blog Factory
Author URI: http://FreeBlogFactory.com
License: GPL2
*/

/*  Copyright 2010  Russell Yermal (email : russell@socialspin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//error_reporting(E_ALL);

	add_action("widgets_init", array('ultimate_follow_me', 'register'));

	$path_to_styles = WP_PLUGIN_URL . '/ultimate-follow-me';
	$preview_image = 'preview.png';
	$twitter_image = 'twitter.png';
	$plus_image = 'plus.png';
	$facebook_image = 'facebook.png';	
	$youtube_image = 'youtube.png';	
	$linkedin_image = 'linkedin.png';	
	$email_image = 'email.png';	
	$rss_image = 'rss.png';
	
	function create_facebook_tag($id, $style_id){
		if(strlen($id) < 1)
			return;
			
		$url = "http://facebook.com";
		if(is_numeric($id))
			$url .= "/profile.php?id=$id";
		else
			$url .= "/$id";
			
		$img = 	'<img src="'.get_facebook_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank">'.$img.'</a>';
	}	
	function create_twitter_tag($id, $style_id){
		if(strlen($id) < 1)
			return;
			
		$url = "http://twitter.com/$id";
			
		$img = 	'<img src="'.get_twitter_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank">'.$img.'</a>';
	}
	function create_plus_tag($id, $style_id){
		if(strlen($id) < 1)
			return;
			
		$url = "https://plus.google.com/u/1/$id/posts";
			
		$img = 	'<img src="'.get_plus_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank">'.$img.'</a>';
	}
	function create_youtube_tag($id, $style_id){
		if(strlen($id) < 1)
			return;
			
		$url = "http://youtube.com/$id";
			
		$img = 	'<img src="'.get_youtube_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank" class="nofancybox">'.$img.'</a>';
	}	
	function create_linkedin_tag($id, $style_id){
		if(strlen($id) < 1)
			return;
			
		$url = "http://linkedin.com/in/$id";
			
		$img = 	'<img src="'.get_linkedin_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank">'.$img.'</a>';
	}		
	function create_rss_tag($display, $style_id){
		if($display != 'on')
			return;
			
		$url = get_bloginfo('rss2_url');;
			
		$img = 	'<img src="'.get_rss_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'" target="_blank">'.$img.'</a>';
	}		
	function create_email_tag($address, $style_id){
		if(strlen($address) < 1)
			return;
			
		if(preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,}\$/i",$address))
			$url = "mailto:$address";
		else
			$url = $address;
			
		$img = 	'<img src="'.get_email_image($style_id).'" border="0" style="margin:3px;"/>';
			
		return '<a href="'.$url.'">'.$img.'</a>';
	}		
	
	function get_preview_image($style_id){
		global $path_to_styles;
		global $preview_image;
		return $path_to_styles.'/style'.$style_id.'/'.$preview_image;
	}
	function get_facebook_image($style_id){
		global $path_to_styles;
		global $facebook_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$facebook_image;
	}	
	function get_twitter_image($style_id){
		global $path_to_styles;
		global $twitter_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$twitter_image;
	}
	function get_plus_image($style_id){
		global $path_to_styles;
		global $plus_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$plus_image;
	}			
	function get_youtube_image($style_id){
		global $path_to_styles;
		global $youtube_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$youtube_image;
	}		
	function get_linkedin_image($style_id){
		global $path_to_styles;
		global $linkedin_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$linkedin_image;
	}				
	function get_email_image($style_id){
		global $path_to_styles;
		global $email_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$email_image;
	}	
	function get_rss_image($style_id){
		global $path_to_styles;
		global $rss_image;		
		return $path_to_styles.'/style'.$style_id.'/'.$rss_image;
	}		 

	function update_options($data){
	
		if(empty($_POST))
			return;
	
		if($_POST['uf_display_rss']=='on')	
			$data['uf_display_rss'] = 'on';
		else
			$data['uf_display_rss'] = 'off';
					
		if(isset($_POST['uf_fb_id']))
			$data['uf_fb_id'] = $_POST['uf_fb_id'];
		if(isset($_POST['uf_tw_id']))
			$data['uf_tw_id'] = $_POST['uf_tw_id'];
		if(isset($_POST['uf_gp_id']))
			$data['uf_gp_id'] = $_POST['uf_gp_id'];
		if(isset($_POST['uf_yt_id']))
			$data['uf_yt_id'] = $_POST['uf_yt_id'];
		if(isset($_POST['uf_li_id']))
			$data['uf_li_id'] = $_POST['uf_li_id'];
		if(isset($_POST['uf_email_address']))
			$data['uf_email_address'] = $_POST['uf_email_address'];
			
		if(isset($_POST['uf_style']))
			$data['uf_style'] = $_POST['uf_style'];	
				
		if(isset($_POST['uf_title']))
			$data['uf_title'] = $_POST['uf_title'];			

		update_option('ultimate_follow_me', $data);	
	}

class ultimate_follow_me { 	
	
  function control(){
	  $data = get_option('ultimate_follow_me');
	  
	  if($data['uf_title']!='')
	  	$title = $data['uf_title'];
	  else
	  	$title = "Follow Me On The Web!";
	  	
	  $check_rss='';	
	  	
	  if($data['uf_display_rss']=='on')
	  	$check_rss='checked';

	  ?>
      	<table>
            <tr>
	  			
                <td align="right"><label>Title:</label></td>
                <td valign="bottom"><input name="uf_title" type="text" value="<?=$title?>" /></td>
            </tr>
            <tr>
	  			
                <td align="right"><label>Facebook username or profile ID <small>(http://facebook.com/<u>username</u><br/>or http://facebook.com/profile.php?id=<u>profile_id</u>)</small>:</label></td>
                <td valign="bottom"><input name="uf_fb_id" type="text" value="<?=$data['uf_fb_id']?>" /></td>
            </tr>
            <tr>
                <td align="right"><label>Twitter username <small>(http://www.twitter.com/<u>username</u>)</small>:</label></td>
                <td><input name="uf_tw_id" type="text" value="<?=$data['uf_tw_id']?>" /></td>
            </tr>
            <tr>
	  			
                <td align="right"><label>Linkedin username <small>(http://www.linkedin.com/in/<u>username</u>)</small>:</label></td>
                <td><input name="uf_li_id" type="text" value="<?=$data['uf_li_id']?>" /></td>
            </tr> 
            <tr>
	  			
                <td align="right"><label>Google Plus user ID <small>(https://plus.google.com/u/1/<u>user ID</u>)</small>:</label></td>
                <td><input name="uf_gp_id" type="text" value="<?=$data['uf_gp_id']?>" /></td>
            </tr> 
            <tr>
	  			
                <td align="right"><label>Youtube username <small>(http://www.youtube.com/<u>username</u>)</small>:</label></td>
                <td><input name="uf_yt_id" type="text" value="<?=$data['uf_yt_id']?>" /></td>
            </tr>       
<tr>
                <td align="right"><label>Email address or URL to contact us page:</label></td>
                <td><input name="uf_email_address" type="text" value="<?=$data['uf_email_address']?>" /></td>
            </tr> 
            <tr>
                <td align="right"><label>Display rss feed?</label></td>
                <td><input name="uf_display_rss" type="checkbox" <?=$check_rss?>/></td>
            </tr>              
<tr>
            	<td colspan="3" align="center">
                	<b>Display style</b>
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center"><input type="radio" name="uf_style" value="1" <?php if ($data['uf_style'] == 1) echo 'checked'; ?>/><img src="<?=get_preview_image(1); ?>">
                </td>
            </tr>
            <tr>            
				<td colspan="3" align="center"><input type="radio" name="uf_style" value="2" <?php if ($data['uf_style'] == 2) echo 'checked'; ?>/><img src="<?=get_preview_image(2); ?>"> 
                </td>
            </tr> 
            <tr>          
				<td colspan="3" align="center"><input type="radio" name="uf_style" value="3" <?php if ($data['uf_style'] == 3) echo 'checked'; ?>/><img src="<?=get_preview_image(3); ?>">
               	</td>
            </tr>            
       </table>
	  <?php
		
		update_options($data);
	}	
	
  function widget($args){
  
    $data = get_option('ultimate_follow_me');
  
  	if($data['uf_title']!='')
	  	$title = $data['uf_title'];
	  else
	  	$title = "Follow Me On The Web!";
  
    echo $args['before_widget'];
    echo $args['before_title'] . $title . $args['after_title'];
    	  
    	  echo '<div id="ultimate-follow-me">';
		  echo create_facebook_tag($data['uf_fb_id'], $data['uf_style']);
		  echo create_twitter_tag($data['uf_tw_id'], $data['uf_style']);
		  echo create_linkedin_tag($data['uf_li_id'], $data['uf_style']);
		  echo create_plus_tag($data['uf_gp_id'], $data['uf_style']);
		  echo create_youtube_tag($data['uf_yt_id'], $data['uf_style']);
		  echo create_email_tag($data['uf_email_address'], $data['uf_style']);
		  echo create_rss_tag($data['uf_display_rss'], $data['uf_style']);
		  echo '</div>';
    echo $args['after_widget'];
  }
  
  function register(){

    register_sidebar_widget('Ultimate Follow Me', array('ultimate_follow_me', 'widget'));
    register_widget_control('Ultimate Follow Me', array('ultimate_follow_me', 'control'), 600, 400);
  }
}
?>