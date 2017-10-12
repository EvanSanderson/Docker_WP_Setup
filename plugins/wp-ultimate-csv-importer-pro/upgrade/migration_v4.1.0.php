<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
?>
<div align=center style="padding-top:220px;">
        <form name="upgrade_to_latest" method="post">
               <div style ='text-align:center;margin:0;color:red;font-size:smaller;'> <?php echo __('Warning: This is 4.3.0 version, dont try in live instance and take proper backup to proceed upgrading.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>
                <label style="font-size:2em;" id="step1"><?php echo __('Upgrade to Latest Version 4.3.0',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                <input type="submit" class="btn btn-primary btn-sm" name="upgrade" id="upgrade" value="<?php echo __('Click Here',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
        </form>
        <form name="goto_plugin_page" method="post" action="admin.php?page=<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/index.php&__module=settings">
                <label style="font-size:2em;display:none;" id='upgrade_state'><?php echo __('Upgrade is inprogress...',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                <input type="submit" style="display:none;" class="btn btn-success" name="gotopluginpage" id="gotopluginpage" value="<?php echo __('Goto Plugin Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
        </form>
</div>
<?php
//print_r($_POST);die();
if (isset($_POST['upgrade'])) { ?>
        <script>
                document.getElementById('step1').style.display = 'none';
                document.getElementById('upgrade').style.display = 'none';
                document.getElementById('upgrade_state').style.display = '';
                document.getElementById('gotopluginpage').style.display = '';
        </script>


<?php
global $wpdb;


// Modify shortcode in manageshortcodes
        if (@mysql_num_rows(mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_manageshortcodes` LIKE 'shortcode'")) != 1) {
                $sql1 = "ALTER TABLE wp_ultimate_csv_importer_manageshortcodes MODIFY `shortcode` VARCHAR(110);";
                $wpdb->query($sql1);
        }

// Modify csvname in dashboard manager
        $check_csvname = $wpdb->query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'csv_name'");
        if ($check_csvname !== 0) {
                $sql2 = "ALTER TABLE `smack_dashboard_manager` MODIFY `csv_name` VARCHAR(100)";
                $wpdb->query($sql2);
        }

$check_table6 = 'wp_ultimate_csv_importer_acf_fields';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table6 . "'")) != 1) {
                 $create_table_for_acf_fields = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_acf_fields` (
                        `id` int(10) NOT NULL AUTO_INCREMENT,
                        `groupId` varchar(100) NOT NULL,
                        `fieldId` varchar(100) NOT NULL,
                        `fieldLabel` varchar(100) NOT NULL,
                        `fieldName` varchar(100) NOT NULL,
                        `fieldType` varchar(60) NOT NULL,
                        `fdOption` varchar(100) DEFAULT NULL,
                        PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_acf_fields);
        }
        $check_table7 = 'smack_field_types';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table7 . "'")) != 1) {
                $create_table_for_field_types = "CREATE TABLE IF NOT EXISTS `smack_field_types` (
                        `id` int(10) NOT NULL AUTO_INCREMENT,
                        `choices` varchar(160) NOT NULL,
                        `fieldType` varchar(100) NOT NULL,
                        `groupType` varchar(100) NOT NULL,
                        PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_field_types);
        }
$acf_choices = array('Basic'=>array('Text','Text Area','Number','Email','Url','Password'),
                     'Content'=>array('Wysiwyg Editor','oEmbed','Image','File','Gallery'),
                     'Choice'=>array('Select','Checkbox','Radio Button','True/False'),
                     'Relational'=>array('Post Object','Page Link','Relationship','Taxonomy','User'),
                     'jQuery'=>array('Google Map','Date Picker','Color picker'),
                     'Layout'=>array('Message','Tab','Repeater','Flexible Content'));
foreach($acf_choices as $key=>$val){

        $val = serialize($val);
        $sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','acf-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'acf-field-type' and fieldType = '$key')";
        $wpdb->query($sql);
}
        //Insert the pods_fields
        $pods_choices = array('Text' => array('Plain Text','Website','Phone','Email','Password'),
                      'Paragraph' => array('Plain Paragraph Text','WYSIWYG (Visual Editor)','Code (Syntax Highlighting)'),
                      'Date/Time' => array('Date/Time','Date','Time'),
                      'Number' => array('Plain Number','Currency'),
                      'Relationships/Media' => array('File/Image/Video','Relationship'),
                      'Other' => array('Yes/No','Color Picker'));
foreach($pods_choices as $key=>$val){
        $val = serialize($val);
        $sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','pods-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'pods-field-type' and fieldType = '$key')";
        $wpdb->query($sql);
}
        //Insert the types_fields
        $types_choices = array('Text'=> array('Textfield','Textarea','Numeric','Phone','Email','Url'),
                       'Content' => array('Wysiwyg','Embed','Image','File','Video','Skype'),
                       'Choice' => array('Select','Checkbox','Checkboxes','Radio'),
                       'jQuery' => array('Colorpicker','Date'));
foreach($types_choices as $key=>$val){
        $val = serialize($val);
        $sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','types-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'types-field-type' and fieldType = '$key')";
        $wpdb->query($sql);
}

update_option('ULTIMATE_CSV_IMP_VERSION', '4.3.0');
update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', '4.3.0');
?>
<script>
                document.getElementById('upgrade_state').innerHTML = 'Upgrade Completed! ';
        </script>
<?php
}
?>


