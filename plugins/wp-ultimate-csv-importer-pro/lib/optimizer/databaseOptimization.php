<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
$dboptimizeObj = new WPImporterPro_DBOptimizer();
$dboptimizeObj->wipro_dboptimizer($_POST);
?>
