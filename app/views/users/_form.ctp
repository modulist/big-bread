<?php $show_zip_code = isset( $show_zip_code ) ? $show_zip_code : true ?>
<?php $title = isset( $title ) ? $title : __( 'Let&#146;s create your SaveBigBread account:' ) ?>

<?php if( $title ): ?>
  <h2><?php $title ?></h2>
<?php endif; ?>

<div class="clearfix">
	<div class="grid_3 first">
		<?php echo $this->Form->input( 'User.first_name' ) ?>
	</div>
	<div class="grid_3">
		<?php echo $this->Form->input( 'User.last_name' ) ?>
	</div>
	<div class="grid_3 last">
		<?php echo $this->Form->input( 'User.email' ) ?>
	</div>
</div>
<div class="clearfix">
	<div class="grid_3 first">
		<?php echo $this->Form->input( 'User.password' ) ?>
	</div>
	<div class="grid_3 last">
		<?php echo $this->Form->input( 'User.confirm_password', array( 'type' => 'password' ) ) ?>
	</div>
</div>

<?php if( $show_zip_code ): ?>
  <div class="clearfix">
    <div class="grid_3 first zip-code">
      <?php echo $this->Form->input( 'User.zip_code', array( 'default' => $this->Session->read( 'default_zip_code' ) ) ) ?>
    </div>
    <div class="grid_3 last zip-code-instructions">
      <p><?php __( 'So we can find you rebates and discounts specific to your area.' ) ?></p>
    </div>
  </div>
<?php endif; ?>

  
