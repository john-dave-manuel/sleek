<?php if ($taxonomies = sleek_get_post_type_taxonomies()) : ?>
	<section id="archive-taxonomies">

		<?php foreach ($taxonomies as $tax) : ?>
			<nav>

				<h2><?php echo $tax['taxonomy']->labels->name ?></h2>

				<ul>
					<li<?php if (!$tax['has_active']) : ?> class="active"<?php endif ?>>
						<a href="<?php echo $tax['post_type_archive_link'] ?>"><?php _e('All', 'sleek') ?></a>
					</li>
					<?php wp_list_categories([
						'taxonomy' => $tax['taxonomy']->name,
						'title_li' => false
					]) ?>
				</ul>

			</nav>
		<?php endforeach ?>

	</section>
<?php endif ?>
