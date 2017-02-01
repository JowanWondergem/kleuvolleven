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
if(is_front_page()):
?>
<br><br>
<div class="clear" data-string="post_type=post&amp;post_status=publish&amp;posts_per_page=4&amp;paged=1&amp;orderby=date&amp;order=ASC&amp;ignore_sticky_posts=0"> 


<?php
	
		$postslist = get_posts( array(
		'category_name' => 'homepage_circles',
		'post_type'   => 'post',
  		'post_status' => 'publish',
	    'numberposts' => 4,
	    'order'          => 'DESC',
	    'orderby'        => 'date'
	) );


	foreach ($postslist as $post):
?>
<?php
	$postId = $post->ID;
	$postTitle = $post->post_title;
	$postContent = $post ->post_content;
	$postLink = simple_fields_value('homepage_circle_link', $postId);
	$postImage = get_the_post_thumbnail_url($post)
?>
    <div class="column-1-4 column" style="text-align:center; margin-right:0px;" >
    <a href="<?php echo $postLink; ?>">
      <div class="image_wrapper" style="cursor:pointer;">
         <img width="148" height="148" src="<?php echo $postImage; ?>" class="content_image wp-post-image" alt="<?php echo $postTitle; ?>" srcset="<?php echo $postImage; ?> 148w" sizes="(max-width: 148px) 100vw, 148px">
      </div>
      <div class="">
         <h3 ><?php echo $postTitle; ?></h3>
         <p ><?php echo $postContent; ?></p>
      </div>
      </a>
   </div>
<?php endforeach; ?>

   <!-- blog_post blog2 blog4-->
   <div class="clear"></div>
   <div class="clear"></div>
</div>
<?php endif; ?>
