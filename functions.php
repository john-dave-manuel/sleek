<?php
/*
###################
# Title tag support
add_theme_support('title-tag');

#####################
# Give pages excerpts
add_action('init', function () {
	add_post_type_support('page', 'excerpt');
});

##################################
# Show the editor on the blog page
# https://wordpress.stackexchange.com/questions/193755/show-default-editor-on-blog-page-administration-panel
add_action('edit_form_after_title', function ($post) {
	if (isset($post) and $post->ID == get_option('page_for_posts')) {
		remove_action('edit_form_after_title', '_wp_posts_page_notice');
		add_post_type_support('page', 'editor');
	}
}, 0);

################################################
# Remove "Protected:" from protected post titles
add_filter('private_title_format', function () {
	return '%s';
});

add_filter('protected_title_format', function () {
	return '%s';
});

#############################
# Hide Sleek theme from admin
add_filter('wp_prepare_themes_for_js', function ($themes) {
	unset($themes['sleek']);

	return $themes;
});

########################
# Set up for translation
add_action('after_setup_theme', function () {
	load_theme_textdomain('sleek', get_template_directory() . '/languages');
});

######################
# 404 attachment pages
add_filter('template_redirect', function () {
	global $wp_query;

	if (is_attachment()) {
		status_header(404); # Sets 404 header
		$wp_query->set_404(); # Shows 404 template
	}
});

##########################
# Disable 404 URL guessing
# https://core.trac.wordpress.org/ticket/16557
add_filter('redirect_canonical', function ($url) {
	if (is_404() and !isset($_GET['p'])) {
		return false;
	}

	return $url;
});

################################################
# Remove title attribute from wp_list_categories
# https://www.isitwp.com/remove-title-attribute-from-wp_list_categories/
add_action('wp_list_categories', function ($output) {
	return preg_replace('/ title="(.*?)"/s', '', $output);
});

#####################################
# Prevent WP wrapping iframe's in <p>
# https://gist.github.com/KTPH/7901c0d2c66dc2d754ce
add_filter('the_content', function ($content) {
	return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
});
*/
?>
