<h1>Dashboard</h1>

<p>Replace this markup with that required for the user dashboard.</p>

<h2>Links to:</h2>
<ul>
  <li><?php echo $this->Html->link( 'Ways to Save', array( 'controller' => 'buildings', 'action' => 'ways_to_save', 'zip_code' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Add Location', array( 'controller' => 'buildings', 'action' => 'add' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Edit Location', array( 'controller' => 'buildings', 'action' => 'edit', 'building_id' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Add/Edit Equipment', array( 'controller' => 'buildings', 'action' => 'equipment', 'building_id' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Redeem a Rebate', array( 'controller' => 'technology_incentives', 'action' => 'redeem' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Profile', array( 'controller' => 'users', 'action' => 'edit' ) ) ?></li>
</ul>
