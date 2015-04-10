<?php
/*
	Section: 		Socialinks
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A social icons listing.
	Class Name: 	PLSocialinks
	Filter: 		localsocial
*/


class PLSocialinks extends PageLinesSection {

	function section_opts(){

	
		$opts = array(
		
			array(
				'type'	=> 'multi',
				'key'	=> 'sl_config', 
				'title'	=> 'Text',
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'text',
						'key'	=> 'sl_text', 
						'label'	=> 'Socialinks Text (e.g. copyright information)',
					),
					array(
						'key'	=> 'menu',
						'type'	=> 'select_menu',
						'label'	=> 'Select Menu',
					),
					array(
						'type'	=> 'check',
						'key'	=> 'sl_web_disable', 
						'label'	=> 'Disable "Built With" Icons (HTML5, CSS3, PageLines)',
						'scope'	=> 'global'
					),
				)
				
			),
			array(
				'type'		=> 'multi',
				'title'		=> 'Link URLs',
				'stylize'	=> 'social-links',
				'opts'		=> $this->pl_social_links_options()
				
			)
			

		);

		return $opts;

	}
	
	
	
	function section_template(  ) { ?>

	<div class="socialinks-wrap fix" >

		<div class="sl-text">
			<span class="sl-copy" data-bind="plsync: sl_text"><?php echo sprintf('&copy; %s %s', date("Y"), get_bloginfo('name')); ?></span> 
			<?php echo pl_dynamic_nav('menu', $this->opt('menu'), 'sl-nav', 'sl-nav-wrap', 'quicklinks');?>
		</div>
		
		<?php echo $this->pl_social_links(); ?>
	</div>
	
<?php }


	/**
	 * The icons used for href, icon, option key
	 * Note, cannot have dashes
	 */
	function pl_social_icons(){
		$icons = array(
			'facebook',
			'linkedin',
			'instagram',
			'twitter',
			'youtube',
			'google',
			'pinterest',
			'dribbble',
			'flickr',
			'github',
		); 
		
		return $icons;
	}

	function pl_social_links_options(){
		$the_urls = array(); 
		
		$icons = $this->pl_social_icons();
		
		foreach($icons as $icon){
			$the_urls[] = array(
				'label'	=> ui_key($icon) . ' URL', 
				'key'	=> sprintf('sl_%s', $icon),
				'type'	=> 'text',
				'scope'	=> 'global',
			); 
		}
		
		return $the_urls;
	}

	function pl_social_links(){

		$links = ''; 

		foreach( $this->pl_social_icons() as $icon){

			$key = sprintf('sl_%s', $icon);
			$links .= sprintf('<a href="%s" class="sl-link" target="_blank" data-bind="visible: %s, plhref: %s"><i class="icon icon-%s"></i></a>', $this->opt($key), $key, $key, $icon); 
			
		}
		
		ob_start(); 
		?>

		<div class="sl-links">

			<?php echo $links; ?>
			<span class="sl-web-links" data-bind="hidden: sl_web_disable() == 1">
				<a class="sl-link" title="CSS3 Valid"><i class="icon icon-css3"></i></a>
				<a class="sl-link" title="HTML5 Valid"><i class="icon icon-html5"></i></a>
				<a class="sl-link" title="Professional Design with PageLines" href="http://www.pagelines.com" ><i class="icon icon-pagelines"></i></a>
			</span>
		
		</div>
		
		<?php 
		return ob_get_clean();
	}

	


}
