<!DOCTYPEhtml>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body>
  
<div id="wrapper">
  <!-- BEGIN COMMON HEADER -->
  <?php echo $this->element( 'layout/header' ) ?>
  <!-- END COMMON HEADER -->

  <?php echo $this->element( 'layout/header_rebate_bar' ) ?>
  
  <div id="pagebody"> 				
    <div id="bodymain">
  
      <div id="sidebar">
        <div id="questionnaire">
          <h2>Questionnaire</h2>
          <ul>
            <li class="first"><?php echo $this->Html->link( __( 'General Information', true ), array( 'class' => 'active' ) ) ?></li>
            <li><?php echo $this->Html->link( __( 'Demographics &amp; Behavior', true ) ) ?></li>
            <li><?php echo $this->Html->link( __( 'Equipment Listing', true ) ) ?></li>
            <li><?php echo $this->Html->link( __( 'Building Characteristics', true ) ) ?></li>
            <li class="last"><?php echo $this->Html->link( __( 'Insulation, Windows, Doors', true ) ) ?></li>
          </ul>
        </div>
        
        <div id="getstart">
          <h2><?php __( 'Let\'s Get Started' ) ?></h2>
          <?php echo $this->Html->image( 'DownloadQ.png' ) ?>
        </div>
      </div>
  
      <div id="content">
        <!-- BEGIN  FLASH MESSAGES -->
        <?php echo $this->element( 'layout/flash_messages' ) ?>
        <!-- END  FLASH MESSAGES -->
        
        <!-- BEGIN PAGE CONTENT -->
        <?php echo $content_for_layout ?>
        <!-- END PAGE CONTENT -->
      </div>
      
    </div>
  </div>
  
  <!-- BEGIN COMMON FOOTER -->
  <?php echo $this->element( 'layout/footer' ) ?>
  <!-- END COMMON FOOTER -->
</div>
  
<?php echo $this->element( 'layout/include_scripts' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
