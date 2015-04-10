<?php
/*
	Section: 		ProPricing
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	An amazing, professional pricing section.
	Class Name: 	PLProPricing
	Filter: 		component
*/


class PLProPricing extends PageLinesSection {


	function section_opts(){
		$options = array();

		$options[] = array(

			'title' => __( 'ProPricing Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				
				array(
					'key'			=> 'propricing_cols',
					'type' 			=> 'count_select',
					'count_start'	=> 1,
					'count_number'	=> 12,
					'default'		=> '4',
					'label' 	=> __( 'Number of Columns for Each Plan (12 Col Grid)', 'pagelines' ),
				),
			)

		);

		$options[] = array(
			'key'		=> 'propricing_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('Pricing Setup', 'pagelines'), 
			'post_type'	=> __('Column', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'	=> 'title',
					'label'	=> __( 'Title', 'pagelines' ),
					'type'			=> 'text'
				),
				array(
					'key'	=> 'price',
					'label'	=> __( 'Price', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'key'	=> 'price_pre',
					'label'	=> __( 'Before Price Text', 'pagelines' ),
					'type'	=> 'text',
					'help'	=> __( 'Typically you will add the monetary unit here. E.g. "$"', 'pagelines' ),
				),
				array(
					'key'	=> 'price_post',
					'label'	=> __( 'After Price Text', 'pagelines' ),
					'type'	=> 'text',
					'help'	=> __( 'Typically you will add the recurring amount here. E.g. "/ MO"', 'pagelines' ),
				),
				array(
					'key'	=> 'sub_text',
					'label'	=> __( 'Sub Text', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'title'			=> __( 'Primary Link', 'pagelines' ),
					'type'			=> 'multi',
					'stylize'		=> 'button-config',
					'opts'			=> pl_button_link_options( 'link' )
				),
				array(
					'key'	=> 'popular',
					'label'	=> __( 'Select as Most Popular?', 'pagelines' ),
					'type'	=> 'check'
				),
				array(
					'key'	=> 'attributes',
					'label'	=> __( 'Plan Features List', 'pagelines' ),
					'type'	=> 'textarea',
					'help'	=> __( 'Add each attribute on a new line. Add a "*" in front to add emphasis.', 'pagelines' ),
				),
				
			)
	    );

		return $options;
	}

	function section_template( ) { ?>
	<div class="propricing-wrap pl-animation-group" >
		<div class="row-pricing row pl-iso-container" data-bind="plforeach: propricing_array, plclass: $root.propricing_cols(), partial: 'col-sm-', child: '.col-pricing'">
			<div class="col-pricing col-sm-4 pl-border pl-iso" >
				<div class="pp-plan pl-animation pl-appear pl-border fix" data-bind="css: {'most-popular': popular() > 0}">
					<div class="pp-header">
						<div class="pp-title pl-border pl-type-tag" >
							<span data-bind="plsync: title"><?php _e('Plan Title', 'pagelines');?></span>
							<span class="label label-default"><?php _e('Most Popular', 'pagelines');?></span>
						</div>
						<div class="pp-price">
							<span class="price-pre" data-bind="plsync:: price_pre">$</span>
							<span class="price" data-bind="plsync: price">99</span>
							<span class="price-post" data-bind="plsync: price_post">/mo</span>
							<div class="price-sub" data-bind="plsync: sub_text"></div>
							<?php pl_dynamic_button( 'link', 'btn-lg btn-primary pricing-action' ); ?>
						</div>
					</div>
					<div class="pp-attributes">
						<ul class="list-unstyled iso-update" data-bind="pllist: attributes"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php }


   function old_section_template( ) { 
	
		
	
		$item_array = $this->opt('propricing_array');

		$format_upgrade_mapping = array(
			'title'			=> 'propricing_title_%s',
			'price'			=> 'propricing_price_%s',
			'price_pre'		=> 'propricing_price_pre_%s',
			'price_post'	=> 'propricing_price_post_%s',
			'sub_text'		=> 'propricing_sub_%s',
			'link'			=> 'propricing_link_%s',
			'link_text'		=> 'propricing_link_text_%s',
			'btn_theme'		=> 'propricing_btn_%s',
			'attributes'	=> 'propricing_attributes_%s',
		); 

		$item_array = $this->upgrade_to_array_format( 'propricing_array', $item_array, $format_upgrade_mapping, $this->opt('propricing_count'));
	
		$cols = ($this->opt('propricing_cols')) ? $this->opt('propricing_cols') : 4;
		$width = 0;
		$output = '';
		$count = 1;
		$item_array = ( ! is_array($item_array) ) ? array( array(), array(), array() ) : $item_array;
		$num = count( $item_array );

		
		foreach( $item_array as $item){
			
			
			$title 		= pl_array_get( 'title', $item, 'Plan');
			$price_pre 	= pl_array_get( 'price_pre', $item, '$');
			$price 		= pl_array_get( 'price', $item, $count*8);
			$price_post = pl_array_get( 'price_post', $item, '/ MO');
			$sub 		= pl_array_get( 'sub_text', $item, sprintf('Billed annually or $%s/MO billed monthly.', $count*10) );
			$link 		= pl_array_get( 'link', $item, '#');
			$link_text 	= pl_array_get( 'link_text', $item);
			$btn_theme 	= pl_array_get( 'btn_theme', $item, 'btn-important');
			$attr 		= pl_array_get( 'attributes', $item);
			
			$popular 	= pl_array_get( 'popular', $item);
		
			$popular_class = ($popular) ? 'most-popular' : '';
			
			$title_bg = ($popular) ? 'pl-link-inverse' : 'pl-link';
			
			$title = ($popular) ? sprintf('%s<div class="mp"><i class="icon icon-star"></i> %s</div>', $title, __('Most Popular!', 'pagelines')) : $title;
		
			$attr_list = ''; 
			
			if($attr != ''){
				
				$attr_array = explode("\n", $attr);
				$attr_count = 0;
				foreach($attr_array as $at){
					
					$at = trim($at);
					
					if( $at == '' )
						continue;
					
					$class = ( $attr_count % 2 == 0 ) ? 'pl-contrast' : '';
					
					if(strpos($at, '*') === 0){
						$at = str_replace('*', '', $at); 
						$attr_list .= sprintf('<li class="pl-border emphasis %s">%s</li>', $class, $at); 
					} else {
						$attr_list .= sprintf('<li class="pl-border 	%s">%s</li>', $class, $at); 
					}
					
					$attr_count++;
					
				}
				
			} 
			
			if($link != ''){
				
				$link_text = ($link_text != '') ? $link_text : 'Sign Up';
				$link_text = sprintf('<span class="btn-link-text" data-sync="propricing_link_text_%s">%s</span>', $count, $link_text);
				
				$formatted_link = sprintf('<li class="pp-link pl-border"><a href="%s" class="btn btn-large %s" >%s <i class="icon icon-chevron-sign-right"></i></a></li>', $link, $btn_theme, $link_text);
				
			} else {
				$formatted_link = ''; 
			}
			
			
			$attr_list = $formatted_link . $attr_list; 
			
			$formatted_attr = ($attr_list != '') ? sprintf('<div class="pp-attributes"><ul>%s</ul></div>', $attr_list) : '';
		
		
			$formatted_sub = ($sub != '') ? sprintf('<div class="price-sub" data-sync="propricing_sub_%s">%s</div>', $count, $sub) : ''; 
		
			$output .= pl_grid_tool('row_start', $cols, $count, $num);
			//$output .= $cols.' '.$count.' '.$num;
			
			$output .= sprintf(
				'<div class="span%1$s %9$s pp-plan pl-animation pl-appear pl-base pl-border fix">
					<div class="pp-header">
						<div class="pp-title %10$s pl-standard-title pl-border" data-sync="propricing_title_%8$s">
							%2$s
						</div>
						<div class="pp-price">
							<span class="price-pre" data-sync="propricing_price_pre_%8$s">%3$s</span>
							<span class="price" data-sync="propricing_price_%8$s">%4$s</span>
							<span class="price-post" data-sync="propricing_price_post_%8$s">%5$s</span>
							%6$s
						</div>
					</div>
					%7$s
				</div>',
				
				$cols,
				$title,
				$price_pre, 
				$price,
				$price_post,
				$formatted_sub,
				$formatted_attr, 
				$count,
				$popular_class,
				$title_bg
			);


			$output .= pl_grid_tool('row_end', $cols, $count, $num);
			
			$count++;
		 }
	
	
	?>
	
	<div class="propricing-wrap pl-animation-group">
		<?php echo $output; ?>
	</div>

<?php }


}
