<?php
/*
 * Template Name: PL Docs: Theming
 */


ob_start();
?>

<h2>Introduction</h2>

<p>Platform 5 is designed to work seamlessly with most WordPress themes. But it also has a lot of tools built in for expanding on a typical themes functionality within the system.</p>

<p>Here we will cover the following:</p>

<ul>
  <li><strong>Setup and Structure</strong> Setting up your themes and child themes</li>
  <li><strong>Header/Footer</strong> Making a theme header and footer drag and drop</li>
  <li><strong>Page Templates</strong> Template scope and adding real time options to a theme page template</li>
</ul>

<hr />

<h3>Example Child Theme</h3>

<p>To help you understand child theming, we've made the pagelines.com child theme publicy available. Feel free to use this as a starter and for reference.</p>

<p><a href="https://github.com/PageLines-Team/pl-framework-pagelines" class="pl-btn pl-btn-primary pl-btn-large" target="_blank"><i class="pl-icon pl-icon-download"></i> PageLines.com Child Theme</a></p>

<hr />

<h3>Theme Structure</h3>

<p>For most use scenarios, it is likely preferable to create a PageLines Framework child theme as opposed to a new base theme to work with Platform 5.</p>

<p>This is because the base theme requires many files and functions that aren't required in child themes; and most functionality is achievable using a child theme alone.</p>

<p>The file structure for child themes looks like this:</p>
<?php
$code = <<<'EOT'
wp-content
└──themes
    └── pl-framework
    └── pl-framework-[framework_id]
        ├── functions.php
        ├── style.css (Note: this includes config and references to parent theme)
        ├── screenshot.png
        ├── tpl-[template_id].php
        ├── readme.md
        └── (other files)
EOT;

echo pl_create_code( $code ); ?>

<hr />

<h3>Theme Config Headers</h3>

<p>To properly setup your child theme, you need to add configuration headers inside of the <code>style.css</code> document. These headers look like this:</p>

<?php
$code = <<<'EOT'
/*
  Theme Name:   [Child Theme Name]
  Theme URI:    [Child Theme URL]
  Description:  [Child Theme Description]
  Author:       [Author Name]
  Author URI:   [Author URL]
  Version:      [Version e.g. 5.0.0]
  Text Domain:  [Text Domain Slug e.g. pagelines]
  Tags:         [Child Theme Tags]
  Category:     [Child Theme Categories]
  Template:     pl-framework
*/
EOT;

echo pl_create_code( $code ); ?>


<hr />

<h2>Theme Head &amp; Footer</h2>

<p>If you are creating a new parent theme, you will need to add a special hook to your header.php and footer.php to enable your theme header and footer with drag and drop functionality. Luckily this is simple. </p>

<p>To add drag and drop to these areas you'll need the <code>pl_template_hook</code> function. Here is what the header and footer inside of PL Framework look like: </p>

<?php
$code = <<<'EOT'
/** header.php This code is inside header.php of PL Framework */
<?php pl_standard_head( pl_edit_head() ); ?>

/** footer.php This code is inside footer.php of PL Framework */
<?php pl_standard_foot( pl_edit_foot() ); ?>
EOT;

echo pl_create_code( $code ); ?>

<p>Note that the drag and drop functionality is create primary through the <code>pl_edit_head();</code> and <code>pl_edit_foot();</code> function which in this case tells Platform 5 where to output the header and footer content.</p>

<p><code>pl_standard_head()</code> and <code>pl_standard_foot()</code> are used to output standard wrapper HTML that you might find in most themes.</p>

<h2>Page Templates</h2>

<p>Platform 5 has robust support for native WordPress templates. In that, it supports all standard WordPress page template functionality and adds additional functions for including sections and real-time options in them well.</p>

<p>
<strong>Note:</strong> Page templates in use with Platform do NOT require you include the <code>get_header()</code> and <code>get_footer()</code> functions.
</p>

<h2>Adding Real Time Options</h2>

<p>Options can be added onto the 'content section' on any page template using Platform 5. To do this simply pass in an option array to the <code>pl_add_static_settings()</code> function and then use PageLines bindings to render them in the template. Here is an example from the 404 template in PageLines Framework:</p>

<?php
$code = <<<'EOT'
/**
 * Example: Adding real time options with pl_add_static_settings()
 * Add real time options to the page template content section on any page template
 */
<?php

/** Create Page Template Option Array */
$opts = array(
  array(
    'key'      => 'four04_message',
    'type'     => 'text',
    'default'  => __('404!', 'pagelines'),
    'title'    => __( 'Edit 404 Message', 'pagelines' ),
  ),
);

/** Send the option array to Platform 5 system */
pl_add_static_settings( $opts );

?>

<div class="pl-content-area">
  <div class="notfound boomboard">
    <div class="boomboard-pad">
      <!-- Bind the option text to the 404 header here -->
      <h2 data-bind="text: four04_message"></h2>
      <p><?php _e('Sorry, This Page Does not exist.', 'pagelines');?></p>
      
    </div>
  </div>
</div>

EOT;

echo pl_create_code( $code ); ?>

<h2>Including Sections In Templates</h2>

<p>To make use of full section designs within page templates, PageLines provides some simple utitilies to make including them and setting their defaults easy.</p>

<p>Below is an example of including the splashup section within a page template. You can add your own HTML and other elements as usual anywhere else you'd like on the template.</p>

<?php
$code = <<<'EOT'
/**
 * Example: pl_get_section function
 * Add this anywhere within a page template to include a section
 */
$default_settings = array(
  'header'                => 'Platform 5', 
  'subheader'             => 'Insanely-Simple Editing for WordPress', 
  'logo'                  => get_stylesheet_directory_uri() . '/images/pl-logo.png
); 

// format: pl_get_section( array( 'section' => [section_id], 'id' => [any_unique_id], 'settings' => [default_settings (array)]))

echo pl_get_section( array( 'section' => 'splashup', 'id' => 'homesplash_321', 'settings' => $default_settings ) );
EOT;

echo pl_create_code( $code ); ?>

<p><strong>Note:</strong> When using the <code>pl_get_section</code> function and <code>[pl_section]</code> shortcodes, the ID is used to find and refer to the section data. Therefore, using the same ID on different sections will give you the same data. This can be useful if you'd like to sync sections across many pages.</p>


<?php 

$the_page = ob_get_clean(); 

echo create_docs_template( $the_page );