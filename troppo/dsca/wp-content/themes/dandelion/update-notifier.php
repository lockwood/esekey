<?php
/**************************************************************
* *
* Provides a notification to the user everytime *
* your WordPress theme is updated *
* *
* Author: Joao Araujo *
* Profile: http://themeforest.net/user/unisphere *
* Follow me: http://twitter.com/unispheredesign *
* *
**************************************************************/

// Constants for the theme name, folder and remote XML url
define( 'NOTIFIER_THEME_NAME', 'Dandelion' ); // The theme name
define( 'NOTIFIER_THEME_FOLDER_NAME', 'dandelion_panel' ); // The theme folder name
define( 'NOTIFIER_XML_FILE', 'http://pexeto.com/updates/dandelion.xml' ); // The remote notifier XML file containing the latest version of the theme and changelog
define( 'NOTIFIER_CACHE_INTERVAL', 43200 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)



// Adds an update notification to the WordPress Dashboard menu
function update_notifier_menu() {
if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css

$latest = explode('.',$xml->latest);
$current= explode('.',$theme_data['Version']);

$newversion=false;
for($i=0; $i<sizeof($latest); $i++){
	if((int)$current[$i]<(int)$latest[$i]){
		$newversion=true;
		break;
	}
}


if($newversion) { // Compare current theme version with the remote XML version
add_dashboard_page( NOTIFIER_THEME_NAME . ' Theme Updates', NOTIFIER_THEME_NAME . ' <span class="update-plugins count-1"><span class="update-count">New Updates</span></span>', 'administrator', 'theme-update-notifier', 'update_notifier');
}
}
}
add_action('admin_menu', 'update_notifier_menu');



// Adds an update notification to the WordPress 3.1+ Admin Bar
function update_notifier_bar_menu() {
if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
global $wp_admin_bar, $wpdb;

if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
return;

$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css

if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . NOTIFIER_THEME_NAME . ' <span id="ab-updates">New Updates</span></span>', 'href' => get_admin_url() . 'index.php?page=theme-update-notifier' ) );
}
}
}
add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );



// The notifier page
function update_notifier() {
$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css ?>

<style>
.update-nag { display: none; }
#instructions {max-width: 670px;}
h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
</style>

<div class="wrap">

<div id="icon-tools" class="icon32"></div>
<h2><?php echo NOTIFIER_THEME_NAME ?> Theme Updates</h2>
<div id="message" class="updated below-h2"><p><strong><?php echo $xml->message; ?></strong> You have version <?php echo $theme_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>


<div id="instructions">
<h3>Update Download and Instructions</h3>
<p>To download the latest update of the theme, login to <a href="http://www.themeforest.net/">ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.</p>
<p>There are two main ways of installing an update:</p>
<ol>
<li><i><b>By uploading the theme as a new theme (recommended)</b></i>- this is an easier way to accomplish this. You just have to upload
the updated theme zip file via the built in WordPress theme uploader as a new theme from the Appearance &raquo; Themes &raquo; Install Themes &raquo; Upload section.

<div class="note_box">
		 <b>Note: </b><i>Please note that with the activating of the new theme it is possible your menu setting not to
		 be saved for the new theme. If so, you just have to go to Appearance &raquo; Menus &raquo; Theme Locations, select the menu (it will be
		 still there) and press the "Save" button</i>.
		</div>
</li>
<li><i><b>Via FTP</b></i> - you have to first unzip the zipped theme file and then you can use an FTP client (such as <a href="http://filezilla-project.org/download.php">FileZilla</a>) and replace all the theme files with the
updated ones.

<div class="note_box">
		 <b>Note: </b><i>Please note that with the file replacing all the code changes you have made to the files 
		 (if you have made any) will be lost, so please
		 make sure you have a backup copy of the theme files before you do the replacement. All the settings that
		 you have made from the admin panel won't be lost- they will be still available.</i>
		</div>
		</li>
</ol>
<div class="clear"></div>
<p>For more information about the updates, please refer to the "Updates" section of the documentation included.</p>
<br />
<div class="icon32 icon32-posts-page" id="icon-edit-pages"><br></div><h2 class="title">Update Changes</h2>
<?php echo $xml->changelog; ?>
</div>
</div>
<?php }



// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function get_latest_theme_version($interval) {
$notifier_file_url = NOTIFIER_XML_FILE;
$db_cache_field = 'notifier-cache';
$db_cache_field_last_updated = 'notifier-cache-last-updated';
$last = get_option( $db_cache_field_last_updated );
$now = time();
// check the cache
if ( !$last || (( $now - $last ) > $interval) ) {
// cache doesn't exist, or is old, so refresh it
if( function_exists('curl_init') ) { // if cURL is available, use it...
$ch = curl_init($notifier_file_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$cache = curl_exec($ch);
curl_close($ch);
} else {
$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
}

if ($cache) {
// we got good results
update_option( $db_cache_field, $cache );
update_option( $db_cache_field_last_updated, time() );
}
// read from the cache file
$notifier_data = get_option( $db_cache_field );
}
else {
// cache file is fresh enough, so read from it
$notifier_data = get_option( $db_cache_field );
}

// Let's see if the $xml data was returned as we expected it to.
// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
if( strpos((string)$notifier_data, '<notifier>') === false ) {
$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
}

// Load the remote XML data into a variable and return it
$xml = simplexml_load_string($notifier_data);

return $xml;
}

?>