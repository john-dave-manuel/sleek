<?php
########
# Vendor
require __DIR__ . '/vendor/autoload.php';

###################
# Load translations
# NOTE: Load this first thing so translations are available everywhere
# NOTE: MO-files are generated by Webpack hence the dist/ folder
load_theme_textdomain('sleek', get_template_directory() . '/dist');

###############
# Theme support
add_theme_support('sleek-classic-editor');
add_theme_support('sleek-jquery-cdn');
add_theme_support('sleek-disable-jquery');
add_theme_support('sleek-disable-404-guessing');
add_theme_support('sleek-nice-email-from');
add_theme_support('sleek-comment-form-placeholders');
add_theme_support('sleek-tinymce-clean-paste');
add_theme_support('sleek-tinymce-no-colors');
add_theme_support('sleek-archive-meta');
add_theme_support('sleek-outdated-browser-warning');
add_theme_support('sleek-hide-acf-admin');
add_theme_support('sleek-disable-theme-editor');
add_theme_support('sleek-notice');

# Disabled by default
# add_theme_support('sleek-disable-comments');
# add_theme_support('sleek-cookie-consent');
# add_theme_support('sleek-gallery-slideshow'); # TODO
# add_theme_support('sleek-archive-filter');
# add_theme_support('sleek-get-terms-post-type-arg');
# add_theme_support('sleek-require-login');

########
# Assets
# NOTE: app.css/app.js are imported by sleek-core
add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.10', [], null, true);
});

#############
# Image sizes
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

##################
# Sidebars & menus
register_sidebar(['name' => __('Header', 'sleek'), 'id' => 'header']);
register_sidebar(['name' => __('Footer', 'sleek'), 'id' => 'footer']);
register_sidebar(['name' => __('Sidebar', 'sleek'), 'id' => 'sidebar']);

register_nav_menus(['main_menu' => __('Main menu', 'sleek')]);
register_nav_menus(['footer_menu' => __('Footer menu', 'sleek')]);

############
# ACF fields
add_action('acf/init', function () {
	# Flexible content field
	acf_add_local_field_group([
		'key' => 'modules',
		'title' => __('Modules', 'sleek'),
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]],
		'fields' => [
			[
				'key' => 'modules_below_content',
				'name' => 'modules_below_content',
				'button_label' => __('Add a module', 'sleek'),
				'type' => 'flexible_content',
				'layouts' => Sleek\Modules\get_module_fields([
					'attachments',
					'related-pages',
					'contact-form',
					'featured-posts',
					'gallery',
					'google-map',
					'hubspot-form',
					'instagram',
					'latest-posts',
					'modules-showcase',
					'share-page',
					'social-links',
					'text-block',
					'text-blocks',
					'vue-component',
					'next-post',
					'related-posts',
					'page-menu',
					'users',
					'video'
				], 'modules_below_content', 'flexible')
			]
		]
	]);

	# Sticky modules
	acf_add_local_field_group([
		'key' => 'sticky_modules',
		'title' => __('Sticky modules', 'sleek'),
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
		'fields' => Sleek\Modules\get_module_fields(['redirect-url'], 'sticky_modules', 'tabbed')
	]);
});

################
# Sleek settings (TODO: Change args to name, label = null, type = text and use inflector to titleize if label==null)
add_action('admin_init', function () {
	Sleek\Settings\add_setting('hubspot_portal_id', 'text', __('Hubspot Portal ID', 'sleek'));
});

# ... use them
add_action('wp_head', function () {
	if ($portalId = Sleek\Settings\get_setting('hubspot_portal_id')) {
		echo '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $portalId . '.js"></script>';
	}
});

#############
# User fields
/* add_filter('user_contactmethods', function ($fields) {
	$fields['github'] = __('GitHub', 'sleek');

	return $fields;
}); */

#################
# REST API Fields
/* add_action('rest_api_init', function () {
	register_rest_field(['page', 'post'], 'custom_fields', ['get_callback' => function ($post) {
		return get_post_custom($post['id']);
	}]);
}); */

######################################
######################################
# TEMP
# Menu shortcode
add_shortcode('sleek_menu', function ($atts, $content, $shortcode_tag) {
	return wp_nav_menu(shortcode_atts([
		'menu' => '',
		'menu_class' => 'menu',
		'menu_id' => '',
		'container' => 'div',
		'container_class' => '',
		'container_id' => '',
		'fallback_cb' => false,
		'echo' => false,
		'before' => '',
		'after' => '',
		'link_before' => '',
		'link_after' => '',
		'depth' => 0,
		'walker' => '',
		'theme_location' => ''
	], $atts));
});

add_filter('the_excerpt', 'do_shortcode');

# Loading class
add_action('wp_head', function () {
	echo "<script>document.documentElement.classList.add('loading')</script>";
});
