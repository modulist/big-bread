<h1>Ways to Save</h1>

<p>This page will display the list of incentives for a given building identifier (using its zip code as the key).</p>

<h2>Links to:</h2>
<ul>
  <li><?php echo $this->Html->link( 'Get a Quote (popup)', array( 'controller' => 'proposals', 'action' => 'request', 'building_id', 'technology_incentive_id' ), array( 'id' => 'get-a-quote', 'title' => 'Request a Quote' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Incentive Details (popup)', array( 'controller' => 'technology_incentives', 'action' => 'details', 'technology_incentive_id' ), array( 'id' => 'show-details', 'title' => 'Rebate Details' ) ) ?></li>
</ul>
