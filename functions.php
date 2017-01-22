<?php
	/*
		Included Files
		Set Maximum Content Width
		Register Styles and Scripts
		Theme Setup
		Admin Custom Stylesheets
		Google Map for Homepage
		Google Map for Search Results
		Google Map for Property
		Google Map for Contact us
		Change Default login logo and link
		Change Default Site title
		Main menu fallback
		Get Page Custom Title
		Get Property Type
		Get Property Terms
		Get Page Template Link
		Custom Excerpt Length
	  Remove Default comment fields
		Custom Comment Style
		Custom Pagination
		Custom Next Previous Link
		Fix Pagination for Taxonomies
		For Pagination working on static homepage
		For Pagination working for author page
		Agent Contributor Upload files
		Agent Custom Columns (Admin)
		Advance Property Search
		Property Sort and Order
		Remove and Add New Field in User Profile
		Add post thumbnail size in media upload
		Add category field
		Convert Hex to RGBA
		Custom Resizable Background
		Custom Header Images
		Google Analytics code
		Property Filter
		Add lightbox for gallery shortcode and image post
		Change label of authors to agent
		Custom Avatar
		Search for property CPT
		Sticky header jquery
		Remove revolution slider meta boxes
		Add odd/even post class
		Get Portfolio Categories
		Ability of contributor to edit post
		Property Price Format
	*/

	/* Included Files */

	include( get_template_directory() . '/includes/lib/custom-posts.php' );
	include( get_template_directory() . '/includes/lib/custom-fields.php' );
	include( get_template_directory() . '/includes/lib/custom-widgets.php' );
	include( get_template_directory() . '/includes/lib/custom-functions.php' );
	include( get_template_directory() . '/includes/lib/custom-css.php' );
	include( get_template_directory() . '/includes/lib/tgm/activation.php' );
	include( get_template_directory() . '/includes/customizer/option-customizer.php' );


	/* Set Maximum Content Width */

	if ( ! function_exists( 'homeland_content_width' ) ) :
		function homeland_content_width() {
			$GLOBALS['content_width'] = apply_filters( 'homeland_content_width', 1080 );
		}
	endif;
	add_action( 'after_setup_theme', 'homeland_content_width', 0 );


	/* Register Styles and Scripts */

	if ( ! function_exists( 'homeland_script_styles_reg' ) ) :
		function homeland_script_styles_reg () {
			$homeland_site_layout = esc_attr( get_option('homeland_site_layout') );	
			$homeland_bg_type = esc_attr( get_option('homeland_bg_type') );
			$homeland_hide_map_list = esc_attr( get_option('homeland_hide_map_list') );
			$homeland_theme_layout = esc_attr( get_option( 'homeland_theme_layout' ) );
			$homeland_map_api = esc_attr( get_option( 'homeland_map_api' ) );
			$homeland_top_element_display = esc_attr( get_option( 'homeland_top_element_display' ) );

			$homeland_directory_uri = get_template_directory_uri();
			$homeland_js_directory_uri = get_template_directory_uri() . '/js';

			// Main Stylesheets
			wp_enqueue_style( 'homeland-style', get_stylesheet_uri() );
			wp_enqueue_style( 'font-awesome', $homeland_directory_uri . '/includes/font-awesome/css/font-awesome.min.css', array(), '4.6.3', 'all' );
			wp_enqueue_style( 'jquery-flexslider', $homeland_js_directory_uri . '/flexslider/flexslider.css', array(), '', 'all' );
			wp_enqueue_style( 'jquery-magnific', $homeland_js_directory_uri . '/magnific-popup/magnific-popup.css',	array(), '', 'all' );
			wp_enqueue_style( 'jquery-select2', $homeland_js_directory_uri . '/select2/select2.css', array(), '', 'all' );
			
			// jQuery Scripts
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'jquery-superfish', $homeland_js_directory_uri . '/superfish.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-easing', $homeland_js_directory_uri . '/jquery.easing-1.3.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-retina', $homeland_js_directory_uri . '/retina.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-flexslider', $homeland_js_directory_uri . '/flexslider/jquery.flexslider-min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-hover-modernizr', $homeland_js_directory_uri . '/modernizr.custom.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-elastic', $homeland_js_directory_uri . '/jquery.elastislide.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-magnific', $homeland_js_directory_uri . '/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-select2', $homeland_js_directory_uri . '/select2/select2.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'jquery-validation', $homeland_js_directory_uri . '/jquery.validate.min.js', array( 'jquery' ), '', true );

			wp_enqueue_script( 'homeland-html5', '//html5shim.googlecode.com/svn/trunk/html5.js' );
			wp_script_add_data( 'homeland-html5', 'conditional', 'lt IE 9' );
			
			// Google Maps
			wp_register_script( 'google-map-api', 'http://maps.google.com/maps/api/js?key='. $homeland_map_api .'&libraries=geometry' );
			wp_register_script( 'google-map-markerclusterer', $homeland_js_directory_uri . '/markerclusterer.min.js' );
			wp_register_script( 'google-map', $homeland_js_directory_uri . '/gmaps.min.js' );
			wp_localize_script( 'google-map', 'wpGlobals', array( 'mapOptions' => file_get_contents( get_template_directory() . '/map_style.json' )) );

			// Homepage Templates
			if(is_page_template('template-homepage-gmap.php') || is_page_template('template-homepage-gmap-large.php')) : 
				wp_enqueue_script( 'google-map-api' );
				wp_enqueue_script( 'google-map-markerclusterer' );
				wp_enqueue_script( 'google-map' );
				add_action( 'wp_footer', 'homeland_google_map_homepage' ); 
			endif;

			if($homeland_top_element_display == "google-map") :
				if(is_page_template('template-homepage.php')) :
					wp_enqueue_script( 'google-map-api' );
					wp_enqueue_script( 'google-map-markerclusterer' );
					wp_enqueue_script( 'google-map' );
					add_action( 'wp_footer', 'homeland_google_map_homepage' ); 
				endif;
			endif;

			// Property Pages and Taxonomies
			if(is_tax( 'homeland_property_type') || is_tax( 'homeland_property_status') || is_tax( 'homeland_property_location') || is_tax( 'homeland_property_amenities' ) || is_page_template('template-properties-1col.php') || is_page_template('template-properties-2cols.php') || is_page_template('template-properties-3cols.php') || is_page_template('template-properties-4cols.php') || is_page_template('template-properties-left-sidebar.php') || is_page_template('template-properties.php') || is_page_template('template-properties-featured.php') || is_page_template('template-properties-grid-sidebar.php') || is_page_template('template-properties-grid-left-sidebar.php') || is_post_type_archive('homeland_properties') || is_page_template('template-properties-dual-sidebar.php') || is_page_template('template-properties-sold.php')) : 
				if($homeland_hide_map_list == "") :
					wp_enqueue_script( 'google-map-api' );
					wp_enqueue_script( 'google-map-markerclusterer' );
					wp_enqueue_script( 'google-map' );
					add_action( 'wp_footer', 'homeland_google_map_homepage' ); 
				endif;
			endif;

			// Single Page for comments
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
				wp_enqueue_script( 'comment-reply' );
			endif;
			
			// Backstretch
			if($homeland_bg_type == "Image" && ($homeland_theme_layout == "Boxed" || $homeland_theme_layout == "Boxed Left")) :
				wp_enqueue_script( 'jquery-backstretch', $homeland_js_directory_uri . '/jquery.backstretch.min.js', array( 'jquery' ), '', true );
			endif;

			// Property Single Page
			if(is_singular('homeland_properties')) : 
				wp_enqueue_script( 'google-map-api' );
				wp_enqueue_script( 'google-map-markerclusterer' );
				wp_enqueue_script( 'google-map' );
				add_action( 'wp_footer', 'homeland_google_map_property' );
			endif;

			// Property Search
			if(is_page_template('template-property-search.php')) :
				wp_enqueue_script( 'google-map-api' );
				wp_enqueue_script( 'google-map-markerclusterer' );
				wp_enqueue_script( 'google-map' );
			endif;
			
			// Blog Templates
			if(is_page_template('template-blog.php') || is_page_template('template-blog-3cols.php') || is_page_template('template-blog-4cols.php') || is_page_template('template-blog-fullwidth.php') || is_page_template('template-blog-grid-left-sidebar.php') || is_page_template('template-blog-grid.php') || is_page_template('template-blog-left-sidebar.php') || is_page_template('template-blog-timeline.php') || is_page_template('template-blog-2cols.php') || is_page_template('template-blog-list-alternate.php') || is_single() || is_archive()) :
				wp_enqueue_style( 'jquery-video', $homeland_js_directory_uri . '/video/video-js.css', array(), '', 'all' );
				wp_enqueue_script( 'jquery-video', $homeland_js_directory_uri . '/video/video.js', array( 'jquery' ), '', true );
				wp_enqueue_script( 'jquery-tipsy', $homeland_js_directory_uri . '/tipsy/jquery.tipsy.min.js', array( 'jquery' ), '', true );
			endif;

			// Contact us Templates
			if(is_page_template('template-contact.php') || is_page_template('template-contact-alternate.php') || is_page_template('template-contact-alternate2.php')) :
				wp_enqueue_script( 'google-map-api' );
				wp_enqueue_script( 'google-map-markerclusterer' );
				wp_enqueue_script( 'google-map' );
				add_action( 'wp_footer', 'homeland_google_map' );
			endif;

			// Coming Soon Template
			if(is_page_template('template-coming-soon.php')) :
				wp_enqueue_script( 'jquery-countdown-plugin', $homeland_js_directory_uri . '/countdown/jquery.plugin.min.js', array( 'jquery' ), '', true );
				wp_enqueue_script( 'jquery-countdown', $homeland_js_directory_uri . '/countdown/jquery.countdown.min.js', array( 'jquery' ), '', true );
			endif;

			// RTL Enable
			if ( is_rtl() ) :
				wp_enqueue_style( 'homeland-rtl-main', $homeland_directory_uri . '/css/rtl-main.css' );	
			endif;

			// Responsive Styles
			if(empty($homeland_site_layout)) :
				wp_enqueue_style( 'homeland-responsive', get_stylesheet_directory_uri() . '/responsive.css' );	
				
				if ( is_rtl() ) :
					wp_enqueue_style( 'homeland-rtl-responsive', $homeland_directory_uri . '/css/rtl-responsive.css' );	
				endif;
			
				wp_enqueue_script( 'jquery-mobile-menu', $homeland_js_directory_uri . '/jquery.mobilemenu.min.js', array( 'jquery' ), '', true );
			endif;

			// Custom jQueries
			wp_enqueue_script( 'homeland-custom-js', $homeland_js_directory_uri . '/custom.js', array( 'jquery' ), '', true );
		}
	endif;
	add_action( 'wp_enqueue_scripts', 'homeland_script_styles_reg' );


	/* Theme Setup */

	if ( ! function_exists( 'homeland_theme_setup' ) ) :
		function homeland_theme_setup() {
			// Localisation
			load_theme_textdomain( 'homeland', get_template_directory() . '/languages' );

			// Register Menus
			register_nav_menus( array(
				'primary-menu' => esc_html__( 'Primary Menu', 'homeland' ),
				'footer-menu' => esc_html__( 'Footer Menu', 'homeland' )
			) );

			// Theme Support and Filter
			add_filter( 'widget_text', 'do_shortcode' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-formats', array( 'image', 'video', 'gallery', 'audio' ) );
			add_theme_support( 'post-thumbnails', 
				array( 
					'post', 
					'homeland_properties', 
					'homeland_testimonial', 
					'homeland_partners', 
					'homeland_portfolio' 
				)
			);

			// Image Sizes
			set_post_thumbnail_size( 160, 120, true ); 
			add_image_size( 'homeland_slider', 1920, 664, true );
			add_image_size( 'homeland_property_thumb', 153, 115, true );		
			add_image_size( 'homeland_property_medium', 330, 230, true );
			add_image_size( 'homeland_property_large', 709, 407, true );
			add_image_size( 'homeland_property_2cols', 520, 350, true );
			add_image_size( 'homeland_property_4cols', 240, 230, true );
			add_image_size( 'homeland_news_thumb', 70, 70, true );
			add_image_size( 'homeland_widget_property', 230, 175, true );
			add_image_size( 'homeland_widget_thumb', 50, 50, true );
			add_image_size( 'homeland_header_bg', 1920, 300, true );
			add_image_size( 'homeland_theme_large', 770, 9999 );
			add_image_size( 'homeland_theme_thumb', 100, 100, true );
			add_image_size( 'homeland_portfolio_large', 1080, 9999 );
		}
	endif;
	add_action('after_setup_theme', 'homeland_theme_setup');


	/* Admin Custom Stylesheets */

	if ( ! function_exists( 'homeland_custom_admin_style' ) ) :	
		function homeland_custom_admin_style() {
			$homeland_directory_uri = get_template_directory_uri();
			$homeland_admin_directory_uri = get_template_directory_uri() . '/includes/admin';

			if(is_rtl()) :
				wp_enqueue_style( 'homeland-rtl-style-admin', $homeland_directory_uri . '/rtl.css' );
			endif;

			wp_enqueue_style( 'homeland-admin-stylesheet', $homeland_admin_directory_uri . '/admin-style.css' );
			wp_enqueue_style( 'font-awesome', $homeland_directory_uri . '/includes/font-awesome/css/font-awesome.min.css', array(), '4.6.3', 'all' );
			wp_enqueue_script( 'homeland-admin-js', $homeland_admin_directory_uri . '/admin-jquery.js', array( 'jquery' ), '', true );
		}
	endif;
	add_action( 'admin_enqueue_scripts', 'homeland_custom_admin_style' );


	/* Google Map for Homepage */

	if ( ! function_exists( 'homeland_google_map_homepage' ) ) :
		function homeland_google_map_homepage() {
			global $post, $wp_query;

			$homeland_home_map_lat = esc_attr( get_option('homeland_home_map_lat') );
			$homeland_home_map_lng = esc_attr( get_option('homeland_home_map_lng') );
			$homeland_home_map_zoom = esc_attr( get_option('homeland_home_map_zoom') );
			$homeland_home_map_icon = esc_attr( get_option('homeland_map_pointer_icon') );
			$homeland_num_properties = esc_attr( get_option('homeland_num_properties') );
			$homeland_price_format = esc_attr( get_option('homeland_price_format') );
			$homeland_currency = esc_attr( get_option('homeland_property_currency') ); 
			$homeland_property_currency_sign = esc_attr( get_option('homeland_property_currency_sign') );
			$homeland_map_pointer_clusterer_icon = esc_attr( get_option('homeland_map_pointer_clusterer_icon') );
			$homeland_lat_main = esc_attr( get_post_meta( $post->ID, 'homeland_property_lat', true ) );
			$homeland_lng_main = esc_attr( get_post_meta( $post->ID, 'homeland_property_lng', true ) );
			$homeland_term = $wp_query->queried_object; 

			if(!empty($homeland_home_map_zoom)) : 
				$homeland_home_map_zoom_value = $homeland_home_map_zoom; 
			else : 
				$homeland_home_map_zoom_value = '8'; 
			endif;

			if(!empty($homeland_lat_main) && !empty($homeland_lng_main)) : 
				$homeland_lat_main_value = $homeland_lat_main; 
				$homeland_lng_main_value = $homeland_lng_main; 
			else : 
				$homeland_lat_main_value = '37.0625'; 
				$homeland_lng_main_value = '-95.677068'; 
			endif;

			if(!empty($homeland_home_map_lat) && !empty($homeland_home_map_lng)) :
				$homeland_home_map_lat_value = $homeland_home_map_lat; 
				$homeland_home_map_lng_value = $homeland_home_map_lng; 
			else :
				$homeland_home_map_lat_value = '37.0625'; 
				$homeland_home_map_lng_value = '-95.677068'; 
			endif;
			?>
			<script type="text/javascript">
				(function($) {
				  	"use strict";
				  	var map;
				  	var snazzyMap = JSON.parse(wpGlobals.mapOptions);
				   	$(document).ready(function(){
				    	<?php if(is_tax( 'homeland_property_location' ) || is_tax( 'homeland_property_type' ) || is_tax( 'homeland_property_status' ) || is_tax( 'homeland_property_amenities' )) : ?>
			    			map = new GMaps({
						      div: '#map-homepage',
						      scrollwheel: false,
						      lat: <?php echo esc_html( $homeland_lat_main_value ); ?>,
									lng: <?php echo esc_html( $homeland_lng_main_value ); ?>,
									zoom: <?php echo esc_html( $homeland_home_map_zoom_value ); ?>,
									styles : snazzyMap,
									markerClusterer: function(map) {
								   	return new MarkerClusterer(map, [], {
							      	gridSize: 60, maxZoom: 14,
								      <?php if(!empty($homeland_map_pointer_clusterer_icon)) : ?>
							      		styles: [{
												width: 50, height: 50,
												url: "<?php echo esc_url( $homeland_map_pointer_clusterer_icon ); ?>"
											}] 
											<?php endif; ?>
								   	});
									}
					    	});
					    	map.setCenter(<?php echo esc_html( $homeland_lat_main ); ?>, <?php echo esc_html( $homeland_lng_main ); ?>); 
							<?php else : ?>
			    			map = new GMaps({
						      div: '#map-homepage',
						      scrollwheel: false,
						      lat: <?php echo esc_html( $homeland_home_map_lat_value ); ?>,
									lng: <?php echo esc_html( $homeland_home_map_lng_value ); ?>,
									zoom: <?php echo esc_html( $homeland_home_map_zoom_value ); ?>,
									styles : snazzyMap,
						      markerClusterer: function(map) {
								   	return new MarkerClusterer(map, [], {
							      	gridSize: 60, maxZoom: 14,
								      <?php if(!empty($homeland_map_pointer_clusterer_icon)) : ?>
							      		styles: [{
												width: 50, height: 50,
												url: "<?php echo esc_url( $homeland_map_pointer_clusterer_icon ); ?>"
											}] 
											<?php endif; ?>
							    	});
							 		}
					      });	
					      map.setCenter(<?php echo esc_html( $homeland_home_map_lat_value ); ?>, <?php echo esc_html( $homeland_home_map_lng_value ); ?>);	<?php
				    	endif;

	      			if(!empty($homeland_home_map_icon)) : ?>
	      				var image = '<?php echo esc_url( $homeland_home_map_icon ); ?>';<?php 
	      			endif;

	      			if(is_tax( 'homeland_property_type') ):
	      				$args = array( 
	      					'post_type' => 'homeland_properties', 
	      					'taxonomy' => 'homeland_property_type', 
	      					'term' => $homeland_term->slug 
	      				);
	      			elseif(is_tax( 'homeland_property_status' )) :
	      				$args = array( 
	      					'post_type' => 'homeland_properties', 
	      					'taxonomy' => 'homeland_property_status', 
	      					'term' => $homeland_term->slug 
	      				);
	      			elseif(is_tax( 'homeland_property_location' )) :
	      				$args = array( 
	      					'post_type' => 'homeland_properties', 
	      					'taxonomy' => 'homeland_property_location', 
	      					'term' => $homeland_term->slug 
	      				);
	      			elseif(is_tax( 'homeland_property_amenities' )) :
	      				$args = array( 
	      					'post_type' => 'homeland_properties', 
	      					'taxonomy' => 'homeland_property_amenities', 
	      					'term' => $homeland_term->slug 
	      				);
	      			elseif(is_page_template( 'template-properties-featured.php' )) :
	      				$args = array( 
		      				'post_type' => 'homeland_properties', 
									'posts_per_page' => -1, 
									'meta_query' => array( array( 
										'key' => 'homeland_featured', 
										'value' => 'on', 
										'compare' => '==' 
									)) 
	      				);
	      			elseif(is_page_template( 'template-properties-sold.php' )) :
	      				$args = array( 
		      				'post_type' => 'homeland_properties', 
									'posts_per_page' => -1, 
									'meta_query' => array( array( 
										'key' => 'homeland_property_sold', 
										'value' => 'on', 
										'compare' => '==' 
									)) 
	      				);
	      			else : 
	      				$args = array( 'post_type' => 'homeland_properties', 'posts_per_page' => -1 );
	      			endif;

	      			$args_map = apply_filters('homeland_properties_parameters', $args);
							$wp_query = new WP_Query( $args_map );	

							while ( $wp_query->have_posts() ) : $wp_query->the_post(); 	
								$homeland_lat = esc_attr( get_post_meta( $post->ID, 'homeland_property_lat', true ));
								$homeland_lng = esc_attr( get_post_meta( $post->ID, 'homeland_property_lng', true ));
								$homeland_price = esc_attr( get_post_meta( $post->ID, 'homeland_price', true ) );
								$homeland_price_per = esc_attr( get_post_meta($post->ID, 'homeland_price_per', true));
								$homeland_property_sold = esc_attr( get_post_meta($post->ID, 'homeland_property_sold', true));

								if(!empty($homeland_lat) && !empty($homeland_lng)) : 
									$homeland_lat_value = $homeland_lat;
									$homeland_lng_value = $homeland_lng;
								else :
									$homeland_lat_value = '37.0625';
									$homeland_lng_value = '-95.677068';
								endif;
								?>
									map.addMarker({
										lat: <?php echo esc_html( $homeland_lat_value ); ?>, 
										lng: <?php echo esc_html( $homeland_lng_value ); ?>, 
								    title: '<?php the_title(); ?>',
								    <?php if(!empty($homeland_home_map_icon)) : ?>icon: image, <?php endif; ?>
								      infoWindow: {
									   		content: '<div class="marker-window"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail('homeland_property_thumb'); endif; ?></a><h6><?php the_title(); ?></h6><?php if(!empty($homeland_price)) : ?><h5><?php homeland_property_price_format(); ?></h5><?php endif; ?><?php if(!empty($homeland_property_sold)) : ?><label class="gmap-sold"><?php esc_html_e('Sold', 'homeland'); ?></label><?php endif; ?><a href="<?php the_permalink(); ?>" class="view-gmap"><?php esc_html_e('View More', 'homeland'); ?></a></div>'
									    }
								  });
								<?php
					    endwhile; 
					    wp_reset_query();
		      	?>			        
				  });
				})(jQuery);					
			</script><?php
		}
	endif;


	/* Google Map for Search Results */

	if ( ! function_exists( 'homeland_google_map_search' ) ) :
		function homeland_google_map_search() {
			global $post, $args_wp;
			
			$homeland_home_map_lat = esc_attr( get_option('homeland_home_map_lat') );
			$homeland_home_map_lng = esc_attr( get_option('homeland_home_map_lng') );
			$homeland_home_map_zoom = esc_attr( get_option('homeland_home_map_zoom') );
			$homeland_home_map_icon = esc_attr( get_option('homeland_map_pointer_icon') );
			$homeland_price_format = esc_attr( get_option('homeland_price_format') );
			$homeland_currency = esc_attr( get_option('homeland_property_currency') ); 
			$homeland_property_currency_sign = esc_attr( get_option('homeland_property_currency_sign') );
			$homeland_map_pointer_clusterer_icon = esc_attr( get_option('homeland_map_pointer_clusterer_icon') );

			if(!empty($homeland_home_map_zoom)) :
				$homeland_home_map_zoom_value = $homeland_home_map_zoom; 
			else :
				$homeland_home_map_zoom_value = '8'; 
			endif;

			if(!empty($homeland_home_map_lat) && !empty($homeland_home_map_lng)) :
				$homeland_home_map_lat_value = $homeland_home_map_lat; 
				$homeland_home_map_lng_value = $homeland_home_map_lng; 
			else :
				$homeland_home_map_lat_value = '37.0625'; 
				$homeland_home_map_lng_value = '-95.677068'; 
			endif;
			?>
			<script type="text/javascript">
				(function($) {
				  	"use strict";
				  	var map;
				  	var snazzyMap = JSON.parse(wpGlobals.mapOptions);
				   	$(document).ready(function(){
				   	map = new GMaps({
				      div: '#map-property-search',
				      scrollwheel: false,
				      lat: <?php echo esc_html( $homeland_home_map_lat_value ); ?>,
							lng: <?php echo esc_html( $homeland_home_map_lng_value ); ?>,
							zoom: <?php echo esc_html( $homeland_home_map_zoom_value ); ?>,
							styles : snazzyMap,
							markerClusterer: function(map) {
						   	return new MarkerClusterer(map, [], {
					      	gridSize: 60, maxZoom: 14,
						      <?php if(!empty($homeland_map_pointer_clusterer_icon)) : ?>
					      		styles: [{
											width: 50, height: 50,
											url: "<?php echo esc_url( $homeland_map_pointer_clusterer_icon ); ?>"
										}] 
									<?php endif; ?>
					    	});
						 	}
				    });		      	

		      	<?php if(!empty($homeland_home_map_icon)) : ?>
		      		var image = '<?php echo esc_url( $homeland_home_map_icon ); ?>';
		      	<?php endif;

	      			$args_map = apply_filters('homeland_advance_search_parameters', $args_wp);
							$wp_query_map = new WP_Query( $args_map );

							while ( $wp_query_map->have_posts() ) :
								$wp_query_map->the_post(); 	
								$homeland_lat = esc_attr( get_post_meta($post->ID, 'homeland_property_lat', true));
								$homeland_lng = esc_attr( get_post_meta($post->ID, 'homeland_property_lng', true));
								$homeland_price = esc_attr( get_post_meta($post->ID, 'homeland_price', true ) );
								$homeland_price_per = esc_attr( get_post_meta($post->ID, 'homeland_price_per', true));
								$homeland_property_sold = esc_attr( get_post_meta($post->ID, 'homeland_property_sold', true));
								
								if(!empty($homeland_lat) && !empty($homeland_lng)) : 
									$homeland_lat_value = $homeland_lat;
									$homeland_lng_value = $homeland_lng;
								else :
									$homeland_lat_value = '37.0625';
									$homeland_lng_value = '-95.677068';
								endif;
								?>
									map.addMarker({
										lat: <?php echo esc_html( $homeland_lat_value ); ?>, 
										lng: <?php echo esc_html( $homeland_lng_value ); ?>,
							      title: '<?php the_title(); ?>',
							      <?php if(!empty($homeland_home_map_icon)) : ?>icon: image, <?php endif; ?>
							      infoWindow: {
								   		content: '<div class="marker-window"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) : the_post_thumbnail('homeland_property_thumb'); endif; ?></a><h6><?php the_title(); ?></h6><?php if(!empty($homeland_price)) : ?><h5><?php homeland_property_price_format(); ?></h5><?php endif; ?><?php if(!empty($homeland_property_sold)) : ?><label class="gmap-sold"><?php esc_html_e('Sold', 'homeland'); ?></label><?php endif; ?><a href="<?php the_permalink(); ?>" class="view-gmap"><?php esc_html_e('View More', 'homeland'); ?></a></div>'
								    }
								  });
								<?php
					    endwhile; 
				    	wp_reset_query();
		      	?>			        
				  });
				})(jQuery);					
			</script><?php
		}
	endif;


	/* Google Map for Property */

	if ( ! function_exists( 'homeland_google_map_property' ) ) :
		function homeland_google_map_property() {
			global $post;

			$homeland_property_hide_map = esc_attr(get_post_meta($post->ID, 'homeland_property_hide_map', true));
			$homeland_lat = esc_attr( get_post_meta( $post->ID, 'homeland_property_lat', true ) );
			$homeland_lng = esc_attr( get_post_meta( $post->ID, 'homeland_property_lng', true ) );
			$homeland_property_map_zoom = esc_attr(get_post_meta($post->ID, 'homeland_property_map_zoom', true));
			$homeland_home_map_icon = esc_attr( get_option('homeland_map_pointer_icon') );
			$homeland_hide_map = esc_attr( get_option('homeland_hide_map') );

			if(!empty($homeland_property_map_zoom)) : 
				$homeland_property_map_zoom_value = $homeland_property_map_zoom; 
			else : 
				$homeland_property_map_zoom_value = '8';
			endif;

			if(!empty($homeland_lat) && !empty($homeland_lng)) : 
				$homeland_lat_value = $homeland_lat; 
				$homeland_lng_value = $homeland_lng; 
			else : 
				$homeland_lat_value = '37.0625';
				$homeland_lng_value = '-95.677068';
			endif;

			if(empty($homeland_property_hide_map)) :
				if(empty($homeland_hide_map)) : ?>
					<script type="text/javascript">
						(function($) {
					  	"use strict";
					  	var map;
					  	var panorama;
					  	var snazzyMap = JSON.parse(wpGlobals.mapOptions);

					   	$(document).ready(function(){
						   	map = new GMaps({
				        	div: '#map-property',
				        	scrollwheel: false,
									lat: <?php echo esc_html( $homeland_lat_value ); ?>, 
									lng: <?php echo esc_html( $homeland_lng_value ); ?>,
									zoom: <?php echo esc_html( $homeland_property_map_zoom_value ); ?>,
									styles : snazzyMap,
					      });
						    		
						    	<?php if(!empty($homeland_home_map_icon)) : ?>
						    		var image = '<?php echo esc_url( $homeland_home_map_icon ); ?>';
						    	<?php endif; ?>
						      	
					      	map.addMarker({
							      <?php if(!empty($homeland_home_map_icon)) : ?>icon: image, <?php endif; ?>
										lat: <?php echo esc_html( $homeland_lat_value ); ?>, 
										lng: <?php echo esc_html( $homeland_lng_value ); ?>,   
					      	});

					      	panorama = GMaps.createPanorama({
								  	el: '#map-property-street',
								  	scrollwheel: false,
								  	lat: <?php echo esc_html( $homeland_lat_value ); ?>, 
								  	lng: <?php echo esc_html( $homeland_lng_value ); ?>,  
								});
					   	});
						})(jQuery);					
					</script><?php
				endif;
			endif;
		}
	endif;


	/* Google Map for Contact us */

	if ( ! function_exists( 'homeland_google_map' ) ) :
		function homeland_google_map() {
			$homeland_lat = esc_attr( get_option('homeland_map_lat') );
			$homeland_lng = esc_attr( get_option('homeland_map_lng') );
			$homeland_map_zoom = esc_attr( get_option('homeland_map_zoom') );		
			$homeland_contact_address = stripslashes( get_option('homeland_contact_address') );		
			$homeland_home_map_icon = esc_attr( get_option('homeland_map_pointer_icon') );

			if(!empty($homeland_map_zoom)) : 
				$homeland_map_zoom_value = $homeland_map_zoom; 
			else : 
				$homeland_map_zoom_value ='8'; 
			endif;

			if(!empty($homeland_lat) && !empty($homeland_lng)) : 
				$homeland_lat_value = $homeland_lat; 
				$homeland_lng_value = $homeland_lng; 
			else : 
				$homeland_lat_value = '37.0625';
				$homeland_lng_value = '-95.677068';
			endif;
			?>
			<script type="text/javascript">
				(function($) {
			  	"use strict";
			  	var map;
			  	var snazzyMap = JSON.parse(wpGlobals.mapOptions);
			  	
			   	$(document).ready(function(){
			    	map = new GMaps({
			        div: '#map',
			        scrollwheel: false,
				      lat: <?php echo esc_html( $homeland_lat_value ); ?>,
							lng: <?php echo esc_html( $homeland_lng_value ); ?>,
							zoom: <?php echo esc_html( $homeland_map_zoom_value ); ?>,
							styles : snazzyMap,
			      });
			    	<?php if(!empty($homeland_home_map_icon)) : ?>
			    		var image = '<?php echo esc_url( $homeland_home_map_icon ); ?>';
			    	<?php endif; ?>

		      	map.addMarker({
			        lat: <?php echo esc_html( $homeland_lat_value ); ?>,
							lng: <?php echo esc_html( $homeland_lng_value ); ?>,
			        title: '',
			        <?php if(!empty($homeland_home_map_icon)) : ?>icon: image, <?php endif; ?>
			        infoWindow: {
				    		content: '<p><?php echo $homeland_contact_address; ?></p>'
				    	}
		      	});
			   	});
				})(jQuery);					
			</script>
			<?php
		}
	endif;


	/* Change Default login logo and link */

	if ( ! function_exists( 'homeland_login_image' ) ) :
		function homeland_login_image() {
			$homeland_logo = esc_attr( get_option('homeland_logo') );

			wp_enqueue_style( 'homeland-custom-style',
        get_template_directory_uri() . '/includes/admin/admin-style.css'
    	);

			$homeland_custom_css = "
				body.login #login h1 a {
					background: url('" . esc_url( $homeland_logo ) . "') center top no-repeat transparent;
					width: 100%; height: 126px;
				}
			";
			wp_add_inline_style( 'homeland-custom-style', $homeland_custom_css );

		}
	endif;

	if ( ! function_exists( 'homeland_custom_login_url' ) ) :
		function homeland_custom_login_url() { return home_url(); }
	endif;

	$homeland_logo = esc_attr( get_option('homeland_logo') );
	
	if(!empty( $homeland_logo )) : 
		add_action( 'login_head', 'homeland_login_image' );
		add_filter( 'login_headerurl', 'homeland_custom_login_url' ); 
	endif;


	/* Change Default Site Title */

	if ( ! function_exists( 'homeland_change_default_site_title' ) ) :
		function homeland_change_default_site_title( $homeland_title ){
			$homeland_screen = get_current_screen();
			if('homeland_properties' == $homeland_screen->post_type) :
				$homeland_title = esc_html__( 'Enter property name', 'homeland' );
			elseif('homeland_portfolio' == $homeland_screen->post_type) :
				$homeland_title = esc_html__( 'Enter portfolio name', 'homeland' );
			elseif('homeland_services' == $homeland_screen->post_type) :
				$homeland_title = esc_html__( 'Enter services name', 'homeland' );
			elseif('homeland_testimonial' == $homeland_screen->post_type) :
				$homeland_title = esc_html__( 'Enter name', 'homeland' );
			elseif('homeland_partners' == $homeland_screen->post_type) :
				$homeland_title = esc_html__( 'Enter partner name', 'homeland' );
			endif;
			return $homeland_title;
		}
	endif;
	add_filter( 'enter_title_here', 'homeland_change_default_site_title' );


	/* Main Menu and Footer fallback */

	if ( ! function_exists( 'homeland_menu_fallback' ) ) :
		function homeland_menu_fallback() {
			$homeland_class = "";
			if(is_front_page()) : $homeland_class="current_page_item"; endif;
			?>
				<div id="dropdown" class="theme-menu clear">
					<ul id="main-menu" class="sf-menu">
						<li <?php sanitize_html_class( post_class( $homeland_class ) ); ?>>
							<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'homeland' ); ?></a>
						</li>
						<?php wp_list_pages( 'title_li=&sort_column=menu_order' ); ?>
					</ul>
				</div>
			<?php
		}
	endif;

	if ( ! function_exists( 'homeland_footer_menu_fallback' ) ) :
		function homeland_footer_menu_fallback() {
			?>
				<div class="footer-menu">
					<ul id="menu-footer-menu" class="clear">
						<li>
							<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home', 'homeland' ); ?></a>
						</li>
						<?php wp_list_pages( 'title_li=&sort_column=menu_order' ); ?>
					</ul>
				</div>
			<?php
		}
	endif;


	/* Get Page Custom Title */

	if ( ! function_exists( 'homeland_get_page_title' ) ) :
		function homeland_get_page_title() {
			global $post, $wp_query, $homeland_page, $homeland_ptitle, $homeland_theme_pages;

			$homeland_search_header = esc_attr( get_option('homeland_search_header') );
			$homeland_search_subtitle = esc_attr( get_option('homeland_search_subtitle') );
			$homeland_not_found_header = esc_attr( get_option('homeland_not_found_header') );
			$homeland_not_found_subtitle = esc_attr( get_option('homeland_not_found_subtitle') );
			$homeland_forum_header = esc_attr( get_option('homeland_forum_header') );
			$homeland_forum_subtitle = esc_attr( get_option('homeland_forum_subtitle') );
			$homeland_property_archive_header = esc_attr( get_option('homeland_property_archive_header') );
			$homeland_property_archive_subtitle = esc_attr( get_option('homeland_property_archive_subtitle') );
			$homeland_portfolio_archive_header = esc_attr( get_option('homeland_portfolio_archive_header') );
			$homeland_portfolio_archive_subtitle = esc_attr( get_option('homeland_portfolio_archive_subtitle') );
			$homeland_services_archive_header = esc_attr( get_option('homeland_services_archive_header') );
			$homeland_services_archive_subtitle = esc_attr( get_option('homeland_services_archive_subtitle') );
			$homeland_agent_profile_header = esc_attr( get_option('homeland_agent_profile_header') );
			$homeland_agent_profile_subtitle = esc_attr( get_option('homeland_agent_profile_subtitle') );

			$homeland_property_archive_header_label = !empty($homeland_property_archive_header) ? $homeland_property_archive_header : esc_html__('Our Properties', 'homeland');
			$homeland_property_archive_subtitle_label = !empty($homeland_property_archive_subtitle) ? $homeland_property_archive_subtitle : esc_html__('This is your property subtitle here', 'homeland');
			$homeland_portfolio_archive_header_label = !empty($homeland_portfolio_archive_header) ? $homeland_portfolio_archive_header : esc_html__('Our Portfolio', 'homeland');
			$homeland_portfolio_archive_subtitle_label = !empty($homeland_portfolio_archive_subtitle) ? $homeland_portfolio_archive_subtitle : esc_html__('This is your portfolio subtitle here', 'homeland');
			$homeland_services_archive_header_label = !empty($homeland_services_archive_header) ? $homeland_services_archive_header : esc_html__('Our Services', 'homeland');
			$homeland_services_archive_subtitle_label = !empty($homeland_services_archive_subtitle) ? $homeland_services_archive_subtitle : esc_html__('This is your services subtitle here', 'homeland');
			$homeland_search_header_label = !empty($homeland_search_header) ? $homeland_search_header : esc_html__('Search Results', 'homeland');
			$homeland_search_subtitle_label = !empty($homeland_search_subtitle) ? $homeland_search_subtitle : esc_html__('This is your search subtitle description', 'homeland');
			$homeland_not_found_header_label = !empty($homeland_not_found_header) ? $homeland_not_found_header : esc_html__('404 Page', 'homeland');
			$homeland_not_found_subtitle_label = !empty($homeland_not_found_subtitle) ? $homeland_not_found_subtitle : esc_html__('This is your 404 not found subtitle here', 'homeland');
			$homeland_agent_profile_header_label = !empty($homeland_agent_profile_header) ? $homeland_agent_profile_header : esc_html__('Agent Profile', 'homeland');
			$homeland_agent_profile_subtitle_label = !empty($homeland_agent_profile_subtitle) ? $homeland_agent_profile_subtitle : esc_html__('This is your agent subtitle here', 'homeland');

			$homeland_ptitle = esc_attr( get_post_meta( @$post->ID, "homeland_ptitle", true ) );
			$homeland_subtitle = esc_attr( get_post_meta( @$post->ID, "homeland_subtitle", true ) );
			$homeland_address = esc_attr( get_post_meta( @$post->ID, 'homeland_address', true) );
			$homeland_property_heading = esc_attr( get_post_meta( @$post->ID, 'homeland_property_heading', true) );

			// header archive properties
			if (is_post_type_archive('homeland_properties')) : 
				echo '<h2 class="ptitle">' . esc_html( $homeland_property_archive_header_label ) . '</h2>';
				echo '<h4 class="subtitle"><label>' . esc_html( $homeland_property_archive_subtitle_label ) . '</label></h4>';

			// header archive portfolio
			elseif (is_post_type_archive('homeland_portfolio')) : 
				echo '<h2 class="ptitle">' . esc_html( $homeland_portfolio_archive_header_label ) . '</h2>';
				echo '<h4 class="subtitle"><label>'. esc_html( $homeland_portfolio_archive_subtitle_label ) .'</label></h4>';

			// header archive services
			elseif (is_post_type_archive('homeland_services')) : 
				echo '<h2 class="ptitle">' . esc_html( $homeland_services_archive_header_label ) . '</h2>';
				echo '<h4 class="subtitle"><label>' . esc_html( $homeland_services_archive_subtitle_label ) . '</label></h4>';

			// header archive default
			elseif(is_archive()) : 
				echo '<h2 class="ptitle">';
					if (is_category()) : single_cat_title();
					elseif(is_tag()) : printf( esc_html_e('Posts Tagged: ', 'homeland'), single_tag_title() ); 
					elseif(is_day()) : printf( esc_html__( 'Daily Archives: %s', 'homeland'), get_the_date()); 
					elseif(is_month()) : printf( esc_html__( 'Monthly Archives: %s', 'homeland' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'homeland' ) ) ); 
					elseif ( is_year() ) : printf( esc_html__( 'Yearly Archives: %s', 'homeland' ), get_the_date( _x( 'Y', 'yearly archives date format', 'homeland' ) ) ); 
					elseif ( is_tax() ) : echo get_queried_object()->name;
					elseif ( is_author() ) : echo esc_html( $homeland_agent_profile_header_label );
					elseif(function_exists('is_bbpress')) :
						if ( bbp_is_forum_archive() ) :
							if(!empty($homeland_forum_header)) : echo esc_html( $homeland_forum_header );
							else : the_title(); endif; 
						endif;
					endif;
				echo '</h2>';

				if( is_author() ) : 
					echo '<h4 class="subtitle"><label>'. esc_html( $homeland_agent_profile_subtitle_label ) .'</label></h4>';
				elseif( is_category() ) : 
					$homeland_category_id = get_query_var('cat'); 
					$homeland_category_data = get_option("category_$homeland_category_id"); 
					
					if(!empty($homeland_category_data['homeland_subtitle'])) : 
						echo '<h4 class="subtitle"><label>' . @$homeland_category_data['homeland_subtitle'] . '</label></h4>';
					endif;
				elseif( is_tax() ) : 
					$homeland_term = $wp_query->queried_object;
					$homeland_category_id = $homeland_term->term_id;
					$homeland_category_data = get_option("category_$homeland_category_id"); 
					
					if(!empty($homeland_category_data['homeland_subtitle'])) : 
						echo '<h4 class="subtitle"><label>' . @$homeland_category_data['homeland_subtitle'] . '</label></h4>';
					endif;
				elseif(function_exists('is_bbpress')) :	
					if ( bbp_is_forum_archive() ) :
						if(!empty($homeland_forum_subtitle)) : 
							echo '<h4 class="subtitle"><label>' . stripslashes ( $homeland_forum_subtitle ) . '</label></h4>';
						endif;	
					endif;	
				endif; 

			// header search
			elseif (is_search()) : 
				echo '<h2 class="ptitle">' . esc_html( $homeland_search_header_label ) . '</h2>';
				echo '<h4 class="subtitle"><label>' . esc_html( $homeland_search_subtitle_label ) . '</label></h4>';

			// header services
			elseif (is_singular('homeland_services')) : the_title('<h2 class="ptitle">', '</h2>');

			// header properties
			elseif (is_singular('homeland_properties')) : 
				the_title('<h2 class="ptitle">', '</h2>');
				if(!empty($homeland_property_heading)) :
					echo '<h4 class="subtitle"><label>' . esc_html( $homeland_property_heading ) . '</label></h4>';
				endif;
