<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

/**
 * Turn all URLs in clickable links.
 * Source: https://gist.github.com/jasny/2000705
 *
 * @param string $value
 * @param array  $protocols  http/https, ftp, mail, twitter
 * @param array  $attributes
 * @param string $mode       normal or all
 * @return string
 */
function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
{
		// Link attributes
		$attr = '';
		foreach ($attributes as $key => $val) {
				$attr .= ' ' . $key . '="' . htmlentities($val) . '"';
		}

		$links = array();

		// Extract existing links and tags
		$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);

		// Extract text links for each protocol
		foreach ((array)$protocols as $protocol) {
				switch ($protocol) {
						case 'http':
						case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
							if ($match[1]) $protocol = $match[1];
							$link = $match[2] ?: $match[3];
							return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
							}, $value);
							break;
						case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
						default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
				}
		}

		// Insert all link
		return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}

?>

<!-- Start K2 Item Layout -->
<span id="startOfPageId<?php echo JRequest::getInt('id'); ?>"></span>

<div id="k2Container" class="itemView<?php echo ($this->item->featured) ? ' itemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

	<div class="itemHeader">

	  <?php if($this->item->params->get('itemTitle')): ?>
	  <!-- Item title -->
	  <h2 class="itemTitle">
			<?php if(isset($this->item->editLink)): ?>
			<!-- Item edit link -->
			<span class="itemEditLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
					<?php echo JText::_('K2_EDIT_ITEM'); ?>
				</a>
			</span>
			<?php endif; ?>

	  	<?php echo $this->item->title; ?>

	  	<?php if($this->item->params->get('itemFeaturedNotice') && $this->item->featured): ?>
	  	<!-- Featured flag -->
	  	<span>
		  	<sup>
		  		<?php echo JText::_('K2_FEATURED'); ?>
		  	</sup>
	  	</span>
	  	<?php endif; ?>

	  </h2>
	  <?php endif; ?>

  </div>

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php echo $this->item->event->K2AfterDisplayTitle; ?>

  <div class="itemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('itemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="itemImageBlock">
		  <span class="itemImage">
		  	<a class="modal" rel="{handler: 'image'}" href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
		  		<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" />
		  	</a>
		  </span>

		  <?php if($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)): ?>
		  <!-- Image caption -->
		  <span class="itemImageCaption"><?php echo $this->item->image_caption; ?></span>
		  <?php endif; ?>

		  <?php if($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)): ?>
		  <!-- Image credits -->
		  <span class="itemImageCredits"><?php echo $this->item->image_credits; ?></span>
		  <?php endif; ?>

		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if(!empty($this->item->fulltext)): ?>
	  <?php /* if($this->item->params->get('itemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="itemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; */ ?>
	  <?php if($this->item->params->get('itemFullText')): ?>
	  <!-- Item fulltext -->
	  <div class="itemFullText">
	  	<?php echo linkify($this->item->fulltext, array('http', 'https', 'mail')); ?>
		<?php
			$view_id = JRequest::getInt('id');
			if ($view_id > 300) $view_id -= 300;
		?>
		<table width="auto" border="0" align="center" id="ppd_media">
			<tr valign="top" align="center">
				<td><a href="images/stories/produkty/<?php echo $view_id; ?>-1.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-1.jpg" /></a></td>
				<td><a href="images/stories/produkty/<?php echo $view_id; ?>-2.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-2.jpg" /></a></td>
			</tr>
			<tr valign="top" align="center">
				<td><a href="images/stories/produkty/<?php echo $view_id; ?>-3.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-3.jpg" /></a></td>
				<td><a href="images/stories/produkty/<?php echo $view_id; ?>-4.jpg" rel="lightbox"><img src="images/stories/produkty/t/<?php echo $view_id; ?>-4.jpg" /></a></td>
			</tr>
		</table>
	  </div>
	  <?php endif; ?>
	  <?php else: ?>
	  <!-- Item text -->
	  <div class="itemFullText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php echo $this->item->event->K2AfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

  <?php if($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)): ?>
  <!-- Item image gallery -->
  <a name="itemImageGalleryAnchor" id="itemImageGalleryAnchor"></a>
  <div class="itemImageGallery">
	  <h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
	  <?php echo $this->item->gallery; ?>
  </div>
  <?php endif; ?>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php echo $this->item->event->K2AfterDisplay; ?>

  <?php if($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
  <!-- K2 Plugins: K2CommentsBlock -->
  <?php echo $this->item->event->K2CommentsBlock; ?>
  <?php endif; ?>

	<div class="clr"></div>
</div>
<!-- End K2 Item Layout -->
