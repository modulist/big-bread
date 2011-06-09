Attached is the link validation report for <?php echo date( DATE_FORMAT_LONG_WITH_DAY ) ?>.

Highlights:
===========
Environment: <?php echo Configure::read( 'Env.name' ) ?> (<?php echo Configure::read( 'Env.domain' ) ?>)
Incentives Checked: <?php echo $summary['incentive_count'] . "\n" ?>
Links Validated: <?php echo $summary['link_count'] . "\n" ?>
Status Counts:
<?php foreach( $summary['status_counts'] as $status => $count ): ?>
  <?php echo "\t" . $status . ": " . $count . "\n" ?>
<?php endforeach; ?>
