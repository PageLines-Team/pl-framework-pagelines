<?php
/*
 * Template Name: PL Docs: Options
 */

// lets buffer and output everything at the end
ob_start();
 ?>


  <h2>Introduction</h2>
    <p>Options inside of Platform 5 are driven by a very simple PHP options array format.</p>

    <p>Using this format allows us a very simple and consistent way of drawing out various options and option types for user customization</p>

  <h3>Where options arrays are used</h3>

  <h4>Inside Sections</h4>
  <p>The primary location for options arrays are inside the <code>section_options()</code> method of the Section API. This function is designed to simply return the options array that will then configure the unique options available for that section.</p>

  <p>The basic option array inside a section looks like this:</p>

<?php
$code = <<<'EOT'
/**
*  Example: "Section Option Array"
*/
class My_Section extends PL_Section {

  /** Option array method (returns options) */
  function section_opts(){

    // Setup Option Array

    $options = array();

    $options[] = array(
        'type'    => 'text,             // type of option
        'key'     => 'my_unique_key',   // the unique key for option, referred to in HTML bindings
        'title'   => 'My Option Title', // Title for option UI
        'help'    => 'Any help for the user',
        'label'   => 'Option Label',
      );


    return $options;
  }

  /** Section HTML Template (with bindings) */
  function section_template(){

    ?>
    <!-- This will sync its text to value of the option -->
    <div data-bind="pltext: my_unique_key"></div>
    <?php

  }
}
EOT;

echo pl_create_code( $code );

?>

    <h4>Inside Templates</h4>

    <p>It is also possible to use option arrays inside of WordPress page templates along with the <code>pl_add_static_settings()</code> function.</p>

<?php
$code = <<<'EOT'
/*
 * Template Name: My Template
 */

$options = array();

$options[] = array(
    'type'    => 'text,             // type of option
    'key'     => 'my_unique_key',   // the unique key for option, referred to in HTML bindings
    'title'   => 'My Option Title', // Title for option UI
    'help'    => 'Any help for the user',
    'label'   => 'Option Label',
  );

// Adds options to the template
pl_add_static_settings( $options );

?>
<!-- This will sync its text to value of the option -->
<div data-bind="pltext: my_unique_key"></div>

EOT;

echo pl_create_code( $code ); ?>

<hr/>

<h2>Option Parameters</h2>

<p>Each entry in your option array supports a variety of different parameters for adding relevant information. For example, adding help text or a link.</p>

<?php
$code = <<<'EOT'
// Standard Option Parameters
$options[] = array(
    'type'    => 'text,                 // Type of option
    'key'     => 'my_unique_key',       // Unique key
    'default' => 'Hello!',              // The default option value
    'title'   => 'My Option Title',     // UI Title
    'help'    => 'Help for the user',   // Help
    'ref'     => 'Help in a dropdown',  // Dropdown Help
    'label'   => 'Option Label',        // Label for Option
    'opts'    => array()                // Sub options (used in selects, accordion, multi),
    'stylize' => 'custom-class'         // Add a custom class to the option (for styling)
);
EOT;

echo pl_create_code( $code ); ?>

<h3>Overriding Section Options</h3>

<p>Every section option can be overridden at runtime using WordPress filters.</p>
<p>In this example we are going to set the posts_per_page section option for postgrid to 48 posts, the maximum the section allows is 32.</p>
<?php
$code = <<<'EOT'
class Postgrid_Posts {

  function __construct() {
    add_filter( 'pl_opt-posts_per_page', array( $this, 'filter' ) );
  }
  function filter( $var ) {
    return 48;
  }
}
new Postgrid_Posts;
EOT;
echo pl_create_code( $code ); ?>

<h2>Option Types</h2>

<h3>Basic</h3>

<h4><code>multi</code></h4>
<p>The multi option type is a utility for nesting options in the UI.</p>

