<style type="text/css">



@media (max-width:768px) {
	.homepage-newsletter{ 
	position: relative !important; 
	margin: 10px !important;
	top:0px !important;
	right:0px !important;
	}

}
	.homepage-newsletter{
		position: absolute;
		right: 50px;
		background: white;
		top:-100px;
		min-height: 90px;
		padding: 10px 10px 20px 10px ;


		-webkit-border-top-left-radius: 20px;
  -webkit-border-top-right-radius: 20px;
  -webkit-border-bottom-right-radius: 20px;
  -webkit-border-bottom-left-radius: 20px;

  -moz-border-radius-topleft: 20px;
  -moz-border-radius-topright: 20px;
  -moz-border-radius-bottomright: 20px;
  -moz-border-radius-bottomleft: 20px;

  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  border-bottom-left-radius: 20px;
	}
	.homepage-newsletter .widget_wysija_cont{
		float: left;
	}
	.homepage-newsletter .widget_wysija_cont label{
		display: none;
	}
	.homepage-newsletter .widget_wysija_cont .wysija-submit.wysija-submit-field{
		display: inline;
		position: absolute;
		margin-top: -25px;
		margin-left: 180px;
	}


	.homepage-newsletter .widget_wysija_cont .formError{
		margin-left:-180px !important;
		margin-top:30px !important;
	}

</style>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Homepage newsletter") ) : ?>
<?php endif;?>

<?php
// DLOCC If URL is Homepage then do this…
$homepage = "/";
$currentpage = $_SERVER["REQUEST_URI"];
if($homepage==$currentpage):
?>
<br><br>
<div class="clear" data-string="post_type=post&amp;post_status=publish&amp;posts_per_page=4&amp;paged=1&amp;orderby=date&amp;order=ASC&amp;ignore_sticky_posts=0"> 
<?php $upload_dir = wp_upload_dir(); ?>
<?php
	$i =0;
	$images = array("/2015/03/FT0A3700", "/2015/03/Blauwe-krukjes", "/2015/03/watercolour-Turkoois1631419_1920","/2016/06/Hele-set");
	$items =  wp_get_nav_menu_items( 'Hoofdmenu');
	foreach ($items as $item):
?>
<?php if($item->title == "Coaching" || $item->title == "Workshops" || $item->title == "Cursussen" || $item->title == "Producten" ): ?>
	
    <div class="column-1-4 column" style="text-align:center; margin-right:0px;" >
    <a href="<?php echo $item->url ?>">
      <div class="image_wrapper" style="cursor:pointer;">
         <img width="148" height="148" src="<?php echo $upload_dir['baseurl']; ?><?php echo $images[$i] ?>-148x148.jpg" class="content_image wp-post-image" alt="<?php echo $item->title ?>" srcset="<?php echo $upload_dir['baseurl']; ?><?php echo $images[$i] ?>-148x148.jpg 148w" sizes="(max-width: 148px) 100vw, 148px">
      </div>
      <!-- image_wrapper -->
      <div class="">
         <h3 ><?php echo $item->title ?></h3>
      </div>
      </a>
   </div>
   <?php $i++ ?>
<?php endif; ?>
<?php endforeach; ?>

   <!-- blog_post blog2 blog4-->
   <div class="clear"></div>
   <div class="clear"></div>
</div>
<?php endif; ?>
