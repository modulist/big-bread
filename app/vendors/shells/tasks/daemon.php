<?php  
class DaemonTask extends Shell { 
  function execute( $prefix = '' ) {
    echo "Daemonizing the " . $prefix . " process...\n";
    
    //the key the pid is stored with - default to just 'pid' 
    $pidstring = $prefix . '_pid'; 
      
    if( !Cache::read( $pidstring ) ) {
      $pid = getmypid();
      
      echo " --> Writing " . $pidstring . " => " . $pid . " to cache.\n";
      
      Cache::write( $pidstring, $pid );     
    }
    else {
      echo " --> $pidstring already exists in the cache.\n";
      
      $ps = shell_exec( 'ps -o pid -A' ); 
      $ps = explode( "\n", trim( $ps ) ); 
      foreach( $ps as $i => $value ) {
        $ps[$i] = trim( $value ); 
      } 
      if( in_array( Cache::read( $pidstring ), $ps ) ) { 
        exit( "already got a process running\n" ); 
      }
      else { 
        echo "replacing stale pid\n"; 
        Cache::write( $pidstring, getmypid(), 3600 );     
      } 
    } 
  } 
} 
