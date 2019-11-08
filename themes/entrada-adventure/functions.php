<?php
// Child function start here

add_action( 'wp_enqueue_scripts', 'entrada_child_scripts', 12 );
require_once(get_stylesheet_directory() . '/admin/widgets/entrada-filter-region-widget-custom.php');

function entrada_child_scripts() {

	if ( is_rtl() ) {

		wp_enqueue_style( 'entrada-child-rtl', get_template_directory_uri()."/rtl.css" );

	}
}

remove_shortcode(  'entrada_search_block', 'entrada_vc_search_block' );

add_shortcode( 'entrada_search_block', 'my_entrada_vc_search_block' );
function my_entrada_vc_search_block( $atts, $content = null ) { 
	global $wpdb;
	extract( shortcode_atts( array(
      'search_block_title' => '',
	  'search_block_desc' => '',
	  'search_field_col' => 3,
	  'search_block_button_text' => ''
	), $atts ) );
  
	$html_content = '';
	$holder = ''; 
	$search_block_desc = "{$search_block_desc}";
	$search_field_col = "{$search_field_col}";
	$search_block_button_text = "{$search_block_button_text}";
  
  //  echo 'Test: '.$search_block_desc;
    $search_fields = explode(",",$search_block_desc);
	$theme = wp_get_theme();
	if ( 'entrada' == strtolower( $theme->name ) || 'entrada' == strtolower( $theme->parent_theme ) ) {	
		if($search_fields){
			
			// Month-Year Date select box
			$date = date('Y-m-d');
			$entrada_start_date_month_year_arr = array();
			$entrada_end_date_month_year_arr = array();
			for($i =0; $i < 12; $i++){
				
				$entrada_current_month = date('n', strtotime($date));
				$start_day = ($i == ($entrada_current_month - 1) ? date('d', strtotime($date)) : 01);

				$entrada_month_year_date = date('d-m-Y', strtotime('+'.$i.' month', strtotime($date)));
				/* Lastday of Month */
				$Year =  date('Y', strtotime($entrada_month_year_date));
				$Month = date('n', strtotime($entrada_month_year_date));
				$aMonth         = mktime(0, 0, 0, $Month, 1, $Year);
				$NumOfDay       = 0+date("t", $aMonth);
				$LastDayOfMonth = mktime(0, 0, 0, $Month, $NumOfDay, $Year);
				
				$start_date_val = $start_day .'-'. date('m-Y', strtotime($entrada_month_year_date));
				$end_date_val = date('t-m-Y', strtotime($entrada_month_year_date));

				$y = date('Y', strtotime($entrada_month_year_date));
				$index = date('n', strtotime($entrada_month_year_date));

				$entrada_start_date_month_year_arr[$start_date_val] = entrada_vc_month_name($index, $y);
				$entrada_end_date_month_year_arr[$end_date_val] = entrada_vc_month_name($index, $y);
			
			}
			
			foreach($search_fields as $field){
					$field_elements = explode("::",$field);
					$default_select_label = '';
					if(isset( $field_elements[2] ) ){
						$default_select_label = $field_elements[2];
					}
					switch ($field_elements[1]) {
						
						case 'destination':
							$desti = array();

							if(empty( $default_select_label ) ){
								$default_select_label = __('All Destinations','entrada');
							}						

							$diestinations = get_terms('destination', array('hide_empty' => 0, 'orderby' => 'name', 'order' => 'asc'));
							if ( $diestinations ) {
								foreach($diestinations as $dest){
								if($dest->parent != 0){
									$term = get_term_by('id', $dest->parent, 'destination');
									$desti[$dest->parent][] = '<option value="'.$dest->slug.'">'.$term->name.' - '.$dest->name.'</option>';
									}
								}
							}
							ksort($desti);
							//return print_r($desti);
							
							$holder .= '<div class="holder">
										<label for="destination">'.$field_elements[0].'</label>
										<div class="select-holder">
											<select placeholder="All Destinations" class="trip trip-banner" id="destination" name="destination" multiple data-jcf=\'{"wrapNative": false, "wrapNativeOnMobile": false, "useCustomScroll": false, "multipleCompactStyle": true}\'> ';
											$holder .= '<option value="">'.$default_select_label.'</option>';
											
									if ( $desti ) {
										foreach($desti as $data){
											foreach($data as $d) {	
												$holder .= $d;	
												}
											}	
									}
											
							$holder .= '</select>
										</div>
									</div>';	
													
						break;

						case 'destination_level_1':

							$desti = array();

							if(empty( $default_select_label ) ){
								$default_select_label = __('All Destinations','entrada');
							}						

							$diestinations = get_terms('destination', array('hide_empty' => 0, 'orderby' => 'name', 'order' => 'asc'));
							if ( $diestinations ) {
								foreach($diestinations as $dest){
						
								$term = get_term_by('id', $dest->parent, 'destination');
								$desti[$dest->parent][] = '<option value="'.$dest->slug.'">'.$dest->name.'</option>';								
								}
							}
							ksort($desti);
							//return print_r($desti);
							
							$holder .= '<div class="holder">
										<label for="destination">'.$field_elements[0].'</label>
										<div class="select-holder">
											<select class="trip trip-banner" id="destination" name="destination">';
											$holder .= '<option value="">'.$default_select_label.'</option>';
											
									if ( $desti ) {
										foreach($desti as $data){
											foreach($data as $d) {	
												$holder .= $d;	
												}
											}	
									}
											
							$holder .= '</select>
										</div>
									</div>';	
													
						break;
						
						case 'start_month_year_selectbox':
							
							if(empty( $default_select_label ) ){
								$default_select_label = __('Any Date','entrada');
							}

							$holder .= '<div class="holder">
									<label for="destination">'.$field_elements[0].'</label>
									<div class="select-holder">
										<select class="trip trip-banner" id="start_date_month_year" name="start_date">';
										$holder .= '<option value="">'.$default_select_label.'</option>';
										
								if ( $entrada_start_date_month_year_arr ) {
									foreach ($entrada_start_date_month_year_arr as $key => $value) {
										$holder .= '<option value="'.$key.'">'.$value.'</option>';											
									}	
								}
											
							$holder .= '</select>
										</div>
									</div>';
						
						break; 
						
						case 'end_month_year_selectbox':
							
							if(empty( $default_select_label ) ){
								$default_select_label = __('Any Date','entrada');
							}

							$holder .= '<div class="holder">
									<label for="destination">'.$field_elements[0].'</label>
									<div class="select-holder">
										<select class="trip trip-banner" id="end_date_month_year" name="end_date">';
										$holder .= '<option value="">'.$default_select_label.'</option>';
										
								if ( $entrada_end_date_month_year_arr ) {
									foreach ($entrada_end_date_month_year_arr as $key => $value) {
										$holder .= '<option value="'.$key.'">'.$value.'</option>';											
									}	
								}
											
							$holder .= '</select>
										</div>
									</div>';
						
						break;
						
						case 'start_date':
							$holder .= '<div class="holder">
										<label>'.$field_elements[0].'</label>
										<div class="select-holder">
											<div id="datepicker5" class="input-group date picker-solid-bg" data-date-format="yyyy-mm-dd">
												<input class="form-control" type="text" name="start_date" />
												<span class="input-group-addon"><i class="icon-arrow-down"></i></span>
											</div>
										</div>
									</div>';
						break;	
						
						case 'end_date':
							$holder .= '<div class="holder">
										<label>'.$field_elements[0].'</label>
										<div class="select-holder">
											<div id="datepicker6" class="input-group date picker-solid-bg" data-date-format="yyyy-mm-dd">
												<input class="form-control" type="text" name="end_date" />
												<span class="input-group-addon"><i class="icon-arrow-down"></i></span>
											</div>
										</div>
									</div>';
						break;
						
						case 'price_range':

							if(empty( $default_select_label ) ){
								$default_select_label = __('All Range', 'entrada');
							}
									
								$holder .= '<div class="holder">
								<label for="destination">'.$field_elements[0].'</label>
								<div class="select-holder">
									<select class="trip trip-banner" id="price_range" name="price_range">';
										
								$holder .= '<option value="">'.$default_select_label.'</option>';		
								$holder .= entrada_product_price_range(false);  									
								$holder .= '</select>
										</div>
									</div>';
						
						break;	

						default:
							
							if(empty( $default_select_label ) ){
								$default_select_label = __('All Activities', 'entrada');
							}
							$holder .= '<div class="holder">
									<label for="destination">'.$field_elements[0].'</label>
									<div class="select-holder">
										<select  placeholder="All Activities"  class="trip trip-banner" id="adventure" name="product_cat" multiple data-jcf=\'{"wrapNative": false, "wrapNativeOnMobile": false, "useCustomScroll": false, "multipleCompactStyle": true}\' >';
										
								$holder .= '<option value="">'.$default_select_label.'</option>';
								$featured_cat_ids = entrada_product_featured_categories('prod_iconbar_cat_val' );
								$prod_cat_args = array(
									  'type'         => 'product',	
									  'taxonomy'     => 'product_cat', 
									  'hide_empty'   => 0,
									  'include'      => $featured_cat_ids
								);
		
							 $activities = get_categories($prod_cat_args);
							 if($activities){
								  foreach($activities as $activity) {
									$holder .= '<option value="'.$activity->slug.'">'.$activity->name.'</option>';  
								  }
							 }

							$holder .= '</select>
										</div>
									</div>';
						
					}
				}
			$search_block_button_text = !empty($search_block_button_text)? $search_block_button_text : 'GO WILD';	
			$holder .= '<div class="holder"><input class="btn btn-trip" type="submit" value="'.$search_block_button_text.'"></div>';	
									
			$html_content .= '<div class="banner-text">
						<div class="center-text">
							<form class="trip-form banner-trip-form" method="get" action = "'.home_url( '/find/tours/' ).'">
								<fieldset>'.$holder;
			$html_content .= '</fieldset>
							</form> 
						</div>
					</div>';
			
			if( !empty( $search_field_col ) ){
				$width = (int)(100/$search_field_col);
				global $post;
				if(isset($post->ID) && $post->ID != ''){
					update_post_meta($post->ID, 'entrada_search_col', $width);
				}
			}
		}
	}
	return $html_content;
}

remove_action( 'template_redirect', 'entrada_url_rewrite_templates' );

function my_entrada_url_rewrite_templates() {
    if ( get_query_var( 'tours' ) ) {
        add_filter( 'template_include', function() {
            return get_stylesheet_directory() . '/page-properties.php';
        });
    } else if ( get_query_var( 'tour-listing' ) ) {
		add_filter( 'template_include', function() {
            return get_stylesheet_directory() . '/tour-listing.php';
        });
	}
}
add_action( 'template_redirect', 'my_entrada_url_rewrite_templates', 12 );

?>