<?php
	if (!function_exists('add_action'))
	{
		require_once("../../../wp-config.php");
	}
	
	require_once(dirname(__FILE__) . "/wp-flickr.php");
	
	global $wpflickr_config;
	
?>
        <?php 
		global $wpflickr_config;
		$title = "My Public PhotoStream";
		
		if(! function_exists("wpflickr_api_call")) {
			include('wp-flickr.php');
		}
		
		if(empty($_REQUEST['set'])) {
			$params = array(
				'method'	=> 'flickr.people.getPublicPhotos',
				'format'	=> 'php_serial',
				'per_page'	=> '50',
				'user_id'	=> $wpflickr_config['nsid']
			);
	
			$rPhotos = wpflickr_api_call($params, false, true);
			
		}
		elseif ($_REQUEST['set'] == "f") {
			$params = array(
				'method'	=> 'flickr.favorites.getList',
				'per_page'	=> '50',
				'format'	=> 'php_serial'
			);
	
			$rPhotos = wpflickr_api_call($params, false, true);
		}
		else {
			$params = array(
				'method'	=> 'flickr.photosets.getPhotos',
				'photoset_id' => $_REQUEST['set'],
				'per_page'	=> '50',
				'format'	=> 'php_serial'
			);
	
			$rPhotoset = wpflickr_api_call($params, false, true);
		}
		
		function photoURL($farm, $server, $id, $secret) {
			return $img_url = "http://farm" . $farm . ".static.flickr.com/" . $server . "/" . $id . "_" . $secret;
		}
		
	?>
	<?php
		 if($rPhotos) {
			foreach($rPhotos['photos']['photo'] as $number=>$photo) {
				// If changing the html below, copy to photoset, as it is identical
	?>
			<a href="javascript:void(0)" onclick="insertIntoEditor('<img src=\'<?php echo photoURL($photo['farm'], $photo['server'], $photo['id'], $photo['secret']); ?>' + $('wpflickr_size').value + '.jpg\' <?php if (!empty($wpflickr_config['img_class'])) echo 'class=\\\'' . $wpflickr_config['img_class'] . '\\\''; if ($wpflickr_config['alt_title'] == "1") echo 'alt=\\\'' . $photo['title'] . '\\\''; ?>/>'); return false;"><img src="<?php echo photoURL($photo['farm'], $photo['server'], $photo['id'], $photo['secret']); ?>_s.jpg"/></a>
	<?php
			}
		}
		if($rPhotoset) {
			foreach($rPhotoset['photoset']['photo'] as $number=>$photo) {
	?>
			<a href="javascript:void(0)" onclick="insertIntoEditor('<img src=\'<?php echo photoURL($photo['farm'], $photo['server'], $photo['id'], $photo['secret']); ?>' + $('wpflickr_size').value + '.jpg\' <?php if (!empty($wpflickr_config['img_class'])) echo 'class=\\\'' . $wpflickr_config['img_class'] . '\\\''; if ($wpflickr_config['alt_title'] == "1") echo 'alt=\\\'' . $photo['title'] . '\\\''; ?>/>'); return false;"><img src="<?php echo photoURL($photo['farm'], $photo['server'], $photo['id'], $photo['secret']); ?>_s.jpg"/></a>
	<?php
			}
		}
		
	?>