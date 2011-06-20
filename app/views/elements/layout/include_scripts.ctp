<!-- Include universal scripts -->
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js' ) . "\n" ?>
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js' ) . "\n" ?>
<?php echo $this->Html->script( 'application' ) ?>
<?php echo $this->Html->script( array(
  'jquery/jquery.fancybox-1.3.4.pack.js',
  'jquery/jquery.autotab-1.1b.js',
  'jquery/jquery.tipsy.js',
) ) ?>

<!-- Include any page-specific scripts -->
<?php if( file_exists( WWW_ROOT . 'js/views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) . '.js' ) ): ?>
  <?php echo $this->Html->script( 'views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) ) ?>
<?php endif; ?>

<?php if( preg_match( '/^(www\.)?bigbread.net$/', env( 'HTTP_HOST' ) ) ): ?>
  <!-- Google Analytics -->
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-22811249-1']);
    _gaq.push(['_trackPageview']);
  
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
<?php endif; ?>
