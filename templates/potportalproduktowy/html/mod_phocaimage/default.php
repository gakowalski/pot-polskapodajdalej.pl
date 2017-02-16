<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php $i = 0; ?>
<?php if(!empty($images)): ?>
	<?php foreach($images as $image): ?>
        <div id="pic_<?php echo $i; ?>" class="image-frame">
            <img alt="<?php echo $image->title; ?>" src="<?php echo $image->attribs['src']; ?>" height="<?php echo $image->attribs['height']; ?>" width="<?php echo $image->attribs['width']; ?>"/>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>
<?php endif; ?>