<?php
$code = <<<'EOT'
// "multi" option type
// This will have two nested text options within the top level option
$options[] = array(
    'type'    => 'multi',
    'opts'    => array(
        array(
            'type'  => 'text',
            'key'   => 'k1'
          ),
        array(
            'type'  => 'text',
            'key'   => 'k2'
          ),
      )
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>text</code> and <code>textarea</code></h4>

<p>The text and textarea option types adds basic text and textarea input fields respectively.</p>
<p><code>text_small</code> creates a text field but it will be a small field.</p>

<?php
$code = <<<'EOT'
// "text" option type
$options[] = array(
    'type'    => 'text,
    // Other parameters
  );

// "textarea" option type
$options[] = array(
    'type'    => 'textarea,
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>richtext</code></h4>
<p>Adds a richtext editor for text with formatting options. Users can switch between this and a simple textarea.</p>
<?php
$code = <<<'EOT'
// "text" option type
$options[] = array(
    'type'    => 'richtext,
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>image_upload</code></h4>
<p>A simple image uploader for the WordPress media library</p>
<?php
$code = <<<'EOT'
// "image_upload" option type
$options[] = array(
    'type'    => 'image_upload',
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>check</code></h4>
<p>A simple checkbox option</p>
<?php
$code = <<<'EOT'
// "check" option type
$options[] =  array(
  'key'     => 'sticky',
  'type'    => 'check',
  'label'   => __( 'Make nav sticky on scroll?', 'pagelines' ),
),
EOT;

echo pl_create_code( $code ); ?>

<p>A checkbox option might be used with a binding as follows:</p>
<?php
$code = <<<'EOT'
// "check" option binded in template
// If the checkbox is 'checked', its value will be 1 so add the class of 'do-sticky' to the item.
<div class="my-nav pl-trigger" data-bind="plclassname: [sticky() == 1 ? 'do-sticky' : '']">
  <div class="nav-stuff">
  </div>
</div>
EOT;

echo pl_create_code( $code ); ?>


<h3>Selects</h3>

<h4><code>select</code></h4>
<p>Create a select option for various options.</p>
<p>Select options use a sub 'opts' array to add the various values.</p>
<?php
$code = <<<'EOT'
// "image_upload" option type
$options[] = array(
    'type'    => 'select',
    'opts'    => array(
        'value_1'  => array( 'name' => "Option 1 Text"),
        'value_2'  => array( 'name' => "Option 2 Text")
      )
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>select_icon</code></h4>
<p>Select a standard icon.</p>
<?php
$code = <<<'EOT'
// "select_icon" option type
$options[] = array(
    'type'    => 'select_icon',
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>select_menu</code></h4>
<p>Select a WP menu.</p>
<?php
$code = <<<'EOT'
// "select_menu" option type
$options[] = array(
    'type'    => 'select_menu',
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>

<h4><code>count_select</code></h4>
<p>Uses count parameters to create a numerical selector</p>
<?php
$code = <<<'EOT'
// "count_select" option type
$options[] = array(
    'type'          => 'count_select',
    'count_start'   => 5,     // Count starts at this value
    'count_mult'    => 5,     // Count between each option
    'count_number'  => 200,   // Count total
    'suffix'        => 'px',  // Suffix added to option text
    'default'       => 10,
    // Other parameters
  );
EOT;

echo pl_create_code( $code ); ?>


<h3>Advanced</h3>
<h4><code>accordion</code></h4>
<p>The advanced accordion type is ideal for adding sortable arrays of items with similar formats. For example, multiple boxes, slides or quotes.</p>
<?php
$code = <<<'EOT'
// "accordion" option type
$options[] = array(
  'key'       => 'my_accordion_key',
  'type'      => 'accordion',
  'title'     => __('Item Setup', 'pagelines'),
  'opts'  => array(
    array(
      'key'      => 'title',
      'label'    => __( 'Title', 'pagelines' ),
      'type'    => 'text',
      'default'  => 'Hello'
    ),
    array(
      'key'      => 'text',
      'label'    => __( 'Text', 'pagelines' ),
      'type'    => 'richtext',
      'default'  => 'This is a box.'
    ),

  )
);
EOT;

echo pl_create_code( $code ); ?>

<p>The accordion is typically used with either the pltemplate or plforeach bindings in a template as follows</p>

<?php
$code = <<<'EOT'
// "accordion" option type
<div class="my-item-wrap pl-trigger" data-bind="plforeach: my_accordion_key">
  <div class="the-item pl-trigger">
    <h3 data-bind="pltext: title"></h3>
    <p data-bind="pltext: text"></p>
  </div>
</div>
EOT;

echo pl_create_code( $code ); ?>

<p>The foreach loop above will loop through and create a unique item for every item in the accordion option.</p>

<h4><code>dragger</code></h4>

<p>The dragger option type creates several small, draggable input fields for numerical inputs. For example, this is used for padding and grid controls.</p>

<p>To add your own dragger options simply use a sub options array as follows:</p>

<?php
$code = <<<'EOT'
// "accordion" option type
$options[] = array(
   'type'    => 'dragger',
   'label'    => __( 'Logo Size / Height', 'pagelines' ),
   'opts'  => array(
     array(
       'key'      => 'logo_height',
       'min'      => 20,
       'max'      => 300,
       'def'      => 30,
       'unit'    => 'px'
     ),
    array(
      'key'      => 'logo_width_max',
      'min'      => 20,
      'max'      => 300,
      'def'      => 30,
      'unit'    => 'px'
    ),
   ),
);
EOT;

echo pl_create_code( $code ); ?>

<h3>Utilities</h3>

<h4><code>pl_std_opt()</code> </h4>

<p>Some options are used time and time again and have a similar format. That's why we've created the pl_std_opt() function to save time by quickly getting a standard type option entry.</p>

<p>Example Standard Option Types</p>
<ul>
  <li><code>posts_per_page</code> Select for amount of posts on a page</li>
  <li><code>text_alignment</code> Text alignment classes</li>
  <li><code>section_alignment</code> Section alignment classes</li>
  <li><code>scheme</code> Background color scheme selector</li>
  <li><code>btn</code> Standard button configuration options</li>
  <li><code>columns</code> Select out of a 12 column grid</li>
  <li><code>background_image</code> Background image option</li>
  <li><code>background_color</code> Background color picker</li>
  <li><code>menu</code> Select a menu</li>
  <li><code>link</code> A link option</li>
</ul>


<?php
$code = <<<'EOT'
// Using pl_std_opt()

$options[] = array(
  'key'       => 'my_accordion_key',
  'type'      => 'accordion',
  'title'     => __('Item Setup', 'pagelines'),
  'opts'  => array(
    pl_std_opt('text'),
    pl_std_opt('button'),
    pl_std_opt('button', array('key'  => 'non_default_key') ), // use the second parameter to override the defaults

  )
);
EOT;

echo pl_create_code( $code ); ?>

<h4>Creating Buttons</h4>
<p>Because each button has a standard structure and options, we have created some utitilities to help you quickly create button options.</p>
<p>The function <code>pl_button_link_options</code> takes a key and creates several options.</p>
<ul>
  <li><code>[the_key]</code> The url of the button</li>
  <li><code>[the_key]_text</code> The text of the button</li>
  <li><code>[the_key]_style</code> The color style of the button</li>
  <li><code>[the_key]_size</code> The size of the button (xs, sm, st, lg)</li>
  <li><code>[the_key]_newwindow</code> Should the link open in new window?</li>
</ul>
<?php
$code = <<<'EOT'
// Using pl_button_link_options()

$options[] = array(
    'title'      => __( 'Primary Button', 'pagelines' ),
    'type'       => 'multi',
    'stylize'    => 'button-config',
    'opts'        => pl_button_link_options( 'button_primary', array(
      'button_primary'        => '#',     // Default URL
      'button_primary_text'   => 'More',  // Default Text
      'button_primary_size'   => 'lg'     // Default Size
    ) )
  );
EOT;

echo pl_create_code( $code ); ?>
<!-- End of Documentation -->
<hr/>

<?php

$the_page = ob_get_clean();


echo create_docs_template( $the_page );
