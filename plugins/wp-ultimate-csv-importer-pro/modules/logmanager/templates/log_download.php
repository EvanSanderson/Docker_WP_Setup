<?php
		if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

               $ekey   = $_REQUEST['eKey'];
               global $wpdb;
               $res = $wpdb->get_results("select log_message from wp_ultimate_csv_importer_log_values where eventKey = '{$ekey}'");
               
               $myFile = $ekey.".txt";
               $fh = fopen('php://output', 'w') or die("can't open file");
               for($i = 0; $i<count($res); $i++) {
               $stringData = 	$res[$i]->log_message;
               $data = unserialize($stringData);
               #echo '<pre>'; print_r($data[$i]);
               $a1 = isset($data[$i]['SHORTCODES']) ? $data[$i]['SHORTCODES'] : '' ; 
               $a2 = strip_tags($data[$i]['RECORD']);
               $a3 = isset($data[$i]['CATEGORIES']) ? $data[$i]['CATEGORIES'] : '';
               $a4 = isset($data[$i]['TAGS']) ? $data[$i]['TAGS'] : '';
               $a5 = isset($data[$i]['TAXONOMIES']) ? $data[$i]['TAXONOMIES'] : '';
               $a6 = isset($data[$i]['SKU']) ? $data[$i]['SKU'] : '';
               $output = '';  
               if(!empty($a2))  
                    $output .= 'RECORD:  '.$a2;
               if(!empty($a1)) 
                    $output .= 'SHORTCODES:  '.$a1;
               if(!empty($a3)) 
                    $output .= 'CATEGORIES:  '.$a3;
               if(!empty($a4)) 
                    $output .= 'TAGS: '.$a4;
               if(!empty($a6)) 
                    $output .= 'SKU: '.$a6;
               if(!empty($a5)) 
                    $output .= 'TAXONOMIES:' .$a5;
               $output .= "\n";
              # $write = $data[0]['RECORD'];
               fwrite($fh, $output);
               }
               fclose($fh);
               header("Content-Disposition: attachment; filename=\"" . basename($myFile) . "\"");
               header("Content-Type: text/plain");
               header("Connection: close");



?>
