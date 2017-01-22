<?php 
	get_header();

	global $homeland_print_page_url;

	$homeland_advance_search = get_post_meta( $post->ID, 'homeland_advance_search', true );
	$homeland_single_property_layout = esc_attr( get_option('homeland_single_property_layout') );
	$homeland_attachment_order = esc_attr( get_option('homeland_attachment_order') );
	$homeland_attachment_orderby = esc_attr( get_option('homeland_attachment_orderby') );
	$homeland_agent_info = esc_attr( get_option('homeland_agent_info') );
	$homeland_other_properties = esc_attr( get_option('homeland_other_properties') );
	$homeland_property_map_header = esc_attr( get_option('homeland_property_map_header') ); 
	$homeland_properties_thumb_slider = esc_attr( get_option('homeland_properties_thumb_slider') );
	$homeland_currency = esc_attr( get_option('homeland_property_currency') ); 
	$homeland_property_currency_sign = esc_attr( get_option('homeland_property_currency_sign') ); 
	$homeland_agent_button = esc_attr( get_option('homeland_agent_button') ); 
	$homeland_agent_form = esc_attr( get_option('homeland_agent_form') ); 
	$homeland_other_properties_header = esc_attr( get_option('homeland_other_properties_header') );
	$homeland_price_format = esc_attr( get_option('homeland_price_format') );
	$homeland_hide_map = esc_attr( get_option('homeland_hide_map') );
	$homeland_show_street_view = esc_attr( get_option('homeland_show_street_view') );
	$homeland_other_property_limit = esc_attr( get_option('homeland_other_property_limit') );
	$homeland_hide_property_comments = esc_attr( get_option('homeland_hide_property_comments') );
	$homeland_all_agents = esc_attr( get_option('homeland_all_agents') );
	$homeland_property_amenities_header = esc_attr( get_option('homeland_property_amenities_header') );
	$homeland_clickable_amenities = esc_attr( get_option('homeland_clickable_amenities') );
	$homeland_hide_property_prevnext = esc_attr( get_option('homeland_hide_property_prevnext') );
	$homeland_property_static_image = esc_attr( get_option('homeland_property_static_image') );

	$homeland_property_amenities_header_label = !empty($homeland_property_amenities_header) ? $homeland_property_amenities_header : esc_html__('Amenities', 'homeland');
	$homeland_property_map_header_label = !empty($homeland_property_map_header) ? $homeland_property_map_header : esc_html__('Property Map', 'homeland');
	$homeland_agent_form_label = !empty($homeland_agent_form) ? $homeland_agent_form : esc_html__('Contact Agent', 'homeland');
	$homeland_other_properties_header_label = !empty($homeland_other_properties_header) ? $homeland_other_properties_header : esc_html__('Other Properties', 'homeland');
	$homeland_agent_button_label = !empty($homeland_agent_button) ? $homeland_agent_button : esc_html__('View Profile', 'homeland');

	if($homeland_single_property_layout =="Fullwidth") :
		$homeland_single_layout_class = "theme-fullwidth";
		$homeland_property_slide_image_size = "homeland_portfolio_large";
	elseif($homeland_single_property_layout =="Left Sidebar") :
		$homeland_single_layout_class = "left-container right";
		$homeland_property_class_sidebar = "sidebar left";
		$homeland_property_slide_image_size = "homeland_theme_large";
	else :
		$homeland_single_layout_class = "left-container";
		$homeland_property_class_sidebar = "sidebar";
		$homeland_property_slide_image_size = "homeland_theme_large";
	endif;

	if(!empty($homeland_property_static_image)) : $homeland_property_static_class = "property-static-images";
	else : $homeland_property_static_class = "properties-flexslider flex-loading";
	endif;

	if(empty($homeland_advance_search)) : homeland_advance_search(); endif;
