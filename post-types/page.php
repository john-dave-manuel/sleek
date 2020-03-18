<?php
namespace Sleek\PostTypes;

class Page extends PostType {
	# init() runs once every page load
	public function init () {
		# Remove editor entirely
	/*	add_action('registered_post_type', function ($post_type) {
			if ($post_type === 'page') {
				remove_post_type_support('page', 'editor');
			}
		}); */
	}

	# Sidebar/meta acf-fields for this post-type
	public function fields () {
		return [];
	}

	# Non flexible modules
	public function sticky_modules () {
	#	return ['hero'];
	}

	# Flexible modules
	public function flexible_modules () {
	/* 	return [
			'attachments', 'featured-posts', 'form', 'gallery', 'google-map',
			'instagram', 'latest-posts', 'next-post', 'related-pages', 'related-posts',
			'share-page', 'social-links', 'text-block', 'text-blocks', 'users', 'video'
		]; */
	}
}
