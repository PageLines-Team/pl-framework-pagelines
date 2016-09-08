<?php
/*
 * Template Name: PL Docs: Section API
 */


ob_start();

?>

<h2>Introduction</h2>

<p>PageLines Section system allows developers to use their imagination in creating their own unique sections. These sections can add extra functionality and can also be packaged and given away (or sold) to other PageLines users.</p>

<p>Using this 'API', you can define what kind of content the sections load on the page, and use the option engine to add options directed at that particular sections.</p>

<h3>Example Starter Section</h3>

<p>To help you understand the basic configuration and setup for a section, we've created a basic starter section for you to use and reference.</p>

<p><a href="https://github.com/PageLines-Team/pl-section-starter" class="pl-btn pl-btn-primary pl-btn-large" target="_blank"><i class="pl-icon pl-icon-download"></i> View Starter Section</a></p>

<h2>Setup</h2>

<h3>Section File Structure</h3>

<p>The first part of section development, is setting up your section files.</p>

<p>Sections are supported in a variety of areas; and are used primarily as plugins in your WordPress plugins folder. However, they are also supported inside of child themes.</p>

<p>A basic section will have a folder name.<br/> The folder should be names as follows: <code>pl-section-[section_id]</code>.</p>

<p>Inside the section you will have the primary PHP file that should be named the same as the folder: <code>pl-section-[section_id].php</code>.</p>

<p>If there is a file names style.css inside of the section plugin, this CSS file will be automatically loaded when the section if found on a page.</p>

<p>Aside from this, this base folder can support any number of files and media; just make sure that the section code calls these files appropriately.</p>

<?php
$code = <<<'EOT'
wp-content
└──plugins
    └── pl-section-[section_id]
        ├── pl-section-[section_id].php
        ├── style.css
        ├── readme.md
        └── (other files)
EOT;

echo pl_create_code( $code ); ?>


<h3>Section Headers</h3>

<p>Once you open up the main section PHP file, the first thing you'll see is the section headers. These are the basic information that you use to set up your section and its meta information inside the system.</p>

<?php
$code = <<<'EOT'
/*
  Plugin Name:  PageLines Section [Section Name]
  Description:  [A short description...]
  Author:       [Your Name]
  Author URI:   [Your URL]
  Docs:         [Docs Url]
  Version:      [Version Number e.g. 5.0.0]
  PageLines:    [Section_Class_Name]
  Filter:       [Where to show in the builder: component, basic, advanced, gallery, slider, content, localsocial, wordpress]
  Category:     [category tags (comma separated)]
  Tags:         [standard tags (comma separated)]
  Loading:      [Should this section force frame reload (active or refresh)]
*/
EOT;

echo pl_create_code( $code ); ?>


<ul>
  <li><strong>PageLines Header</strong> Set to the same as the section PHP class name.</li>
  <li><strong>Filter Header</strong> Determines where section is shown in add-new panels.</li>
  <li><strong>Loading Header</strong> If set to refresh, the section will force a frame reload when added to a page.</li>
</ul>

<h3>The Section Class Format</h3>

<p>To control the when and where of the section functionality, PageLines uses a standard PHP class format. Here is the the basic structure, with inline formatting explaining what each component does:</p>

<?php
$code = <<<'EOT'
<?php

/*
  Plugin Name:    PageLines Section My Section
  Version:        5.0.0
  PageLines:      PL_My_Section_Class
*/

/** A PHP Guard to prevent the section from loading if it's not supposed to */
if( ! class_exists('PL_Section') ){
  return;
}

/** The section class extends a standard core PL_Section class */
class PL_My_Section_Class extends PL_Section {