?>

	<!-- Property Detailed Page -->
	<section class="theme-pages">
		<div class="inside clear">
			<div class="<?php echo esc_attr( $homeland_single_layout_class ); ?>">				
				<div class="property-list-page single-property clear">
					<?php
						if (have_posts()) : 
							if ( post_password_required() ) :
								?><div class="password-protect-content"><?php the_content(); ?></div><?php
							else :
								while (have_posts()) : the_post(); 
									$homeland_price_per = esc_attr(get_post_meta($post->ID,'homeland_price_per', true));
									$homeland_price = esc_attr(get_post_meta($post->ID, 'homeland_price', true));
									$homeland_thumbnails = esc_attr(get_post_meta( $post->ID, 'homeland_thumbnails', true));
									$homeland_area = esc_attr(get_post_meta($post->ID, 'homeland_area', true));
									$homeland_area_unit = esc_attr(get_post_meta($post->ID, 'homeland_area_unit', true));
									$homeland_floor_area = esc_attr(get_post_meta($post->ID, 'homeland_floor_area', true));
									$homeland_floor_area_unit = esc_attr( get_post_meta( $post->ID, 'homeland_floor_area_unit', true ) );
									$homeland_room = esc_attr(get_post_meta($post->ID, 'homeland_room', true));
									$homeland_bedroom = esc_attr(get_post_meta($post->ID, 'homeland_bedroom', true));
									$homeland_bathroom = esc_attr(get_post_meta($post->ID, 'homeland_bathroom', true));
									$homeland_garage = esc_attr(get_post_meta($post->ID,'homeland_garage', true));
									$homeland_year_built = esc_attr(get_post_meta($post->ID,'homeland_year_built', true));
									$homeland_stories = esc_attr(get_post_meta($post->ID,'homeland_stories', true) );
									$homeland_basement = esc_attr( get_post_meta($post->ID, 'homeland_basement', true) );
									$homeland_structure_type = esc_attr( get_post_meta($post->ID, 'homeland_structure_type', true) );
									$homeland_roofing = esc_attr( get_post_meta($post->ID, 'homeland_roofing', true) );
									$homeland_address = esc_attr( get_post_meta($post->ID, 'homeland_address', true) );
									$homeland_inspection = esc_attr( get_post_meta($post->ID, 'homeland_inspection', true) );
									$homeland_property_id = esc_attr( get_post_meta($post->ID, 'homeland_property_id', true) );
									$homeland_zip = esc_attr( get_post_meta($post->ID, 'homeland_zip', true) );
									$homeland_property_hide_map = esc_attr( get_post_meta($post->ID, 'homeland_property_hide_map', true) );
									$homeland_featured = esc_attr(get_post_meta($post->ID, 'homeland_featured', true));
									$homeland_property_sold = esc_attr(get_post_meta($post->ID, 'homeland_property_sold', true));
									$homeland_lat = esc_attr(get_post_meta($post->ID, 'homeland_property_lat', true));
									$homeland_lng = esc_attr(get_post_meta($post->ID, 'homeland_property_lng', true));
									$homeland_rev_slider = esc_attr(get_post_meta($post->ID, 'homeland_rev_slider', true));
									$homeland_property_type = get_the_term_list($post->ID, 'homeland_property_type', ' ', ', ', ''); 
									$homeland_property_status = get_the_term_list($post->ID, 'homeland_property_status', ' ', ', ', '');
									$homeland_property_amenities = get_the_term_list($post->ID, 'homeland_property_amenities', ' ', ' ', '');
									$homeland_agent_mobile = get_the_author_meta( 'homeland_mobile' );
									$homeland_agent_telno = get_the_author_meta( 'homeland_telno' );
									$homeland_agent_fax = get_the_author_meta( 'homeland_fax' );
									$homeland_agent_id = get_the_author_meta( 'ID' );
									$homeland_agent_desc = get_the_author_meta( 'description' );
									$homeland_agent_fname = get_the_author_meta( 'user_firstname' );
									$homeland_agent_lname = get_the_author_meta( 'user_lastname' ); 
									$homeland_agent_facebook = get_the_author_meta( 'homeland_facebook' );
									$homeland_agent_gplus = get_the_author_meta( 'homeland_gplus' );
									$homeland_agent_linkedin= get_the_author_meta( 'homeland_linkedin' );
									$homeland_agent_twitter = get_the_author_meta( 'homeland_twitter' );
									$homeland_agent_email = get_the_author_meta( 'user_email' );
									$homeland_agent_desc_trim = wp_trim_words( $homeland_agent_desc, $homeland_num_words = 60, $homeland_more = null );
									$homeland_custom_avatar = get_the_author_meta( 'homeland_custom_avatar', $wp_query->ID );
									$homeland_thumb_id = get_post_thumbnail_id( get_the_ID() );
									$homeland_large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
									$homeland_feature_image_caption = get_post( get_post_thumbnail_id())->post_excerpt;
									$homeland_featured_img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
									
									if( !empty($homeland_properties_thumb_slider) ) :
										$args = array( 
											'post_type' => 'attachment', 
											'numberposts' => -1, 
											'order' => $homeland_attachment_order, 
											'orderby' => $homeland_attachment_orderby, 
											'post_status' => null, 
											'post_parent' => $post->ID, 
											'exclude' => $homeland_thumb_id
										);
									else :
										$args = array( 
											'post_type' => 'attachment', 
											'numberposts' => -1, 
											'order' => $homeland_attachment_order, 
											'orderby' => $homeland_attachment_orderby, 
											'post_status' => null, 
											'post_parent' => $post->ID
										);
									endif;
									$homeland_attachments = get_posts( $args );
								?>
									<article id="post-<?php the_ID(); ?>" class="plist">
										<div class="property-page-info clear">
											<?php
												if(!empty($homeland_property_id)) : ?>
													<div class="property-page-id">
														<?php esc_html_e( 'Property ID : ', 'homeland' ); ?>
														<span><?php echo esc_html( $homeland_property_id ); ?></span>
													</div><?php
												endif;
												if(!empty( $homeland_property_type )) : ?>
													<div class="property-page-type"><?php echo $homeland_property_type; ?></div><?php
												endif;		

												if(!empty($homeland_property_sold)) : ?>
													<div class="property-page-status property-sold">
														<span><?php esc_html_e('Sold', 'homeland'); ?></span>
													</div><?php
												else :
													if(!empty( $homeland_property_status )) : ?>
														<div class="property-page-status">
															<span><?php echo $homeland_property_status; ?></span>
														</div><?php
													endif; 
												endif;
											?>	
											<div class="print-property">
												<a href="<?php echo esc_url( $homeland_print_page_url ); ?>?printid=<?php echo $post->ID; ?>" class="property-print" title="<?php esc_html_e('Print', 'homeland'); ?>" target="_blank"><i class="fa fa-print"></i></a>
											</div>
										</div>

										<!-- Calling revolution slider or flexslider -->
										<?php
											if(shortcode_exists("rev_slider") && !empty($homeland_rev_slider)) : 
												echo(do_shortcode('[rev_slider '.$homeland_rev_slider.']'));
											else : ?>
												<div class="<?php echo esc_attr( $homeland_property_static_class ); ?>">
													<?php if(!empty($homeland_featured)) : ?>
														<div class="featured-ribbon">
															<i class="fa fa-star" title="<?php esc_html_e('Featured', 'homeland'); ?>"></i>
														</div>
													<?php endif; ?>
													<ul class="slides">
														<?php
															if ( $homeland_attachments ) :						
																foreach ( $homeland_attachments as $homeland_attachment ) :
																	$homeland_attachment_id = $homeland_attachment->ID;
																	$homeland_attachment_caption = $homeland_attachment->post_excerpt;
																	$homeland_large_image_url = wp_get_attachment_image_src( $homeland_attachment_id, 'full' ); ?>
																	<li>
																		<a href="<?php echo esc_url( $homeland_large_image_url[0] ); ?>" title="<?php echo esc_html( $homeland_attachment_caption ); ?>" class="large-image-popup">
																			<?php 
																				echo wp_get_attachment_image( $homeland_attachment->ID, $homeland_property_slide_image_size ); 
																			?>
																		</a>
																		<?php if(!empty($homeland_attachment_caption)) : ?>
																			<span class="flex-caption"><?php echo esc_html( $homeland_attachment_caption ); ?></span>
																		<?php endif; ?>
																	</li><?php	
																endforeach;
															else :
																if ( has_post_thumbnail() ) : ?>
																	<li>
																		<a href="<?php echo esc_url( $homeland_featured_img_url[0]); ?>" title="<?php echo esc_html( $homeland_feature_image_caption ); ?>" class="large-image-popup"><?php the_post_thumbnail($homeland_property_slide_image_size); ?></a>
																	</li><?php
																endif;
															endif; 
														?>
													</ul>	
												</div>

												<?php if(empty($homeland_thumbnails) && empty($homeland_property_static_image)) : ?>
													<div id="carousel-flex" class="properties-flexslider">
														<ul class="slides">
															<?php
																if ( $homeland_attachments ) :						
																	foreach ($homeland_attachments as $homeland_attachment): ?>
																		<li>
																			<?php 
																				echo wp_get_attachment_image( $homeland_attachment->ID, 'homeland_property_thumb' ); 
																			?>
																		</li><?php
																	endforeach;
																else :
																	if ( has_post_thumbnail() ) : ?>
																		<li><?php the_post_thumbnail('homeland_property_thumb' ); ?></li><?php
																	endif;
																endif;
															?>		
														</ul>
													</div><?php
												endif;
											endif;

											if(!empty($homeland_price)) : ?>
												<span class="property-page-price">
													<?php homeland_property_price_format(); ?>
												</span><?php
											endif;	
										?>

										<!-- Property More Informations -->
										<div class="property-info-agent clear">
											<?php
												if(!empty($homeland_area)) : ?>
													<span><i class="fa fa-expand"></i><strong><?php esc_html_e( 'Lot Area', 'homeland' ); echo ":"; ?></strong>
														<?php 
															echo esc_html( $homeland_area ) . "&nbsp;" . esc_html( $homeland_area_unit ); 
														?>
													</span><?php
												endif;
												if(!empty($homeland_floor_area)) : ?>
													<span><i class="fa fa-arrows-alt"></i><strong><?php esc_html_e( 'Floor Area', 'homeland' ); echo ":"; ?></strong>
														<?php 
															echo esc_html( $homeland_floor_area ) . "&nbsp;" . esc_html( $homeland_floor_area_unit ); 
														?>
													</span><?php
												endif;
												if(!empty($homeland_room)) : ?>
													<span><i class="fa fa-home"></i><strong><?php esc_html_e( 'Rooms', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_room ); ?></span><?php
												endif;
												if(!empty($homeland_bedroom)) : ?>
													<span><i class="fa fa-bed"></i><strong><?php esc_html_e( 'Bedrooms', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_bedroom ); ?></span><?php
												endif;
												if(!empty($homeland_bathroom)) : ?>
													<span><i class="fa fa-male"></i><strong><?php esc_html_e( 'Bathrooms', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_bathroom ); ?></span><?php
												endif;
												if(!empty($homeland_garage)) : ?>
													<span><i class="fa fa-car"></i><strong><?php esc_html_e( 'Garage', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_garage ); ?></span><?php
												endif;
												if(!empty($homeland_year_built)) : ?>
													<span><i class="fa fa-calendar"></i><strong><?php esc_html_e( 'Year Built', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_year_built ); ?></span><?php
												endif;
												if(!empty($homeland_stories)) : ?>
													<span><i class="fa fa-building"></i><strong><?php esc_html_e( 'Stories', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_stories ); ?></span><?php
												endif;
												if(!empty($homeland_basement)) : ?>
													<span><i class="fa fa-cubes"></i><strong><?php esc_html_e( 'Basement', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_basement ); ?></span><?php
												endif;
												if(!empty($homeland_structure_type)) : ?>
													<span><i class="fa fa-sitemap"></i><strong><?php esc_html_e( 'Structure Type', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_structure_type ); ?></span><?php
												endif;
												if(!empty($homeland_roofing)) : ?>
													<span><i class="fa fa-sort-asc"></i><strong><?php esc_html_e( 'Roofing', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_roofing ); ?></span><?php
												endif;
												if(!empty($homeland_zip)) : ?>
													<span><i class="fa fa-map-marker"></i><strong><?php esc_html_e( 'Zip Code', 'homeland' ); echo ":"; ?></strong>
														<?php echo esc_html( $homeland_zip ); ?></span><?php
												endif;
											?>
										</div>
										<?php if(!empty($homeland_inspection)) { ?>
										<div class="property-amenities">
										<h4><?php echo esc_html( "Inspection Date & Time" ); ?></h4>
													<span class="map-address"><?php echo esc_html( $homeland_inspection ); ?></span>
										</div>			
										
										<?php
										} 
											the_content(); 
											
											// Amenities
											if(!empty($homeland_property_amenities)) : ?>
												<div class="property-amenities">
													<h4><?php echo esc_html( $homeland_property_amenities_header_label ); ?></h4>
													<?php 
														if(empty($homeland_clickable_amenities)) :
															$homeland_terms = get_the_terms($post->ID, 'homeland_property_amenities');
															$homeland_count = count($homeland_terms); ?>
															<div class="property-amenities">
																<?php
																	if ( $homeland_count > 0 ) :
																		foreach ( $homeland_terms as $homeland_term ) : ?>
																    	<span class="amenities-list">
																    		<?php echo $homeland_term->name; ?>
																    	</span><?php
																	  endforeach;
																	endif; 
																?>
															</div><?php
														else :
															echo $homeland_property_amenities; 
														endif;
													?>
												</div><?php
											endif;

											// Google Map
											if(empty($homeland_property_hide_map)) :
												if(empty($homeland_hide_map)) : ?>
													<h4><?php echo esc_html( $homeland_property_map_header_label ); ?></h4>
													<span class="map-address"><?php echo esc_html( $homeland_address ); ?></span>
													<section id="map-property"></section>
													<?php if(!empty($homeland_show_street_view)) : ?>
														<section id="map-property-street"></section>
													<?php endif;
												endif;
											endif;
										?>
									</article><?php 
									
									homeland_social_share(); // modify in custom-functions.php
								endwhile; 

								if(empty($homeland_all_agents)) :
									if(empty($homeland_agent_info)) : ?>
										<!-- Agent Profile -->
										<div class="clear">	
											<div class="agent-list clear">
								    		<div class="agent-image">
								    			<div class="grid cs-style-3">	
								    				<figure class="pimage">
								    					<a href="<?php echo esc_url( get_author_posts_url( $homeland_agent_id ) ); ?>">
								    						<?php if(!empty($homeland_custom_avatar)) : ?>
								    							<img src="<?php echo esc_url( $homeland_custom_avatar ); ?>" />
								    						<?php else : 
								    								echo get_avatar( $homeland_agent_id, 230 );
																endif;
															?>
								    					</a>
								    					<figcaption>
								    						<a href="<?php echo esc_url( get_author_posts_url( $homeland_agent_id ) ); ?>"><i class="fa fa-link fa-lg"></i></a>
								    					</figcaption>
								    				</figure>
								    			</div>
								    			<div class="agent-social">
								    				<ul class="clear">
								    					<?php
								    						if(!empty($homeland_agent_facebook)) : ?>
								    							<li><a href="<?php echo esc_url( $homeland_agent_facebook ); ?>" target="_blank"><i class="fa fa-facebook fa-lg"></i></a></li><?php
								    						endif;
								    						if(!empty($homeland_agent_gplus)) : ?>
								    							<li><a href="<?php echo esc_url( $homeland_agent_gplus ); ?>" target="_blank"><i class="fa fa-google-plus fa-lg"></i></a></li><?php
								    						endif;
								    						if(!empty($homeland_agent_linkedin)) : ?>
								    							<li><a href="<?php echo esc_url( $homeland_agent_linkedin ); ?>" target="_blank"><i class="fa fa-linkedin fa-lg"></i></a></li><?php
								    						endif;
								    						if(!empty($homeland_agent_twitter)) : ?>
								    							<li><a href="<?php echo esc_url( $homeland_agent_twitter ); ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a></li><?php
								    						endif;
								    						if(!empty($homeland_agent_email)) : ?>
								    							<li class="last"><a href="mailto:<?php echo esc_html( $homeland_agent_email ); ?>" target="_blank"><i class="fa fa-envelope-o fa-lg"></i></a></li><?php
								    						endif;
								    					?>
								    				</ul>
								    			</div>
								    		</div>

								    		<!-- Agent Descriptions -->
								    		<div class="agent-desc">
								    			<h4>
								    				<a href="<?php echo esc_url( get_author_posts_url( $homeland_agent_id ) ); ?>"><?php echo esc_html( $homeland_agent_fname ) . "&nbsp;" . esc_html( $homeland_agent_lname ); ?></a>
								    			</h4>
								    			<?php echo wpautop ( $homeland_agent_desc_trim ); ?>
								    			<label class="more-info">
								    				<?php
								    					if(!empty($homeland_agent_telno)) : ?>
								    						<span><i class="fa fa-phone"></i><strong><?php esc_html_e( 'Tel no', 'homeland' ); echo ":"; ?></strong>
								    							<?php echo esc_html( $homeland_agent_telno ); ?></span><?php
								    					endif;
								    					if(!empty($homeland_agent_mobile)) : ?>
								    						<span><i class="fa fa-mobile"></i><strong><?php esc_html_e( 'Mobile', 'homeland' ); echo ":"; ?></strong>
								    							<?php echo esc_html( $homeland_agent_mobile ); ?></span><?php
								    					endif;
								    					if(!empty($homeland_agent_fax)) : ?>
								    						<span><i class="fa fa-print"></i><strong><?php esc_html_e( 'Fax', 'homeland' ); echo ":"; ?></strong>
								    							<?php echo esc_html( $homeland_agent_fax ); ?></span><?php
								    					endif;
								    				?>
								    			</label>
									    		<a href="<?php echo esc_url(get_author_posts_url($homeland_agent_id)); ?>" class="view-profile"><?php echo esc_html( $homeland_agent_button_label ); ?></a>
								    		</div>
									    </div>	

								    	<!-- Agent Form -->
								    	<div class="agent-form">
								    		<h4><?php echo esc_html( $homeland_agent_form_label ); ?></h4>
								    		<?php
								    			if(isset($_POST['btsend'])) :
								    				$homeland_property_link = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
								    				$homeland_receiver = get_the_author_meta( 'email' );
								    				
														if(!isset($hasError)) :
															$fname = trim($_POST['fname']);
															$email = trim($_POST['email']);
															if(function_exists('stripslashes')) : 
																$message = stripslashes(trim($_POST['message']));
															else : 
																$message = trim($_POST['message']);
															endif;

															$emailTo = esc_html( $homeland_receiver ); 
															$subject = esc_html__('Prospect Clients', 'homeland');
															$body = "Name: " . esc_html( $fname ) . "\n\n";
															$body .= "Email: " . esc_html( $email ) . "\n\n";
															$body .= "Message: " . esc_html( $message ) . "\n\n";
															$body .= "Property Link: " . esc_url( $homeland_property_link ) . "\n\n";
															$headers = "From: " . esc_html( $fname ) . " <" . esc_html( $email ) . ">\n";
															$headers .= "Content-Type: text/plain; charset=UTF-8\n";
												      $headers .= "Content-Transfer-Encoding: 8bit\n";
															
															wp_mail( $emailTo, $subject, $body, $headers );		
															$homeland_emailSent = true;

														endif;
													endif;

													if(isset($homeland_emailSent) && $homeland_emailSent == true) : ?>
														<label class="sent"><?php esc_html_e( 'You have successfully send your message to this agent!', 'homeland' ); ?></label><?php 
													endif; 
								    		?>
								    		<form id="agent-form" action="<?php the_permalink(); ?>#agent-form" method="post">
								    			<input name="permalink" type="hidden" value="<?php the_permalink(); ?>" />
								    			<ul>
								    				<li><input name="fname" type="text" class="required" placeholder="<?php esc_html_e( 'Name', 'homeland' ); ?>" /></li>
								    				<li><input name="email" type="email" class="required email" placeholder="<?php esc_html_e( 'Email Address', 'homeland' ); ?>" /></li>
								    				<li><textarea name="message" class="required" placeholder="<?php esc_html_e( 'Message', 'homeland' ); ?>" /></textarea></li>
								    				<li><input name="btsend" type="submit" value="<?php esc_html_e( 'Send', 'homeland' ); ?>" /></li>
								    			</ul>	
								    		</form>
								    	</div>
										</div><?php
									endif;
								endif;

								if(empty($homeland_other_properties)) : ?>
									<div class="property-list clear">
										<h4><?php echo esc_html( $homeland_other_properties_header_label ); ?></h4>
										<div class="property-four-cols clear">
											<?php
												$homeland_exclude_post = $post->ID;
												$args = array( 
													'post_type' => 'homeland_properties', 
													'orderby' => 'rand', 
													'post__not_in' => array($homeland_exclude_post), 
													'posts_per_page' => $homeland_other_property_limit 
												);
												query_posts( $args );

												if (have_posts()) : ?>
													<div class="grid cs-style-3 masonry">
														<ul class="clear">
															<?php
																for($homeland_i = 1; have_posts(); $homeland_i++) {
																	the_post();		

																	if($homeland_single_property_layout == "Fullwidth") : $homeland_columns = 4;
																	else : $homeland_columns = 3;	
																	endif;

																	$homeland_class = 'property-cols masonry-item ';
																	$homeland_class .= ($homeland_i % $homeland_columns == 0) ? 'last' : '';
																	
																	get_template_part( 'loop', 'property-4cols' );
																} 
															?>
														</ul>
													</div><?php
												endif;
												wp_reset_query();	
											?>
										</div>
									</div><?php
								endif;

								if(empty($homeland_hide_property_comments)) : 
									comments_template(); 
								endif;

								if(empty($homeland_hide_property_prevnext)) : ?>
									<div class="post-link-blog clear">
										<span class="prev">
											<?php 
												previous_post_link( 
													'%link', '&larr;&nbsp;' . esc_html__( 'Previous Property', 'homeland' ), '' 
												); 
											?>
										</span>
										<span class="next">
											<?php 
												next_post_link( 
													'%link', esc_html__( 'Next Property', 'homeland' ) . '&nbsp;&rarr;', '' 
												); 
											?>
										</span>
									</div><?php
								endif;
							endif;
						endif;	
					?>	
				</div>
			</div>

			<?php if($homeland_single_property_layout != "Fullwidth") : ?>
				<div class="<?php echo esc_attr( $homeland_property_class_sidebar ); ?>"><?php get_sidebar(); ?></div>
			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>