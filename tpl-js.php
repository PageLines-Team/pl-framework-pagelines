<?php
/*
 * Template Name: PL Docs: Section Javascript
 */


ob_start();

?>

<h2>Introduction</h2>

<p>To enable real-time editing of javascript driven elements, such as carousels or sliders, there are special considerations in Platform 5. This is because the javascript has to be made aware of new elements and rerendered.</p>

<p>To get around this problem, PageLines has engineered some utilities to. Specifically, trigger classes and simple rerendering functions.</p>

<h3>How it works</h3>

<p>The basic process for working with javascript elements works like this:</p>

<ol>
  <li>After section is rendered, trigger javascript script for element. </li>
  <li>Use a render function duplicate the 'synced' output from the system.</li>
  <li>Apply the plugin script to the duplicated item.</li>
  <li>Every time the settings changed for the section, destroy the rendered section and repeat the first three steps</li>
</ol>

<h3>Starter Section</h3>

<p>The starter section has a javascript file included that has the basic structure for working with javascript in PageLines.</p>

<p><a href="https://github.com/PageLines-Team/pl-section-starter" class="pl-btn pl-btn-primary pl-btn-large" target="_blank"><i class="pl-icon pl-icon-download"></i> View Starter Section</a></p>

<h2>Setting Up</h2>

<h3>Javascript File</h3>

<p>The first step is to include the javascript file and structure the js so that it fires after the section is setup:</p>

<p>To include the file, simply use the <code>pl_script</code> function within the <code>section_styles</code> method of the section class.</p>

<?php
$code = <<<'EOT'
/**
 * Include extra scripts and styles here
 * Use the pl_script and pl_style functions (which enqueues the files)
 */
function section_styles(){

  /** Include the sample script */
  pl_script( $this->id, plugins_url( 'starter.js', __FILE__ ) );

}
EOT;

echo pl_create_code( $code ); ?>

<h3>Structuring the Javascript File</h3>

<p><strong>jQuery Namespace Wrapper</strong> Note that we wrap the entire file in a wrapper designed to contain the jQuery namespace and prevent leakages between scripts.</p>

<p><strong>template_ready</strong> The <code>template_ready</code> event is designed to fire on the section wrapper after it is loaded and whenever an element with the <code>.pl-trigger</code> class changes. This allows you to rerender based on user option changes.</p>

<p><strong>plRenderItem</strong> The <code>plRenderItem()</code> function will scan the entire section for items with the <code>pl-render-item</code> class. If it finds, them it will duplicate the item and use it to apply any scripts (e.g. a jQuery plugin).</p>

<p><strong>.loaded</strong> Optionally you can use a loaded class guard to prevent scripts from being applied to the same elements multiple times. This can happen if the template_ready event fires multiple times for whatever reason.</p>

<?php
$code = <<<'EOT'
!function ($) {

  /** Set up initial load and load on option updates (.pl-trigger will fire this) */
  $( '.pl-sn-starter' ).on('template_ready', function(){

    $.plStarterSection.init( $(this) )

  })

  /** A JS object to encapsulate functions related to the section */
  $.plStarterSection = {

    init: function( section ){

      var that       = this

      /**
       * plRenderItem()
       * Use a wrapper to look for and clone elements with the .pl-render-item class
       * This prevents the binding code from getting confused by the slider code
       *
       * (If it finds one already there, remove it and create a new one)
       */
      var rendered   = plRenderItem( section )

      /** Apply the JS to the element */
      rendered
        .not('.loaded')
        .addClass('do-something-here')  // Here is where you'd apply any scripts
        .addClass('loaded')             // Use a loaded class to prevent things triggering multiple times ()

    }
  }

/** end of jQuery wrapper */
}(window.jQuery);
EOT;

echo pl_create_code( $code ); ?>

<h3><code>pl-trigger</code> Class</h3>

<p>Apply a class of pl-trigger to elements that, when their binding values change, should cause a rerendering of the section (via JS).</p>

<p>A common example might be the wording inside a slide from a rendered section, this will require a rerender because the users won't see the change until it is rerendered.</p>

<?php

$the_page = ob_get_clean();

echo create_docs_template( $the_page );