  /** This method runs on every page load on both the admin and front end. Ideal for options and other hooks (ajax) */
  function section_persistent(){ // persistent code and hooks here }

  /** This method runs if a section is placed on a page. This way we can ensure that scripts and styles are only included if need be. */
  function section_styles(){ // styles here }

  /** This method should return an options configuration array for the section */
  function section_opts(){ return array(); }

  /** This is the HTML output that shows on the page for the section */
  function section_template(){ // HTML here }

}

EOT;

echo pl_create_code( $code ); ?>


<p>Now your section is started! Now let's build on this...</p>

<h3>Basic Section Class Attributes</h3>

<p>Since the sections extend a base class, each section gets several standard attributes and methods that can be references in your code:</p>

<?php
$code = <<<'EOT'
$url  = $this->base_url;      // The base URL for the section
$dir  = $this->base_dir;      // The base directory for the section
$id   = $this->id;            // The section ID
$nm   = $this->name;          // The section name
$opt  = $this->opt('key');    // Get the option value for: 'key'
EOT;

echo pl_create_code( $code ); ?>

<h2>Methods</h2>

<h3>Adding Scripts and Styles</h3>

<p>All section scripts and styles should be included using the <code>pl_script</code> and <code>pl_style</code> functions respectively, from within the <code>section_styles</code> method in a section.</p>

<?php
$code = <<<'EOT'
function section_styles(){

  // pl_script( 'unique_id', 'http://url_to_file.js' );
  // pl_style(  'unique_id', 'http://url_to_file.css' );

  pl_script(  $this->id,          plugins_url( 'pl.popthumbs.js', __FILE__ ) );

  pl_script(  'prettyphoto',      plugins_url( 'prettyphoto.min.js', __FILE__ ) );
  pl_style(   'prettyphoto-css',  plugins_url( 'prettyPhoto/css/prettyPhoto.css', __FILE__ ) );

}
EOT;

echo pl_create_code( $code ); ?>


<h3>Adding Hooks &amp; Filters</h3>

<p>Sections can easily use hooks and filters to access other elements of the WordPress system. Add these hooks inside of the <code>section_persistent</code> method.</p>

<?php
$code = <<<'EOT'
function section_persistent(){

  add_filter('the_content', array($this, 'adjust_content'));

}

function adjust_content( $content ){

  // do something...

  return $content;
}
EOT;

echo pl_create_code( $code ); ?>

<h4>AJAX Callbacks</h4>

<p>A typical use of a hook inside of Platform 5 is to create an AJAX callback for a callback binding. To add an AJAX callback, again simply add it to the <code>section_persistent</code> method with the appropriate name.</p>

<?php
$code = <<<'EOT'
function section_persistent(){
  add_filter('pl_binding_' . $this->id, array( $this, 'callback'), 10, 2);
}


function callback( $response, $data ){

  $response['template'] = $this->do_callback( $data['value']);

  return $response;
}
EOT;

echo pl_create_code( $code ); ?>

<h2>Templating</h2>

<h3>Section Template</h3>

<p>The section_template method is what outputs all the HTML that is rendered for your section on the page. </p>

<?php
$code = <<<'EOT'
// This will be output wherever the section is located on the page.
function section_template(){ ?>

 <div class="my-element">Some Text</div>

<?php }
EOT;

echo pl_create_code( $code ); ?>

<p>Great! Now that we know how to output HTML, all we have to do is create some options for users and "bind" them to the HTML output.</p>

<h3>Options</h3>

<p>To add options for any section, we just need to use the section_options method and return a standard options array.</p>

<?php
$code = <<<'EOT'
function section_options(){

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


EOT;

echo pl_create_code( $code ); ?>

<p>Options arrays are a powerful way to control the options for your section and are fully documented in the 'options array' document.</p>

<h3>Bindings</h3>

<p>Once we have options created for the section, all that is left is for us to 'bind' them to the section template. </p>

<p>In PageLines, bindings are done via a very simple data-bind HTML api.</p>

<?php
$code = <<<'EOT'

function section_template(){ ?>
 <!-- This will sync to the value of the option with the 'my_unique_key' key parameter -->
 <div class="my-element" data-bind="pltext: my_unique_key"></div>

<?php }
EOT;

echo pl_create_code( $code ); ?>

<p>Bindings are very powerful and are fully covered in their own document within PageLines developer docs.</p>

<h3>Nested Sections</h3>

<p>Sections can also allow for sections to be nested inside of them. In other words, sections can contain other sections.</p>

<p>And do enable this within a section only requires two lines of code! They are: </p>

<ul>
  <li>A section header of <code>Contain: yes</code></li>
  <li>The function <code>pl_nested_container( $this );</code> inside of <code>section_template</code></li>
</ul>

<p>Something like this:</p>

<?php
$code = <<<'EOT'

<?php
/*
  Plugin Name: My Section
  (other headers)
  Contain:      yes
*/

class PL_Section_MySection extends PL_Section {

  function section_template(){ ?>
    <div class="my-other-section-stuff">
        <?php pl_nested_container( $this ); // render nested sections ?>
      </div>
    </div>
  <?php
  }
}
EOT;

echo pl_create_code( $code ); ?>


<h2>Other Methods</h2>

<h3>Section Head</h3>

<p>If you'd like to output raw HTML into the head of your HTML document (if the section is one the page) then you'll want to use the <code>section_head</code> method.</p>

<?php
$code = <<<'EOT'
function section_head(){
  // This will out put in between your sites <head> tags.
  // For example, adding javascript:
  ?>

  <script>
  jQuery(window).ready(function() {
    // Javascript could go here.
  });
  </script>

}
EOT;

echo pl_create_code( $code ); ?>

<h3>Section Foot</h3>

<p>Likewise if you'd like to output HTML specifically in the page footer. You'll want to use the <code>section_foot</code> method.</p>


<?php

$the_page = ob_get_clean();

echo create_docs_template( $the_page );
