<?php
/*
Name: lt3 Template Page for the gallery overview

Follow variables are useable :

	$gallery	 : Contain all about the gallery
	$images		 : Contain all images, path, title
	$pagination	 : Contain the pagination content
	$album		 : Contain all about the album

You can check the content when you insert the tag <?php var_dump($variable) ?>
If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
*/
?>

<?php if(!defined('ABSPATH')) die ('No direct access allowed'); ?><?php if(!empty ($gallery)) : ?>

<section class="ngg-gallery-page-container">

	<?php $album = nggdb::find_album(get_query_var('gallery')); ?>

	<?php /* Album Name */ ?>
	<?php if($album) : /* Album Title */ ?>
		<h5 class="ngg-album-name"><span>Album:</span> <?php echo $album->name; ?></h5>
	<?php endif; ?>

	<?php /* Gallery Name */ ?>
	<h4 class="ngg-gallery-name"><span>Gallery:</span> <?php echo $gallery->title; ?></h4>

	<?php /* Gallery Description */ ?>
	<?php if($gallery->description) : ?>
		<p class="ngg-gallery-description"><?php echo $gallery->description; ?></p>
	<?php endif; ?>

	<?php /* Back to Album link */ ?>
	<?php if($album) : ?>
		<div class="ngg-album-navigation">
			<a href="<?php the_permalink(); ?>" title="Back to the <?php echo $album->name; ?> Album">&larr; Back to the <?php echo $album->name; ?> Album</a>
		</div>
	<?php endif; ?>

	<article class="ngg-galleryoverview" id="<?php echo $gallery->anchor; ?>">

		<?php /* Slideshow Link */ ?>
		<?php if($gallery->show_slideshow) : ?>
			<div class="slideshowlink">
				<a class="slideshowlink" href="<?php echo $gallery->slideshow_link; ?>" title="<?php the_title_attribute(); ?>">
					<?php echo $gallery->slideshow_link_text ?>
				</a>
			</div>
		<?php endif; ?>

		<?php /* Piclense Link */ ?>
		<?php if($gallery->show_piclens) : ?>
			<div class="piclenselink">
				<a class="piclenselink" href="<?php echo $gallery->piclens_link; ?>" title="<?php the_title_attribute(); ?>">
					<?php _e('[View with PicLens]','nggallery'); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php /* Image Thumbnails) */ ?>
		<?php foreach($images as $image) : ?>
			<div id="ngg-image-<?php echo $image->pid ?>" class="ngg-gallery-thumbnail-box" <?php echo $image->style ?> >
				<figure class="ngg-gallery-thumbnail">

					<?php /* Image (Show if not hidden) */ ?>
					<?php if(!$image->hidden){ ?>
						<a href="<?php echo $image->imageURL; ?>" title="<?php echo $image->description; ?>" <?php echo $image->thumbcode; ?> >
							<img title="<?php echo $image->alttext; ?>" alt="<?php echo $image->alttext; ?>" src="<?php echo $image->thumbnailURL; ?>" <?php echo $image->size; ?>>
						</a>
					<?php } ?>

					<?php /* Image Caption */ ?>
					<figcaption><?php echo $image->caption ?></figcaption>
				</figure>
			</div>

			<?php if($image->hidden) continue; ?>
			<?php if($gallery->columns > 0 && ++$i % $gallery->columns == 0) : ?>
				<div class="clear">&nbsp;</div>
			<?php endif; ?>
		<?php endforeach; ?>

		<?php /* Pagination */ ?>
		<?php echo $pagination ?>

	</article>

	<?php /* Back to Album link */ ?>
	<?php if($album) : ?>
		<footer class="ngg-album-navigation">
			<a href="<?php the_permalink(); ?>" title="Back to the <?php echo $album->name; ?> Album">&larr; Back to the <?php echo $album->name; ?> Album</a>
		</footer>
	<?php endif; ?>

</section>

<?php endif; ?>