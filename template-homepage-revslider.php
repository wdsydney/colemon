<?php
/*
	Template Name: Homepage + Revolution Slider
*/
?>

<?php 
	get_header(); 

	$homeland_hide_three_cols = esc_attr( get_option('homeland_hide_three_cols') );	
	$homeland_hide_two_cols = esc_attr( get_option('homeland_hide_two_cols') );	
	$homeland_hide_welcome = esc_attr( get_option('homeland_hide_welcome') );	
	$homeland_hide_properties = esc_attr( get_option('homeland_hide_properties') );	
	$homeland_hide_services = esc_attr( get_option('homeland_hide_services') );	
	$homeland_hide_testimonials = esc_attr( get_option('homeland_hide_testimonials') );	
	$homeland_hide_partners = esc_attr( get_option('homeland_hide_partners') );	
	$homeland_hide_portfolio = esc_attr( get_option('homeland_hide_portfolio') );	
	$homeland_hide_cta = esc_attr( get_option('homeland_hide_cta') );	

	if ( is_active_sidebar( 'homeland_top_slider' ) ) : dynamic_sidebar( 'homeland_top_slider' );
	else : esc_html_e( 'Please add revolution slider widget here...', 'homeland' );
	endif;

	homeland_advance_search(); 

	if(empty($homeland_hide_services)) : homeland_services_list(); endif; 
	if(empty($homeland_hide_properties)) : homeland_property_list(); endif; 	
	if(empty($homeland_hide_cta)) : homeland_call_to_action_button(); endif; 
	if(empty($homeland_hide_portfolio)) : homeland_portfolio_list_grid();	endif;
	if(empty($homeland_hide_welcome)) : homeland_welcome_text(); endif;

	if(empty($homeland_hide_three_cols)) : ?>
		<!-- 3 Columns -->
		<section class="three-columns-block">
			<div class="inside clear">
				<?php 
					homeland_agent_list(); 
					homeland_featured_list(); 
					homeland_blog_latest();
				?>
			</div>
		</section><?php
	endif;

	if(empty($homeland_hide_partners)) : homeland_partners_list(); endif;

	get_footer(); 
?>