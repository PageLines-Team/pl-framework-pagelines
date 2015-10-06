<?php

/**
 * Welcome to PageLines.com child theme.
 *  
 * Here are some notes: 
 * 
 *   Code
 *   PHP Escaping: uses the PHP Nowdoc syntax to help with formatting
 *   https://php.net/manual/en/language.types.string.php#language.types.string.syntax.nowdoc
 *
 *   Syntax Highlighting
 *   Uses the popular Prism JS library
 *   http://prismjs.com/index.html
 *
 * 
 */



/**
 * Add Syntax highlighting plugin
 * http://prismjs.com/index.html
 */

add_action( 'wp_head', 'pl_add_syntax_highlighting' );
function pl_add_syntax_highlighting(){
?>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/_plugins/prism/prism.css">
  <script src="<?php echo get_stylesheet_directory_uri();?>/_plugins/prism/prism.js"></script>
<?php 
}

add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts' );
function enqueue_child_scripts() {
    
  wp_enqueue_script( 'stickykit', get_stylesheet_directory_uri() . '/_plugins/stickykit/stickykit.js' );

  wp_enqueue_script( 'pl-docs', get_stylesheet_directory_uri() . '/script.js' );
  //  wp_enqueue_style( 'pagelines-framework-child', get_stylesheet_directory_uri() . '/build.css' );
}



/**
 * Code syntax creation utility function
 */
function pl_create_code( $code, $lang = 'php' ){

  $replace_codes = str_replace('[n]', "\n", $code );

  $encoded = htmlentities( $replace_codes );

  $output = sprintf('<div class="code-block" data-bind="stopBinding: true"><pre><code class="language-%s">%s</code></pre></div>', $lang, $encoded); 

  return $output;

}


/**
 * EXAMPLE
 * Callback Example. Must be in functions.php since it runs in AJAX
 */
add_filter('pl_binding_taxlist', 'pl_list_tax', 10, 2);  
function pl_list_tax( $response, $data ){

  // Value of option / variable assigned to plcallback
  $taxonomy = $data['value'];

  // editID is always passed
  $id = $data['editID'];

  // Do something
  $the_terms = get_terms( $taxonomy );

  $html = '';

  if( is_array( $the_terms ) ){
    foreach( $the_terms as $term ){
        $html .= sprintf('<span><i class="pl-icon pl-icon-tag" style="opacity: .2;"></i> %s</span> ', $term->name);
    }
  }

  else 
    return 'No terms returned.';
  

  // Return
  $response['template'] = $html;

  return $response;
}


