<?php
/*
 * Template Name: PL Docs: Components
 */


ob_start();
?>

<h2>Introduction</h2>
  <p>PageLines Platform 5 has several utility CSS components designed to increase development speed and consistency.</p>

  <p>The components that are included are meant to be very simple and non intrusive, and reflect common UX elements present in nearly every extension.</p>

  <p>Components and handling that is included is:</p>

  <ul>
    <li>12-Column Responsive Grid with multiple breakpoint formats</li>
    <li>Button Components and Styles</li>
    <li>Form Components and Styles</li>
    <li>Color Scheme Handling</li>
    <li>Alignments Handling</li>
    <li>Icons Library</li>
  </ul>

<h2>Components</h2>
<h3>Grid</h3>

<p>The basic grid system consists of a 12-column grid. To employ it simply wrap the columns in a div with class of <code>pl-row</code>.</p>
<p>Add a class to each column associated with the amount of columns of 12 you've like it to take.</p>

<div class="pl-row grid-example">
  <div class="pl-col-sm-6"><div class="wrap">.pl-col-sm-6</div></div>
  <div class="pl-col-sm-6"><div class="wrap">.pl-col-sm-6</div></div>
  <div class="pl-col-sm-4"><div class="wrap">.pl-col-sm-4</div></div>
  <div class="pl-col-sm-4"><div class="wrap">.pl-col-sm-4</div></div>
  <div class="pl-col-sm-4"><div class="wrap">.pl-col-sm-4</div></div>
  <div class="pl-col-sm-3"><div class="wrap">.pl-col-sm-3</div></div>
  <div class="pl-col-sm-3"><div class="wrap">.pl-col-sm-3</div></div>
  <div class="pl-col-sm-3"><div class="wrap">.pl-col-sm-3</div></div>
  <div class="pl-col-sm-3"><div class="wrap">.pl-col-sm-3</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
  <div class="pl-col-sm-2"><div class="wrap">.pl-col-sm-2</div></div>
</div>

<p>Platform includes a simple responsive grid system that includes multiple break points depending on the classes used.</p>
<ul>
  <li><code>.pl-col-lg-</code> Breaks at <strong>1200px</strong></li>
  <li><code>.pl-col-sm-</code> Breaks at <strong>768px</strong></li>
  <li><code>.pl-col-xs-</code> Doesn't break, even on small resolutions</li>
</ul>

<p>The following grid will have 4 columns on large screens, 3 columns on smaller screens and 2 columbs on mobile.</p>
<div class="pl-row grid-example">
  <div class="pl-col-lg-3 pl-col-sm-4 pl-col-xs-6"><div class="wrap">.pl-col-lg-3 .pl-col-sm-4 .pl-col-xs-6</div></div>
  <div class="pl-col-lg-3 pl-col-sm-4 pl-col-xs-6"><div class="wrap">.pl-col-lg-3 .pl-col-sm-4 .pl-col-xs-6</div></div>
  <div class="pl-col-lg-3 pl-col-sm-4 pl-col-xs-6"><div class="wrap">.pl-col-lg-3 .pl-col-sm-4 .pl-col-xs-6</div></div>
  <div class="pl-col-lg-3 pl-col-sm-4 pl-col-xs-6"><div class="wrap">.pl-col-lg-3 .pl-col-sm-4 .pl-col-xs-6</div></div>
</div>

<hr/>

<h3>Buttons</h3>

<p>PageLines Platform 5 provides the basics for creating buttons. Along with controlling their size and coloring.</p>

<h4>Button Colors</h4>
<div class="btns-example">
<span class="pl-btn pl-btn-default">Default</span>
<span class="pl-btn pl-btn-primary">Primary</span>
<span class="pl-btn pl-btn-success">Success</span>
<span class="pl-btn pl-btn-info">Info</span>
<span class="pl-btn pl-btn-warning">Warning</span>
<span class="pl-btn pl-btn-danger">Danger</span>
<span class="pl-btn pl-btn-link">Link</span>
<span class="pl-btn pl-btn-ol-black">Outline Black</span>
<span class="pl-btn pl-btn-ol-white">Outline White</span>
</div>

<?php
$code = <<<'EOT'
<span class="pl-btn pl-btn-default">Default</span>
<span class="pl-btn pl-btn-primary">Primary</span>
<span class="pl-btn pl-btn-success">Success</span>
<span class="pl-btn pl-btn-info">Info</span>
<span class="pl-btn pl-btn-warning">Warning</span>
<span class="pl-btn pl-btn-danger">Danger</span>
<span class="pl-btn pl-btn-link">Link</span>
<span class="pl-btn pl-btn-ol-black">Outline Black</span>
<span class="pl-btn pl-btn-ol-white">Outline White</span>
EOT;

echo pl_create_code( $code ); ?>

<h4>Button Sizes</h4>

<div class="btns-example">
<span class="pl-btn pl-btn-default pl-btn-xs">Extra Small</span>
<span class="pl-btn pl-btn-default pl-btn-sm">Small</span>
<span class="pl-btn pl-btn-default pl-btn-st">Standard</span>
<span class="pl-btn pl-btn-default pl-btn-lg">Large</span>
</div>

<?php
$code = <<<'EOT'
<span class="pl-btn pl-btn-default pl-btn-xs">Extra Small</span>
<span class="pl-btn pl-btn-default pl-btn-sm">Small</span>
<span class="pl-btn pl-btn-default pl-btn-st">Standard</span>
<span class="pl-btn pl-btn-default pl-btn-lg">Large</span>
EOT;

