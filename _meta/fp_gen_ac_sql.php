<?php

function uuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    // 32 bits for "time_low"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

    // 16 bits for "time_mid"
    mt_rand( 0, 0xffff ),

    // 16 bits for "time_hi_and_version",
    // four most significant bits holds version number 4
    mt_rand( 0, 0x0fff ) | 0x4000,

    // 16 bits, 8 bits for "clk_seq_hi_res",
    // 8 bits for "clk_seq_low",
    // two most significant bits holds zero and one for variant DCE1.1
    mt_rand( 0, 0x3fff ) | 0x8000,

    // 48 bits for "node"
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}

function parse( $tech, $file ) {
  $src_file = fopen( dirname( __FILE__ ) . '/' . $file, 'r' );
  $fields = array();
  
  while( !feof( $src_file ) ) {
    $manuf = trim( fgets( $src_file ) );
    $manuf = preg_replace( '/,+$/', '', $manuf );
    $manuf = preg_replace( '/["]/', '', $manuf );
    
    if( !empty( $manuf ) ) {
      $record = array(
        'id'       => '\'' . uuid() . '\'',
        'name'     => '\'' . trim( $manuf ) . '\'',
        'created'  => 'NOW()',
        'modified' => 'NOW()',
      );
      
      array_push( $fields, $record );
    }
  }
  
  fclose( $src_file );
  
  return $fields;
}

$hp_tech_id = 'c48c7874-6f7f-11e0-be41-80593d270cc9';
$ac_tech_id = 'c48c6d7a-6f7f-11e0-be41-80593d270cc9';
$wh_tech_id = 'c48c9944-6f7f-11e0-be41-80593d270cc9';

$tech_codes = array(
  'ac' => 'Air Conditioner',
  'hp' => 'Heat Pump',
  'wh' => 'Water Heater',
);
$files = array(
  'ac' => 'fp_ac_manuf.csv',
  'hp' => 'fp_hp_manuf.csv',
  'wh' => 'fp_wh_manuf.csv',
);


$sql_file  = fopen( dirname( __FILE__ ) . '/__script.sql', 'a' );
$processed = array();
$sql       = '';
foreach( $files as $tech => $file ) {
  $records = parse( $tech, $file );
  
  $sql .= "\n" . '-- ' . $tech_codes[$tech] . ' Manufacturers' . "\n";
  foreach( $records as $fields ) {
    $uuid = $fields['id'];
    
    # Insert new manufacturer record
    if( !array_key_exists( $fields['name'], $processed ) ) {
      $sql .= 'INSERT INTO equipment_manufacturers( id, name, created, modified ) ' . "\n" .
              'VALUES( ' . join( ',', array_values( $fields ) ) . ' );' . "\n";
           
      $processed[$fields['name']] = $uuid;
    }
    else {
      $sql .= '-- Skipping ' . $fields['name'] . ' (already exists)' . "\n";
      # Reuse the existing id when inserting the tech record
      $uuid = $processed[$fields['name']];
    }
    
    # Join the manufacturer to the tech
    $sql .= 'INSERT INTO equipment_manufacturers_technologies( equipment_manufacturer_id, technology_id, created, modified ) ' . "\n" .
            'VALUES( ' . $uuid . ', \'' . ${$tech . '_tech_id'} . '\', NOW(), NOW() );' . "\n";
  }
  
}

fwrite( $sql_file, $sql );
fclose( $sql_file );
