<div id="messages" class="grid_9">
	<h1><?php __( 'Let&#146;s find rebates in your area' ) ?></h1>
	<p><?php __( 'First, you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.' ) ?></p>
</div>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'value' => UserType::OWNER ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>
  <?php echo $this->Form->input( 'WatchedTechnology.selected', array( 'type' => 'hidden', 'value' => join( ',', $this->data['WatchedTechnology']['selected'] ) ) ) ?>
  
	<!-- my interests -->
	<div id="my-interests" class="grid_9">
		<h2><?php __( 'What are you interested in?' ) ?></h2>
	  <p class="instructions">
	  	<?php __( 'Select as many categories of rebates as you like by clicking on the stars below. You can always change this later.' ) ?>
	  </p>
		<div class="my-interests-grid clearfix">
	  	<?php foreach( $watchable_technologies as $column => $items ): ?>
        <div class="grid_3">
          <?php foreach( $items as $group ): ?>
              <h4><?php echo h( $group['TechnologyGroup']['title'] ) ?></h4>
              <ul>
                <?php foreach( $group['Technology'] as $technology ): ?>
                  <li<?php echo in_array( $technology['id'], $this->data['WatchedTechnology']['selected'] ) ? ' class="active"' : false ?>>
                    <?php echo $this->Html->link( h( $technology['name'] ), '#', array( 'data-watch-technology-id' => $technology['id'] ) ) ?>
                  </li>
                <?php endforeach; ?>
              </ul>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
	  </div><!-- /my interests grid -->
	</div><!-- /my interests -->

  <div id="user-registration" class="grid_9">
  	<?php echo $this->element( '../users/_form' ) ?>
  </div>

<?php echo $this->Form->end( __( 'Let\'s go!', true ) ) ?>
