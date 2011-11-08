<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<body class="layout-default layout-default-login <?php echo Inflector::underscore( $this->name ) . ' ' . Inflector::underscore( $this->action ) ?><?php echo $this->Session->check( 'Auth.User' ) ? ' authenticated' : false ?>">
  
<div id="wrapper" class="container_12">
  <header class="clearfix"><div class="header">
    <?php echo $this->element( 'layout/header' ) ?>
  </div></header><!-- #header -->
  
  <section><div id="page_content"> 				
    <div id="bodymain" class="clearfix">
      <aside><div id="sidebar">
        <!-- page-specific sidebar -->
        <?php if( file_exists( ELEMENTS . 'layout/sidebar/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) . '.ctp' ) ): ?>
          <?php echo $this->element( 'layout/sidebar/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) ) ?>
        <?php endif; ?>
      </div</aside> <!-- #sidebar -->
      
      <div id="content" class="grid_6 clearfix">
        <?php echo $this->element( 'layout/flash_messages' ) ?>
        
        <?php echo $content_for_layout ?>
      </div> <!-- #content -->
      
    </div> <!-- #bodymain -->
  </div></section> <!-- #page_content -->
  
  <footer id="footer"><div class="footer">
    <?php echo $this->element( 'layout/footer' ) ?>
  </div></footer> <!-- #footer -->
</div> <!-- #wrapper -->
  
<?php echo $this->element( 'layout/include_scripts' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
