<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
if($_POST['eventdoneby'] == 'selectall') {
        $dataArray['delete_all_orphaned_post_page_meta'] = 1;
        $dataArray['delete_all_unassigned_tags'] = 1;
        $dataArray['delete_all_post_page_revisions'] = 1;
        $dataArray['delete_all_auto_draft_post_page'] = 1;
        $dataArray['delete_all_post_page_in_trash'] = 1;
        $dataArray['delete_all_spam_comments'] = 1;
        $dataArray['delete_all_comments_in_trash'] = 1;
        $dataArray['delete_all_unapproved_comments'] = 1;
        $dataArray['delete_all_pingback_commments'] = 1;
        $dataArray['delete_all_trackback_comments'] = 1;
        update_option('wpcsvpro_da_optimization', $dataArray);
} else if($_POST['eventdoneby'] == 'deselectall') {
        $dataArray['delete_all_orphaned_post_page_meta'] = 0;
        $dataArray['delete_all_unassigned_tags'] = 0;
        $dataArray['delete_all_post_page_revisions'] = 0;
        $dataArray['delete_all_auto_draft_post_page'] = 0;
        $dataArray['delete_all_post_page_in_trash'] = 0;
        $dataArray['delete_all_spam_comments'] = 0;
        $dataArray['delete_all_comments_in_trash'] = 0;
        $dataArray['delete_all_unapproved_comments'] = 0;
        $dataArray['delete_all_pingback_commments'] = 0;
        $dataArray['delete_all_trackback_comments'] = 0;
        update_option('wpcsvpro_da_optimization', $dataArray);
} else {
        $get_optimize = get_option('wpcsvpro_da_optimization');
	if (is_array($get_optimize)) {
		foreach($get_optimize as $key => $value) {
			if(isset($key))
				$optimize_settings[$key] = $value;
		}
	}
        $optimize_settings[$_POST['option']] = $_POST['value'];
        update_option('wpcsvpro_da_optimization', $optimize_settings);
}
?>