/*				
				if(!empty($homeland_address)) :
					echo '<h4 class="subtitle"><label><i class="fa fa-map-marker"></i>' . esc_html( $homeland_address ) . '</label></h4>';
				endif;
*/
			// header portfolio
			elseif (is_singular('homeland_portfolio')) : the_title('<h2 class="ptitle">', '</h2>');

			// header single page
			elseif (is_single() || is_home()) : 
				if(function_exists('is_bbpress')) :
					if(bbp_is_single_forum() || bbp_is_single_topic() || bbp_is_topic_edit()) : 
						the_title('<h2 class="ptitle">', '</h2>'); 
					else :
						the_title('<h2 class="ptitle">', '</h2>');
					endif;
				else : 
					the_title('<h2 class="ptitle">', '</h2>');
				endif;
				
			// header 404		
			elseif (is_404()) :	
				echo '<h2 class="ptitle">' . esc_html( $homeland_not_found_header_label ) . '</h2>';
				echo '<h4 class="subtitle"><label>' . esc_html( $homeland_not_found_subtitle_label ) . '</label></h4>';

			// header default	
			else :
				if(!empty($homeland_ptitle)) : 
					echo '<h2 class="ptitle">' . esc_html( $homeland_ptitle ) . '</h2>';
				else : the_title('<h2 class="ptitle">', '</h2>'); endif; 

				if(!empty($homeland_subtitle)) : 
					echo '<h4 class="subtitle"><label>' . stripslashes ( $homeland_subtitle ) . '</label></h4>';
				endif;
			endif;		
		}
	endif;

	/* Subtitle description */
	if ( ! function_exists( 'homeland_get_page_title_subtitle_desc' ) ) :
		function homeland_get_page_title_subtitle_desc() {
			global $homeland_theme_pages;

			foreach($homeland_theme_pages as $homeland_page) :
				$homeland_page_title = esc_attr( get_post_meta( $homeland_page->ID, "homeland_ptitle", true ) );
				$homepage_subtitle = esc_attr( get_post_meta( $homeland_page->ID, "homeland_subtitle", true ) );

				if($homeland_page_title != "") : $homeland_ptitle = $homeland_page_title;
				else : $homeland_ptitle = esc_attr( $homeland_page->post_title ); endif;
			endforeach; 

			echo '<h2 class="ptitle">' . stripslashes ( $homeland_ptitle ) . '</h2>';
			if(!empty($homepage_subtitle)) : 
				echo '<h4 class="subtitle"><label>' . stripslashes ( $homeland_subtitle ) . '</label></h4>';
			endif;
		}
	endif;


	/* Get Property Type */
	
	if ( ! function_exists( 'homeland_get_property_category' ) ) :
		function homeland_get_property_category() {
			global $homeland_properties_page_url, $homeland_properties_page_2cols_url, $homeland_properties_page_3cols_url, $homeland_properties_page_4cols_url; ?>
			<div class="cat-toogles">
				<ul class="cat-list clear">
					<li class="<?php if(is_page_template('template-properties.php') || is_page_template('template-properties-2cols.php') || is_page_template('template-properties-3cols.php') || is_page_template('template-properties-4cols.php')) : echo 'current-cat'; endif; ?>"><a href="<?php echo esc_url( $homeland_properties_page_url ); ?>"><?php esc_html_e('All', 'homeland'); ?></a></li>
					<?php
						$args = array( 'taxonomy' => 'homeland_property_type', 'style' => 'list', 'title_li' => '', 'hierarchical' => false, 'order' => 'ASC', 'orderby' => 'title' );
						wp_list_categories ( $args );
					?>	
				</ul>
			</div><?php
		}
	endif;	


	/* Get Property Terms */

	if ( ! function_exists( 'homeland_property_terms' ) ) :
		function homeland_property_terms() {
			global $post, $homeland_property_status;

			$homeland_terms = get_the_terms( @$post->ID, 'homeland_property_status' ); 
			if ( $homeland_terms && ! is_wp_error( $homeland_terms ) ) : 
				$homeland_property_status = array();
				foreach ( $homeland_terms as $homeland_term ) :
					$homeland_property_status[] = $homeland_term->name;
				endforeach;					
				$homeland_property_status = join( ", ", $homeland_property_status );
			endif;
		}
	endif;


	/* Get Page Template Link */

	if ( ! function_exists( 'homeland_template_page_link' ) ) :
		function homeland_template_page_link() {
			global $homeland_blog_page_url, $homeland_contact_page_url, 
			$homeland_properties_page_url, $homeland_properties_page_2cols_url, 
			$homeland_properties_page_3cols_url, $homeland_properties_page_4cols_url, 
			$homeland_about_page_url, $homeland_agent_page_url, 
			$homeland_services_page_url, $homeland_advance_search_page_url, 
			$homeland_portfolio_page_url, $homeland_login_page_url, $homeland_print_page_url;

			$homeland_properties_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-properties.php' ));
			foreach($homeland_properties_pages as $page) :
				$homeland_properties_page_id = $page->ID;
				$homeland_properties_page_url = get_permalink($homeland_properties_page_id);
			endforeach;

			$homeland_properties_pages_4cols = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-properties-4cols.php' ));
			foreach($homeland_properties_pages_4cols as $page) :
				$homeland_properties_page_4cols_id = $page->ID;
				$homeland_properties_page_4cols_url = get_permalink($homeland_properties_page_4cols_id);
			endforeach;

			$homeland_properties_pages_3cols = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-properties-3cols.php' ));
			foreach($homeland_properties_pages_3cols as $page) :
				$homeland_properties_page_3cols_id = $page->ID;
				$homeland_properties_page_3cols_url = get_permalink($homeland_properties_page_3cols_id);
			endforeach;

			$homeland_properties_pages_2cols = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-properties-2cols.php' ));
			foreach($homeland_properties_pages_2cols as $page) :
				$homeland_properties_page_2cols_id = $page->ID;
				$homeland_properties_page_2cols_url = get_permalink($homeland_properties_page_2cols_id);
			endforeach;

			$homeland_blog_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-blog.php' ));
			foreach($homeland_blog_pages as $page) :
				$homeland_blog_page_id = $page->ID;
				$homeland_blog_page_url = get_permalink($homeland_blog_page_id);
			endforeach;

			$homeland_contact_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'template-contact.php'));
			foreach($homeland_contact_pages as $page) :
				$homeland_contact_page_id = $page->ID;
				$homeland_contact_page_url = get_permalink($homeland_contact_page_id);
			endforeach;

			$homeland_about_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'template-about.php'));
			foreach($homeland_about_pages as $page) :
				$homeland_about_page_id = $page->ID;
				$homeland_about_page_url = get_permalink($homeland_about_page_id);
			endforeach;

			$homeland_agent_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'template-agents.php'));
			foreach($homeland_agent_pages as $page) :
				$homeland_agent_page_id = $page->ID;
				$homeland_agent_page_url = get_permalink($homeland_agent_page_id);
			endforeach;

			$homeland_services_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'template-services.php'));
			foreach($homeland_services_pages as $page) :
				$homeland_services_page_id = $page->ID;
				$homeland_services_page_url = get_permalink($homeland_services_page_id);
			endforeach;

			$homeland_advance_search_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-property-search.php' ));
			foreach($homeland_advance_search_pages as $page) :
				$homeland_advance_search_page_id = $page->ID;
				$homeland_advance_search_page_url = get_permalink($homeland_advance_search_page_id);
			endforeach;

			$homeland_portfolio_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-portfolio.php' ));
			foreach($homeland_portfolio_pages as $page) :
				$homeland_portfolio_page_id = $page->ID;
				$homeland_portfolio_page_url = get_permalink($homeland_portfolio_page_id);
			endforeach;

			$homeland_login_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-login.php' ));
			foreach($homeland_login_pages as $page) :
				$homeland_login_page_id = $page->ID;
				$homeland_login_page_url = get_permalink($homeland_login_page_id);
			endforeach;

			$homeland_print_pages = get_pages(array( 'meta_key' => '_wp_page_template', 'meta_value' => 'template-print.php' ));
			foreach($homeland_print_pages as $page) :
				$homeland_print_page_id = $page->ID;
				$homeland_print_page_url = get_permalink($homeland_print_page_id);
			endforeach;
		}
	endif;


	/* Custom Excerpt Length */

	if(!function_exists('homeland_custom_excerpt_length')) :
		function homeland_custom_excerpt_length($length) { 
			global $post;

			$homeland_excerpt_length_properties = esc_attr( get_option('homeland_excerpt_length_properties') );
			$homeland_excerpt_length_services = esc_attr( get_option('homeland_excerpt_length_services') );
			$homeland_excerpt_length_portfolio = esc_attr( get_option('homeland_excerpt_length_portfolio') );
			$homeland_excerpt_length_blog = esc_attr( get_option('homeland_excerpt_length_blog') );

			if ($post->post_type == 'post') :
			  if(empty($homeland_excerpt_length_blog)) : return 30;
				else : return $homeland_excerpt_length_blog;
				endif;
			elseif ($post->post_type == 'homeland_properties') :
			  if(empty($homeland_excerpt_length_properties)) : return 30;
				else : return $homeland_excerpt_length_properties;
				endif;
			elseif ($post->post_type == 'homeland_services') :
				if(empty($homeland_excerpt_length_services)) : return 30;
				else : return $homeland_excerpt_length_services;
				endif;
			elseif ($post->post_type == 'homeland_portfolio') :
				if(empty($homeland_excerpt_length_portfolio)) : return 30;
				else : return $homeland_excerpt_length_portfolio;
				endif;
			else :
				return 30; 
			endif;
		}
	endif;
	add_filter('excerpt_length', 'homeland_custom_excerpt_length', 999);

	if(!function_exists('homeland_custom_excerpt_more')) :
		function homeland_custom_excerpt_more($more) { return ' ...'; }
	endif;
	add_filter('excerpt_more', 'homeland_custom_excerpt_more');


	/* Remove Default Comment Fields */

	if(!function_exists('homeland_remove_comment_fields')) :
		function homeland_remove_comment_fields($arg) {
		  $arg['url'] = '';
		  return $arg;
		}
	endif;
	add_filter('comment_form_default_fields', 'homeland_remove_comment_fields');

	
	/* Custom Comment Style */

	if(!function_exists('homeland_theme_comment')) :
		function homeland_theme_comment($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment; ?>		
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div class="parent clear" id="comment-<?php comment_ID(); ?>">					
					<?php echo get_avatar( $comment, 60 ); ?>
					<div class="comment-details">
						<h5><?php comment_author_link(); ?>
							<span><?php echo human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago'; ?> <?php edit_comment_link('edit','&nbsp;',''); ?></span>	
						</h5> 
						<?php 
							comment_text(); 
							comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
							edit_comment_link('edit','&nbsp;',''); 
							if ($comment->comment_approved == '0') : ?><em><?php esc_html_e('Your comment is awaiting moderation.', 'homeland'); ?></em><?php 
							endif; 					
						?>
					</div>
				</div><?php
			$oddcomment = (empty($oddcomment)) ? 'class="alt" ' : '';
		}
	endif;


	/* Custom Pagination */

	if(!function_exists( 'homeland_pagination')) :
		function homeland_pagination() {  
			global $wp_query, $homeland_max_num_pages;
			$big = 999999999;

			if(is_page_template('template-agents.php') || is_page_template('template-agents-fullwidth.php') || is_page_template('template-agents-list-fullwidth.php') || is_page_template('template-agents-left-sidebar.php') || is_page_template('template-agents-grid-right-sidebar.php') || is_page_template('template-agents-grid-left-sidebar.php')) : $max_num_pages_count = $homeland_max_num_pages;
			else : $max_num_pages_count = $wp_query->max_num_pages;
			endif;

			if($max_num_pages_count == '1') : 
			else : echo '<div class="pagination clear">'; 
			endif;
				
			echo paginate_links( array(
				'base' => str_replace($big, '%#%', get_pagenum_link($big)),
				'format' => '?paged=%#%',
				'prev_text' => esc_html__('&laquo;', 'homeland'),
	    	'next_text' => esc_html__('&raquo;', 'homeland'),
				'current' => max(1, get_query_var('paged')),
				'total' => $max_num_pages_count,
				'type' => 'list'
			));
			if($max_num_pages_count == '1') : else : echo "</div>"; endif;
		}
	endif;


	/* Custom Next Previous Link */

	if(!function_exists('homeland_next_previous')) :
		function homeland_next_previous() { ?>
			<div class="pagination">
				<?php
				  global $wp_query, $paged, $homeland_max_num_pages;		

				  if(is_page_template('template-agents.php') || is_page_template('template-agents-fullwidth.php') || is_page_template('template-agents-list-fullwidth.php') || is_page_template('template-agents-left-sidebar.php')) : $max_num_pages_count = $homeland_max_num_pages;
					else : $max_num_pages_count = $wp_query->max_num_pages;
					endif;

				  if($paged > 1) : ?>
				  	<div class="alignleft"><a href="<?php previous_posts(); ?>">&larr; <?php esc_html_e('Previous', 'homeland'); ?></a></div><?php
				  endif;
				    
				  if($max_num_pages_count == 1) :	    		
			    elseif($paged < $max_num_pages_count) : ?>
			    	<div class="alignright"><a href="<?php next_posts(); ?>"><?php esc_html_e('Next', 'homeland'); ?> &rarr;</a></div><?php
			    endif;
				?>
			</div><?php
		}
	endif;


	/* Fix Pagination for Taxonomies */

	$homeland_posts_per_page = get_option('posts_per_page');
	
	if(!function_exists('homeland_modify_posts_per_page')) :		
		function homeland_modify_posts_per_page() { 
			add_filter('option_posts_per_page', 'homeland_option_posts_per_page'); 
		}
	endif;
	add_action('init', 'homeland_modify_posts_per_page', 0);

	if(!function_exists('homeland_option_posts_per_page')) :	
		function homeland_option_posts_per_page($value) {
			global $homeland_posts_per_page, $wp_query;

			if(is_tax('homeland_property_type')) : 
				return $wp_query->max_num_pages;
			elseif(is_tax('homeland_property_status')) : 
				return $wp_query->max_num_pages;
			elseif(is_tax('homeland_property_location')) : 
				return $wp_query->max_num_pages;
			elseif(is_tax('homeland_property_amenities')) : 
				return $wp_query->max_num_pages;
			elseif(is_author()) : 
				return $wp_query->max_num_pages;
			elseif(is_post_type_archive('homeland_properties')) : 
				return $wp_query->max_num_pages;
			elseif(is_post_type_archive('homeland_portfolio')) : 
				return $wp_query->max_num_pages;
			elseif(is_post_type_archive('homeland_services')) : 
				return $wp_query->max_num_pages;
			else : 
				return $homeland_posts_per_page; 
			endif;
		}
	endif;


	/* Pagination working on static homepage */

	if(!function_exists('homeland_get_home_pagination')) :	
		function homeland_get_home_pagination() {
			global $paged, $wp_query, $wp;

			$args = wp_parse_args($wp->matched_query);
			if(!empty($args['paged']) && 0 == $paged) :
				$wp_query->set('paged', $args['paged']);
			  $paged = $args['paged'];
			endif;
		}
	endif;


	/* Pagination working for author page */

	if(!function_exists('homeland_custom_agent_pagination')) :	
		function homeland_custom_agent_pagination($query) {
	    if($query->is_author) $query->set('post_type', array('homeland_properties', 'post'));
		}
		add_action('pre_get_posts', 'homeland_custom_agent_pagination');
	endif;


	/* Agent Contributor upload files */

	if(!function_exists('homeland_allow_contributor_uploads')) :	
		function homeland_allow_contributor_uploads() {
	 		$contributor = get_role('contributor');
	 		$contributor->add_cap('upload_files');
	 		$contributor->add_cap('can_edit_posts');
		}
	endif;
	//if ( current_user_can('contributor') && !current_user_can('upload_files') )
 	add_action('admin_init', 'homeland_allow_contributor_uploads');


 	/* Agent Custom Columns in admin area */
 	
	function homeland_users_properties_column($homeland_cols) {
  	$homeland_cols['homeland_user_properties'] = esc_html__( 'Listings', 'homeland' );   
  	return $homeland_cols;
	}

	function homeland_user_properties_column_value($homeland_value, $homeland_column_name, $homeland_id) {
  	if($homeland_column_name == 'homeland_user_properties') {
    	global $wpdb;
    	$homeland_count = (int) $wpdb->get_var($wpdb->prepare( "SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'homeland_properties' AND post_status = 'publish' AND post_author = %d", $homeland_id ));
    	return $homeland_count;
  	}
	}
	add_filter('manage_users_custom_column', 'homeland_user_properties_column_value', 10, 3);
	add_filter('manage_users_columns', 'homeland_users_properties_column');


	/* Advance Property Search */

	if(!function_exists('homeland_advance_property_search')) :	
		function homeland_advance_property_search($homeland_search_args) {
			$homeland_tax_query = array();
			$homeland_meta_query = array();

			if((!empty($_GET['location']))) : 
				$homeland_tax_query[] = array(
					'taxonomy' => 'homeland_property_location', 'field' => 'slug', 'terms' => $_GET['location']
				); 
			endif;

			if((!empty($_GET['status']))) : 
				$homeland_tax_query[] = array(
					'taxonomy' => 'homeland_property_status', 'field' => 'slug', 'terms' => $_GET['status']
				); 
			endif;

			if((!empty($_GET['type']))) : 
				$homeland_tax_query[] = array(
					'taxonomy' => 'homeland_property_type', 'field' => 'slug', 'terms' => $_GET['type']
				); 
			endif;

			if((!empty($_GET['amenities']))) : 
				$homeland_tax_query[] = array(
					'taxonomy' => 'homeland_property_amenities', 'field' => 'slug', 'terms' => $_GET['amenities']
				); 
			endif;

			if((!empty($_GET['bed']))) : 
				$homeland_meta_query[] = array(
					'key' => 'homeland_bedroom', 'value' => $_GET['bed'], 'type' => 'NUMERIC', 'compare' => '='
				); 
			endif;

			if((!empty($_GET['bath']))) : 
				$homeland_meta_query[] = array(
					'key' => 'homeland_bathroom', 'value' => $_GET['bath'], 'type' => 'NUMERIC', 'compare' => '='
				);
			endif;

			if((!empty($_GET['pid']))) : 
				$homeland_meta_query[] = array(
					'key' => 'homeland_property_id', 'value' => $_GET['pid'], 'type' => 'CHAR', 'compare' => '='
				); 
			endif;

			// Both Minimum and Maximum Price
	    if(isset($_GET['min-price']) && isset($_GET['max-price'])) :
	      $homeland_min_price = intval($_GET['min-price']);
	      $homeland_max_price = intval($_GET['max-price']);
	         
				if($homeland_min_price >= 0 && $homeland_max_price > $homeland_min_price) :
				  $homeland_meta_query[] = array( 
			  		'key' => 'homeland_price', 
			  		'value' => array($homeland_min_price, $homeland_max_price), 
			  		'type' => 'NUMERIC', 
			  		'compare' => 'BETWEEN' 
			  	);
				endif;
			endif;
	      
      // Minimum Price
      if(isset($_GET['min-price'])) :
      	$homeland_min_price = intval($_GET['min-price']);   
      	if( $homeland_min_price > 0 ) : 
      		$homeland_meta_query[] = array( 
      			'key' => 'homeland_price', 
      			'value' => $homeland_min_price, 
      			'type' => 'NUMERIC', 
      			'compare' => '>=' 
      		); 
      	endif;
      endif;

      // Maximum Price
      if(isset($_GET['max-price'])) :
        $homeland_max_price = intval($_GET['max-price']);
        if( $homeland_max_price > 0 ) : 
        	$homeland_meta_query[] = array( 
        		'key' => 'homeland_price', 
        		'value' => $homeland_max_price, 
        		'type' => 'NUMERIC', 
        		'compare' => '<=' 
        	); 
        endif;
	 		endif;

	 		$homeland_tax_count = count($homeland_tax_query);
			if($homeland_tax_count > 1) : $homeland_tax_query['relation'] = 'AND'; 
			endif;

			$homeland_meta_count = count($homeland_meta_query);
			if($homeland_meta_count > 1) : $homeland_meta_query['relation'] = 'AND'; 
			endif;
			if($homeland_tax_count > 0) : $homeland_search_args['tax_query'] = $homeland_tax_query; 
			endif;
			if($homeland_meta_count > 0) : $homeland_search_args['meta_query'] = $homeland_meta_query; 
			endif;

			if(isset($_GET['filter-order'])) :
				if($_GET['filter-order'] == "ASC") : $homeland_search_args['order'] = 'ASC';
				else : $homeland_search_args['order'] = 'DESC';
			  endif;
			endif;

			if(isset($_GET['filter-sort'])) :
				if($_GET['filter-sort'] == "homeland_price") :
				  $homeland_search_args['meta_key'] = 'homeland_price';
				  $homeland_search_args['orderby'] = 'meta_value_num';
				elseif($_GET['filter-sort'] == "title") : $homeland_search_args['orderby'] = 'title';
				else : $homeland_search_args['orderby'] = 'date';
				endif;
			endif;
			return $homeland_search_args;
	   }
	endif;
  add_filter('homeland_advance_search_parameters', 'homeland_advance_property_search');


 	/* Property Sort and Order */

	if(!function_exists('homeland_property_sort_order')) :	
		function homeland_property_sort_order() {
			$homeland_filter_default = esc_attr(get_option('homeland_filter_default'));	
			$homeland_path = $_SERVER['REQUEST_URI']; ?>
			<div class="clear">
				<div class="filter-sort-order">
					<form action="<?php echo esc_url( $homeland_path ); ?>" method="get" class="form-sorting-order">
						<?php
							if(is_page_template('template-property-search.php')) : ?>
								<input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
								<input type="hidden" name="location" value="<?php echo $_GET['location']; ?>">
                <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
                <input type="hidden" name="bed" value="<?php echo $_GET['bed']; ?>">
                <input type="hidden" name="bath" value="<?php echo $_GET['bath']; ?>">
                <input type="hidden" name="min-price" value="<?php echo $_GET['min-price']; ?>">
                <input type="hidden" name="max-price" value="<?php echo $_GET['max-price']; ?>"><?php
							endif;
						?>
						<label for="input_order"><?php _e('Order', 'homeland'); ?></label>
					 	<select name="filter-order" id="input_order">
				      <?php
								$homeland_filter_order = @$_GET['filter-order'];
								$homeland_array = array( 
									'DESC' => esc_html__('Descending', 'homeland'), 
									'ASC' => esc_html__('Ascending', 'homeland') 
								);

								foreach($homeland_array as $homeland_order_option_value=>$homeland_order_option) : ?>
		              <option value="<?php echo $homeland_order_option_value; ?>" <?php if($homeland_filter_order == $homeland_order_option_value) : echo "selected='selected'"; endif; ?>><?php echo $homeland_order_option; ?></option><?php
		            endforeach;
							?>		
				    </select>
				    <label for="input_sort"><?php esc_html_e('Sort By', 'homeland'); ?></label>
					 	<select name="filter-sort" id="input_sort">
							<?php
								$homeland_filter_sort = @$_GET['filter-sort'];

								if($homeland_filter_default == "Name") :
									$homeland_array = array( 
										'title' => esc_html__('Name', 'homeland'), 
										'date' => esc_html__('Date', 'homeland'), 
										'homeland_price' => esc_html__('Price', 'homeland'), 
										'rand' => esc_html__('Random', 'homeland'), 
									);
								elseif($homeland_filter_default == "Price") :
									$homeland_array = array( 
										'homeland_price' => esc_html__('Price', 'homeland'), 
										'title' => esc_html__('Name', 'homeland'), 
										'date' => esc_html__('Date', 'homeland'), 
										'rand' => esc_html__('Random', 'homeland'), 
									);
								elseif($homeland_filter_default == "Random") :
									$homeland_array = array( 
										'rand' => esc_html__('Random', 'homeland'), 
										'title' => esc_html__('Name', 'homeland'), 
										'homeland_price' => esc_html__('Price', 'homeland'), 
										'date' => esc_html__('Date', 'homeland'), 
									);
								else :
									$homeland_array = array( 
										'date' => esc_html__('Date', 'homeland'), 
										'title' => esc_html__('Name', 'homeland'), 
										'homeland_price' => esc_html__('Price', 'homeland'), 
										'rand' => esc_html__('Random', 'homeland'), 
									);
								endif;
								
								foreach($homeland_array as $homeland_sort_option_value=>$homeland_sort_option) : ?>
		              <option value="<?php echo $homeland_sort_option_value; ?>" <?php if($homeland_filter_sort == $homeland_sort_option_value) : echo "selected='selected'"; endif; ?>><?php echo $homeland_sort_option; ?></option><?php
		            endforeach;
							?>		
						</select>                                                                                   
				   </form>	
				</div>
			</div><?php
		}
	endif;


	/* Remove & Add new field in user profile */

	if(!function_exists('homeland_add_new_contact_info')) :	
		function homeland_add_new_contact_info( $homeland_contact_methods ) {
			$homeland_contact_methods['homeland_designation'] = esc_html__('Designation', 'homeland');
			$homeland_contact_methods['homeland_twitter'] = esc_html__('Twitter', 'homeland');
			$homeland_contact_methods['homeland_facebook'] = esc_html__('Facebook', 'homeland');
			$homeland_contact_methods['homeland_gplus'] = esc_html__('Google Plus', 'homeland');
			$homeland_contact_methods['homeland_linkedin'] = esc_html__('LinkedIn', 'homeland');
			$homeland_contact_methods['homeland_telno'] = esc_html__('Telephone', 'homeland');
			$homeland_contact_methods['homeland_mobile'] = esc_html__('Mobile', 'homeland');
			$homeland_contact_methods['homeland_fax'] = esc_html__('Fax', 'homeland');

			// remove fields
		  unset($homeland_contact_methods['aim']);
			unset($homeland_contact_methods['jabber']);
			unset($homeland_contact_methods['yim']);

		  return $homeland_contact_methods;
		}
	endif;
	add_filter('user_contactmethods','homeland_add_new_contact_info', 10, 1);


	/* Add Post Thumbnail size in media upload */

	if(!function_exists('homeland_get_additional_image_sizes')) :
		function homeland_get_additional_image_sizes() {
			$sizes = array();
			global $_wp_additional_image_sizes;
			if (isset($_wp_additional_image_sizes) && count($_wp_additional_image_sizes)) :
				$sizes = apply_filters('intermediate_image_sizes', $_wp_additional_image_sizes);
				$sizes = apply_filters('homeland_get_additional_image_sizes', $_wp_additional_image_sizes);
			endif;
			return $sizes;
		}
	endif;

	if(!function_exists('homeland_additional_image_size_input_fields')) :
		function homeland_additional_image_size_input_fields($fields, $post) {
			if(!isset($fields['image-size']['html']) || substr($post->post_mime_type, 0, 5) != 'image')
			return $fields;

			$sizes = homeland_get_additional_image_sizes();
			if(!count($sizes))
			return $fields;

			$items = array();
			foreach (array_keys($sizes) as $size) {
				$downsize = image_downsize($post->ID, $size);
				$enabled = $downsize[3];
				$css_id = "image-size-{$size}-{$post->ID}";
				$label = apply_filters('image_size_name', $size);

				$html  = "<div class='image-size-item'>\n";
				$html .= "<input type='radio' " . disabled( $enabled, false, false ) . "name='attachments[{$post->ID}][image-size]' id='{$css_id}' value='{$size}' />\n";
				$html .= "<label for='{$css_id}'>{$label}</label>\n";
				if ( $enabled )
					$html .= "<label for='{$css_id}' class='help'>" . sprintf( "(%d x %d)", $downsize[1], $downsize[2] ). "</label>\n";
				$html .= "</div>";
				$items[] = $html;
			}
			$items = join( "\n", $items );
			$fields['image-size']['html'] = "{$fields['image-size']['html']}\n{$items}";
			return $fields;
		}
	endif;
	add_filter('attachment_fields_to_edit', 'homeland_additional_image_size_input_fields', 11, 2);


	/* Add Category Field */

	if(!function_exists('homeland_create_category_fields')) :
		function homeland_create_category_fields($homeland_tag) {    
	    $homeland_extra_id = @$homeland_tag->term_id;
	    $homeland_cat_meta = get_option("category_$homeland_extra_id"); ?>
			<div class="form-field">
				<label for="homeland_cat_meta[homeland_subtitle]"><?php esc_html_e('Subtitle', 'homeland'); ?></label>
				<input type="text" name="homeland_cat_meta[homeland_subtitle]" id="homeland_cat_meta[homeland_subtitle]" value="<?php echo $homeland_cat_meta['homeland_subtitle'] ? $homeland_cat_meta['homeland_subtitle'] : ''; ?>">
			    <p><?php esc_html_e('Add your subtitle text here', 'homeland'); ?></p>
			</div><?php
		}
	endif;

	if(!function_exists('homeland_edit_category_fields')) :
		function homeland_edit_category_fields($homeland_tag) {    
	    $homeland_extra_id = $homeland_tag->term_id;
	    $homeland_cat_meta = get_option("category_$homeland_extra_id"); ?>
			<tr class="form-field">
				<th valign="top" scope="row"><label for="homeland_cat_meta[homeland_subtitle]"><?php esc_html_e('Subtitle', 'homeland'); ?></label></th>
				<td>
					<input type="text" name="homeland_cat_meta[homeland_subtitle]" id="homeland_cat_meta[homeland_subtitle]" value="<?php echo $homeland_cat_meta['homeland_subtitle'] ? $homeland_cat_meta['homeland_subtitle'] : ''; ?>"><br>
					<span class="description"><?php esc_html_e('Edit your subtitle text here', 'homeland'); ?></span>
				</td>		        
			</tr><?php
		}
	endif;

	add_action('category_edit_form_fields', 'homeland_edit_category_fields');
	add_action('category_add_form_fields', 'homeland_create_category_fields');
	add_action('homeland_property_type_edit_form_fields', 'homeland_edit_category_fields');
	add_action('homeland_property_type_add_form_fields', 'homeland_create_category_fields');
	add_action('homeland_property_status_edit_form_fields', 'homeland_edit_category_fields');
	add_action('homeland_property_status_add_form_fields', 'homeland_create_category_fields');
	add_action('homeland_property_location_edit_form_fields', 'homeland_edit_category_fields');
	add_action('homeland_property_location_add_form_fields', 'homeland_create_category_fields');
	add_action('homeland_property_amenities_edit_form_fields', 'homeland_edit_category_fields');
	add_action('homeland_property_amenities_add_form_fields', 'homeland_create_category_fields');
	add_action('homeland_portfolio_category_edit_form_fields', 'homeland_edit_category_fields');
	add_action('homeland_portfolio_category_add_form_fields', 'homeland_create_category_fields');

	if(!function_exists('homeland_save_extra_category_fields')) :
		function homeland_save_extra_category_fields($term_id) {
			if(isset($_POST['homeland_cat_meta'])) :
				$homeland_extra_id = $term_id;
				$homeland_cat_meta = get_option("category_$homeland_extra_id");
				$homeland_cat_keys = array_keys($_POST['homeland_cat_meta']);
				foreach ($homeland_cat_keys as $homeland_key) :
					if (isset($_POST['homeland_cat_meta'][$homeland_key])) :
					  $homeland_cat_meta[$homeland_key] = $_POST['homeland_cat_meta'][$homeland_key];
					endif;
				endforeach;
				update_option("category_$homeland_extra_id", $homeland_cat_meta);        
			endif;
		}
	endif;

	add_action('edited_category', 'homeland_save_extra_category_fields');
	add_action('create_category', 'homeland_save_extra_category_fields');
	add_action('edited_homeland_property_type', 'homeland_save_extra_category_fields');
	add_action('create_homeland_property_type', 'homeland_save_extra_category_fields');
	add_action('edited_homeland_property_status', 'homeland_save_extra_category_fields');
	add_action('create_homeland_property_status', 'homeland_save_extra_category_fields');
	add_action('edited_homeland_property_location', 'homeland_save_extra_category_fields');
	add_action('create_homeland_property_location', 'homeland_save_extra_category_fields');
	add_action('edited_homeland_property_amenities', 'homeland_save_extra_category_fields');
	add_action('create_homeland_property_amenities', 'homeland_save_extra_category_fields');
	add_action('edited_homeland_portfolio_category', 'homeland_save_extra_category_fields');
	add_action('create_homeland_portfolio_category', 'homeland_save_extra_category_fields');


	/* Convert Hex to RGBA */

	if(!function_exists('homeland_hex2rgba')) :	
		function homeland_hex2rgba($homeland_color, $homeland_opacity = false) {
			$homeland_default = 'rgb(0,0,0)';
			if(empty($homeland_color))
				return $homeland_default; 
				if($homeland_color[0] == '#') : $homeland_color = substr( $homeland_color, 1 ); endif;

				if(strlen($homeland_color) == 6) :
				   $homeland_hex = array( $homeland_color[0] . $homeland_color[1], $homeland_color[2] . $homeland_color[3], $homeland_color[4] . $homeland_color[5] );
				elseif(strlen( $homeland_color ) == 3) :
				  $homeland_hex = array( $homeland_color[0] . $homeland_color[0], $homeland_color[1] . $homeland_color[1], $homeland_color[2] . $homeland_color[2] );
				else : return $homeland_default;
				endif;

				$homeland_rgb =  array_map('hexdec', $homeland_hex);

				if($homeland_opacity) :
					if(abs($homeland_opacity) > 1)
						$homeland_opacity = 1.0;
						$homeland_output = 'rgba('.implode(",",$homeland_rgb).','.$homeland_opacity.')';
				else :
					$homeland_output = 'rgb('.implode(",",$homeland_rgb).')';
				endif;

				return $homeland_output;
		}	
	endif;


	/* Custom Responsive Background */

	if(!function_exists('homeland_theme_custom_background')) :	
		function homeland_theme_custom_background() {
			$homeland_bg_type = esc_attr(get_option('homeland_bg_type'));
			$homeland_theme_layout = esc_attr(get_option('homeland_theme_layout'));
			$homeland_forum_bgimage = esc_attr(get_option('homeland_forum_bgimage'));
			$homeland_forum_single_bgimage = esc_attr(get_option('homeland_forum_single_bgimage'));
			$homeland_forum_single_topic_bgimage = esc_attr(get_option('homeland_forum_single_topic_bgimage'));
			$homeland_forum_topic_edit_bgimage = esc_attr(get_option('homeland_forum_topic_edit_bgimage'));
			$homeland_forum_search_bgimage = esc_attr(get_option('homeland_forum_search_bgimage'));
			$homeland_user_profile_bgimage = esc_attr(get_option('homeland_user_profile_bgimage'));

			if(function_exists('is_bbpress')) :
				if($homeland_bg_type == "Image" && ($homeland_theme_layout == "Boxed" || $homeland_theme_layout == "Boxed Left")) :
					if(bbp_is_single_forum()) :
						if(!empty($homeland_forum_single_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_forum_single_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					elseif(bbp_is_single_topic()) :
						if(!empty($homeland_forum_single_topic_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_forum_single_topic_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;	
					elseif(bbp_is_topic_edit()) :
						if(!empty($homeland_forum_topic_edit_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_forum_topic_edit_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					elseif(bbp_is_search()) :
						if(!empty($homeland_forum_search_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_forum_search_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					elseif(bbp_is_single_user()) :
						if(!empty($homeland_user_profile_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_user_profile_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					elseif(bbp_is_forum_archive() || is_bbpress()) :
						if(!empty($homeland_forum_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_forum_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					else : homeland_bg_conditions();
					endif;
				endif;
			else : homeland_bg_conditions();
			endif;
		}	
	endif;
	add_action('wp_footer', 'homeland_theme_custom_background');

	if(!function_exists('homeland_bg_conditions')) :	
		function homeland_bg_conditions() {
			global $post;
			$homeland_bg_type = esc_attr( get_option('homeland_bg_type') );
			$homeland_theme_layout = esc_attr( get_option('homeland_theme_layout') );
			$homeland_archive_bgimage = esc_attr( get_option('homeland_archive_bgimage') );
			$homeland_search_bgimage = esc_attr( get_option('homeland_search_bgimage') );
			$homeland_notfound_bgimage = esc_attr( get_option('homeland_notfound_bgimage') );
			$homeland_taxonomy_bgimage = esc_attr( get_option('homeland_taxonomy_bgimage') );
			$homeland_agent_bgimage = esc_attr( get_option('homeland_agent_bgimage') );
			$homeland_attachment_bgimage = esc_attr( get_option('homeland_attachment_bgimage') );
			$homeland_bgimage = esc_attr( get_post_meta(@$post->ID, "homeland_bgimage", true) );

			if($homeland_bg_type == "Image" && ($homeland_theme_layout == "Boxed" || $homeland_theme_layout == "Boxed Left")) :
				// Archive 
				if(is_archive()) :
					if(is_author()) :
						if(!empty($homeland_agent_bgimage)) : ?>
							<script type="text/javascript">
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_agent_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					elseif(is_tax()) :
						if(!empty($homeland_taxonomy_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_taxonomy_bgimage ); ?>"); 
								}); 
							</script><?php					
						else : homeland_default_img_bg(); endif;
					else :
						if(!empty($homeland_archive_bgimage)) : ?>
							<script type="text/javascript"> 
								jQuery(window).load(function() { 
									jQuery.backstretch("<?php echo esc_url( $homeland_archive_bgimage ); ?>"); 
								}); 
							</script><?php	
						else : homeland_default_img_bg(); endif;
					endif;

				// Search
				elseif(is_search()) :
					if(!empty($homeland_search_bgimage)) : ?>
						<script type="text/javascript"> 
							jQuery(window).load(function() { 
								jQuery.backstretch("<?php echo esc_url( $homeland_search_bgimage ); ?>"); 
							}); 
						</script><?php					
					else : homeland_default_img_bg(); endif;

				// Attachment
				elseif(is_attachment()) :
					if(!empty($homeland_attachment_bgimage)) : ?>
						<script type="text/javascript"> 
							jQuery(window).load(function() { 
								jQuery.backstretch("<?php echo esc_url( $homeland_attachment_bgimage ); ?>"); 
							}); 
						</script><?php					
					else : homeland_default_img_bg(); endif;

				// 404 Page
				elseif(is_404()) :
					if(!empty($homeland_notfound_bgimage)) : ?>
						<script type="text/javascript"> 
							jQuery(window).load(function() { 
								jQuery.backstretch("<?php echo esc_url( $homeland_notfound_bgimage ); ?>"); 
							}); 
						</script><?php						
					else : homeland_default_img_bg(); endif;	

				// Coming Soon
				elseif(is_page_template('template-coming-soon.php')) :

				// Login Page
				elseif(is_page_template('template-login.php')) :

				// Page and Single Page
				elseif(is_page() || is_single()) :
					if(!empty($homeland_bgimage)) : ?>
						<script type="text/javascript">
							jQuery(window).load(function() { 
								jQuery.backstretch("<?php echo esc_url( $homeland_bgimage ); ?>"); 
							});
						</script><?php					
					else : homeland_default_img_bg(); endif;	

				// Homepage
				elseif(is_home()) : homeland_default_img_bg();
				else : homeland_default_img_bg();
				endif;
			endif;
		}
	endif;


	/* Background Default Image */

	if(!function_exists('homeland_default_img_bg')) :	
		function homeland_default_img_bg() {
			$homeland_default_bgimage = esc_attr(get_option('homeland_default_bgimage'));
			$homeland_empty_bg = "http://themecss.com/wp/Homeland/wp-content/uploads/2013/12/View-over-the-lake_www.LuxuryWallpapers.net_.jpg";
			if(!empty($homeland_default_bgimage)) : ?>
				<script type="text/javascript"> 
					jQuery(window).load(function() { 
						jQuery.backstretch("<?php echo esc_url( $homeland_default_bgimage ); ?>"); 
					}); 
				</script><?php	
			else : ?>
				<script type="text/javascript"> 
					jQuery(window).load(function() { 
						jQuery.backstretch("<?php echo esc_url( $homeland_empty_bg ); ?>");  
					}); 
				</script><?php
			endif;
		}	
	endif;


	/* Custom Header Images */

	if(!function_exists('homeland_header_image')) :	
		function homeland_header_image() {
			global $post;

			$homeland_page_hd_image = esc_attr( get_post_meta( @$post->ID, 'homeland_hdimage', true ) );
			$homeland_page_hide_search = get_post_meta( @$post->ID, 'homeland_advance_search', true );
			$homeland_archive_hdimage = esc_attr( get_option('homeland_archive_hdimage') );
			$homeland_search_hdimage = esc_attr( get_option('homeland_search_hdimage') );
			$homeland_notfound_hdimage = esc_attr( get_option('homeland_notfound_hdimage') );
			$homeland_agent_hdimage = esc_attr( get_option('homeland_agent_hdimage') );
			$homeland_attachment_hdimage = esc_attr( get_option('homeland_attachment_hdimage') );
			$homeland_taxonomy_hdimage = esc_attr( get_option('homeland_taxonomy_hdimage') );
			$homeland_default_hdimage = esc_attr( get_option('homeland_default_hdimage') );
			$homeland_forum_hdimage = esc_attr( get_option('homeland_forum_hdimage') );
			$homeland_forum_single_hdimage = esc_attr( get_option('homeland_forum_single_hdimage') );
			$homeland_forum_single_topic_hdimage = esc_attr( get_option('homeland_forum_single_topic_hdimage') );
			$homeland_forum_topic_edit_hdimage = esc_attr( get_option('homeland_forum_topic_edit_hdimage') );
			$homeland_forum_search_hdimage = esc_attr( get_option('homeland_forum_search_hdimage') );
			$homeland_user_profile_hdimage = esc_attr( get_option('homeland_user_profile_hdimage') );
			$homeland_disable_advance_search = esc_attr( get_option('homeland_disable_advance_search') );
			$homeland_hide_ptitle_stitle = esc_attr( get_option('homeland_hide_ptitle_stitle') );
			$homeland_header_overlay = esc_attr( get_option('homeland_header_overlay') );

			// Agent
			if(!empty($homeland_agent_hdimage)) : $homeland_title_block_agent = "page-title-block-agent"; 
			else : $homeland_title_block_agent = "page-title-block-default"; endif;

			// Attachment
			if(!empty($homeland_attachment_hdimage)) : 
				$homeland_title_block_attachment = "page-title-block-attachment"; 
			else : 
				$homeland_title_block_attachment = "page-title-block-default"; 
			endif;

			// Taxonomy
			if(!empty($homeland_taxonomy_hdimage)) : $homeland_title_block_taxonomy = "page-title-block-taxonomy"; 
			else : $homeland_title_block_taxonomy = "page-title-block-default"; endif;

			// Forum
			if(!empty($homeland_forum_hdimage)) : $homeland_title_block_forum = "page-title-block-forum"; 
			else : $homeland_title_block_forum = "page-title-block-default"; endif;

			// Archive
			if(!empty($homeland_archive_hdimage)) : $homeland_title_block_archive = "page-title-block-archive"; 
			else : $homeland_title_block_archive = "page-title-block-default"; endif;

			// Search
			if(!empty($homeland_search_hdimage)) : $homeland_title_block_search =  "page-title-block-search"; 
			else : $homeland_title_block_search = "page-title-block-default"; endif;

			// 404
			if(!empty($homeland_notfound_hdimage)) : $homeland_title_block_notfound = "page-title-block-error"; 
			else : $homeland_title_block_notfound = "page-title-block-default"; endif;

			// Title
			if(!empty($homeland_page_hd_image)) : $homeland_title_block = "page-title-block"; 
			else : $homeland_title_block = "page-title-block-default"; endif;

			// Forum Single
			if(!empty($homeland_forum_single_hdimage)) : $homeland_title_block_forum_single =  "page-title-block-forum-single"; 
			else : $homeland_title_block_forum_single = "page-title-block-default"; endif;

			// Forum Single Topic
			if(!empty($homeland_forum_single_topic_hdimage)) : $homeland_title_block_forum_single_topic = "page-title-block-topic-single"; 
			else : $homeland_title_block_forum_single_topic = "page-title-block-default"; endif;

			// Forum Topic Edit
			if(!empty($homeland_forum_topic_edit_hdimage)) : $homeland_title_block_forum_topic_edit = "page-title-block-topic-edit"; 
			else : $homeland_title_block_forum_topic_edit = "page-title-block-default"; endif;

			// Forum Search
			if(!empty($homeland_forum_search_hdimage)) : $homeland_title_block_forum_search = "page-title-block-forum-search"; 
			else : $homeland_title_block_forum_search = "page-title-block-default"; endif;

			// Forum Single User
			if(!empty($homeland_user_profile_hdimage)) : $homeland_title_block_forum_single_user = "page-title-block-user-profile"; 
			else : $homeland_title_block_forum_single_user = "page-title-block-default"; endif;
			
			if(is_page_template('template-homepage.php') || is_page_template('template-homepage2.php') || is_page_template('template-homepage3.php') || is_page_template('template-homepage4.php') || is_page_template('template-homepage-video.php') || is_page_template('template-homepage-revslider.php') || is_page_template('template-homepage-gmap.php') || is_page_template('template-homepage-gmap-large.php') || is_page_template('template-page-builder.php')) :  
			else :
				if(is_archive()) :
					if(is_author()) : 
						echo "<section class='" . esc_attr( $homeland_title_block_agent ) . " header-bg'>";
						if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
					elseif(is_tax()) : 
						echo "<section class='" . esc_attr( $homeland_title_block_taxonomy ) . " header-bg'>";
						if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
					elseif(function_exists('is_bbpress')) :
						if( bbp_is_forum_archive() ) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						else : 
							echo "<section class='" . esc_attr( $homeland_title_block_archive ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						endif;
					else : 
						echo "<section class='" . esc_attr( $homeland_title_block_archive ) . " header-bg'>";
						if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif; 
					endif;
				elseif(is_search()) : 
					echo "<section class='" . esc_attr( $homeland_title_block_search ) . " header-bg'>";
					if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
				elseif(is_attachment()) : 
					echo "<section class='" . esc_attr( $homeland_title_block_attachment ) . " header-bg'>";
					if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
				elseif(is_404()) : 
					echo "<section class='" . esc_attr( $homeland_title_block_notfound ) . " header-bg'>";
					if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
				elseif(is_page_template( 'template-contact.php' )) : 
					echo "<section class='" . esc_attr( $homeland_title_block ) . " header-bg'>";
					if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
				else : 
					if(function_exists('is_bbpress')) :
						if(bbp_is_single_forum()) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum_single ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						elseif(bbp_is_single_topic()) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum_single_topic ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						elseif(bbp_is_topic_edit()) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum_topic_edit ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						elseif(bbp_is_search()) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum_search ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						elseif(bbp_is_single_user()) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum_single_user ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						elseif( is_bbpress() ) : 
							echo "<section class='" . esc_attr( $homeland_title_block_forum ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
						else : 
							echo "<section class='" . esc_attr( $homeland_title_block ) . " header-bg'>";
							if(!empty($homeland_header_overlay)) : 
								echo "<div class='overlay'>&nbsp;</div>"; 
							endif;
						endif;
					else : 
						echo "<section class='" . esc_attr( $homeland_title_block ) . " header-bg'>";
						if(!empty($homeland_header_overlay)) : echo "<div class='overlay'>&nbsp;</div>"; endif;
					endif;
				endif; ?>
				<div class="inside">
					<?php if(empty($homeland_hide_ptitle_stitle)) : homeland_get_page_title(); endif; ?>
				</div></section><?php 
			endif; 
		}
	endif;


	/* Google Analytics Code */

	if(!function_exists('homeland_google_analytics')) :	
		function homeland_google_analytics() {
			$homeland_ga_code = get_option('homeland_ga_code');

			if(!empty($homeland_ga_code)) : 
				?><script type="text/javascript"><?php echo stripslashes( $homeland_ga_code ); ?></script><?php
			endif;
		}
	endif;
	add_action('wp_footer', 'homeland_google_analytics', 100);


	/* Property Filters */

	if(!function_exists('homeland_property_listings')) :
		function homeland_property_listings($homeland_property_list_args) {
			$homeland_filter_default = esc_attr( get_option('homeland_filter_default') );	

	   	if(isset($_GET['filter-order'])) :
				if($_GET['filter-order'] == "ASC") : $homeland_property_list_args['order'] = 'ASC';
				else : $homeland_property_list_args['order'] = 'DESC';
			  endif;
			endif;

			if(isset($_GET['filter-sort'])) :
				if($homeland_filter_default == "Name") :
					if($_GET['filter-sort'] == "homeland_price") :
						$homeland_property_list_args['meta_key'] = 'homeland_price';
						$homeland_property_list_args['orderby'] = 'meta_value_num';
					elseif($_GET['filter-sort'] == "date") :
						$homeland_property_list_args['orderby'] = 'date';
					elseif($_GET['filter-sort'] == "rand") :
						$homeland_property_list_args['orderby'] = 'rand';
					else :
						$homeland_property_list_args['orderby'] = 'title';
					endif;
				elseif($homeland_filter_default == "Price") :
					if($_GET['filter-sort'] == "date") :
					  $homeland_property_list_args['orderby'] = 'date';
					elseif($_GET['filter-sort'] == "title") :
					  $homeland_property_list_args['orderby'] = 'title';
					elseif($_GET['filter-sort'] == "rand") :
					  $homeland_property_list_args['orderby'] = 'rand';
					else :
						$homeland_property_list_args['meta_key'] = 'homeland_price';
					  $homeland_property_list_args['orderby'] = 'meta_value_num';
					endif;
				elseif($homeland_filter_default == "Random") :
					if($_GET['filter-sort'] == "date") :
					  $homeland_property_list_args['orderby'] = 'date';
					elseif($_GET['filter-sort'] == "title") :
					  $homeland_property_list_args['orderby'] = 'title';
					elseif($_GET['filter-sort'] == "homeland_price") :
						$homeland_property_list_args['meta_key'] = 'homeland_price';
					  $homeland_property_list_args['orderby'] = 'meta_value_num';
					else :
						$homeland_property_list_args['orderby'] = 'rand';
					endif;
				else :
					if($_GET['filter-sort'] == "homeland_price") :
					  $homeland_property_list_args['meta_key'] = 'homeland_price';
					  $homeland_property_list_args['orderby'] = 'meta_value_num';
					elseif($_GET['filter-sort'] == "title") :
					  $homeland_property_list_args['orderby'] = 'title';
					elseif($_GET['filter-sort'] == "rand") :
					  $homeland_property_list_args['orderby'] = 'rand';
					else :
						$homeland_property_list_args['orderby'] = 'date';
					endif;
				endif;
			endif;

			return $homeland_property_list_args;
	   }
	endif;
  add_filter('homeland_properties_parameters', 'homeland_property_listings');


  /* Add Lightbox for gallery shortcode and image post */

	if(!function_exists('homeland_add_rel_attribute')) :
	  function homeland_add_rel_attribute($homeland_link) {
			global $post;
			return str_replace('<a href', '<a class="large-image-popup" href', $homeland_link);
		}
	endif;
	add_filter('wp_get_attachment_link', 'homeland_add_rel_attribute');    

	if(!function_exists('homeland_lightbox_rel')) :
		function homeland_lightbox_rel($homeland_content) {
			global $post;
			$homeland_pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
			$homeland_replace = '<a$1href=$2$3.$4$5 class="large-image-popup" title="'.$post->post_title.'"$6>';
			$homeland_content = preg_replace($homeland_pattern, $homeland_replace, $homeland_content);
			return $homeland_content;
		}
	endif;
	add_filter('the_content', 'homeland_lightbox_rel');


	/* Change Label of Authors to Agent */

	if(!function_exists('homeland_metabox_agent')) :
		function homeland_metabox_agent() {
			remove_meta_box('authordiv', 'homeland_properties', 'normal');
			add_meta_box('homeland_authordiv', esc_html__('Agent', 'homeland'), 'post_author_meta_box', 'homeland_properties', 'normal', 'core');
		}
	endif;
	add_action('admin_menu',  'homeland_metabox_agent');


	/* Custom Avatar */

	if(!function_exists('homeland_custom_avatar')) :
		function homeland_custom_avatar($user) { 
			?>
				<h3><?php esc_html_e('Custom Avatar', 'homeland'); ?></h3> 
				<table class="form-table">
					<tr>
						<th>
							<label for="homeland_custom_avatar"><?php esc_html_e('Avatar', 'homeland'); ?></label>
						</th>
						<td>
							<input type="text" name="homeland_custom_avatar" id="homeland_custom_avatar" value="<?php echo esc_attr( get_the_author_meta( 'homeland_custom_avatar', $user->ID ) ); ?>" class="regular-text" /><input id="upload_image_button_avatar" type="button" value="<?php esc_html_e( 'Upload', 'homeland' ); ?>" class="button-secondary" /><br />
							<span class="description">
								<?php esc_html_e('This will override your default Gravatar or show up if you dont have a Gravatar', 'homeland'); ?><br /><strong><?php esc_html_e('Image should be 240x240 pixels', 'homeland'); ?>.</strong>
							</span>
						</td>
					</tr>
				</table>
			<?php 
		}
	endif;
	add_action('show_user_profile', 'homeland_custom_avatar');
	add_action('edit_user_profile', 'homeland_custom_avatar');

	if(!function_exists('homeland_save_custom_avatar')) :
		function homeland_save_custom_avatar($user_id) {
			if(!current_user_can('edit_user', $user_id)) { return false; }
			update_user_meta($user_id, 'homeland_custom_avatar', $_POST['homeland_custom_avatar']);
		}
	endif;
	add_action('personal_options_update', 'homeland_save_custom_avatar');
	add_action('edit_user_profile_update', 'homeland_save_custom_avatar');


	/* Search cpt admin for properties */

	global $homeland_postmeta_alias, $homeland_is_specials_search;
	$homeland_cpt_name = 'homeland_properties';
	$homeland_postmeta_alias = 'homeland_pm';
	$homeland_is_specials_search = is_admin() && $pagenow=='edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type']==$homeland_cpt_name && isset( $_GET['s'] );

	if($homeland_is_specials_search) :
		add_filter('posts_join', 'homeland_description_search_join');
		add_filter('posts_where', 'homeland_description_search_where');
		add_filter('posts_groupby', 'homeland_search_dupe_fix');
	endif;

	if(!function_exists('homeland_description_search_join')) :
		function homeland_description_search_join ($homeland_join){
	  	global $homeland_pagenow, $wpdb, $homeland_postmeta_alias, $homeland_is_specials_search;

	  	if($homeland_is_specials_search)  
	    	$homeland_join .='LEFT JOIN '.$wpdb->postmeta. ' as ' . $homeland_postmeta_alias . ' ON '. $wpdb->posts . '.ID = ' . $homeland_postmeta_alias . '.post_id ';
	  	return $homeland_join;
		}
	endif;

	if(!function_exists('homeland_description_search_where')) :
		function homeland_description_search_where($homeland_where){
			global $homeland_pagenow, $wpdb, $homeland_postmeta_alias, $homeland_is_specials_search;

			if($homeland_is_specials_search)
			 	$homeland_where = preg_replace("/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/", "(".$wpdb->posts.".post_title LIKE $1) OR (".$homeland_postmeta_alias.".meta_value LIKE $1)", $homeland_where);
			return $homeland_where;
		} 
	endif;

	if(!function_exists('homeland_search_dupe_fix')) :
		function homeland_search_dupe_fix($homeland_groupby) {
			global $homeland_pagenow, $wpdb, $homeland_is_specials_search;

			if($homeland_is_specials_search) $homeland_groupby = "$wpdb->posts.ID";
			return $homeland_groupby;
		} 
	endif;


	/* Sticky Header jQuery */

	if(!function_exists('homeland_header_sticky_js')) :
		function homeland_header_sticky_js() {
			$homeland_sticky_header = esc_attr( get_option('homeland_sticky_header') );
			$homeland_theme_header = esc_attr( get_option('homeland_theme_header') );

			if(!empty($homeland_sticky_header) || $homeland_theme_header == "Header 4") : ?>
				<script type="text/javascript">
					(function($) {
						"use strict";
						$(window).scroll(function() {
				      if ($(this).scrollTop() > 160){  
				        $('header').addClass("sticky-header-animate");
				      }else{
				        $('header').removeClass("sticky-header-animate");
				      }
					   });
				   })(jQuery);
				</script><?php
			endif;
		}
	endif;
	add_action('wp_footer', 'homeland_header_sticky_js');


	/* Remove Revolution Slider Meta Boxes */

	if(!function_exists('homeland_remove_revolution_slider_meta_boxes')) :
		function homeland_remove_revolution_slider_meta_boxes() {
			if(is_admin()) :
				remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'homeland_properties', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'homeland_services', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'homeland_testimonial', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'homeland_partners', 'normal' );
				remove_meta_box( 'mymetabox_revslider_0', 'homeland_portfolio', 'normal' );
			endif;
		}
	endif;
	add_action('do_meta_boxes', 'homeland_remove_revolution_slider_meta_boxes');


	/* Add odd/even post class */

	if ( ! function_exists( 'homeland_oddeven_post_class' ) ) :
		function homeland_oddeven_post_class ( $homeland_classes ) {
			global $homeland_current_class;
			$homeland_classes[] = $homeland_current_class;
			$homeland_current_class = ($homeland_current_class == 'odd') ? 'even' : 'odd';
			return $homeland_classes;
		}
	endif;
	add_filter ( 'post_class' , 'homeland_oddeven_post_class' );
	global $homeland_current_class;
	$homeland_current_class = 'odd';


	/* Get Portfolio Categories */

	if ( ! function_exists( 'homeland_get_portfolio_category' ) ) :
		function homeland_get_portfolio_category() {
			global $homeland_portfolio_page_url; 

			if(is_page_template('template-portfolio.php') || is_page_template('template-portfolio-right-sidebar.php') || is_page_template('template-portfolio-left-sidebar.php')) : $homeland_portfolio_current_class = "current-cat";
			endif; ?>
			<div class="cat-toogles">
				<ul class="cat-list clear">
					<li class="<?php echo esc_attr( $homeland_portfolio_current_class ); ?>">
						<a href="<?php echo esc_url( $homeland_portfolio_page_url ); ?>"><?php esc_html_e('All', 'homeland'); ?></a>
					</li>
					<?php
						$args = array( 
							'taxonomy' => 'homeland_portfolio_category', 
							'style' => 'list', 
							'title_li' => '', 
							'hierarchical' => false, 
							'order' => 'ASC', 
							'orderby' => 'title' 
						);
						wp_list_categories ( $args );
					?>	
				</ul>
			</div><?php
		}
	endif;


	/* Ability of Contributor to edit post */

	$obj_existing_role = get_role( 'contributor' );
	$obj_existing_role->add_cap( 'edit_published_posts' );


	/* Property Price Format */

	if ( ! function_exists( 'homeland_property_price_format' ) ) :
		function homeland_property_price_format() {
			global $post;

			$homeland_price_per = esc_attr( get_post_meta( $post->ID, 'homeland_price_per', true ) );
			$homeland_property_currency = get_post_meta($post->ID, 'homeland_property_currency', true);
			$homeland_price = get_post_meta($post->ID, 'homeland_price', true);
			$homeland_contact_agent = get_post_meta($post->ID, 'homeland_contact_agent', true);
			$homeland_property_currency_sign = esc_attr( get_option('homeland_property_currency_sign') ); 
			$homeland_currency = esc_attr( get_option('homeland_property_currency') ); 
			$homeland_price_format = esc_attr( get_option('homeland_price_format') );
			$homeland_property_decimal = esc_attr( get_option('homeland_property_decimal') );
			$homeland_property_decimal = !empty($homeland_property_decimal) ? $homeland_property_decimal : 0;

			$homeland_property_currency_before = "";
			$homeland_property_currency_after = "";
			$homeland_price_per_result = "";

			// Currency Position
			if( $homeland_property_currency_sign == "After" ) : 
				$homeland_property_currency_after = !empty($homeland_property_currency) ? $homeland_property_currency : $homeland_currency;
			else :
				$homeland_property_currency_before = !empty($homeland_property_currency) ? $homeland_property_currency : $homeland_currency;
			endif;

			// Price Format
			if($homeland_price_format == "Dot") :
				$homeland_price_format_result = number_format ( $homeland_price, $homeland_property_decimal, ".", "." );
			elseif($homeland_price_format == "Comma") : 
				$homeland_price_format_result = number_format ( $homeland_price, $homeland_property_decimal );
			elseif($homeland_price_format == "Brazil" || $homeland_price_format == "Europe") :
				$homeland_price_format_result = number_format( $homeland_price, $homeland_property_decimal, ",", "." );
			else : 
				$homeland_price_format_result = $homeland_price;
			endif;
			
			// Price Per
			if($homeland_contact_agent == "on") {
			echo esc_html("Contact Agent");
			} else {
			$homeland_price_per_result = !empty($homeland_price_per) ? "/" . $homeland_price_per : '';

			// Price Results
			echo esc_html( $homeland_property_currency_before ) . esc_html( $homeland_price_format_result ) . esc_html( $homeland_property_currency_after ) . esc_html( $homeland_price_per_result );
			}
		}
	endif;
?>