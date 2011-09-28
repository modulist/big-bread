<?php echo $this->Html->link( 'Dashboard', array( 'action' => 'dashboard' ) ) ?>

<!-- Messaging area -->

<div id="messages">
	<h1>Let&#146;s find rebates in your area</h1>
	<p>First,  you&#146;ll have to help us out by letting us know what kinds of rebates you&#146;re interested in.</p>
</div>

<?php echo $this->Form->create( 'User', array( 'action' => 'register' ) ) ?>
  <?php echo $this->Form->input( 'User.user_type_id', array( 'type' => 'hidden', 'value' => UserType::OWNER ) ) ?>
  <?php echo $this->Form->input( 'User.invite_code', array( 'type' => 'hidden' ) ) ?>
  
	<!-- my interests -->
	<div id="my-interests">
		<h2>My Interests</h2>
	  <p class="instructions">
	  	Select as many categories of rebates as you like by clicking on the stars below. 
	  </p>
		<div class="my-interests-grid clearfix">
	  	<div class="column-first grid_3">
	    	<h4>Heating and Cooling</h4>
	      <ul>
	      	<li class="active"><a href="#">Air conditioner</a></li>
	      	<li><a href="#">Boiler</a></li>
	      	<li><a href="#">Furnace</a></li>
	      	<li><a href="#">Heat Pump</a></li>
	      	<li><a href="#">Space heaters</a></li>
	      	<li><a href="#">Ducts</a></li>
	      </ul>
	      <h4>Building shell</h4>
	      <ul>
	      	<li><a href="#">Windows</a></li>
	      	<li><a href="#">Doors</a></li>
	      	<li><a href="#">Roof</a></li>
	      </ul>
	    </div>
	  	<div class="column-middle grid_3">
	    	<h4>Kitchen</h4>
	      <ul>
	      	<li><a href="#">Refrigerator</a></li>
	      	<li class="active"><a href="#">Freezer</a></li>
	      	<li><a href="#">Range/cooktop/oven</a></li>
	      	<li class="active"><a href="#">Dishwasher</a></li>
	      </ul>
	    	<h4>Laundry</h4>
	      <ul>
	      	<li><a href="#">Washer</a></li>
	      	<li><a href="#">Dryer</a></li>
	      </ul>
	    </div>
	  	<div class="column-last grid_3">
	    	<h4>Hot Water</h4>
	      <ul>
	      	<li><a href="#">Water heater</a></li>
	      	<li><a href="#">Solar water heater</a></li>
	      </ul>
	    	<h4>Lighting</h4>
	      <ul>
	      	<li><a href="#">Light bulbs</a></li>
	      	<li><a href="#">Light fixtures</a></li>
	      </ul>
	    </div>
	  </div>
	</div><!-- /my interests-->

  <div id="user-registration">
  	<?php echo $this->element( '../users/_form' ) ?>
  </div>

<?php echo $this->Form->end( 'Let\'s go!' ) ?>

<?php echo $this->Html->link( 'Dashboard', array( 'action' => 'dashboard' ) ) ?>