echo pl_create_code( $code ); ?>

<hr/>

<h3>Forms</h3>

<p>PageLines Platform 5 has some very basic handling and configuration used for form elements.</p>

<p>For standardized formatting just add a class of <code>pl-form-control</code> to any standard form element.</p>

<p><label class="pl-form-label">Text Input</label><input type="text" class="pl-form-control" placeholder="Text Input" /></p>

<p><label class="pl-form-label">Textarea Input</label><textarea class="pl-form-control" placeholder="Textarea Input" /></textarea></p>

<p><label class="pl-form-label">Select Input</label><select class="pl-form-control"><option>Option 1</option><option>Option 2</option><option>Option 3</option></select></p>

<p><input type="submit" value="Submit" /></p>

<?php
$code = <<<'EOT'
<p>
  <label class="pl-form-label">Text Input</label>
  <input type="text" class="pl-form-control" placeholder="Text Input" />
</p>

<p>
  <label class="pl-form-label">Textarea Input</label>
  <textarea class="pl-form-control" placeholder="Textarea Input" /></textarea>
</p>

<p>
  <label class="pl-form-label">Select Input</label>
  <select class="pl-form-control">
    <option>Option 1</option>
    <option>Option 2</option>
    <option>Option 3</option>
  </select>
</p>

<p>
  <input type="submit" value="Submit" />
</p>
EOT;

echo pl_create_code( $code ); ?>


<h2>Handling Classes</h2>

<h3>Color Schemes</h3>

<p>Platform 5 supports three basic color schemes: default, dark text, and light text. This is the easiest way to accomodate various background colors and background images.</p>

<ul>
  <li><code>.pl-scheme-default</code> Default theme color scheme</li>
  <li><code>.pl-scheme-dark</code> Dark colored text and black based elements (borders, etc...)</li>
  <li><code>.pl-scheme-light</code> Light colored text and white based elements (borders, etc...)</li>
</ul>

<div class="scheme-examples">
  <div class="scheme-example pl-scheme-dark">
    <div class="header">Dark Color Scheme</div>
    <div><a href="#">Basic Link</a></div>
  </div>

  <div class="scheme-example pl-scheme-light">
    <div class="header">Light Color Scheme</div>
    <div><a href="#">Basic Link</a></div>
  </div>
</div>

<?php
$code = <<<'EOT'
<div class="scheme-example pl-scheme-dark">
  <div class="header">Dark Color Scheme</div>
  <div><a href="#">Basic Link</a></div>
</div>

<div class="scheme-example pl-scheme-light">
  <div class="header">Light Color Scheme</div>
  <div><a href="#">Basic Link</a></div>
</div>
EOT;

echo pl_create_code( $code ); ?>


<h3>Text Alignment</h3>

<p>PageLines supports standard text alignment classes that sections use in various ways to align things.  They are simply:</p>

<ul>
  <li><code>.pl-alignment-left</code></li>
  <li><code>.pl-alignment-center</code></li>
  <li><code>.pl-alignment-right</code></li>
</ul>

<div class="alignment-examples">
  <div class="pl-alignment-left">Left</div>
  <div class="pl-alignment-center">center</div>
  <div class="pl-alignment-right">right</div>
</div>

<h3>Icons</h3>

<p>PageLines supports the full <a href="https://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome icon library</a>. To use them</p>

<ul>
  <li><code>.pl-icon</code> Base icon class</li>
  <li><code>.pl-icon-[key]</code> Add the key for the icon to the element</li>
</ul>

<div class="icons-examples">
  <div>
    <i class="pl-icon pl-icon-pagelines"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-2x"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-3x"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-4x"></i>
  </div>
  <div>
    <i class="pl-icon pl-icon-refresh pl-icon-spin"></i>
    <i class="pl-icon pl-icon-refresh pl-icon-2x pl-icon-spin"></i>
    <i class="pl-icon pl-icon-refresh pl-icon-3x pl-icon-spin"></i>
  </div>
  <div>
    <i class="pl-icon pl-icon-facebook"></i>
    <i class="pl-icon pl-icon-twitter"></i>
    <i class="pl-icon pl-icon-random"></i>
    <i class="pl-icon pl-icon-cog"></i>
    <i class="pl-icon pl-icon-code"></i>
    <i class="pl-icon pl-icon-comment"></i>
  </div>
  
</div>
<?php
$code = <<<'EOT'
<div class="icons-examples">
  <div>
    <i class="pl-icon pl-icon-pagelines"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-2x"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-3x"></i>
    <i class="pl-icon pl-icon-pagelines pl-icon-4x"></i>
  </div>
  <div>
    <i class="pl-icon pl-icon-refresh pl-icon-spin"></i>
    <i class="pl-icon pl-icon-refresh pl-icon-2x pl-icon-spin"></i>
    <i class="pl-icon pl-icon-refresh pl-icon-3x pl-icon-spin"></i>
  </div>
  <div>
    <i class="pl-icon pl-icon-facebook"></i>
    <i class="pl-icon pl-icon-twitter"></i>
    <i class="pl-icon pl-icon-random"></i>
    <i class="pl-icon pl-icon-cog"></i>
    <i class="pl-icon pl-icon-code"></i>
    <i class="pl-icon pl-icon-comment"></i>
  </div>
</div>
EOT;

echo pl_create_code( $code ); ?>


<?php 

$the_page = ob_get_clean(); 

echo create_docs_template( $the_page );