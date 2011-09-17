<h1>Incentive Details</h1>

<p>This page displays the details of a given incentive.</p>

<h2>Links to:</h2>
<ul>
  <li><?php echo $this->Html->link( 'Get a Quote', array( 'controller' => 'proposals', 'action' => 'request', 'building_id', 'technology_incentive_id' ), array( 'id' => 'get-a-quote', 'title' => 'Request a Quote' ) ) ?></li>
  <li><?php echo $this->Html->link( 'Printable Rebate Form', array( 'controller' => 'technology_incentive', 'action' => 'print' ) ) ?></li>
</ul>
