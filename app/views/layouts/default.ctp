<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="no-js onecolumn">
  
<div id="wrapper">
  <header>
    <?php echo $this->element( 'layout/header' ) ?>
  </header><!-- #header -->
  
  <section id="page_content"> 				
    <div id="bodymain">
      <div id="content">
        <?php echo $this->element( 'layout/flash_messages' ) ?>
        
        <?php echo $content_for_layout ?>
      </div> <!-- #content -->
      <div class="clear"></div>
      
    </div> <!-- #bodymain -->
  </section> <!-- #page_content -->
  
  <footer>
    <?php echo $this->element( 'layout/footer' ) ?>
  </footer> <!-- #footer -->
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
