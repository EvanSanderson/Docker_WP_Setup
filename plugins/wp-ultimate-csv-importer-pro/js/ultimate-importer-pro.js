jQuery(document).ready(function () {
/* Prem code - import specify rec*/
	jQuery('.dropdown-toggle').dropdown('toggle');
		if(document.getElementById('checkstep').value == 'importoptions'){
			choose_import_mode('');
			jQuery('#importspecific').click(function(){
				importSpecificChecked();
			});

			jQuery('#importspecific_scheduler').click(function(){
                                importSpecificChecked();
                        });

			var importSpecificChecked = function() {
				var scheduleNow = jQuery('#scheduleNow').prop('checked');
				var importNow = jQuery('#importNow').prop('checked');
				var import_specific_rec_textbox = "#import_specific_records";
				var import_specific_rec_checkbox = '#importspecific';
				if(scheduleNow){
					import_specific_rec_textbox = "#import_specific_records_scheduler";
					import_specific_rec_checkbox = '#importspecific_scheduler';
				}

				var isChecked = jQuery(import_specific_rec_checkbox).prop('checked');

				if(isChecked){
					jQuery( import_specific_rec_textbox).removeAttr("disabled");;
					jQuery( import_specific_rec_textbox ).focus();
					if(jQuery(import_specific_rec_textbox).val().length == 0)
						showMapMessages('error', translateAlertString('Please Specify Records.'));
				}
				else{
					jQuery(import_specific_rec_textbox).attr("disabled", "disabled");;
				}
					enableDisableImportButton();
				};
			importSpecificChecked();
		}
/* prem code ends - import specify*/
    var checkmodule = document.getElementById('checkmodule').value;
    if (checkmodule != 'dashboard' && checkmodule != 'filemanager' && checkmodule !='support' && checkmodule !='export' && checkmodule != 'mappingtemplate') {
	if(document.getElementById('log') != null)
        var get_log = document.getElementById('log').innerHTML;
        if (!jQuery.trim(jQuery('#log').html()).length) {
		if(document.getElementById('log') != null)
            document.getElementById('log').innerHTML = '<p style="margin:15px;color:red;">'+translateAlertString("NO LOGS YET NOW.")+'</p>';
        }
    }
    jQuery(".various").fancybox({
        maxWidth: 800,
        maxHeight: 600,
        fitToView: true,
        width: '100%',
        height: '70%',
        autoSize: false,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none'
    });

    lineStats();
    drillStats();
    jQuery('.inlinebar').sparkline('html', {width: 80, type: 'bar', barColor: 'red', width: '80'});
    if (checkmodule != 'dashboard') {
	    if (checkmodule == 'custompost') {
		    var step = jQuery('#stepstatus').val();
		    if (step == 'mapping_settings') {
			    var cust_post_list_count = jQuery('#cust_post_list_count').val();
			    if (cust_post_list_count == '0')
				    document.getElementById('cust_post_empty').style.display = '';
		    }
	    }
	    if (checkmodule != 'filemanager' && checkmodule != 'settings' && checkmodule !='support' && checkmodule !='export') {
		    var checkfile = jQuery('#checkfile').val();
		    var uploadedFile = jQuery('#uploadedFile').val();
		    var select_delimeter = jQuery('#select_delim').val();
		    var select_delim = jQuery('#select_delim').val();
		    var get_log = jQuery('#log').val();

		    if (checkfile != '') {
			    uploadedFile = checkfile;
		    }
		    if (select_delimeter != '') {
			    select_delim = select_delimeter;
		    }
		    if(uploadedFile != '' && select_delim != '') { 
			    //var doaction = 'record_no=1&file_name=' + uploadedFile + '&selected_delimeter=' + select_delim;
			    var tmpLoc = jQuery('#tmpLoc').val();
			    if(tmpLoc != '' && tmpLoc != null) {
				    jQuery.ajax({
					url: ajaxurl,
					type: 'post',
					data: {
						'record_no' : '1',
						'file_name' : uploadedFile,
						'delim' : select_delim,
						'action' : 'shownextrecords',
					},
					dataType: 'json',
					success: function (response) {
						if (response != null) {
							var totalLength = response.length;
							var setHeight = (parseInt(totalLength) * 30) + 250;
						}
					}
				    });
			    }
		     }
	    }
     }
});

function goto_mapping(id) {
    if (id == 'importfile') {
        var currentURL = document.URL;
        var go_to_url = currentURL.replace("uploadfile", "mapping_settings");
        window.location.assign(go_to_url);
        document.getElementById('sec-one').style.display = 'none';
        document.getElementById('sec-two').style.display = '';
    }
}

function databaseoptimization() {
	var orphaned, unassignedTags, postpagerevisions, autodraftedpostpage, postpagetrash, spamcomments, trashedcomments, unapprovedcomments, pingbackcomments, trackbackcomments;
	var tmpLoc = document.getElementById('tmpLoc').value;
	document.getElementById('log').innerHTML = '';
	if(document.getElementById('delete_all_orphaned_post_page_meta').checked) {
		orphaned = 1;
	} else {
		orphaned = 0;
	}
	if(document.getElementById('delete_all_unassigned_tags').checked) {
		unassignedTags = 1;
	} else {
		unassignedTags = 0;
	}
	if(document.getElementById('delete_all_post_page_revisions').checked) {
		postpagerevisions = 1;
	} else {
		postpagerevisions = 0;
	}
        if(document.getElementById('delete_all_auto_draft_post_page').checked) {
		autodraftedpostpage = 1;
        } else {
		autodraftedpostpage = 0;
        }
        if(document.getElementById('delete_all_post_page_in_trash').checked) {
		postpagetrash = 1;
        } else {
		postpagetrash = 0;
        }
        if(document.getElementById('delete_all_spam_comments').checked) {
		spamcomments = 1;
        } else {
		spamcomments = 0;
        }
        if(document.getElementById('delete_all_comments_in_trash').checked) {
		trashedcomments = 1;
        } else {
		trashedcomments = 0;
        }
        if(document.getElementById('delete_all_unapproved_comments').checked) {
		unapprovedcomments = 1;
        } else {
		unapprovedcomments = 0;
        }
        if(document.getElementById('delete_all_pingback_commments').checked) {
		pingbackcomments = 1;
        } else {
		pingbackcomments = 0;
        }
        if(document.getElementById('delete_all_trackback_comments').checked) {
		trackbackcomments = 1;
        } else {
		trackbackcomments = 0;
        }
	if(!orphaned && !unassignedTags && !postpagerevisions && !autodraftedpostpage && !postpagetrash && !spamcomments && !trashedcomments && !unapprovedcomments && !pingbackcomments && !trackbackcomments) {
		document.getElementById('log').innerHTML = '<p style="margin:15px;color:red;">'+translateAlertString('NO LOGS YET NOW.')+'</p>';
	}
	jQuery.ajax({
		//url: tmpLoc + 'lib/optimizer/databaseOptimization.php',
		url: ajaxurl,
		type: 'post',
		data: {
		'action': 'database_optimization',
                'orphaned': orphaned,
		'unassignedTags': unassignedTags,
		'postpagerevisions': postpagerevisions,
		'autodraftedpostpage': autodraftedpostpage,
		'postpagetrash': postpagetrash,
		'spamcomments': spamcomments,
		'trashedcomments': trashedcomments,
		'unapprovedcomments': unapprovedcomments,
		'pingbackcomments': pingbackcomments,
		'trackbackcomments': trackbackcomments,
		},
		dataType: 'json',
		success: function (response) { 
			document.getElementById('optimizelog').style.display = "";
			if(response['orphaned'] != 'non_affected')
				document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['orphaned'] + ' ) '+ translateAlertString("no of Orphaned Post/Page meta has been removed.") + '</p>';
                        if(response['unassignedTags'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['unassignedTags'] + ' ) '+ translateAlertString("no of Unassigned tags has been removed.") + '</p>';
                        if(response['postpagerevisions'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['postpagerevisions'] + ' ) '+ translateAlertString("no of Post/Page revisions has been removed.") + '</p>';
                        if(response['autodraftedpostpage'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['autodraftedpostpage'] + ' ) ' + translateAlertString('no of Auto drafted Post/Page has been removed.') + '</p>';
                        if(response['postpagetrash'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['postpagetrash'] + ' ) '+ translateAlertString("no of Post/Page in trash has been removed.") + '</p>';
                        if(response['spamcomments'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['spamcomments'] + ' ) ' + translateAlertString("no of Spam comments has been removed.") + '</p>';
                        if(response['trashedcomments'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['trashedcomments'] + ' ) ' + translateAlertString('no of Comments in trash has been removed.') + '</p>';
                        if(response['unapprovedcomments'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['unapprovedcomments'] + ' ) ' + translateAlertString("no of Unapproved comments has been removed.") + '</p>';
                        if(response['pingbackcomments'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['pingbackcomments'] + ' ) ' + translateAlertString("no of Pingback comments has been removed.") + '</p>';
                        if(response['trackbackcomments'] != 'non_affected')
                                document.getElementById('log').innerHTML += '<p style="margin:15px; margin-left:10px;"> ( ' + response['trackbackcomments'] + ' ) '+ translateAlertString("no of Trackback comments has been removed.") + '</p>';
		}
	}); 
}

function database_optimization_settings( id ) { 
	var ele_value = document.getElementById(id).checked; 
	if(ele_value == true)
		post_val = 1;
	else
		post_val = 0;
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                	'action': 'database_optimization_settings',
			'option': id,
			'value': post_val,
		},
                success: function (response) {
		 shownotification('Settings Saved', 'success');

		}
	});
}

function gotoelement(id) {
    var gotoElement = document.getElementById('current_record').value;
    var no_of_records = document.getElementById('totRecords').value;
    var uploadedFile = document.getElementById('uploadedFile').value;
    var delim = document.getElementById('select_delimeter').value;
    if (id == 'prev_record') {
        gotoElement = parseInt(gotoElement) - 1;
    }
    if (id == 'next_record') {
        gotoElement = parseInt(gotoElement) + 1;
    }
    if (gotoElement <= 0) {
        gotoElement = 0;
    }
    if (gotoElement >= no_of_records) {
        gotoElement = parseInt(no_of_records) - 1;
    }
    if (id == 'apply_element') {
        gotoElement = parseInt(document.getElementById('goto_element').value);
        if (isNaN(gotoElement)) {
            showMapMessages('error', translateAlertString(' Please provide valid record number.'));
        }
        if (gotoElement <= 0) {
            gotoElement = 0;
            showMapMessages('error', translateAlertString(' Please provide valid record number.'));
        } else {
            gotoElement = gotoElement - 1;
        }
        if (gotoElement >= no_of_records) {
            gotoElement = parseInt(no_of_records) - 1;
            showMapMessages('error', translateAlertString('CSV file have only ') + no_of_records + translateAlertString(' records.'));
            return false;
        }
    }
    var doaction = 'record_no=' + gotoElement + '&file_name=' + uploadedFile + '&delim='+ delim;
    var tmpLoc = document.getElementById('tmpLoc').value;
    jQuery.ajax({
        url: ajaxurl,
        type: 'post',
        data: {
		'record_no' : gotoElement,
		'file_name' : uploadedFile,
		'delim'     : delim,
		'action'    : 'shownextrecords',
	},
        dataType: 'json',
        success: function (response) {
            var totalLength = response.length;
            for (var i = 0; i < totalLength; i++) {
                if ((response[i].length) > 32) {
                    document.getElementById('elementVal_' + i).innerHTML = response[i].substring(0, 28) + '...';
                } else {
                    document.getElementById('elementVal_' + i).innerHTML = response[i];
                }
            }
	var displayRecCount = gotoElement + 1;
	    document.getElementById('preview_of_row').innerHTML = translateAlertString("Showing Preview of Row #") + displayRecCount;
            document.getElementById('current_record').value = gotoElement;
        }
    });
}

function showtemplatediv_wpuci(checked, div) {
    if (checked)
        jQuery('#' + div).show();
    else
        jQuery('#' + div).hide();
}

function showtemplatediv_edit(checked, value) {
    if (value == 'savetemplate') {
        jQuery('#showtemplate_edit_div').show();
    } else {
        jQuery('#showtemplate_edit_div').hide();
    }
}

function selectpoststatus() {
    var ps = document.getElementById("importallwithps");
    var selectedpsindex = ps.options[ps.selectedIndex].value;
    if (selectedpsindex == 3) {
        document.getElementById('globalpassword_label').style.display = "block";
        document.getElementById('globalpassword_text').style.display = "block";
    }
    else {
        document.getElementById('globalpassword_label').style.display = "none";
        document.getElementById('globalpassword_text').style.display = "none";
    }
    var totdropdown = document.getElementById('h2').value;
    var total = parseInt(totdropdown);
    if (selectedpsindex == '0') {

        for (var i = 0; i < total; i++) {

            dropdown = document.getElementById("mapping" + i);
            var option = document.createElement('option');
            option.text = "post_status";
            dropdown.add(option);

        }

    }
    else {
        for (var i = 0; i < total; i++) {

            dropdown = document.getElementById("mapping" + i);

            var totarr = dropdown.options.length;

            for (var j = 0; j < totarr; j++) {

                if (dropdown.options[j].value == 'post_status') {

                    dropdown.options.remove(j);
                    totarr--;
                }
            }

        }
    }
}

function edittemplatefield(myval, selected_id) {
    var a = document.getElementById('h1').value;
    var importer = document.getElementById('selectedImporter').value;
    var aa = document.getElementById('h2').value;
    if (importer == 'custompost' || importer == 'post' || importer == 'page') {
        var selected_dropdown = document.getElementById('mapping' + selected_id);
        var selected_value = selected_dropdown.value;
        var prevoptionindex = document.getElementById('prevoptionindex').value;
        var prevoptionvalue = document.getElementById('prevoptionvalue').value;
        var mappedID = 'mapping' + selected_id;
        var add_prev_option = false;
        if (mappedID == prevoptionindex) {
            add_prev_option = true;
        }
        for (var i = 0; i < aa; i++) {
            var b = document.getElementById('mapping' + i).value;
            var id = 'mapping' + i;
            if (add_prev_option) {
                if (i != selected_id) {
                    jQuery('#' + id).append(new Option(prevoptionvalue, prevoptionvalue));
                }
            }
            if (i != selected_id) {
                var x = document.getElementById('mapping' + i);
                jQuery('#' + id + ' option[value="' + selected_value + '"]').remove();
            }
            if (b == 'add_custom' + i) {
                document.getElementById('textbox' + i).style.display = "";
                document.getElementById('customspan' + i).style.display = "";
            }
            else {
                document.getElementById('textbox' + i).style.display = "none";
                document.getElementById('customspan' + i).style.display = "none";
            }
        }
        document.getElementById('prevoptionindex').value = 'mapping' + selected_id;
        var customField = selected_value.indexOf("add_custom");
        if (selected_value != '-- Select --' && customField != 0) {
            document.getElementById('prevoptionvalue').value = selected_value;
        }
    }
}

// Function for add customfield

function addcustomfield(myval, selected_id) {
    var a = document.getElementById('h1').value;
    var importer = document.getElementById('selectedImporter').value;
    var aa = document.getElementById('h2').value;
    var selected_dropdown = document.getElementById('mapping' + selected_id);
    var selected_value = selected_dropdown.value;
    var prevoptionindex = document.getElementById('prevoptionindex').value;
    var prevoptionvalue = document.getElementById('prevoptionvalue').value;
    var mappedID = 'mapping' + selected_id;
    var add_prev_option = false;
    if (mappedID == prevoptionindex) {
        add_prev_option = true;
    }
    for (var i = 0; i < aa; i++) {
        var b = document.getElementById('mapping' + i).value;
        var id = 'mapping' + i;
        if (add_prev_option) {
            if (i != selected_id) {
                jQuery('#' + id).append(new Option(prevoptionvalue, prevoptionvalue));
            }
        }
        if (i != selected_id) {
            var x = document.getElementById('mapping' + i);
            jQuery('#' + id + ' option[value="' + selected_value + '"]').remove();
        }
        if (b == 'add_custom' + i) {
            document.getElementById('textbox' + i).style.display = "";
            document.getElementById('customspan' + i).style.display = "";
        }
        else {
            document.getElementById('textbox' + i).style.display = "none";
            document.getElementById('customspan' + i).style.display = "none";
        }
    }
    document.getElementById('prevoptionindex').value = 'mapping' + selected_id;
    var customField = selected_value.indexOf("add_custom");
    if (selected_value != '-- Select --' && customField != 0) {
        document.getElementById('prevoptionvalue').value = selected_value;
    }
    //}
}


function clearMapping() {
    var total_mfields = document.getElementById('h2').value;
    var mfields_arr = document.getElementById('mapping_fields_array').value;
    var n = mfields_arr.split(",");
    var options = '<option id="select">' + translateAlertString("-- Select --") + '</option>';
    for (var i = 0; i < n.length; i++) {
        options += "<option value='" + n[i] + "'>" + n[i] + "</option>";
    }
    for (var j = 0; j < total_mfields; j++) {
        document.getElementById('mapping' + j).innerHTML = options;
        document.getElementById('mapping' + j).innerHTML += "<option value='add_custom" + j + "'>" + translateAlertString('Add Custom Field') + "</option>";
        document.getElementById('textbox' + j).style.display = 'none';
        document.getElementById('customspan' + j).style.display = 'none';
    }
}

function clearmapping() {
    var total_mfields = document.getElementById('h2').value;
    var mfields_arr = document.getElementById('mapping_fields_array').value;
    var n = mfields_arr.split(",");
    var options = "<option id='select'>" + translateAlertString("-- Select --") + "</option>";
    for (var i = 0; i < n.length; i++) {
        options += "<option value='" + n[i] + "'>" + n[i] + "</option>";
    }
    for (var j = 0; j < total_mfields; j++) {
        document.getElementById('mapping' + j).innerHTML = options;
        document.getElementById('textbox' + j).style.display = 'none';
        document.getElementById('customspan' + j).style.display = 'none';
    }
}


function checktemplatename_edit(form) {
    var mapping_tempname = form.templatename.value;
    var templateid = form.templateid.value;
    if (jQuery.trim(mapping_tempname) == '') {
        alert(translateAlertString('Template name is empty'));
        return false;
    }
    else {
        // check templatename already exists
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'checktemplatename',
                'templatename': mapping_tempname,
                'templateid': templateid,
            },
            success: function (data) {
                if (data != 0) {
                    jQuery('#templatename').val('');
                }
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    mapping_tempname = form.templatename.value;
    if (mapping_tempname == '') {
        alert(translateAlertString('Template Name already exists'));
        return false;
    }
}

function shownotification(msg, alerts) {
    var newclass;
    var divid = "notification_wp_csv";
    document.getElementById('notification_wp_csv').style.display = ''; 
    var height = $(document).height() - $(window).height();
    if (alerts == 'success')
        newclass = "alert alert-success";
    else if (alerts == 'danger')
        newclass = "alert alert-danger";
    else if (alerts == 'warning')
        newclass = "alert alert-warning";
    else
        newclass = "alert alert-info";

    jQuery('#' + divid).removeClass()
    jQuery('#' + divid).html(msg);
    jQuery('#' + divid).addClass(newclass);
    // Scroll
    jQuery('html,body').animate({
            scrollTop: jQuery("#" + divid).height},
        'slow');
    jQuery("#notification_wp_csv").fadeOut(7000);
}

function validatescheduleforall() {
    var msg = cptype = termtype = taxonomyname = '';
    var date = jQuery('#datetoschedule').val();
    var time = jQuery('#timetoschedule').val();
    var filename = jQuery('#uploaded_versioned_name').val();
    var uploaddir = jQuery('#uploaddir').val();
    var uploadedfilename = jQuery('#csv_name').val();
    var templateid = jQuery('#select_templatename').val();
    var module = jQuery('#current_imptype').val();
    var schedule_row = jQuery('#import_specific_records_scheduler').val();
    var schedule_limit = jQuery('#schedule_limit').val();
    var schedule_frequency = jQuery('#schedule_frequency').val();
    var import_by_method = jQuery('#import_by_method').val();
    var tot_records = jQuery('#tot_records').val();
    var importmode = jQuery('#importmode').val();
    if (module == 'categories' || module == 'custompost') {
        var cptype = jQuery('#schedulecustompost').val();
        if (cptype == 'select') {
            msg = translateAlertString('Before Schedule kindly select the post type');
            shownotification(msg, 'danger');
            return false;
        }
        if (module == 'categories') {
            var termtype = jQuery('#scheduletermtype').val();
            if (termtype == 'select') {
			    msg = translateAlertString('Before Schedule kindly select the term type');
			    shownotification(msg, 'danger');
			    return false;
            }
        }
    }
    else if (module == 'customtaxonomy') {
        var taxonomyname = jQuery('#scheduletaxonomy').val();
        if (taxonomyname == 'select') {
            msg = translateAlertString('Before Schedule kindly select the taxonomy');
            shownotification(msg, 'danger');
            return false;
        }

    }
    else {
        var cptype = module;
    }
    if (filename == '') {
        msg = translateAlertString('Before Schedule kindly select filename');
        shownotification(msg, 'danger');
        return false;
    }

    if (templateid == '') {
        msg = translateAlertString('Select Template to schedule the CSV ');
        shownotification(msg, 'danger');
        return false;
    }

    if (date == '') {
        msg = translateAlertString('Select Date');
        shownotification(msg, 'danger');
        return false;
    }

    if(schedule_row == '') {
var importspecificisChecked = jQuery('#importspecific').prop('checked');
                    if(importspecificisChecked){
	msg = translateAlertString('Before Schedule kindly enter the row limits');
	shownotification(msg, 'danger');
	return false;
	}
    } else {
	if(!schedule_row.match(/^(\s*\d+\s*(-\s*\d+\s*)?)(,\s*\d+\s*(-\s*\d+\s*)?)*$/)) {
		msg = translateAlertString('Kindly enter the valid format of row limits');
		shownotification(msg, 'danger');
		return false;
	} 
    }

    if(schedule_limit == '') {
	    msg = translateAlertString('Kindly enter the schedule limit');
	    shownotification(msg, 'danger');
	    return false;
    }

    if(parseInt(schedule_limit) > parseInt(tot_records)) {
	msg = translateAlertString('Schedule limit should not be greater than')+' (' + parseInt(tot_records) + ')';
	shownotification(msg, 'danger');
	return false;
    }

    // schedule starts
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        async: false,
        data: {
            'action': 'generateandstoreschedule',
            'date': date,
            'time': time,
            'filename': filename,
            'uploadedfilename': uploadedfilename,
            'templateid': templateid,
            '__module': module,
            'cptype': cptype,
            'termtype': termtype,
            'taxonomyname': taxonomyname,
	    'schedule_row': schedule_row,
	    'frequency': schedule_frequency,
	    'limit': schedule_limit,
	    'importmode' : importmode,
	    'import_type' : module,
	    'import_method': import_by_method,
        },
        success: function (data) { 
            shownotification(data.notification, data.notification_class);
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
  alert(translateAlertString('CSV Scheduled Successfully'));
  var currentURL = document.URL;
  var gotoURL = currentURL.replace(/__module=.*/g, '__module=dashboard');
  window.location.assign(gotoURL);

}

function showschedulediv(checked) {
    if (checked)
        jQuery('#schedulediv').show();
    else
        jQuery('#schedulediv').hide();
}

function checkfilter(form) {
	var msg = '';
	var fromdate = form.fromdate.value;
	var todate = form.todate.value;
	// check from date greater than to date
	if (fromdate && todate && (fromdate > todate))
		msg = translateAlertString('From date should be greater than To Date');

	if (msg != '') {
		shownotification(msg, 'danger');
		return false;
	}
	jQuery("#saiob_filter").submit();
}

function clearfilter(form) {
	form.fromdate.value = '';
	form.todate.value = '';
	form.templatename.value = '';
	jQuery("#saiob_filter").submit();
}

function update_rename(id) {
	var selected = '';
	var len = document.getElementsByName('update_rename_file').length;
	for (var k = 0; k < len; k++) {
		var chk = document.getElementsByName('update_rename_file')[k].checked;
		if (chk == true) {
			selected = k;
		}
	}
	if (id == 'rename_template') {
		//document.getElementById('update_template').checked = false;
		//document.getElementById('updatemappingtemplatename').style.display = "";
if(document.getElementById(id).checked == true)
                   {
                       document.getElementById('updatemappingtemplatename').style.display = "";
                        jQuery("#template_name").focus();
                   }
               else
                       document.getElementById('updatemappingtemplatename').style.display = "none";

	}
	if (id == 'update_template') {
		document.getElementById('rename_template').checked = false;
		document.getElementById('updatemappingtemplatename').style.display = "none";
	}
	if (id == 'newmappingtemplate') {
		if(document.getElementById(id).checked == true){
			document.getElementById('newmappingtemplatename').style.display = "";
			jQuery("#template_name").focus();
		}
		else
			document.getElementById('newmappingtemplatename').style.display = "none";
	}
}

function translateAlertString(alertstring){
var convertedStr = "";
jQuery.ajax({
        type:'POST',
        url: ajaxurl,
        async: false,
        data: {
          'action'      : 'trans_alert_str',
          'alertmsg': alertstring,
        },
        success:function(response)
        {
                convertedStr = response;
        },
        error: function(errorThrown){
                console.log(errorThrown);
        }
        });
return convertedStr;
}

function import_csvrecords() {
	var importer = document.getElementById('selectedImporter').value;
	var mapping_tempname = jQuery('#map_temp_name').val();
        /*if (jQuery.trim(mapping_tempname) == '') {
            alert(translateAlertString('Template name is empty'));
            return false;
	} */
                if(document.getElementById('newmappingtemplatename').checked == false){
                   return true;
}
	else {
		// check templatename already exists
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			async: false,
			data: {
				'action': 'checktemplatename',
				'templatename': mapping_tempname,
			},
			success: function (data) {
				if (data != 0) {
					//jQuery('#template_name').val('');
					jQuery('#map_temp_name').val('');
				}
			},
			error: function (errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	if((jQuery('#template_name').val()) != '' && (jQuery('#map_temp_name').val()) == '') {
		alert(translateAlertString('TemplateTry with different template name'));
		return false;
	}
	else if((jQuery('#map_temp_name').val()) == '') {
		alert(translateAlertString('Template name is empty'));
		return false;
	}
	/*else if (id == 'newmappingtemplate') {
               if(document.getElementById(id).checked == false)
                  return true;
       }*/
/* validation starting*/
        var csvarray = new Array();
        var wparray = new Array();
	var req_wparr = new Array();
        var hiddenvalue = document.getElementsByClassName('hiddenclass');
        var flag,userflag1,userflag2,userflag3,commflag1,commflag2,commflag3,commflag4,cateflag1,taxoflag1,reviewflag1 = 0;
        var post_type,cate_type,taxo_type = 'Off';
        var selectvalue = document.getElementsByClassName('uiButton');
	var req_wparray = document.getElementsByClassName('req_hiddenclass');
	var import_type = document.getElementById('selectedImporter').value;
	var reqflag = 0;
	jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        async: false,
                        data: {
                                'action': 'check_requiredfields',
				'import_type' : import_type,
                                
                        },
                        success: function (response) {
//alert(response);
				data = JSON.parse(response);
				for(var i=0; i < req_wparray.length; i++){
			                reqwp_value = req_wparray[i].value;
			                req_wparr[i] = reqwp_value;
			        }
				for(i=0; i<selectvalue.length; i++){
			                var selvalue = selectvalue[i].value;
			                csvarray[i] = selvalue;
			        }

//alert(csvarray.length);alert(req_wparr.length);

				for(j=0; j< req_wparr.length; j++){
					for(k=0;k< data.length; k++){
//						if(data[k] == 'mmm')
//							alert(req_wparr[136]);
					if(req_wparr[j] == data[k])
					{
//						if(req_wparr[j] == 'hhh' && data[k] == 'hhh')
//							alert(j);
						if(csvarray[j] == '-- Select --'){
							reqflag = 1;
						showMapMessages('error', 'Error: ' + req_wparr[j] + translateAlertString('- Mandatory fields. Please map the fields to proceed.'));
						break;
						}

					}
				}
					if(reqflag == 1)
					break;
				}

                        },
                        error: function (errorThrown) {
                                console.log(errorThrown);
                        }
                });

if(reqflag == 1)
return false;


        for(var i=0; i<hiddenvalue.length; i++){
                var value2 = hiddenvalue[i].value;
                wparray[i] = value2;
        }

/*        for(i=0; i<selectvalue.length; i++){
                var selvalue = selectvalue[i].value;
                csvarray[i] = selvalue;
        }
*/
        for(j=0; j<wparray.length; j++){
                if(wparray[j] == 'post_title' && csvarray[j] == '-- Select --'){

	//var checkstaticvalue = document.getElementById('CORE_static_mapping'+j).value;
                flag = 1;
                }
		else if(wparray[j] == 'post_title' && csvarray[j] == 'header_manip'){
			staticdiv = document.getElementById('CORE_statictext_mapping'+j);
			formuladiv = document.getElementById('CORE_formulatext_mapping'+j);
		if(staticdiv == null && formuladiv == null){ 
			flag = 1;
		}
		else if(staticdiv != null && staticdiv.value == ''){ 
			flag = 1;
		}
		else if(formuladiv != null && formuladiv.value == ''){ 
			flag = 1;
		}
		}
        }
if(importer == 'post' || importer == 'page' || importer == 'custompost' || importer == 'marketpress' || importer == 'woocommerce_products' || importer == 'wpcommerce' || importer == 'eshop')
        {
             if (importer == 'custompost') {
                            var getSelect = document.getElementById('custompostlist');
                            var customIndex = getSelect.options[getSelect.selectedIndex].value;
                            if (customIndex != '---Select---'){
                                post_type = 'On';
                            }
             }
                if(importer == 'custompost' && post_type == 'On' && flag != 1)
                {
                   return true;
                }
                else if(importer != 'custompost' && flag != 1){
                   return true;
                }
                else
                {
                   error_msg = '';
                   if(flag == 1)
                     error_msg += "post_title";
                   if (customIndex == '---Select---')
                     error_msg += " post_type,";
                     showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
                     return false;
                }
        }
	else if(importer == 'users')
        {
                for(j=0; j<wparray.length; j++){
                        if(wparray[j] == 'user_login' && csvarray[j] == '-- Select --'){
                                userflag1 = 1;
                        }
                        if(wparray[j] == 'user_email' && csvarray[j] == '-- Select --'){
                                userflag2 = 1;
                        }
                        if(wparray[j] == 'role' && csvarray[j] == '-- Select --'){
                                userflag3 = 1;
                        }
                }
                if(userflag1 != 1 && userflag2 != 1 && userflag3 != 1){
                 return true;
                }
                else
                {
                 showMapMessages('error', translateAlertString('"User Login", "User Email" and "User Role" should be mapped.'));
                 return false;
                }
        }
	else if(importer == 'comments')
        {
                for(j=0; j<wparray.length; j++){

                        if(wparray[j] == 'comment_author' && csvarray[j] == '-- Select --'){
                                commflag1 = 1;
                        }
                        if(wparray[j] == 'comment_author_email' && csvarray[j] == '-- Select --'){
                                commflag2 = 1;
                        }
                        if(wparray[j] == 'comment_content' && csvarray[j] == '-- Select --'){
                                commflag3 = 1;
                        }
                        if(wparray[j] == 'comment_post_ID' && csvarray[j] == '-- Select --'){
                                commflag4 = 1;
                        }
                }
                if(commflag1 != 1 && commflag2 != 1 && commflag3 != 1 && commflag4 != 1){
                 return true;
                }
                else
                {
                 showMapMessages('error', translateAlertString(' "Comment Post Id", "Comment Author", "Comment Author Email" and "Comment Content" should be mapped.'));
                 return false;
                }

        }
	else if (importer == 'categories') {
                var getSelectedIndex = document.getElementById('wptermslist');
                var cateIndex =  getSelectedIndex.options[getSelectedIndex.selectedIndex].value;
                if (cateIndex != '---Select---'){
                                cate_type = 'On';
                }
                /*var getSelect = document.getElementById('custompostlist');
                var customIndex = getSelect.options[getSelect.selectedIndex].value;
                if (customIndex != '---Select---'){
                        post_type = 'On';
                }*/
                for(j=0; j<wparray.length; j++){
                        if(wparray[j] == 'name' && csvarray[j] == '-- Select --'){
                                cateflag1 = 1;
                        }
                }
                 if(cateflag1 != 1 && cate_type == 'On' ){
                     return true;
                }
                else
                {
                    showMapMessages('error', translateAlertString('"Select Term","Select Post type","Category Name" should be mapped.'));
                    return false;
                }
        }
	else if (importer == 'customtaxonomy') {
                var getSelectedIndex = document.getElementById('wptaxolist');
                var taxoIndex = getSelectedIndex.options[getSelectedIndex.selectedIndex].value;
                if (taxoIndex != '---Select---'){
                                taxo_type = 'On';
                }
                for(j=0; j<wparray.length; j++){
                        if(wparray[j] == 'name' && csvarray[j] == '-- Select --'){
                                taxoflag1 = 1;
                        }
                }
                if(taxoflag1 != 1 && taxo_type == 'On'){
                 return true;
                }
                else
                {
                 showMapMessages('error', translateAlertString('"Select Taxonomy","Taxonomy Name" should be mapped.'));
                 return false;
                }
        }
        else if (importer == 'customerreviews') {
                for(j=0; j<wparray.length; j++){
                        if(wparray[j] == 'page_id' && csvarray[j] == '-- Select --'){
                                reviewflag1 = 1;
                        }
                }
                if(reviewflag1 != 1){
                 return true;
                }
                else
                {
                 showMapMessages('error', translateAlertString('"Review to Post/Page Id" should be mapped.'));
                 return false;
                }

        }
}

function import_csv() {
    // code added by goku to check whether templatename
    var mapping_checked = jQuery('#mapping_templatename_checked').is(':checked');
    var mapping_tempname = jQuery('#mapping_templatename').val();
    var mapping_checked_radio = jQuery('input[name=tempaction]:radio:checked').val();
    if (mapping_checked || mapping_checked_radio == 'saveas') {
        if (mapping_checked_radio == 'saveas')
            mapping_tempname = jQuery('#mapping_templatename_edit').val();

        if (jQuery.trim(mapping_tempname) == '') {
            alert(translateAlertString('Template name is empty'));
            return false;
        }
        else {
            // check templatename already exists
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                async: false,
                data: {
                    'action': 'checktemplatename',
                    'templatename': mapping_tempname,
                },
                success: function (data) {
                    if (data != 0) {
                        jQuery('#mapping_templatename').val('');
                    }
                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }
    var mapping_tempname = jQuery('#mapping_templatename').val();
    if (mapping_checked_radio == 'saveas')
        if (mapping_tempname == '' && (mapping_checked || mapping_templatename_edit == 'saveas')) {
            alert(translateAlertString('Template Name already exists'));
            return false;
        }
    // code ends here on checking templatename

    var importer = document.getElementById('selectedImporter').value;
    var header_count = document.getElementById('h2').value;
    var array = new Array();
    var val1, val2, val3, val4, val5, val6, val7, error_msg, chk_status_in_csv, post_status_msg;
    val1 = val2 = val3 = val4 = val5 = val6 = val7 = post_status_msg = post_type = 'Off';
    for (var i = 0; i < header_count; i++) {
        var e = document.getElementById("mapping" + i);
        var value = e.options[e.selectedIndex].value;
        array[i] = value;
    }
    if (importer == 'post' || importer == 'page' || importer == 'custompost') {
        if (importer == 'custompost') {
            var getSelectedIndex = document.getElementById('custompostlist');
            var SelectedIndex = getSelectedIndex.value;
            if (SelectedIndex != 'select')
                post_type = 'On';
        }

        chk_status_in_csv = document.getElementById('importallwithps').value;
        if (chk_status_in_csv != 0)
            post_status_msg = 'On';

        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'post_title') {
                val1 = 'On';
            }
            if (array[j] == 'post_content') {
                val2 = 'On';
            }
            if (post_status_msg == 'Off') {
                if (array[j] == 'post_status')
                    post_status_msg = 'On';
            }
        }
        if (importer != 'custompost' && val1 == 'On' && val2 == 'On' && post_status_msg == 'On') {
            return true;
        }
        else if (importer == 'custompost' && val1 == 'On' && val2 == 'On' && post_status_msg == 'On' && post_type == 'On') {
            return true;
        }
        else {
            error_msg = '';
            if (val1 == 'Off')
                error_msg += " post_title,";
            if (val2 == 'Off')
                error_msg += " post_content,";
            if (importer == 'custompost') {
                if (SelectedIndex == 'select')
                    error_msg += " post_type,";
            }
            if (post_status_msg == 'Off')
                error_msg += " post_status";
            showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
            return false;
        }
    }

// validation starts
    else if (importer == 'comments') {
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'comment_author') {
                val1 = 'On';
            }
            if (array[j] == 'comment_author_email') {
                val2 = 'On';
            }
            if (array[j] == 'comment_content') {
                val3 = 'On';
            }
            if (array[j] == 'comment_post_ID') {
                val4 = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On' && val4 == 'On') {
            return true;
        }
        else {
            showMapMessages('error', translateAlertString(' "Post Id", "Comment Author", "Comment Author Email" and "Comment Content" should be mapped.'));
            return false;
        }
        showMapMessages('error', header_count);
        return false;
    }
    else if (importer == 'wpcommerce') {
        var chk_status_in_csv;
        var post_status_msg;
        chk_status_in_csv = document.getElementById('importallwithps').value;
        if (chk_status_in_csv != 0)
            post_status_msg = 'On';
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'post_title') {
                val1 = 'On';
            }
            if (array[j] == 'post_content') {
                val2 = 'On';
            }
            if (array[j] == 'SKU') {
                val3 = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On' && post_status_msg == 'On') {
            return true;
        }
        else {
            error_msg = '';
            if (val1 == 'Off')
                error_msg += " post_title,";
            if (val2 == 'Off')
                error_msg += " post_content,";
            if (val3 == 'Off')
                error_msg += " SKU,";
            if (post_status_msg == 'Off')
                error_msg += " post_status,";

            showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
            return false;
        }
    }
    else if (importer == 'woocommerce') {
        var chk_status_in_csv;
        var post_status_msg;
        chk_status_in_csv = document.getElementById('importallwithps').value;
        if (chk_status_in_csv != 0)
            post_status_msg = 'On';
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'product_name') {
                val1 = 'On';
            }
            if (array[j] == 'product_content') {
                val2 = 'On';
            }
            if (array[j] == 'sku') {
                val3 = 'On';
            }
            if (post_status_msg == 'Off') {
                if (array[j] == 'product_status')
                    post_status_msg = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On' && post_status_msg == 'On') {
            return true;
        }
        else {
            error_msg = '';
            if (val1 == 'Off')
                error_msg += " product_name,";
            if (val2 == 'Off')
                error_msg += " product_content,";
            if (val3 == 'Off')
                error_msg += " SKU,";
            if (post_status_msg == 'Off')
                error_msg += " product_status,";

            showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
            return false;
        }
    }
    else if (importer == 'marketpress') {
        var chk_status_in_csv;
        var post_status_msg;
        chk_status_in_csv = document.getElementById('importallwithps').value;
        if (chk_status_in_csv != 0)
            post_status_msg = 'On';
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'product_title') {
                val1 = 'On';
            }
            if (array[j] == 'product_content') {
                val2 = 'On';
            }
            if (array[j] == 'SKU') {
                val3 = 'On';
            }
            if (post_status_msg == 'Off') {
                if (array[j] == 'product_status')
                    post_status_msg = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On' && post_status_msg == 'On') {
            return true;
        }
        else {
            error_msg = '';
            if (val1 == 'Off')
                error_msg += " product_title,";
            if (val2 == 'Off')
                error_msg += " product_content,";
            if (val3 == 'Off')
                error_msg += " SKU,";
            if (post_status_msg == 'Off')
                error_msg += " product_status,";

            showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
            return false;
        }
    }
    else if (importer == 'eshop') {
        var chk_status_in_csv;
        var post_status_msg;
        chk_status_in_csv = document.getElementById('importallwithps').value;
        if (chk_status_in_csv != 0)
            post_status_msg = 'On';

        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'post_title') {
                val1 = 'On';
            }
            if (array[j] == 'post_content') {
                val2 = 'On';
            }
            if (array[j] == 'SKU') {
                val3 = 'On';
            }
            if (array[j] == 'products_option') {
                val4 = 'On';
            }
            if (array[j] == 'description') {
                val5 = 'On';
            }
            if (array[j] == 'sale_price') {
                val6 = 'On';
            }
            if (array[j] == 'regular_price') {
                val7 = 'On';
            }
            if (post_status_msg == 'Off') {
                if (array[j] == 'post_status')
                    post_status_msg = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On' && val4 == 'On' && val5 == 'On' && val6 == 'On' && val7 == 'On' && post_status_msg == 'On') {
            return true;
        }
        else {
            error_msg = '';
            if (val1 == 'Off')
                error_msg += " post_title,";
            if (val2 == 'Off')
                error_msg += " post_content,";
            if (val3 == 'Off')
                error_msg += " SKU,";
            if (val4 == 'Off')
                error_msg += " products_option,";
            if (val5 == 'Off')
                error_msg += " description,";
            if (val6 == 'Off')
                error_msg += " regular_price,";
            if (val7 == 'Off')
                error_msg += " sale_price,";
            if (post_status_msg == 'Off')
                error_msg += " post_status";

            showMapMessages('error', 'Error: ' + error_msg + translateAlertString(' - Mandatory fields. Please map the fields to proceed.'));
            return false;
        }
    }
    else if (importer == 'users') {
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'user_login') {
                val1 = 'On';
            }
            if (array[j] == 'user_email') {
                val2 = 'On';
            }
            if (array[j] == 'role') {
                val3 = 'On';
            }
        }
        if (val1 == 'On' && val2 == 'On' && val3 == 'On') {
            return true;
        }
        else {
            showMapMessages('error', translateAlertString('"role", "user_login" and "user_email" should be mapped.'));
            return false;
        }
    }
    else if (importer == 'categories') {
        var getSelectedIndex = document.getElementById('category_dropdown');
        var SelectedIndex = getSelectedIndex.options[getSelectedIndex.selectedIndex].text;
        var getSelectedIndex1 = document.getElementById('post_type_dropdown');
        var SelectedIndex1 = getSelectedIndex1.options[getSelectedIndex1.selectedIndex].text;
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'name') {
                val1 = 'On';
            }
        }
        if (val1 == 'On' && SelectedIndex != '-- Select --' && SelectedIndex1 != '-- Select --') {
            return true;
        }
        else {
            showMapMessages('error', translateAlertString('"Select Term","Attach post type" and header "name" should be mapped.'));
            return false;
        }
    }
    else if (importer == 'customtaxonomy') {
        var getSelectedIndex = document.getElementById('taxonomydropdown');
        var SelectedIndex = getSelectedIndex.options[getSelectedIndex.selectedIndex].text;
        for (var j = 0; j < array.length; j++) {
            if (array[j] == 'name') {
                val1 = 'On';
            }
        }
        if (val1 == 'On' && SelectedIndex != '-- Select --') {
            return true;
        }
        else {
            showMapMessages('error', translateAlertString('"Custom Taxonomy" and header "name" should be mapped.'));
            return false;
        }
    }
// validation ends
}

function showMapMessages(alerttype, msg) {
    document.getElementById('showMsg').style.display = '';
    jQuery("#showMsg").addClass("maperror");
    document.getElementById('showMsg').innerHTML = msg;
    document.getElementById('showMsg').className += ' ' + alerttype;
    jQuery("#showMsg").fadeOut(10000);
}
function filezipopen()
{
var advancemedia = document.getElementById('advance_media_handling').checked;
if(advancemedia == true)
	document.getElementById('filezipup').style.display = '';
else
	document.getElementById('filezipup').style.display = 'none';

}
//var allowedextension ={ '.zip' : 1 };
function checkextension(filename)
{
var allowedextension ={ '.zip' : 1 };
var match = /\..+$/;
	  var ext = filename.match(match);
	  if (allowedextension[ext]) 
	  {
		return true;
	  } 
	  else 
	  {
		alert(translateAlertString("File must be .zip!"));
		//will clear the file input box.
		location.reload();
		return false;
	  } 

}
function process_inline() {

	var filename = document.getElementById('inlineimages').value;
        if(filename == '') {
                showMapMessages('error', translateAlertString('Upload image zip file'));
        } else {
        	var file_data = $('#inlineimages').prop('files')[0];
            	var form_data = new FormData();
          	var eventKey = document.getElementById('csvimporter_eventkey').value;
            	var pluginurl =  document.getElementById('pluginurl').value;
             	var slug      = document.getElementById('slug').value;
           	document.getElementById('ajaximage').style.display = '';
            	var  url = pluginurl +'/plugins/'+slug+'/lib/imagesinline/upload.php';
             	form_data.append('file', file_data)
             	form_data.append('eventKey', eventKey)
		form_data.append('action','inlineimage_upload')
            	
             	jQuery.ajax({
//                   	url: url, // point to server-side PHP script
                    	url: ajaxurl,
                    	dataType: 'text',  // what to expect back from the PHP script, if anything
                       	cache: false,
                 	contentType: false,
                    	processData: false,
                      	data: form_data,
                    	type: 'post',
                       	success: function(php_script_response){ 
				if(php_script_response == 'Uploaded file size exceeds the MAX Size in php.ini') {
					showMapMessages('error', php_script_response+translateAlertString('. Cannot upload')); 
                                        document.getElementById('ajaximage').style.display = 'none';
				} else {
					document.getElementById('ajaximage').style.display = 'none';
				}
                  	}
    		});
    	}
}
          

function inline_image_option(id) {
        var selected_option = document.getElementById(id).value;
        document.getElementById('inlineimagevalue').value = selected_option;
        if(selected_option == 'inlineimage_location') {
                var image_location = document.getElementById('imagelocation').value;
                document.getElementById('inlineimagevalue').value = image_location;
        }
}

function customimagelocation(val) {
        document.getElementById('inlineimagevalue').value = val;
}

function enableinlineimageoption() {
        var importinlineimage = document.getElementById('multi_image').checked;
        if(importinlineimage == true)
                document.getElementById('inlineimageoption').style.display = '';
        else
                document.getElementById('inlineimageoption').style.display = 'none';
}


function importRecordsbySettings(siteurl, runmethod) {
	// Update woocommerce variations
/*	var updateProductAttributeObj = document.getElementById('updateUsingSku');
	var updateProductAttribute = "import";
	if( updateProductAttributeObj != null )
	{
		if( updateProductAttributeObj.checked )
		{
			updateProductAttribute = updateProductAttributeObj.value;
		}
		else if( document.getElementById('updateUsingPostId').checked )
		{
			updateProductAttribute = document.getElementById('updateUsingPostId').value;
		}
		else
		{
			updateProductAttribute = updateProductAttributeObj.value;
		}
	} */
	// Update woocommerce variations
        var importProductAttributeObj = document.getElementById('importUsingSku');
        var importProductAttribute = "import";
        if( importProductAttributeObj != null )
        {
                if( importProductAttributeObj.checked )
                {
                        importProductAttribute = importProductAttributeObj.value;
                }
                else if( document.getElementById('importUsingPostId').checked )
                {
                        importProductAttribute = document.getElementById('importUsingPostId').value;
                }
                else
                {
                        importProductAttribute = importProductAttributeObj.value;
                }
        }
        var updateVariationAttributeObj = document.getElementById('updateVariationSku');
        var updateVariationAttribute = 'update';
        if( updateVariationAttributeObj != null )
        {
                if(updateVariationAttributeObj.checked)
                {
                        updateVariationAttribute = updateVariationAttributeObj.value;
                }
                else if(document.getElementById('updateVariationId').checked)
                {
                        updateVariationAttribute = document.getElementById('updateVariationId').value;
                }
                else
                {
                        updateVariationAttribute = updateVariationAttributeObj.value;
                }
        }

	document.getElementById('backbutton').style.display = 'none';
	/*     if(runmethod == 'dryrun') {
	       document.getElementById('ajaxloader').style.display = "";
	       document.getElementById('startbutton').style.display = "none";
	       document.getElementById('dryrunbutton').disabled = "true";
	       }
	       if(runmethod == 'normal') {
	       document.getElementById('dryrunbutton').style.display = "none";
	       }*/
	var importlimit = document.getElementById('importlimit').value;
	var file_type = document.getElementById('check_filetype').value;
	if ((parseInt(importlimit) >= 1) && (runmethod == 'dryrun')) {
		document.getElementById('server_request_warning').innerHTML = translateAlertString('You can set only 1 per request.');
		document.getElementById('server_request_warning').style.display = '';
	} 
	var get_requested_count = importlimit;
	//    var tot_no_of_records = document.getElementById('checktotal').value;
	var importas = document.getElementById('selectedImporter').value;
	var uploadedFile = document.getElementById('checkfile').value;
	var step = document.getElementById('stepstatus').value;
	//    var multiimage = document.getElementById('multiimage').checked;
	var mappingArr = document.getElementById('mappingArr').value;
	var import_row_id = document.getElementById('import_specific_records').value;
	var importspecificisChecked = jQuery('#importspecific').prop('checked');
	var renameattachment = jQuery('#renameattachment').prop('checked');
	if(renameattachment){
		var renameimage = 'renameimage';
	}else{
		var renameimage = '';
	}
	import_row_id = import_row_id.trim();
	var get_all_rows = import_row_id.split(','); 
	var row_nos = new Array();
	var row_index = 0;
	if(runmethod == 'dryrun') {
		var tot_no_of_records = 1;
	} else {
		var tot_no_of_records = document.getElementById('checktotal').value;
	}
	if(importspecificisChecked){
		for(var a=0; a<get_all_rows.length; a++){
			var add_all_rows = get_all_rows[a].split('-'); 
			var is_inter_limit = add_all_rows.length;
			if(is_inter_limit == 2){
				for(var b = add_all_rows[0]; b <= add_all_rows[1]; b++) {
					row_nos[row_index] = b;
					row_index++;
				}
			} else {
				row_nos[row_index] = get_all_rows[a].trim();
				row_index++;
			}
		}
	}else{
		for(var a=0;a<tot_no_of_records;a++)
			row_nos[a] = a+1;
	}

	if (importas == 'customerreviews') {
		if(document.getElementById('duplicatetitle') != null){
		var dupTitle = document.getElementById('duplicatetitle').checked;
		}
	}
	else {
		if (importas != 'customtaxonomy' && importas != 'categories' && importas != 'comments') {
			if(document.getElementById('duplicatecontent') != null && document.getElementById('duplicatetitle') != null){
			var dupContent = document.getElementById('duplicatecontent').checked;
			var dupTitle = document.getElementById('duplicatetitle').checked;
			}
			else{
				dupContent = 'false';
				dupTitle = 'false';
			}
		}
	}
	var currentlimit = document.getElementById('currentlimit').value;
	var tmpCnt = document.getElementById('tmpcount').value;
	if(runmethod == 'dryrun') {
		if(parseInt(tmpCnt) >= parseInt(tot_no_of_records)) {
			document.getElementById('ajaxloader').style.display = "none";
			document.getElementById('startbutton').style.display = "none";
			//		    document.getElementById('dryrunbutton').style.display = "none";
			document.getElementById('terminatenow').style.display = "none";
			document.getElementById('continuebutton').style.display = "none";
			document.getElementById('importagain').style.display = "";
			document.getElementById('dwnld_log_link').style.display = "";
			return false;
		} 
		var no_of_tot_records = 1;
	} else {
		var no_of_tot_records = document.getElementById('tot_records').value;
	}
	var importinlineimage = true;
	var imagehandling = true;
	var inline_image_location = true;
	/*    if( importas != 'customtaxonomy' && importas != 'categories' && importas != 'comments' && importas != 'users' && importas != 'customerreviews') {

	      var importinlineimage = document.getElementById('multi_image').checked;
	      var imagehandling = document.getElementById('inlineimagevalue').value;
	      var inline_image_location = document.getElementById('inline_image_location').value;
	      }
	      if(importinlineimage == true) {
	      } else {
	      } */
	var get_log = document.getElementById('log').innerHTML;
	//var imagehandling = document.getElementById('inlineimagevalue').value;
	//var inline_image_location = document.getElementById('inline_image_location').value;

	var terminate_action = document.getElementById('terminateaction').value;
	var importmode =document.getElementById('importmode').value;
	document.getElementById('reportLog').style.display = '';
	if (get_requested_count != '') {
		//return true;
	} else {
		document.getElementById('showMsg').style.display = "";
		document.getElementById('showMsg').innerHTML = '<p id="warning-msg" class="alert alert-warning">' + translateAlertString("Fill all mandatory fields.") + '</p>';
		jQuery("#showMsg").fadeOut(10000);
		return false;
	}
	if (parseInt(get_requested_count) <= parseInt(no_of_tot_records)) {
		document.getElementById('server_request_warning').style.display = 'none';
	} else {
		document.getElementById('server_request_warning').style.display = '';
		return false;
	}
	if (get_log == '<p style="margin:15px;color:red;">' + translateAlertString("NO LOGS YET NOW.") + '</p>') {
		//document.getElementById('log').innerHTML = '<p style="margin:15px;color:red;">Your Import Is In Progress...</p>';
		document.getElementById('log').innerHTML = '';
		document.getElementById('startbutton').disabled = true;
	}
	document.getElementById('ajaxloader').style.display = "";
	if(document.getElementById('ajaxloader').style.display == "")
		document.getElementById('dispinprogress').innerHTML = '<p style="margin:15px;color:red;">' + translateAlertString("Your Import Is In Progress...") + '</p>';
	else
		document.getElementById('dispinprogress').style.display = 'none';
	document.getElementById('terminatenow').style.display = "";
	var tempCount = parseInt(tmpCnt);
	totalCount = parseInt(row_nos.length);
	//alert(totalCount);
	if (tempCount >= totalCount) {
		document.getElementById('ajaxloader').style.display = "none";
		document.getElementById('startbutton').style.display = "none";
		//	document.getElementById('dryrunbutton').style.display = "none";
		document.getElementById('importagain').style.display = "";
		if(document.getElementById('importagain').style.display == "") {
			jQuery('#log').prepend(jQuery("<p style='margin-left:10px;color:green;'>"+ translateAlertString('Import successfully completed!.') + "</p>"));
			document.getElementById('dispinprogress').innerHTML = '';
		}
		document.getElementById('terminatenow').style.display = "none";
		document.getElementById('dwnld_log_link').style.display = "";
		var unlink = document.getElementById('filedir').value;
		var doaction = new Array({unlink:unlink});
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
			'action': 'smack_csv_unlink',
			'postdata': doaction,
			},
			success: function (data)  {

			},
			error: function (errorThrown) {
				console.log(errorThrown);
			}

		}); 
		return false;

	}
	if (terminate_action == 'continue') {
		var postdata = new Array();
		var startLimit = currentlimit;
		var endLimit = parseInt(importlimit) + parseInt(currentlimit); 
		if(endLimit >= totalCount) {
			endLimit = totalCount;
		}
		postdata = {'dupContent': dupContent, 'dupTitle': dupTitle,'importlimit': importlimit, 'limit': currentlimit, 'totRecords': totalCount, 'selectedImporter': importas, 'uploadedFile': uploadedFile, 'tmpcount': tmpCnt, 'importinlineimage':importinlineimage,'inlineimagehandling':imagehandling, 'inline_image_location':inline_image_location, 'import_row_id': row_nos, 'startLimit': startLimit, 'endLimit': endLimit, 'importspecificisChecked':importspecificisChecked, 'importmode':importmode, 'importproductattribute': importProductAttribute,'updateVariationAttribute':updateVariationAttribute, 'file_type': file_type,'renameimage':renameimage}
		var tmpLoc = document.getElementById('tmpLoc').value;
		var record_tot = document.getElementById('tot_num').value;
		var imp_count = document.getElementById('imp_count').value;
		//alert(tmp_count);
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
			'action': 'smack_csv_importByRequest',
			'postdata': postdata,
			'siteurl': siteurl,
			'runmethod': runmethod,
			},
			success: function (data) {
				if (parseInt(tmpCnt) == parseInt(totalCount)) {
					document.getElementById('terminatenow').style.display = "none";
				}
				if (parseInt(tmpCnt) < parseInt(totalCount)) {
					if (terminate_action == 'continue') {
						currentlimit = parseInt(currentlimit) + parseInt(importlimit);
						document.getElementById('currentlimit').value = currentlimit;
						console.log('impLmt: ' + importlimit + 'totRecds: ' + totalCount);
						document.getElementById('tmpcount').value = parseInt(tmpCnt) + parseInt(importlimit);
						if(runmethod == 'dryrun') {
							setTimeout(function () { importRecordsbySettings('siteurl', 'dryrun') }, 0);
						} else {
							setTimeout(function () { importRecordsbySettings('siteurl', 'normal') }, 0);
						}
					} else {
						return false;
					}
				} else {
					document.getElementById('ajaxloader').style.display = "none";
					document.getElementById('startbutton').style.display = "none";
					//		    document.getElementById('dryrunbutton').style.display = "none";
					document.getElementById('terminatenow').style.display = "none";
					document.getElementById('continuebutton').style.display = "none";
					document.getElementById('importagain').style.display = "";
					if(document.getElementById('importagain').style.display == "") {
						document.getElementById('dispinprogress').innerHTML = ''; 
						jQuery('#log').prepend(jQuery("<p style='margin-left:10px;color:green;'>"+ translateAlertString('Import successfully completed!.')+"</p>"));
					}	
					document.getElementById('dwnld_log_link').style.display = "";
					return false;
				}
				//                document.getElementById('log').innerHTML += data + "<br>";
				jQuery('#log').prepend(jQuery(data + "<br>"));
				if(importspecificisChecked){
					var get_specificrecordimportcount = document.getElementById('specificrecordimportcount').value;
//alert(get_specificrecordimportcount);
					if(parseInt(get_specificrecordimportcount) == 0)
						var remaining_rec = parseInt(totalCount) - importlimit;
					else
						var remaining_rec = parseInt(get_specificrecordimportcount) - importlimit;
					document.getElementById('specificrecordimportcount').value = remaining_rec;
				} else {
					var remaining_rec = parseInt(record_tot) - importlimit;
				}
				var importlimitstart = document.getElementById('importlimit').value;
/*				if(importlimitstart != 0){
					var remaining_rec =  parseInt(record_tot) - 1;
					var remaining_rec = parseInt(record_tot) - importlimitstart;
				//	var imp_count = parseInt(record_tot) + 1;
				//	var imp_count = parseInt(record_tot) + importlimitstart;


				}*/

//alert(importlimitstart);
				var current_processing_record = document.getElementById('tmpcount').value;
				if(importspecificisChecked){
                                       if(parseInt(current_processing_record) >= parseInt(totalCount))
                                        current_processing_record = totalCount;
                                }else{
                                       if(parseInt(current_processing_record) >= parseInt(no_of_tot_records))
                                        current_processing_record = no_of_tot_records;
                                }
				if(parseInt(remaining_rec) < 0)
					remaining_rec = 0;
				document.getElementById('imprec').innerHTML = "<span style='color:green;'>"+ translateAlertString("Current Processing Record: ") + current_processing_record+"/"+totalCount+"</span>";
				document.getElementById('remrec').innerHTML = "<span style='color:red;'>"+ translateAlertString("Remaining Record: ") + remaining_rec+"/"+totalCount+"</span>";
				document.getElementById('tot_num').value = parseInt(remaining_rec);
//				var imported_rec = parseInt(imp_count) + 1;
//				document.getElementById('imp_count').value = parseInt(imported_rec);
			},
			error: function (errorThrown) {
			       console.log(errorThrown);
			}
		});
	} else {
		//document.getElementById('log').innerHTML += "<div style='margin-left:7px;color:red;'> Import process has been terminated.</div></br>";
		jQuery('#log').prepend(jQuery("<div style='margin-left:7px;color:red;'> "+ translateAlertString('Import process has been terminated.') + "</div></br>"));
		document.getElementById('ajaxloader').style.display = "none";
		document.getElementById('startbutton').style.display = "none";
		//	document.getElementById('dryrunbutton').style.display = "none";
		document.getElementById('terminatenow').style.display = "none";
		document.getElementById('continuebutton').style.display = "";
		if(document.getElementById('continuebutton').style.display == "")
			document.getElementById('dispinprogress').innerHTML = '';
		document.getElementById('dwnld_log_link').style.display = "";
		return false;
	}
}

// Terminate import process
function terminateProcess() {
    document.getElementById('terminateaction').value = 'terminate';
}

// Continue import process
function continueprocess() {
    var tot_no_of_records = document.getElementById('checktotal').value;
    var tmpCnt = document.getElementById('tmpcount').value;
    if (parseInt(tmpCnt) > parseInt(tot_no_of_records)) {
        document.getElementById('terminatenow').style.display = "none";
    } else {
        document.getElementById('terminatenow').style.display = "";
    }
    //document.getElementById('log').innerHTML += "<div style='margin-left:7px;color:green;'> Import process has been continued.</div></br>";
    jQuery('#log').prepend(jQuery("<div style='margin-left:7px;color:green;'>"+translateAlertString(' Import process has been continued.')+ "</div></br>"));
    document.getElementById('ajaxloader').style.display = "";
    document.getElementById('startbutton').style.display = "";
    document.getElementById('continuebutton').style.display = "none";
    document.getElementById('dwnld_log_link').style.display = "none";
    document.getElementById('terminateaction').value = 'continue';
    setTimeout(function () {
        importRecordsbySettings()
    }, 0);
}
// Enable/Disable WP-e-Commerce Custom Fields
function enablewpcustomfield(val, id) {
    ecommercesetting(id);
    if (val == 'wpcustomfields') {
        document.getElementById('wpcustomfieldstr').style.display = '';
    }
    else {
        document.getElementById('wpcustomfields').checked = false;
        document.getElementById('wpcustomfieldstr').style.display = 'none';
    }
}

/*function saveSettings() {
    var selected = '';
    var len = document.getElementsByName('recommerce').length;
    for (var k = 0; k < len; k++) {
        var chk = document.getElementsByName('recommerce')[k].checked;
        if (chk == true) {
            selected = k;
        }
    }
    var recommerce = document.getElementsByName('recommerce')[selected].value;

    var wpcustomfields = document.getElementById('wpcustomfields').checked;
    var selected = '';
    var len = document.getElementsByName('rcustompost').length;
    for (var k = 0; k < len; k++) {
        var chk = document.getElementsByName('rcustompost')[k].checked;
        if (chk == true) {
            selected = k;
        }
    }
    var rcustompost = document.getElementsByName('rcustompost')[selected].value;
    var rcustomfield = document.getElementsByName('rcustomfield').checked;
    var rwpmembers = document.getElementById('rwpmembers').checked;
    var selected = '';
    var len = document.getElementsByName('rseooption').length;
    for (var k = 0; k < len; k++) {
        var chk = document.getElementsByName('rseooption')[k].checked;
        if (chk == true) {
            selected = k;
        }
    }
    var rseooption = document.getElementsByName('rseooption')[selected].value;
    var drop_table = document.getElementById('drop_table').checked;
    var woocomattr = document.getElementById('woocomattr').checked;
    var doaction = new Array({recommerce: recommerce, wpcustomfields: wpcustomfields, rcustompost: rcustompost, rcustomfield: rcustomfield, rwpmembers: rwpmembers, drop_table: drop_table, rseooption: rseooption, woocomattr: woocomattr});

    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': 'missingPluginss',
            'postdata': doaction,
        },
        type: 'post',
        async: false,
        success: function (response) {
            if (response != '') {
                document.getElementById('ShowMsg').innerHTML = '<p>' + response + '</p>'
                document.getElementById('ShowMsg').style.display = '';
                jQuery('#ShowMsg').delay(7000).fadeOut();
            }
        }
    });

}*/

function sendemail2smackers() {
    var message_content = document.getElementById('message').value;
    if (message_content != '')
        return true;
    else
        document.getElementById('showMsg').style.display = '';
    document.getElementById('showMsg').innerHTML = '<p id="warning-msg" class="alert alert-warning">' + translateAlertString("Fill all mandatory fields.") + '</p>';
    jQuery("#showMsg").fadeOut(10000);
    return false;
}

function Reload() {
    window.location.reload();
}

function exportprocess() {
    var selected = '';
    var len = document.getElementsByName('export').length;
    for (var k = 0; k < len; k++) {
        var chk = document.getElementsByName('export')[k].checked;
        if (chk == true) {
            selected = k;
        }
    }
    var selectedvalue = document.getElementsByName('export')[selected].value;

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'export',
            'postdata': selectedvalue,
        },
        success: function (data) {
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
}


//line chart
function lineStats() {
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'smack_csv_importer_linechart',
            'postdata': 'importerlinechartdata',
        },
        dataType: 'json',
        cache: false,
        success: function (data) {
            var val = JSON.parse(data);
            var get_cat = val['cat'];
// Comment module was removed in pro version 4.3.0 so only val[2] is not added in "line" variable.
            var line = [val[0], val[1], val[3], val[4], val[5], val[6], val[7], val[8], val[9],val[10],val[11],val[12]];
            jQuery('#lineStats').highcharts({
                title: {
                    text: '',
                    x: -5 //center
                },
                subtitle: {
                    text: '',
                    x: -5
                },
                xAxis: {
                    categories: get_cat 
                },
                yAxis: {
                    title: {
                        text: 'Import (Nos)'
                    },
                    plotLines: [
                        {
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }
                    ]
                },
                tooltip: {
                    valueSuffix: ' Nos'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: line  
            });
        }
    });
}
function drillStats() {

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'smack_csv_importer_drillchartdata',
            'postdata': 'importerdrillchartdata',
        },
        dataType: 'json',
        cache: false,
        success: function (data) {
            if (data == 'no_import_yet') {
		jQuery('#drillStats').html("<h2 style='color: red;text-align: center;margin-top: 140px;' >" + translateAlertString('No Imports Yet')+ "</h2>");
            }
            else {
                jQuery(function () {
                    Highcharts.data({
                        csv: data, 
                        itemDelimiter: '\t',
                        parsed: function (columns) {

                            var brands = {},
                                brandsData = [],
                                versions = {},
                                drilldownSeries = [];

                            // Parse percentage strings
                            columns[1] = jQuery.map(columns[1], function (value) {
                                if (value.indexOf('%') === value.length - 1) {
                                    value = parseInt(value);
                                }

                                return value;
                            });
                            jQuery.each(columns[0], function (i, name) {
                                var brand,
                                    version, ver_name;

                                if (i >= 0) {
                                    // Remove special edition notes
                                    ver_name = name.split(' ')[1];
                                    name = name.split(' ')[0]; 
                                    version = ver_name;
                                    if (version) {
                                        version = version;
                                    }
                                    brand = name.replace(version, '');
                                    // Create the main data
                                    if (!brands[brand]) {
                                        brands[brand] = columns[1][i];
                                    } else {
                                        brands[brand] += columns[1][i];
                                    }
                                    // Create the version data
                                    if (version !== null) {
                                        if (!versions[brand]) {
                                            versions[brand] = [];
                                        }
                                        versions[brand].push(['File:' + version, columns[1][i]]);
                                    }
                                }

                            });

                            jQuery.each(brands, function (name, y) {
                                brandsData.push({
                                    name: name,
                                    y: y,
                                    drilldown: versions[name] ? name : null
                                });
                            });
                            jQuery.each(versions, function (key, value) {
                                drilldownSeries.push({
                                    name: key,
                                    id: key,
                                    data: value
                                });
                            });

                            // Create the chart
                            jQuery('#drillStats').highcharts({
                                chart: {
                                    type: 'pie'
                                },
                                title: {
                                    text: ''
                                },
                                subtitle: {
                                    text: ''
                                },
                                plotOptions: {
                                    series: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}: {point.y} Nos'
                                        }
                                    }
                                },

                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} Nos</b> of total<br/>'
                                },

                                series: [
                                    {
                                        name: 'Module',
                                        colorByPoint: true,
                                        data: brandsData
                                    }
                                ],
                                drilldown: {
                                    series: drilldownSeries
                                }
                            })

                        }
                    });
                });


            }
        }
    });
}
function inlinebar() {
    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': 'thirdchart',
            'postdata': 'thirdchartdata',
        },
        type: 'post',
        success: function (response) {

        }
    });


}

//
function checkcsvfound(id) {
    var checkcsvfound = document.getElementById("version" + id);
    var selected_version = checkcsvfound.options[checkcsvfound.selectedIndex].value; 
    document.getElementById('selectedversion' + id).value = selected_version;
}

function download_selected_file(id) {
    var selected_version = document.getElementById('selectedversion' + id).value;
    if (selected_version == 0) {
        showMapMessages('error', translateAlertString('Please select the version to download.'));
        return false;
    }
    else {
        if (selected_version != '-- Select --' && selected_version != 0) {
            document.getElementById('button_action' + id).value = 'download_file'; 
            document.getElementById("fileManager_Action" + id).submit();
        }
    }
}

function downloadallfile(id) {
    var managerId = document.getElementById('managerid' + id).value; 
    document.getElementById('button_action' + id).value = 'download_all_file';
    document.getElementById("fileManager_Action" + id).submit();
}

function check_exists(id) {
    var version_id = document.getElementById('version' + id).value;
    var ver = version_id.split('__');
    var checkcsvfound = ver['0'];
    if (checkcsvfound == '') {
        showMapMessages('error', translateAlertString('Please select the version to download'));
        return false;
    }
    else {
        var doaction = new Array({action: 'download', file: checkcsvfound});
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'smack_check_fileexist',
                'postdata': doaction,
            },
            type: 'post',

            success: function (response) {
                if (response == 'The file does not exist') {
                    showMapMessages('error', translateAlertString('The file does not exist'));
                    return false;
                }
            }
        });
    }
}

function deletefiles(id) {
    var version_id = document.getElementById('version' + id).value;
    var ver = version_id.split('__');
    var checkcsvfound = ver['0'];
    var recordid = document.getElementById('managerid' + id).value;
    var importedas = document.getElementById('importedas' + id).value;
    var csv_name = document.getElementById('csv_name' + id).value;
    var versionoption = document.getElementsByName("version");
    //if (checkcsvfound != '') {
	if(checkcsvfound != versionoption[0].value){
        var totalcount = document.getElementById('totalcount').value;
        var doaction = new Array({action: 'deletefiles', file: csv_name, managerid: recordid, importedas: importedas, totalfilescount: totalcount, csvname: checkcsvfound});
        var r = confirm(translateAlertString("Do you want to delete the selected version ?"));
        if (r == true) {
            x = "You pressed OK!";
        }
        else {
            x = "You pressed Cancel!";
        }
        if (x == "You pressed OK!") {
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    'action': 'deletefiles',
                    'postdata': doaction,
                },
                type: 'post',
                success: function (response) {
                    var getversion = document.getElementById('version' + id);
                    getversion.remove(getversion.selectedIndex);
                    showMapMessages('error', translateAlertString('Your selected version has been deleted successfully'));
                }
            });
        }
    }
    else {
        showMapMessages('error', translateAlertString('Please select the version to delete'));
        return false;
    }
}

function deletefilesandecords(id)
{
    var recordid = document.getElementById('managerid' + id).value;
    var importedas = document.getElementById('importedas' + id).value;
    var csv_name = document.getElementById('csv_name' + id).value;
    var totalcount = document.getElementById('totalcount').value;
    var doaction = new Array({action: 'deletefilesandrecords', csvname: csv_name, managerid: recordid, importedas: importedas, totalfilescount: totalcount});
    var r = confirm(translateAlertString("Do you want to delete all version of the file and records completely ?"));
    if (r == true) {
        x = "You pressed OK!";
    }
    else {
        x = "You pressed Cancel!";
    }
    if (x == "You pressed OK!") {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'deletefilesandrecords',
                'postdata': doaction,
            },
            type: 'post',

            success: function (response) {
                showMapMessages('success', translateAlertString('Your files and records has been deleted successfully'));
                window.location.reload();
            }
        });
    }
}

function deleteall(id)
{
    var recordid = document.getElementById('managerid' + id).value;
    var importedas = document.getElementById('importedas' + id).value;
    var csv_name = document.getElementById('csv_name' + id).value;
    var totalcount = document.getElementById('totalcount').value;
    var doaction = new Array({action: 'deleteall', csvname: csv_name, managerid: recordid, importedas: importedas, totalfilescount: totalcount});
    var r = confirm(translateAlertString("Do you surely want to delete all records ?"));
    if (r == true) {
        x = "You pressed OK!";
    }
    else {
        x = "You pressed Cancel!";
    }
    if (x == "You pressed OK!") {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'deletefilesandrecords',
                'postdata': doaction,
            },
            type: 'post',

            success: function (response) {
                showMapMessages('error', translateAlertString('Your records has been deleted successfully'));
                window.location.reload();
            }
        });
    }
}

function trashall(id)
{
    var csv_name = document.getElementById('csv_name' + id).value;
    var importedas = document.getElementById('importedas' + id).value;
    var sdmid = document.getElementById('managerid' + id).value;
    var perform = document.getElementById('trash' + id).value;
    var doaction = new Array({action: 'trashall', csvname: csv_name, managerid: sdmid, importedas: importedas, perform: perform});
    var r = confirm(translateAlertString("Do you surely want to ") + perform + translateAlertString(" all records ?"));
    if (r == true) {
        x = "You pressed OK!";
    }
    else {
        x = "You pressed Cancel!";
    }
    if (r) {
        jQuery.ajax({
            url: ajaxurl,
            data: {
                'action': 'trashall',
                'postdata': doaction,
            },
            type: 'post',

            success: function (response) {
                if (perform == 'trash') {

                    showMapMessages('success', translateAlertString('Your records has been trashed successfully'));
                    document.getElementById('trash' + id).value = 'restore';
                    document.getElementById('trashall' + id).innerHTML = '<span class="manageraction glyphicon glyphicon-repeat"></span>';
                    document.getElementById('trashall' + id).title = 'Restore all records';
                }
                else if (perform == 'restore') {
                    showMapMessages('success', translateAlertString('Your records has been restored successfully'));
                    document.getElementById('trash' + id).value = 'trash';
                    document.getElementById('trashall' + id).innerHTML = '<span class="manageraction glyphicon glyphicon-trash"></span>';
                    document.getElementById('trashall' + id).title = 'Trash all records';
                }
            }
        });
    }
}

function export_module() {
    var get_selected_module = document.getElementsByName('export');
    for (var i = 0, length = get_selected_module.length; i < length; i++) {
        if (get_selected_module[i].checked) {
            // do whatever you want with the checked radio
            // only one radio can be logically checked, don't check the rest
            return true;
        }
    }
    showMapMessages('error', translateAlertString('Please choose one module to export the records!'));
    return false;
}

function exportexclusion(name, id) {
        var selected_node = document.getElementById(id).checked;
	var export_module_type = document.getElementById('export_module_type').value;
	var customposts_type = document.getElementById('export_cust_type').value;
	var taxonomies = document.getElementById('export_taxo_type').value;
        if(selected_node == true)
                var exclusion_status = 'enable';
        else
                var exclusion_status = 'disable';
        var doaction = new Array({'exclusion_status': exclusion_status, 'exclusion_node': name,'export_module':export_module_type,'customposts_type':customposts_type,'taxonomies':taxonomies});
        jQuery.ajax({
                url: ajaxurl,
                data: {
                        'action': 'UpdateExportExclusion',
                        'postdata': doaction,
                },
                type: 'post',
                success: function (response) {
//                        alert(response); return false;
                        // showMapMessages('error', 'Your records has been deleted successfully');
                        // window.location.reload();
                }
        });
}

//Export check All
function exportselectall(param,group)
{
        var res = new Array();
	var export_module_type = document.getElementById('export_module_type').value;
	var result = document.getElementsByClassName(group+'_class');
	var customposts_type = document.getElementById('export_cust_type').value;
	var taxonomies = document.getElementById('export_taxo_type').value;
        var result = document.getElementsByClassName(group+'_class');
	for(var j=0;j<result.length;j++) {
		var name1 = result[j].name;
		res[j] = name1;
	}
        for(var i=0;i<result.length;i++) {
                var ans = result[i].id;
               var check = document.getElementById(ans).checked;
               if(check == true) { 
                        if(param == 'uncheck')
                        document.getElementById(ans).checked = false;
			jQuery.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: {
			'action': 'UpdateExportExclusion',
			'eventdoneby': param,
			'export_module':export_module_type,
			'cust_posts_type':customposts_type,
			'taxo_type':taxonomies,
			'result':res,
                        },
                        success: function (response) {
//                        alert(response); return false;
                        }
                	});

               }
               else {
                        if(param == 'check')
                        document.getElementById(ans).checked = true;
			jQuery.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: {
			'action': 'UpdateExportExclusion',
			'eventdoneby': param,
			'export_module':export_module_type,
			'cust_posts_type':customposts_type,
			'taxo_type':taxonomies,
			'result':res,
                        },
                        success: function (response) {
//                        alert(response); return false;
                        }
                	});
               }
       }
}

function performdeleteaction(mod, id, buttonthis) {
    var res = confirm(translateAlertString('Are you sure you want to delete this ?'));
    if (!res) return false;

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'ultimate_csv_deletemappingorschedule',
            'mod': mod,
            'id': id,
        },
        success: function (data) {
            if (data.msgclass == 'success') {
                var tr = jQuery(buttonthis).closest('tr');
                tr.css("background-color", "#FF3700");

                tr.fadeOut(400, function () {
                    tr.remove();
                });
                return false;
            }
            shownotification(data.msg, data.msgclass)
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
}

function is_categoryicon_avail() {
    var doaction = 'is_caticon_plugin_avail';

    jQuery.ajax({
        url: ajaxurl,
        data: {
            'action': 'is_caticon_plugin_avail',
            'postdata': doaction,
        },
        type: 'post',

        success: function (response) {
            if (response == 'notavail') {
                showMapMessages('error', translateAlertString('Category Icons plugin not available. Please Install the Plugin first!'));
                document.getElementById("caticonenable").checked = false;
            }
            else if (response == 'notactive') {
                showMapMessages('error', translateAlertString('Please activate Category Icons Plugin first!'));
                document.getElementById("caticonenable").checked = false;
            }
        }
    });
}

function check_allnumeric(inputtxt) {
    var numbers = /^[0-9]+$/;
    if (inputtxt.match(numbers)) {
    }
    else {
        if (inputtxt == '')
            alert(translateAlertString('Fill all mandatory fields.'));
        else
            alert(translateAlertString('Please enter numeric characters only'));
    }
enableDisableImportButton();
}

function enableDisableImportButton(){

	var scheduleNow = jQuery('#scheduleNow').prop('checked');
	var importNow = jQuery('#importNow').prop('checked');
	var import_specific_rec_textbox = "#import_specific_records";
	var import_specific_rec_checkbox = '#importspecific';
	var button = 'startbutton';

	if(scheduleNow){
		import_specific_rec_textbox = "#import_specific_records_scheduler";
		import_specific_rec_checkbox = '#importspecific_scheduler';
		button = 'schedule_mapping';
	}

	var check = true;

	if(importNow){
		check = false;
		var importlimit = jQuery('#importlimit').val();
		var numbers = /^[0-9]+$/;
		if (importlimit.match(numbers)) 
			check = true;

	}	

	var isChecked = jQuery(import_specific_rec_checkbox).prop('checked');
	var import_specific_records = jQuery(import_specific_rec_textbox).val();

	if((!isChecked && check)){
		document.getElementById(button).disabled = false;
	}
	else if((isChecked)&&(check)){
		if(import_specific_records != ''){
			document.getElementById(button).disabled = false;

		}
		else{
			document.getElementById(button).disabled = true;
			jQuery( import_specific_rec_textbox).focus();
			showMapMessages('error', 'Please Specify Records.');
		}
	}
	else	
		document.getElementById(button).disabled = true; 
}

function import_again() { 
    var get_current_url = document.getElementById('current_url').value;
    window.location.assign(get_current_url);
}

/*function renamefile() {
    var renameforfile = document.getElementById('renametextbox').value;
    if (renameforfile == '' || renameforfile == null) {
        document.getElementById('importfile').disabled = true;
        alert('Textbox should not empty');
        return false;
    }
    document.getElementById('importfile').disabled = false;
    renameforfile = renameforfile.split('.csv');
    renameforfile = renameforfile[0];
    renameforfile = renameforfile + '.csv';
    //uploaddir
    var file_name = document.getElementById('uploadFileName').value; 
    var cur_module = document.getElementById('current_module').value;
    var currentBlog = document.getElementById('cur_blogid').value;
    var doaction = new Array({action: 'rename_file', filename: file_name, renamefile: renameforfile, currentmodule: cur_module, currentblog: currentBlog, });
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action': 'smack_csv_importer_checkfileversion',
            'postdata': doaction,
        },
        success: function (data) {
            if (data == 'exist') {
                document.getElementById('importfile').disabled = true;
                alert('Filename already exist! Try another one.');
                return false;
            } else {
                document.getElementById('filenamedisplay').innerHTML = data;
                var get_current_version = data.split('-' + currentBlog + '-');
                get_current_version = get_current_version[1].split('.');
                var current_version = get_current_version[0];
                document.getElementById('current_file_version').value = current_version;
                var new_file_name = data.split('-');
                document.getElementById('uploadFileName').value = new_file_name[0] + '-' + cur_module + '-' + currentBlog + '-1.csv';
                var new_csv_name = new_file_name[0].split('-' + cur_module);
                document.getElementById('upload_csv_realname').value = new_csv_name[0] + '-' + cur_module + '-' + currentBlog + '.csv';
            }
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
    document.getElementById('importfile').disabled = false;
}
function updatewith() {
    var up_postid = document.getElementById('updatewithpostid').checked;
    var currentmodule = document.getElementById('current_module').value;
    if (currentmodule != 'users' && currentmodule != 'customtaxonomy' && currentmodule != 'categories')
        var up_post_title = document.getElementById('updatewithposttitle').checked;

    if (up_postid == true || up_post_title == true) {
        document.getElementById('importfile').disabled = false;
    } else {
        document.getElementById('importfile').disabled = true;
    }
}
function updateRename() {
    var selected = '';
    document.getElementById('importfile').disabled = true;
    var len = document.getElementsByName('updaterenamefile').length; 
    for (var k = 0; k < len; k++) {
        var chk = document.getElementsByName('updaterenamefile')[k].checked;
        if (chk == true) {
            selected = k;
        }
    }
    var renameupdate = document.getElementsByName('updaterenamefile')[selected].value;
    var importbymethod = document.getElementById('importbymethod').value; //alert(importbymethod); return false;
    if (renameupdate == 'rename') {
	if(importbymethod == 'dwnldftpfile' || importbymethod == 'useuploadedfile') {
		document.getElementById('csv_import_file').style.height = "720px";
		jQuery('.importmethod').attr('disabled', true);
	} else {
	        document.getElementById('csv_import_file').style.height = "550px";
		jQuery('.importmethod').attr('disabled', true);
	}
        document.getElementById('updatediv').style.display = "none";
        document.getElementById('renamediv').style.display = "";
    }
    else if (renameupdate == 'update') {
        var up_postid = document.getElementById('updatewithpostid').checked;
        var up_post_title = document.getElementsByName('updatewithposttitle').checked;
	if(importbymethod == 'dwnldftpfile' || importbymethod == 'useuploadedfile') {
		document.getElementById('csv_import_file').style.height = "720px";
		jQuery('.importmethod').attr('disabled', true);
	} else {
	        document.getElementById('csv_import_file').style.height = "550px";
		jQuery('.importmethod').attr('disabled', true);
	}
        document.getElementById('renamediv').style.display = "none";
        document.getElementById('updatediv').style.display = "";
    }
}*/

function fileVer(file_name) {
    var doaction = new Array({action: 'file_exist_check', filename: file_name});
    var ret_val = '';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        async: false,
        data: {
            'action': 'smack_csv_importer_checkfileversion',
            'postdata': doaction,
        },
        success: function (data) {
            ret_val = data;
        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });
    return ret_val;

}

// Function to select all record for the global actions in file manager
function AllManagerRecords(id) {
    var get_tot_record_count = document.getElementById('totalcount').value;
    for (var i = 1; i <= get_tot_record_count; i++) {
        var isCheck = document.getElementById('selectAllId').checked;
        if (isCheck == true)
            document.getElementById('selectAllId' + i).checked = true;
        else
            document.getElementById('selectAllId' + i).checked = false;
    }
}

// Function for unselect the select all option
function checkwhetherallchecked(id) {
    var inc = 0;
    if (document.getElementById(id).checked == false) {
        document.getElementById('selectAllId').checked = false;
    }
    else {
        var get_tot_record_count = document.getElementById('totalcount').value;
        for (var i = 1; i <= get_tot_record_count; i++) {
            if (document.getElementById('selectAllId' + i).checked == true)
                inc = inc + 1;
            if (inc == get_tot_record_count)
                document.getElementById('selectAllId').checked = true;
        }
    }
}
// function for download files by global action
function downloadallfiles() {
	if(document.getElementById('totalcount') != null)
    var totalCount = document.getElementById('totalcount').value;
    var selected_manager_records = '';
    for (var i = 1; i <= totalCount; i++) {
        if (document.getElementById('selectAllId' + i).checked == true) {
            selected_manager_records += document.getElementById('managerid' + i).value + ',';
        }
    }
    selected_manager_records = selected_manager_records.slice(0, selected_manager_records.lastIndexOf(","));
    document.getElementById('choosen_manager_records').value = selected_manager_records;
    document.getElementById('gbuttonaction').value = 'download_all_file';
    document.getElementById("global_Action").submit();
}
// function for delete files and records by global action
function delete_allfiles_and_records(doaction) {
	if(document.getElementById('totalcount') != null)
    var totalCount = document.getElementById('totalcount').value;
    var selected_manager_records = '';
    for (var i = 1; i <= totalCount; i++) {
        if (document.getElementById('selectAllId' + i).checked == true) {
            selected_manager_records += document.getElementById('managerid' + i).value + ',';
        }
    }
    selected_manager_records = selected_manager_records.slice(0, selected_manager_records.lastIndexOf(","));
    document.getElementById('choosen_manager_records').value = selected_manager_records;
    if (doaction == 'deleteallfilesandrecords') {
        document.getElementById('gbuttonaction').value = 'deleteall_file_and_records';
    } else if (doaction == 'deleteallrecords') {
        document.getElementById('gbuttonaction').value = 'deleteall_records';
    }
    document.getElementById("global_Action").submit();
}
// function for trash and restore all records by global action
function gtrash_restore_records(doaction) {
	if(document.getElementById('totalcount') != null)
    var totalCount = document.getElementById('totalcount').value;
    var selected_manager_records = '';
    for (var i = 1; i <= totalCount; i++) {
        if (document.getElementById('selectAllId' + i).checked == true) {
            selected_manager_records += document.getElementById('managerid' + i).value + ',';
        }
    }
    selected_manager_records = selected_manager_records.slice(0, selected_manager_records.lastIndexOf(","));
    document.getElementById('choosen_manager_records').value = selected_manager_records;
    if (doaction == 'trashallrecords') {
        document.getElementById('gbuttonaction').value = 'trash_all';
    } else if (doaction == 'restoretrashedrecords') {
        document.getElementById('gbuttonaction').value = 'restore_all';
    }
    document.getElementById("global_Action").submit();
}

function ftpfiledownload() {
        var host_name = document.getElementById('host_name').value; 
	var host_path = document.getElementById('host_path').value; 
        var host_password = document.getElementById('host_password').value; 
	var host_username = document.getElementById('host_username').value; 
        var host_port = document.getElementById('host_port').value; 
	var current_module = document.getElementById('current_imptype').value; 
        var import_method = document.getElementById('importbymethod').value; 
        var get_path = host_path.split('/');
        var get_file = get_path[get_path.length - 1];
        var get_abs_file = get_file.split('.');
        var get_abs_file_ext = get_abs_file[get_abs_file.length - 1]; 
        if(get_abs_file_ext == 'csv' || get_abs_file_ext == 'xml' || get_abs_file_ext == 'txt') {
	var doaction = new Array({host_name: host_name, host_path: host_path,host_password:host_password, host_username: host_username, host_port: host_port,current_module : current_module, import_method: import_method});
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
		'action': 'smack_csv_importer_ftpfiledownload',
		'postdata': doaction,
		},
                success: function (data) {
			data = JSON.parse(data);
			if(data['return_message'] == 'Success!') {
                                document.getElementById('displayname').style.display = '';
				document.getElementById('importfile').disabled = false;
				document.getElementById('updatefile').disabled = false;
				document.getElementById('uploadfilefromcomputer').disabled = true;
                                document.getElementById('useuploadedfile').disabled = true;
                                document.getElementById('dwnldextrfile').disabled = true;
				//document.getElementById('csv_import_file').style.height = "720px";
				document.getElementById('filenamedisplay').innerHTML = data['realfilename'] + ' - ' + data['filesize'];
				document.getElementById('uploadedfilename').value = data['uploadedfilename'];
				document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
				document.getElementById('uploadFileName').value = data['filename'];
				document.getElementById('current_file_version').value = data['current_version'];
				if(data['current_version'] != 1)
					jQuery('#renameradio').css('display', 'block');
			} else { 
                                document.getElementById('showMsg').style.display = "";
                                var warning_msg = '<p id="warning-msg" class="alert alert-warning">';
                                warning_msg += data['return_message'];
                                warning_msg += '</p>';
                                document.getElementById('showMsg').innerHTML = warning_msg;
                                jQuery("#showMsg").fadeOut(10000);
                                document.getElementById('filenamedisplay').innerHTML = data['filename'] + ' - ' + data['filesize'];
                                document.getElementById('uploadedfilename').value = data['uploadedfilename'];
                                document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
                                document.getElementById('uploadFileName').value = data['filename'];
                                document.getElementById('current_file_version').value = data['current_version'];
				document.getElementById('importfile').disabled = true;
			}
			var cur_blogid = document.getElementById('cur_blogid').value;
		 },
		error: function (errorThrown) {
			console.log(errorThrown);
		}
	});
        }
        else if(get_abs_file_ext == 'zip') {
                var doaction = new Array({host_name: host_name, host_path: host_path,host_password:host_password, host_username: host_username, host_port: host_port,current_module : current_module, import_method: import_method});
                 jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                'action': 'smack_csv_importer_zipfile_handler',
                'postdata': doaction,
                },
                success: function (data) {
                   data = JSON.parse(data);
                        document.getElementById('choose_file').innerHTML =data['data'];
                        jQuery('#modal_zip').modal('show');
                        var path = data['path'];
                        document.getElementById('filedir').value = path;
                       
                      },
                       error: function (errorThrown) {
                        console.log(errorThrown);
                }
        });

       }      
}

/*function choose_protocols(id) {
        if(id == 'ftp') {
            document.getElementById('importbymethod').value = 'dwnldftpfile';
            document.getElementById('selected_protocols').value = 'ftp';
         }
        if(id == 'sftp') {
            document.getElementById('importbymethod').value = 'dwnldsftpfile';
            document.getElementById('selected_protocols').value = 'sftp';
         }
} */
function choose_import_method(id) {
	document.getElementById('importfile').style.height = 'auto';
	if(id == 'uploadfilefromcomputer') {
		document.getElementById('boxmethod1').style.border = "1px solid #ccc";
                document.getElementById('boxmethod2').style.border = "";
                document.getElementById('boxmethod3').style.border = "";
                document.getElementById('boxmethod4').style.border = "";
		document.getElementById('method1').style.display = '';
		document.getElementById('method2').style.display = 'none';
		document.getElementById('method3').style.display = 'none';
		document.getElementById('method4').style.display = 'none';
                document.getElementById('importbymethod').value = 'uploadfilefromcomputer';
	} else if (id == 'dwnldftpfile') {
                document.getElementById('boxmethod1').style.border = "";
                document.getElementById('boxmethod2').style.border = "1px solid #ccc";
                document.getElementById('boxmethod3').style.border = "";
                document.getElementById('boxmethod4').style.border = "";
                document.getElementById('method1').style.display = 'none';
                document.getElementById('method2').style.display = '';
                document.getElementById('method3').style.display = 'none';
                document.getElementById('method4').style.display = 'none';
                document.getElementById('importbymethod').value = 'dwnldftpfile';
	} else if (id == 'dwnldextrfile') {
                document.getElementById('boxmethod1').style.border = "";
                document.getElementById('boxmethod2').style.border = "";
                document.getElementById('boxmethod3').style.border = "1px solid #ccc";
                document.getElementById('boxmethod4').style.border = "";
                document.getElementById('method1').style.display = 'none';
                document.getElementById('method2').style.display = 'none';
                document.getElementById('method3').style.display = '';
                document.getElementById('method4').style.display = 'none';
                document.getElementById('importbymethod').value = 'dwnldextrfile';
        } else if(id == 'useuploadedfile') {
                document.getElementById('boxmethod1').style.border = "";
                document.getElementById('boxmethod2').style.border = "";
                document.getElementById('boxmethod3').style.border = "";
                document.getElementById('boxmethod4').style.border = "1px solid #ccc";
                document.getElementById('method1').style.display = 'none';
                document.getElementById('method2').style.display = 'none';
                document.getElementById('method3').style.display = 'none';
                document.getElementById('method4').style.display = '';
                document.getElementById('importbymethod').value = 'useuploadedfile';
        }
}
function choose_import_mode(id) {
	var scheduleNow = jQuery('#scheduleNow').prop('checked');
	var importNow = jQuery('#importNow').prop('checked');
	if(importNow) {
		document.getElementById('importrightaway').style.display='';
		document.getElementById('reportLog').style.display='';
		document.getElementById('schedule').style.display='none';
	}
	if(scheduleNow) {
		document.getElementById('schedule').style.display='';
		document.getElementById('importrightaway').style.display='none';
		document.getElementById('reportLog').style.display='none';
	}
}

function extrnlfiledownload() {

	var external_url = document.getElementById('extrnfileurl').value;
        var current_module = document.getElementById('current_imptype').value;
        var doaction = new Array({external_file_url:external_url, current_module: current_module, import_method: 'fromexternalurl'});
        var get_file_extension = external_url.split('/');
        var get_file_name = get_file_extension[get_file_extension.length-1];
        var get_zip = get_file_name.split('.');
        var zip_check = get_zip[get_zip.length-1];
        if( zip_check == 'csv' || zip_check == 'xml' || zip_check == 'txt') {
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
		'action': 'smack_csv_importer_extrnlfiledownload',
		'postdata': doaction,
		},
		success: function (data) {
			data = JSON.parse(data); 
			if(data['return_message'] == 'Success!') {
				document.getElementById('displayname').style.display = '';
				document.getElementById('importfile').disabled = false;
				document.getElementById('updatefile').disabled = false;
           			document.getElementById('uploadfilefromcomputer').disabled = true;
                                document.getElementById('dwnldftpfile').disabled = true;
                                document.getElementById('useuploadedfile').disabled = true;
				//document.getElementById('csv_import_file').style.height = "445px";
				document.getElementById('filenamedisplay').innerHTML = data['realfilename'] + ' - ' + data['filesize'];
				document.getElementById('uploadedfilename').value = data['uploadedfilename'];
				document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
				document.getElementById('uploadFileName').value = data['filename'];
				document.getElementById('current_file_version').value = data['current_version'];
				if(data['current_version'] != 1)
					jQuery('#renameradio').css('display', 'block');
			} else { 
				document.getElementById('showMsg').style.display = "";
				var warning_msg = '<p id="warning-msg" class="alert alert-warning">';
				warning_msg += 'Error: '+data['return_message'];
				warning_msg += '</p>';
				document.getElementById('showMsg').innerHTML = warning_msg;
				jQuery("#showMsg").fadeOut(10000);
				document.getElementById('filenamedisplay').innerHTML = data['filename'] + ' - ' + data['filesize'];
				document.getElementById('uploadedfilename').value = data['uploadedfilename'];
				document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
				document.getElementById('uploadFileName').value = data['filename'];
				document.getElementById('current_file_version').value = data['current_version'];
			}
			var cur_blogid = document.getElementById('cur_blogid').value;
		 },
		error: function (errorThrown) {
			console.log(errorThrown);
		}
	});
        }// for csv
       else if(zip_check == 'zip' || zip_check == 'gz') {
                 jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                'action': 'smack_csv_importer_zipfile_handler',
                'postdata': doaction,
                },
                success: function (data) {
                   data = JSON.parse(data);
                        document.getElementById('choose_file').innerHTML =data['data'];
                        jQuery('#modal_zip').modal('show');
                        var path = data['path'];
                        document.getElementById('filedir').value = path;
                       
                      },
                       error: function (errorThrown) {
                        console.log(errorThrown);
                }
        });



       } // for zip and gzip
}
function choose_csv_zipfile(id,realPath) {
                        var file_name = id;
                        var import_method = document.getElementById('importbymethod').value;
                        var path = document.getElementById('filedir').value;
                          if(import_method == 'uploadfilefromcomputer') {
                        var new_path = path+ realPath + "/" + file_name;
                          }
                        else {
                        var new_path = path +"/"+file_name;
                         }
			var zip_path = realPath+"/"+file_name;
                        var current_module = document.getElementById('current_imptype').value;
                        var get_ext = file_name.split('.');
                        var check_ext = get_ext[get_ext.length - 1];
                    var doaction = new Array({external_file_url:new_path,current_module:current_module,import_method:import_method});
                     if(import_method == 'dwnldextrfile' || import_method == 'dwnldftpfile' || import_method == 'uploadfilefromcomputer') {
            if( check_ext == 'csv' || check_ext == 'xml' || check_ext == 'txt') {
        	jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                'action': 'smack_csv_importer_extrnlfiledownload',
                'postdata': doaction,
                },
                success: function (data) {
                        data = JSON.parse(data);
                        if(data['return_message'] == 'Success!') {
                                document.getElementById('displayname').style.display = '';
                                document.getElementById('importfile').disabled = false;
				document.getElementById('updatefile').disabled = false;
                            //    document.getElementById('csv_import_file').style.height = "410px";
                                document.getElementById('filenamedisplay').innerHTML = data['realfilename'] + ' - ' + data['filesize'];
                                document.getElementById('uploadedfilename').value = data['uploadedfilename'];
                                document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
                                document.getElementById('uploadFileName').value = data['filename'];
                                document.getElementById('current_file_version').value = data['current_version'];
                                if(data['current_version'] != 1)
                                        jQuery('#renameradio').css('display', 'block');
                        } else {
                                document.getElementById('showMsg').style.display = "";
                                var warning_msg = '<p id="warning-msg" class="alert alert-warning">';
                                warning_msg += 'Error: '+data['return_message'];
                                warning_msg += '</p>';
                                document.getElementById('showMsg').innerHTML = warning_msg;
                                jQuery("#showMsg").fadeOut(10000);
                                document.getElementById('filenamedisplay').innerHTML = data['filename'] + ' - ' + data['filesize'];
                                document.getElementById('uploadedfilename').value = data['uploadedfilename'];
                                document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
                                document.getElementById('uploadFileName').value = data['filename'];
                                document.getElementById('current_file_version').value = data['current_version'];
                        }
                        var cur_blogid = document.getElementById('cur_blogid').value;
                 },
                error: function (errorThrown) {
                        console.log(errorThrown);
                }});

                }
                }else if(import_method == 'useuploadedfile' ){ 
		var action = new Array({external_file_url:zip_path,current_module:current_module,import_method:'zipuseuploadedfile'});
		jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
		'action': 'smack_csv_importer_extrnlfiledownload',
		'postdata': action,
		},
		success: function (data) {
		data = JSON.parse(data);
			if(data['return_message'] == 'Success!') {
				document.getElementById('displayname').style.display = '';
				document.getElementById('importfile').disabled = false;
				document.getElementById('updatefile').disabled = false;
				document.getElementById('uploadfilefromcomputer').disabled = true;
				document.getElementById('dwnldftpfile').disabled = true;
				document.getElementById('dwnldextrfile').disabled = true;
				document.getElementById('uploadFileName').value = data['filename'];
				document.getElementById('uploadedfilename').value = data['uploadedfilename'];
				document.getElementById('filedir').value = data['filedir'];
				document.getElementById('upload_csv_realname').value = data['uploadedfilename'];
				document.getElementById('current_file_version').value = data['current_version'];
				document.getElementById('filenamedisplay').innerHTML = data['realfilename'] + ' - ' + data['filesize'];
				document.getElementById('importbymethod').value = 'useuploadedfile';
			}else{
				document.getElementById('showMsg').style.display = '';
				showMapMessages('error', translateAlertString('File not found!.'));
				//var warning_msg = '<p id='warning-msg' class='alert alert-warning'>';
				//warning_msg += 'Error: '+data['return_message'];
				//warning_msg += '</p>';
				//document.getElementById('showMsg').innerHTML = warning_msg;
				//jQuery('#showMsg').fadeOut(10000);
			}

		},error: function (errorThrown) {
		console.log(errorThrown);
		}
		});
 
                      /*  document.getElementById('filedir').value = new_path;
                        document.getElementById('filename').value = file_name;
                        document.getElementById('uploadFileName').value = file_name;
                        document.getElementById('uploadedfilename').value = file_name;
                        document.getElementById('upload_csv_realname').value = file_name;
                        document.getElementById('current_file_version').value = file_name;
                        document.getElementById('filenamedisplay').innerHTML = file_name;
                       // alert('You have been selected the '+file_name);
                       document.getElementById('importbymethod').value = 'useuploadedfile';
                        var get_csv = file_name.split('.');
                        var csv_check = get_csv[get_csv.length-1];
                        if (csv_check == 'csv' || csv_check == 'xml' || csv_check == 'txt') {
                        document.getElementById('importfile').disabled = false;
			document.getElementById('updatefile').disabled = false;

         		}*/
		}
}
function checkallOption(id) {
	var param = id ;
	if(param == 'checkallModules') {
		document.getElementById('post').checked = true;
		document.getElementById('page').checked = true;
		document.getElementById('users').checked = true;
		//document.getElementById('comments').checked = true;
		document.getElementById('customtaxonomy').checked = true;
		document.getElementById('custompost').checked = true;
		document.getElementById('categories').checked = true;
		document.getElementById('rcustomerreviews').checked = true;

		jQuery('#postlabel').removeClass("disablesetting");
                jQuery('#postlabel').addClass("enablesetting");
                jQuery('#nopostlabel').addClass("disablesetting");
                jQuery('#nopostlabel').removeClass("enablesetting");
		jQuery('#pagelabel').removeClass("disablesetting");
                jQuery('#pagelabel').addClass("enablesetting");
                jQuery('#nopagelabel').addClass("disablesetting");
                jQuery('#nopagelabel').removeClass("enablesetting");
		jQuery('#userlabel').removeClass("disablesetting");
                jQuery('#userlabel').addClass("enablesetting");
                jQuery('#nouserlabel').addClass("disablesetting");
                jQuery('#nouserlabel').removeClass("enablesetting");
		/*jQuery('#commentslabel').removeClass("disablesetting");
                jQuery('#commentslabel').addClass("enablesetting");
                jQuery('#nocommentslabel').addClass("disablesetting");
                jQuery('#nocommentslabel').removeClass("enablesetting");*/
		jQuery('#cplabel').removeClass("disablesetting");
                jQuery('#cplabel').addClass("enablesetting");
                jQuery('#nocplabel').addClass("disablesetting");
                jQuery('#nocplabel').removeClass("enablesetting");
		jQuery('#custaxlabel').removeClass("disablesetting");
                jQuery('#custaxlabel').addClass("enablesetting");
                jQuery('#nocustaxlabel').addClass("disablesetting");
                jQuery('#nocustaxlabel').removeClass("enablesetting");
		jQuery('#catlabel').removeClass("disablesetting");
                jQuery('#catlabel').addClass("enablesetting");
                jQuery('#nocatlabel').addClass("disablesetting");
                jQuery('#nocatlabel').removeClass("enablesetting");
		jQuery('#custrevlabel').removeClass("disablesetting");
                jQuery('#custrevlabel').addClass("enablesetting");
                jQuery('#nocustrevlabel').addClass("disablesetting");
                jQuery('#nocustrevlabel').removeClass("enablesetting");
	
		//Ajax save option
	        jQuery.ajax({
        	        url: ajaxurl,
                	type: 'post',
	                data: {
        	                'action': 'save_settings_ajaxmethod',
                	        'option': name,
                        	'eventdoneby': 'checkall',
	                },
        	        success: function (response) {
				shownotification(translateAlertString('Settings Saved'), 'success');
	                }
        	});

	}
	else if(param == 'uncheckallModules') {

		document.getElementById('post').checked = false;
		document.getElementById('page').checked = false;
		document.getElementById('users').checked = false;
		//document.getElementById('comments').checked = false;
		document.getElementById('customtaxonomy').checked = false;
		document.getElementById('custompost').checked = false;
		document.getElementById('categories').checked = false;
		document.getElementById('rcustomerreviews').checked = false;

		jQuery('#nopostlabel').removeClass("disablesetting");
                jQuery('#nopostlabel').addClass("enablesetting");
                jQuery('#postlabel').addClass("disablesetting");
                jQuery('#postlabel').removeClass("enablesetting");
		jQuery('#nopagelabel').removeClass("disablesetting");
                jQuery('#nopagelabel').addClass("enablesetting");
                jQuery('#pagelabel').addClass("disablesetting");
                jQuery('#pagelabel').removeClass("enablesetting");
		jQuery('#nouserlabel').removeClass("disablesetting");
                jQuery('#nouserlabel').addClass("enablesetting");
                jQuery('#userlabel').addClass("disablesetting");
                jQuery('#userlabel').removeClass("enablesetting");
		/*jQuery('#nocommentslabel').removeClass("disablesetting");
                jQuery('#nocommentslabel').addClass("enablesetting");
                jQuery('#commentslabel').addClass("disablesetting");
                jQuery('#commentslabel').removeClass("enablesetting");*/
		jQuery('#nocplabel').removeClass("disablesetting");
                jQuery('#nocplabel').addClass("enablesetting");
                jQuery('#cplabel').addClass("disablesetting");
                jQuery('#cplabel').removeClass("enablesetting");
		jQuery('#nocustaxlabel').removeClass("disablesetting");
                jQuery('#nocustaxlabel').addClass("enablesetting");
                jQuery('#custaxlabel').addClass("disablesetting");
                jQuery('#custaxlabel').removeClass("enablesetting");
		jQuery('#nocatlabel').removeClass("disablesetting");
                jQuery('#nocatlabel').addClass("enablesetting");
                jQuery('#catlabel').addClass("disablesetting");
                jQuery('#catlabel').removeClass("enablesetting");
		jQuery('#nocustrevlabel').removeClass("disablesetting");
                jQuery('#nocustrevlabel').addClass("enablesetting");
                jQuery('#custrevlabel').addClass("disablesetting");
                jQuery('#custrevlabel').removeClass("enablesetting");
		//Ajax save option
	        jQuery.ajax({
        	        url: ajaxurl,
                	type: 'post',
	                data: {
        	                'action': 'save_settings_ajaxmethod',
                	        'option': name,
                        	'eventdoneby': 'uncheckall',
	                },
        	        success: function (response) {
				shownotification(translateAlertString('Settings Saved'), 'success');
	                }
        	});

	}
}

function selectOptimizer(id)  {
	var opt = id ;
	if(opt == 'checkOpt') {
		document.getElementById('delete_all_orphaned_post_page_meta').checked = true;
		document.getElementById('delete_all_unassigned_tags').checked = true;
		document.getElementById('delete_all_post_page_revisions').checked = true;
		document.getElementById('delete_all_auto_draft_post_page').checked = true;
		document.getElementById('delete_all_post_page_in_trash').checked = true;
		document.getElementById('delete_all_spam_comments').checked = true;
		document.getElementById('delete_all_comments_in_trash').checked = true;
		document.getElementById('delete_all_unapproved_comments').checked = true;
		document.getElementById('delete_all_pingback_commments').checked = true;
		document.getElementById('delete_all_trackback_comments').checked = true;
		jQuery.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				'action': 'database_optimization_settings',
				'option': id,
				'eventdoneby': 'selectall',
			},
			success: function (response) {
			}
		});
	}
	else if(opt == 'uncheckOpt') {
		document.getElementById('delete_all_orphaned_post_page_meta').checked = false;
		document.getElementById('delete_all_unassigned_tags').checked = false;
		document.getElementById('delete_all_post_page_revisions').checked = false;
		document.getElementById('delete_all_auto_draft_post_page').checked = false;
		document.getElementById('delete_all_post_page_in_trash').checked = false;
		document.getElementById('delete_all_spam_comments').checked = false;
		document.getElementById('delete_all_comments_in_trash').checked = false;
		document.getElementById('delete_all_unapproved_comments').checked = false;
		document.getElementById('delete_all_pingback_commments').checked = false;
		document.getElementById('delete_all_trackback_comments').checked = false;
		jQuery.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				'action': 'database_optimization_settings',
				'option': id,
				'eventdoneby': 'deselectall',
			},
			success: function (response) {
			}
		});
	}
}

function addexportfilter(id) {
	if(document.getElementById(id).checked == true) {
		if(id == 'getdataforspecificperiod') {
			document.getElementById('specificperiodexport').style.display = '';
			document.getElementById('periodstartfrom').style.display = '';
			document.getElementById('postdatefrom').style.display = '';
			document.getElementById('periodendto').style.display = '';
			document.getElementById('postdateto').style.display = '';
		}
		else if(id == 'getdatawithspecificstatus') {
			document.getElementById('specificstatusexport').style.display = '';
			document.getElementById('status').style.display = '';
			document.getElementById('postwithstatus').style.display = '';
		}
		else if(id == 'getdatabyspecificauthors') {
			document.getElementById('specificauthorexport').style.display = '';
			document.getElementById('authors').style.display = '';
			document.getElementById('postauthor').style.display = '';
		}
		else if(id == 'getdatabasedonexclusions') {
			document.getElementById('exclusiongrouplist').style.display = '';
		}
		else if(id == 'getdatawithdelimiter'){
			document.getElementById('delimiterstatus').style.display = '';
		}
	} else if (document.getElementById(id).checked == false) {
                if(id == 'getdataforspecificperiod') {
			document.getElementById('specificperiodexport').style.display = 'none';
			document.getElementById('periodstartfrom').style.display = 'none';
			document.getElementById('postdatefrom').style.display = 'none';
			document.getElementById('periodendto').style.display = 'none';
			document.getElementById('postdateto').style.display = 'none';
                }
                else if(id == 'getdatawithspecificstatus') {
			document.getElementById('specificstatusexport').style.display = 'none';
			document.getElementById('status').style.display = 'none';
			document.getElementById('postwithstatus').style.display = 'none';
                }
                else if(id == 'getdatabyspecificauthors') {
			document.getElementById('specificauthorexport').style.display = 'none';
                        document.getElementById('authors').style.display = 'none';
                        document.getElementById('postauthor').style.display = 'none';
                }
		else if(id == 'getdatabasedonexclusions') {
			document.getElementById('exclusiongrouplist').style.display = 'none';
		}
		else if(id == 'getdatawithdelimiter'){
                        document.getElementById('delimiterstatus').style.display = 'none';
                }
	}
}

//Settings js code
function showsettingsoption(id) {
	document.getElementById('securitymsg').style.display ='';
        for(i=1;i<=9;i++) {
		if(parseInt(id) == parseInt(i)) {
			if(parseInt(i) == 8) {
				document.getElementById('sidebar').style.height = '1168px';
				document.getElementById('contentbar').style.height = '1168px';
				document.getElementById('settingsholder').style.height = '1169px';
				document.getElementById('securitymsg').style.display ='none';
			} else if(parseInt(i) == 9) {
				document.getElementById('sidebar').style.height = '665px';
				document.getElementById('contentbar').style.height = '665px';
				document.getElementById('settingsholder').style.height = '666px';
			} else if(parseInt(i) == 6) {
				document.getElementById('sidebar').style.height = '655px';
				document.getElementById('contentbar').style.height = '655px';
				document.getElementById('settingsholder').style.height = '656px';
			} else if(parseInt(i) == 4) {
				document.getElementById('sidebar').style.height = '420px';
				document.getElementById('contentbar').style.height = '420px';
				document.getElementById('settingsholder').style.height = '421px';
			} else if(parseInt(i) == 3) {
				document.getElementById('sidebar').style.height = '600px';
				document.getElementById('contentbar').style.height = '600px';
				document.getElementById('settingsholder').style.height = '601px';
			} else if(parseInt(i) == 2) {
				document.getElementById('sidebar').style.height = '522px';
				document.getElementById('contentbar').style.height = '522px';
				document.getElementById('settingsholder').style.height = '523px';
			} else if(parseInt(i) == 1) {
				document.getElementById('sidebar').style.height = '965px';
				document.getElementById('contentbar').style.height = '965px';
				document.getElementById('settingsholder').style.height = '966px';
			} else {
				document.getElementById('sidebar').style.height = 'auto';
				document.getElementById('contentbar').style.height = 'auto';
				document.getElementById('settingsholder').style.height = 'auto';
			}

			jQuery('#'+id).removeClass( "bg-sidebar" );
			jQuery('#'+id).addClass( "selected" );
			document.getElementById('section'+id).style.display="";
			//  document.getElementById('arrow'+id).style.display="";
			document.getElementById('activemenu').innerHTML = document.getElementById('settingmenu'+id).innerHTML ;
		} else {
                        jQuery('#'+i).removeClass( "selected" );
                        jQuery('#'+i).addClass( "bg-sidebar" );
                        document.getElementById('section'+i).style.display="none";
                    //  document.getElementById('arrow'+i).style.display="none";
                }
        }
        document.getElementById('section'+id).style.display="";
}


//seo setting enable and disable
function seosetting(id,name) {
	var post_val = 'disable';
             if(name == 'rseooption' && id == 'none') {
		var post_val = 'nonerseooption';
               jQuery('#seosetting1').removeClass("disablesetting");
               jQuery('#seosetting1').addClass("enablesetting");
               document.getElementById("seosetting1text").innerHTML="Enabled";
               document.getElementById("seosetting2text").innerHTML="Disabled";
               document.getElementById("seosetting3text").innerHTML="Disabled";
               jQuery('#seosetting2').addClass("disablesetting");
               jQuery('#seosetting2').removeClass("enablesetting");
               jQuery('#seosetting3').addClass("disablesetting");
               jQuery('#seosetting3').removeClass("enablesetting");
       }
        else if(name == 'rseooption' && id == 'aioseo') {
                var post_val = 'aioseo';
              jQuery('#seosetting2').removeClass("disablesetting");
               jQuery('#seosetting2').addClass("enablesetting");
               document.getElementById('seosetting2text').innerHTML="Enabled";
               document.getElementById("seosetting1text").innerHTML="Disabled";
               document.getElementById("seosetting3text").innerHTML="Disabled";
               jQuery('#seosetting1').addClass("disablesetting");
               jQuery('#seosetting1').removeClass("enablesetting");
               jQuery('#seosetting3').addClass("disablesetting");
               jQuery('#seosetting3').removeClass("enablesetting");
       }
       else if(name == 'rseooption' && id == 'yoastseo') {
               var post_val = 'yoastseo';
               jQuery('#seosetting3').removeClass("disablesetting");
               jQuery('#seosetting3').addClass("enablesetting");
               document.getElementById('seosetting3text').innerHTML="Enabled";
               document.getElementById("seosetting1text").innerHTML="Disabled";
               document.getElementById("seosetting2text").innerHTML="Disabled";
               jQuery('#seosetting1').addClass("disablesetting");
               jQuery('#seosetting1').removeClass("enablesetting");
               jQuery('#seosetting2').addClass("disablesetting");
               jQuery('#seosetting2').removeClass("enablesetting");
       }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}
//Custom post setting
function cptuicustompostsetting(id,name) {       
	var post_val = 'disable';
       if(name =='cptuicustompost' && id == 'cptui') {
		var post_val = 'enable';
		jQuery('#cptulabel').removeClass("disablesetting");
                jQuery('#cptulabel').addClass("enablesetting");
                jQuery('#nocptulabel').addClass("disablesetting");
                jQuery('#nocptulabel').removeClass("enablesetting");
         }
        else if(name =='cptuicustompost' && id == '') {
		var post_val = 'disable';
                jQuery('#nocptulabel').removeClass("disablesetting");
                jQuery('#nocptulabel').addClass("enablesetting");
                jQuery('#cptulabel').addClass("disablesetting");
                jQuery('#cptulabel').removeClass("enablesetting");
        }
	//Ajax save option
         jQuery.ajax({
               url: ajaxurl,
               type: 'post',
               data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

function typescustompostsetting(id,name) {
	var post_val = 'disable';
        if (name == 'typescustompost' && id == 'wptypespost') {
		var post_val = 'enable';
		jQuery('#typescustompost').removeClass("disablesetting");
                jQuery('#typescustompost').addClass("enablesetting");
                jQuery('#notypescustompost').addClass("disablesetting");
                jQuery('#notypescustompost').removeClass("enablesetting");
         }
        else if (name == 'typescustompost' && id == '') {
		var post_val = 'disable';
                jQuery('#notypescustompost').removeClass("disablesetting");
                jQuery('#notypescustompost').addClass("enablesetting");
                jQuery('#typescustompost').addClass("disablesetting");
                jQuery('#typescustompost').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

 }
function cctmcustompostsetting(id,name) {
	var post_val = 'disable';
       if(name == 'cctmcustompost' && id == 'cctm') {
		var post_val = 'enable';
		jQuery('#cctmcustompost').removeClass("disablesetting");
                jQuery('#cctmcustompost').addClass("enablesetting");
               jQuery('#nocctmcustompost').addClass("disablesetting");
                jQuery('#nocctmcustompost').removeClass("enablesetting");
         }
        else if(name == 'cctmcustompost' && id == '') {
		var post_val = 'disable';
                jQuery('#nocctmcustompost').removeClass("disablesetting");
                jQuery('#nocctmcustompost').addClass("enablesetting");
                jQuery('#cctmcustompost').addClass("disablesetting");
                jQuery('#cctmcustompost').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
               type: 'post',
                data: {
                      'action': 'save_settings_ajaxmethod',
                       'option': name,
                        'value': post_val,
             },
               success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
               }
       });
}

function podscustompostsetting(id,name) {
	var post_val = 'disable';
      if(name == 'podscustompost' && id == 'podspost') {
		var post_val = 'enable';
		jQuery('#podscustompost').removeClass("disablesetting");
                jQuery('#podscustompost').addClass("enablesetting");
                jQuery('#nopodscustompost').addClass("disablesetting");
                jQuery('#nopodscustompost').removeClass("enablesetting");
         }
        else if(name == 'podscustompost' && id == '') {
		var post_val = 'disable';
                jQuery('#nopodscustompost').removeClass("disablesetting");
                jQuery('#nopodscustompost').addClass("enablesetting");
                jQuery('#podscustompost').addClass("disablesetting");
                jQuery('#podscustompost').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

//Security and performance
function authorimportsetting(id,name) {
	var post_val = 'disable';
         if(name == 'enable_plugin_access_for_author' && id == 'enableimport') {
		var post_val = 'enable';
                jQuery('#allowimport').removeClass("disablesetting");
                jQuery('#allowimport').addClass("enablesetting");
                jQuery('#donallowimport').addClass("disablesetting");
		jQuery('#donallowimport').removeClass("enablesetting");
         }
	 else if(name == 'enable_plugin_access_for_author' && id == '') {
		var post_val = 'disable';
                jQuery('#donallowimport').removeClass("disablesetting");
                jQuery('#donallowimport').addClass("enablesetting");
                jQuery('#allowimport').addClass("disablesetting");
                jQuery('#allowimport').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

//General Settings
function postsetting(id,name) {
	var post_val = 'disable';
         if(name== 'post' && id == 'post') {
		var post_val = 'enable';
                jQuery('#postlabel').removeClass("disablesetting");
                jQuery('#postlabel').addClass("enablesetting");
                jQuery('#nopostlabel').addClass("disablesetting");
                jQuery('#nopostlabel').removeClass("enablesetting");
         }
	 else if(name== 'post' && id == '') {
		var post_val = 'disable';
                jQuery('#nopostlabel').removeClass("disablesetting");
                jQuery('#nopostlabel').addClass("enablesetting");
                jQuery('#postlabel').addClass("disablesetting");
                jQuery('#postlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function pagesetting(id,name) {
	var post_val = 'disable';
         if(name == 'page_module' && id == 'page') {
		var post_val = 'enable';
                jQuery('#pagelabel').removeClass("disablesetting");
                jQuery('#pagelabel').addClass("enablesetting");
                jQuery('#nopagelabel').addClass("disablesetting");
                jQuery('#nopagelabel').removeClass("enablesetting");
         }
        else if(name == 'page_module' && id == ''){
		var post_val = 'disable';
                jQuery('#nopagelabel').removeClass("disablesetting");
                jQuery('#nopagelabel').addClass("enablesetting");
                jQuery('#pagelabel').addClass("disablesetting");
                jQuery('#pagelabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function usersetting(id,name) {
	var post_val = 'disable';
         if(name == 'users' && id == 'users') {
		var post_val = 'enable';
                jQuery('#userlabel').removeClass("disablesetting");
                jQuery('#userlabel').addClass("enablesetting");
                jQuery('#nouserlabel').addClass("disablesetting");
                jQuery('#nouserlabel').removeClass("enablesetting");
         }
        else if(name == 'users' && id == '') {
		var post_val = 'disable';
                jQuery('#nouserlabel').removeClass("disablesetting");
                jQuery('#nouserlabel').addClass("enablesetting");
                jQuery('#userlabel').addClass("disablesetting");
                jQuery('#userlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function commentsetting(id,name) {
	var post_val = 'disable';
         if(name == 'comments' && id == 'comments') {
		var post_val = 'enable';
                jQuery('#commentslabel').removeClass("disablesetting");
                jQuery('#commentslabel').addClass("enablesetting");
                jQuery('#nocommentslabel').addClass("disablesetting");
                jQuery('#nocommentslabel').removeClass("enablesetting");
         }
        else if(name == 'comments' && id == ''){
		var post_val = 'disable';
                jQuery('#nocommentslabel').removeClass("disablesetting");
                jQuery('#nocommentslabel').addClass("enablesetting");
                jQuery('#commentslabel').addClass("disablesetting");
                jQuery('#commentslabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
               type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

function cpsetting(id,name) {
	var post_val = 'disable';
         if(name == 'custompost' && id == 'custompost') {
		var post_val = 'enable';
                jQuery('#cplabel').removeClass("disablesetting");
                jQuery('#cplabel').addClass("enablesetting");
                jQuery('#nocplabel').addClass("disablesetting");
                jQuery('#nocplabel').removeClass("enablesetting");
         }
	else if(name == 'custompost' && id == '') {
		var post_val = 'disable';        
                jQuery('#nocplabel').removeClass("disablesetting");
                jQuery('#nocplabel').addClass("enablesetting");
                jQuery('#cplabel').addClass("disablesetting");
                jQuery('#cplabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function custaxsetting(id,name) {
	var post_val = 'disable';
         if(name == 'customtaxonomy' && id == 'customtaxonomy') {
		var post_val = 'enable';
                jQuery('#custaxlabel').removeClass("disablesetting");
                jQuery('#custaxlabel').addClass("enablesetting");
                jQuery('#nocustaxlabel').addClass("disablesetting");
                jQuery('#nocustaxlabel').removeClass("enablesetting");
         }
        else if(name == 'customtaxonomy' && id == '') {
		var post_val = 'disable';
                jQuery('#nocustaxlabel').removeClass("disablesetting");
                jQuery('#nocustaxlabel').addClass("enablesetting");
                jQuery('#custaxlabel').addClass("disablesetting");
                jQuery('#custaxlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });		
}

function catsetting(id,name) {
	var post_val = 'disable';
         if(name == 'categories' && id == 'categories') {
		var post_val = 'enable';
                jQuery('#catlabel').removeClass("disablesetting");
                jQuery('#catlabel').addClass("enablesetting");
                jQuery('#nocatlabel').addClass("disablesetting");
                jQuery('#nocatlabel').removeClass("enablesetting");
         }
        else if(name == 'categories' && id == '') {
		var post_val = 'disable';
                jQuery('#nocatlabel').removeClass("disablesetting");
                jQuery('#nocatlabel').addClass("enablesetting");
                jQuery('#catlabel').addClass("disablesetting");
                jQuery('#catlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function cusrevsetting(id,name) {
		var post_val = 'disable';
         if(name== 'rcustomerreviews' && id == 'rcustomerreviews') {
		var post_val = 'enable';
                jQuery('#custrevlabel').removeClass("disablesetting");
                jQuery('#custrevlabel').addClass("enablesetting");
                jQuery('#nocustrevlabel').addClass("disablesetting");
                jQuery('#nocustrevlabel').removeClass("enablesetting");
         }
        else if(name== 'rcustomerreviews' && id == ''){
		var post_val = 'disable';
                jQuery('#nocustrevlabel').removeClass("disablesetting");
                jQuery('#nocustrevlabel').addClass("enablesetting");
                jQuery('#custrevlabel').addClass("disablesetting");
                jQuery('#custrevlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

//Custom field
function  resetOption(id) {
        if (id == 'resetopt') {
        document.getElementById('runcheckmember').checked = true;
        document.getElementById('wpcustomfields').checked = false;
        document.getElementById('cctmcustomfield').checked = false;
        document.getElementById('acfcustomfield').checked = false;
        document.getElementById('typescustomfield').checked = false;
        document.getElementById('podscustomfield').checked = false;

        jQuery('#wpuseruncheck').removeClass("disablesetting");
        jQuery('#wpuseruncheck').addClass("enablesetting");
        jQuery('#wpusercheck').addClass("disablesetting");
        jQuery('#wpusercheck').removeClass("enablesetting");
	jQuery('#noecomlabel').removeClass("disablesetting");
        jQuery('#noecomlabel').addClass("enablesetting");
        jQuery('#ecomlabel').addClass("disablesetting");
        jQuery('#ecomlabel').removeClass("enablesetting");
        jQuery('#acffieldlabel').addClass("disablesetting");
        jQuery('#acffieldlabel').removeClass("enablesetting");
	jQuery('#noacffieldlabel').removeClass("disablesetting");
        jQuery('#noacffieldlabel').addClass("enablesetting");
        jQuery('#cctmfieldlabel').addClass("disablesetting");
        jQuery('#cctmfieldlabel').removeClass("enablesetting");
 	jQuery('#nocctmfieldlabel').removeClass("disablesetting");
        jQuery('#nocctmfieldlabel').addClass("enablesetting");
        jQuery('#typesfieldlabel').addClass("disablesetting");
        jQuery('#typesfieldlabel').removeClass("enablesetting");
	jQuery('#notypesfieldlabel').removeClass("disablesetting");
        jQuery('#notypesfieldlabel').addClass("enablesetting");
        jQuery('#podsfieldlabel').addClass("disablesetting");
        jQuery('#podsfieldlabel').removeClass("enablesetting");
	jQuery('#nopodsfieldlabel').removeClass("disablesetting");
        jQuery('#nopodsfieldlabel').addClass("enablesetting");
        }
	//Ajax save option
                jQuery.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: {
                                'action': 'save_settings_ajaxmethod',
                                'option': name,
                                'eventdoneby': 'reset',
                        },
                        success: function (response) {
          //                      alert('Hai, Am from save_settings_ajaxmethod function. My response is: ' + response);
				shownotification(translateAlertString('Settings Saved'), 'success');
                        }
                });
}

function wpmembersetting(id,name) {
	var post_val = 'disable';
        if(name == 'rwpmembers' && id == 'rwpmembers') {
		var post_val = 'enable';
                jQuery('#wpusercheck').removeClass("disablesetting");
                jQuery('#wpusercheck').addClass("enablesetting");
                jQuery('#wpuseruncheck').addClass("disablesetting");
                jQuery('#wpuseruncheck').removeClass("enablesetting");
         }
        else if(name == 'rwpmembers' && id == 'runcheckmember') {
		var post_val = 'disable';
                jQuery('#wpuseruncheck').removeClass("disablesetting");
                jQuery('#wpuseruncheck').addClass("enablesetting");
                jQuery('#wpusercheck').addClass("disablesetting");
                jQuery('#wpusercheck').removeClass("enablesetting");
        }
 	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
	
}
function wpfieldsetting(id,name) {
	var post_val = 'disable';
	if(name == 'wpcustomfields' && id == 'wpcustomfields') {
		var post_val = 'enable';
		jQuery('#ecomlabel').removeClass("disablesetting");
                jQuery('#ecomlabel').addClass("enablesetting");
                jQuery('#noecomlabel').addClass("disablesetting");
                jQuery('#noecomlabel').removeClass("enablesetting");
         }
        else if(name == 'wpcustomfields' && id == '') {
		var post_val = 'disable';
                jQuery('#noecomlabel').removeClass("disablesetting");
                jQuery('#noecomlabel').addClass("enablesetting");
                jQuery('#ecomlabel').addClass("disablesetting");
               jQuery('#ecomlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

function acfcustomfieldsetting(id,name) {
	var post_val = 'disable';
         if(name == 'acfcustomfield' && id == 'acfcustomfield') {
	var post_val = 'enable';
		jQuery('#acffieldlabel').removeClass("disablesetting");
                jQuery('#acffieldlabel').addClass("enablesetting");
                jQuery('#noacffieldlabel').addClass("disablesetting");
                jQuery('#noacffieldlabel').removeClass("enablesetting");
         }
        else if(name == 'acfcustomfield' && id == '') {
	var post_val = 'disable';
                jQuery('#noacffieldlabel').removeClass("disablesetting");
                jQuery('#noacffieldlabel').addClass("enablesetting");
                jQuery('#acffieldlabel').addClass("disablesetting");
                jQuery('#acffieldlabel').removeClass("enablesetting");
       }
       //Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}
function cctmcustomfieldsetting(id, name) {
	var post_val = 'disable';
       if(name == 'cctmcustomfield' && id == 'cctmcustomfield') {
		post_val = 'enable';
		jQuery('#cctmfieldlabel').removeClass("disablesetting");
                jQuery('#cctmfieldlabel').addClass("enablesetting");
                jQuery('#nocctmfieldlabel').addClass("disablesetting");
                jQuery('#nocctmfieldlabel').removeClass("enablesetting");
         }
        else if(name == 'cctmcustomfield' && id == '') {
		post_val = 'disable';
                jQuery('#nocctmfieldlabel').removeClass("disablesetting");
                jQuery('#nocctmfieldlabel').addClass("enablesetting");
                jQuery('#cctmfieldlabel').addClass("disablesetting");
                jQuery('#cctmfieldlabel').removeClass("enablesetting");
	} 
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}
function typescustomfieldsetting(id,name) {
	var post_val = 'disable';
       if(name == 'typescustomfield' && id == 'typescustomfield') {
		post_val = 'enable';
		jQuery('#typesfieldlabel').removeClass("disablesetting");
                jQuery('#typesfieldlabel').addClass("enablesetting");
                jQuery('#notypesfieldlabel').addClass("disablesetting");
                jQuery('#notypesfieldlabel').removeClass("enablesetting");
         }
        else if(name == 'typescustomfield' && id == '')  {
		post_val = 'disable';
                jQuery('#notypesfieldlabel').removeClass("disablesetting");
                jQuery('#notypesfieldlabel').addClass("enablesetting");
                jQuery('#typesfieldlabel').addClass("disablesetting");
                jQuery('#typesfieldlabel').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

function podscustomfieldsetting(id,name) {
	 post_val = 'disable';
       if(name == 'podscustomfield' && id == 'podscustomfield') {
	 post_val = 'enable';
		jQuery('#podsfieldlabel').removeClass("disablesetting");
                jQuery('#podsfieldlabel').addClass("enablesetting");
                jQuery('#nopodsfieldlabel').addClass("disablesetting");
                jQuery('#nopodsfieldlabel').removeClass("enablesetting");
         }
        else if(name == 'podscustomfield' && id == '') {
		 post_val = 'disable';
                jQuery('#nopodsfieldlabel').removeClass("disablesetting");
                jQuery('#nopodsfieldlabel').addClass("enablesetting");
                jQuery('#podsfieldlabel').addClass("disablesetting");
                jQuery('#podsfieldlabel').removeClass("enablesetting");
       }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

//Additional Features
function schedulesetting(id,name) {
	post_val = 'disable';
         if(name == 'send_log_email' && id == 'scheduled') {
		post_val = 'enable';
                jQuery('#schedulecheck').removeClass("disablesetting");
                jQuery('#schedulecheck').addClass("enablesetting");
                jQuery('#scheduleuncheck').addClass("disablesetting");
		jQuery('#scheduleuncheck').removeClass("enablesetting");
         }
	  else if(name == 'send_log_email' && id == 'noscheduled') {	
                post_val = 'disable';
                jQuery('#scheduleuncheck').removeClass("disablesetting");
                jQuery('#scheduleuncheck').addClass("enablesetting");
                jQuery('#schedulecheck').addClass("disablesetting");
                jQuery('#schedulecheck').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function categoryiconsetting(id,name) {
	post_val = 'disable';
         if(name =='rcateicons' && id == 'caticonenable') {
		post_val = 'enable';
                jQuery('#catenable').removeClass("disablesetting");
                jQuery('#catenable').addClass("enablesetting");
                jQuery('#catdisable').removeClass("enablesetting");
                jQuery('#catdisable').addClass("disablesetting");
         }
	 else if(name =='rcateicons' && id == 'caticondisable') {	
                post_val = 'disable';
                jQuery('#catdisable').removeClass("disablesetting");
                jQuery('#catdisable').addClass("enablesetting");
                jQuery('#catenable').removeClass("enablesetting");
                jQuery('#catenable').addClass("disablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}
function dropsetting(id,name) {
	post_val = 'disable';
         if(name == 'drop_table' && id == 'drop_table') {
		post_val = 'enable';
                jQuery('#dropon').removeClass("disablesetting");
                jQuery('#dropon').addClass("enablesetting");
                jQuery('#dropoff').addClass("disablesetting");
                jQuery('#dropoff').removeClass("enablesetting");
         }
         else if(name == 'drop_table' && id == 'drop_tab') {
		post_val = 'disable';
                jQuery('#dropoff').removeClass("disablesetting");
                jQuery('#dropoff').addClass("enablesetting");
                jQuery('#dropon').addClass("disablesetting");
                jQuery('#dropon').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

function woocomregattr(id,name) {
	post_val = 'disable';
         if(name == 'woocomattr' && id == 'woocomattr') {
		post_val = 'enable';
                jQuery('#onwoocomreg').removeClass("disablesetting");
                jQuery('#onwoocomreg').addClass("enablesetting");
                jQuery('#offwoocomreg').addClass("disablesetting");
                jQuery('#offwoocomreg').removeClass("enablesetting");
         }
	 else if(name == 'woocomattr' && id == 'disablewoocomattr') {	
                post_val = 'disable';
                jQuery('#offwoocomreg').removeClass("disablesetting");
                jQuery('#offwoocomreg').addClass("enablesetting");
                jQuery('#onwoocomreg').addClass("disablesetting");
                jQuery('#onwoocomreg').removeClass("enablesetting");
        }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

// Enable / Disable the debug mode
function debugmode_check (id,name) {
	post_val = 'disable';
	if(name == 'debug_mode' && id == 'enabled') {
		post_val = 'enable';
		jQuery('#debugmode_enable').removeClass("disablesetting");
		jQuery('#debugmode_enable').addClass("enablesetting");
		jQuery('#debugmode_disable').removeClass("enablesetting");
		jQuery('#debugmode_disable').addClass("disablesetting");
	} else if(name == 'debug_mode' && id == 'disabled') {
		post_val = 'disable';
		jQuery('#debugmode_disable').removeClass("disablesetting");
		jQuery('#debugmode_disable').addClass("enablesetting");
		jQuery('#debugmode_enable').removeClass("enablesetting");
		jQuery('#debugmode_enable').addClass("disablesetting");
	}
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
                        //alert('Hai, Am from save_settings_ajaxmethod function. My response is: ' + response);
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });
}

//Ecommerce setting
function ecommercesetting(id,name) {
	post_val = 'disable';
       if(name =='recommerce' && id == 'ecommercenone') {
		post_val = 'ecommercenone';
                jQuery('#ecommercesetting1').removeClass("disablesetting");
                jQuery('#ecommercesetting1').addClass("enablesetting");
                document.getElementById("ecommerce1text").innerHTML="Enabled";
                document.getElementById("ecommerce2text").innerHTML="Disabled";
                document.getElementById("ecommerce3text").innerHTML="Disabled";
                document.getElementById("ecommerce4text").innerHTML="Disabled";
                document.getElementById("ecommerce5text").innerHTML="Disabled";

               jQuery('#ecommercesetting2').addClass("disablesetting");
               jQuery('#ecommercesetting2').removeClass("enablesetting");
               jQuery('#ecommercesetting3').addClass("disablesetting");
               jQuery('#ecommercesetting3').removeClass("enablesetting");
               jQuery('#ecommercesetting4').addClass("disablesetting");
               jQuery('#ecommercesetting4').removeClass("enablesetting");
               jQuery('#ecommercesetting5').addClass("disablesetting");
               jQuery('#ecommercesetting5').removeClass("enablesetting");
       }
       else if(name =='recommerce' && id == 'eshop') {
		post_val = 'eshop';
               jQuery('#ecommercesetting2').removeClass("disablesetting");
               jQuery('#ecommercesetting2').addClass("enablesetting");
               document.getElementById("ecommerce2text").innerHTML="Enabled";
               document.getElementById("ecommerce1text").innerHTML="Disabled";
               document.getElementById("ecommerce3text").innerHTML="Disabled";
               document.getElementById("ecommerce4text").innerHTML="Disabled";
               document.getElementById("ecommerce5text").innerHTML="Disabled";

               jQuery('#ecommercesetting1').addClass("disablesetting");
               jQuery('#ecommercesetting1').removeClass("enablesetting");
               jQuery('#ecommercesetting3').addClass("disablesetting");
               jQuery('#ecommercesetting3').removeClass("enablesetting");
               jQuery('#ecommercesetting4').addClass("disablesetting");
               jQuery('#ecommercesetting4').removeClass("enablesetting");
               jQuery('#ecommercesetting5').addClass("disablesetting");
               jQuery('#ecommercesetting5').removeClass("enablesetting");
       }
       else if(name =='recommerce' && id == 'marketpress') {
		post_val = 'marketpress';
               jQuery('#ecommercesetting3').removeClass("disablesetting");
               jQuery('#ecommercesetting3').addClass("enablesetting");
               document.getElementById("ecommerce3text").innerHTML="Enabled";
               document.getElementById("ecommerce2text").innerHTML="Disabled";
               document.getElementById("ecommerce1text").innerHTML="Disabled";
               document.getElementById("ecommerce4text").innerHTML="Disabled";
               document.getElementById("ecommerce5text").innerHTML="Disabled";
               jQuery('#ecommercesetting1').addClass("disablesetting");
               jQuery('#ecommercesetting1').removeClass("enablesetting");
               jQuery('#ecommercesetting2').addClass("disablesetting");
               jQuery('#ecommercesetting2').removeClass("enablesetting");
               jQuery('#ecommercesetting4').addClass("disablesetting");
               jQuery('#ecommercesetting4').removeClass("enablesetting");
               jQuery('#ecommercesetting5').addClass("disablesetting");
               jQuery('#ecommercesetting5').removeClass("enablesetting");
      }
        else if(name =='recommerce' && id == 'woocommerce') {
		post_val = 'woocommerce';
              jQuery('#ecommercesetting4').removeClass("disablesetting");
               jQuery('#ecommercesetting4').addClass("enablesetting");
               document.getElementById("ecommerce4text").innerHTML="Enabled";
               document.getElementById("ecommerce2text").innerHTML="Disabled";
               document.getElementById("ecommerce3text").innerHTML="Disabled";
               document.getElementById("ecommerce1text").innerHTML="Disabled";
               document.getElementById("ecommerce5text").innerHTML="Disabled";
               jQuery('#ecommercesetting1').addClass("disablesetting");
               jQuery('#ecommercesetting1').removeClass("enablesetting");
              jQuery('#ecommercesetting2').addClass("disablesetting");
               jQuery('#ecommercesetting2').removeClass("enablesetting");
               jQuery('#ecommercesetting3').addClass("disablesetting");
               jQuery('#ecommercesetting3').removeClass("enablesetting");
               jQuery('#ecommercesetting5').addClass("disablesetting");
               jQuery('#ecommercesetting5').removeClass("enablesetting");
       }
        else if(name =='recommerce' && id == 'wpcommerce') {
		post_val = 'wpcommerce';
               jQuery('#ecommercesetting5').removeClass("disablesetting");
               jQuery('#ecommercesetting5').addClass("enablesetting");
               document.getElementById("ecommerce5text").innerHTML="Enabled";
               document.getElementById("ecommerce2text").innerHTML="Disabled";
               document.getElementById("ecommerce3text").innerHTML="Disabled";
	       document.getElementById("ecommerce4text").innerHTML="Disabled";
              document.getElementById("ecommerce1text").innerHTML="Disabled";
               jQuery('#ecommercesetting1').addClass("disablesetting");
               jQuery('#ecommercesetting1').removeClass("enablesetting");
               jQuery('#ecommercesetting2').addClass("disablesetting");
               jQuery('#ecommercesetting2').removeClass("enablesetting");
               jQuery('#ecommercesetting4').addClass("disablesetting");
               jQuery('#ecommercesetting4').removeClass("enablesetting");
               jQuery('#ecommercesetting3').addClass("disablesetting");
               jQuery('#ecommercesetting3').removeClass("enablesetting");
       }
       else if(name =='' && id == '') {
		post_val = 'disable';
               jQuery('#ecommercesetting5').removeClass("enablesetting");
               jQuery('#ecommercesetting5').addClass("disablesetting");
               document.getElementById("ecommerce5text").innerHTML="Disabled";
               document.getElementById("ecommerce2text").innerHTML="Disabled";
               document.getElementById("ecommerce3text").innerHTML="Disabled";
               document.getElementById("ecommerce4text").innerHTML="Disabled";
               document.getElementById("ecommerce1text").innerHTML="Disabled";
               jQuery('#ecommercesetting1').addClass("disablesetting");
               jQuery('#ecommercesetting1').removeClass("enablesetting");
               jQuery('#ecommercesetting2').addClass("disablesetting");
               jQuery('#ecommercesetting2').removeClass("enablesetting");
               jQuery('#ecommercesetting4').addClass("disablesetting");
               jQuery('#ecommercesetting4').removeClass("enablesetting");
               jQuery('#ecommercesetting3').addClass("disablesetting");
               jQuery('#ecommercesetting3').removeClass("enablesetting");
       }
	//Ajax save option
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                        'action': 'save_settings_ajaxmethod',
                        'option': name,
                        'value': post_val,
                },
                success: function (response) {
			shownotification(translateAlertString('Settings Saved'), 'success');
                }
        });

}

//End of settings js
//Reset Import
function importreset() {
      window.location.reload();
}
/*	document.getElementById('browsefile').reset();
	document.getElementById('method1').style.display = '';
	document.getElementById('method2').style.display = 'none';
	document.getElementById('method3').style.display = 'none';
	document.getElementById('method4').style.display = 'none';
//	document.getElementById('inlineimages').style.display = 'none';
	document.getElementById('progress').innerHTML = "";
	document.getElementById('displayname').innerHTML = "";
	document.getElementById('boxmethod1').style.border ='none';
	document.getElementById('boxmethod2').style.border ='none';
	document.getElementById('boxmethod3').style.border ='none';
	document.getElementById('boxmethod4').style.border ='none';
*/

//function for new UI

function registrationUI(id,groupname,import_type){
	var table =id;
       var prefix = groupname;
       var filename = document.getElementById('session_key_filename').value;
       var mappingcount = document.getElementById('h1').value;
       var core_count = document.getElementById(prefix+'_count').value;
       var url = (document.getElementById('pluginurl').value);
       var slug = (document.getElementById('slug').value);
       var realnm = document.getElementById('uploaded_csv_name').value;
	var row = table.insertRow(-1);
       row.id = prefix+'_tr_count'+core_count;
                       jQuery.ajax({

                type: 'POST',
                url: ajaxurl,
                data: {
                       'action': 'smack_csv_importer_picklist_handler',
                       'mappingcount' : mappingcount,
                       'count' : core_count,
                       'prefix' : prefix,
                       'filename' : filename,
                       'realfilenm' : realnm,
                       'url' : url,
                       'slug' : slug,
                       'import_type' : import_type,
                       //'register' : 'false',
                      },
                       success: function (data) {
                               document.getElementById(prefix+'_tr_count'+core_count).innerHTML = data;
			if(prefix == 'CORECUSTFIELDS'){
			       document.getElementById(prefix+'_count').value = parseInt(core_count) + 1;
			       document.getElementById('h1').value = parseInt(mappingcount) + 1;
			}
			                           },
                       error: function (errorThrown) {
                               console.log(errorThrown);
                       }
        });
}


//function to insert custom fields

function disp(id, count, groupname,coreid,import_type) {
	var coreid = coreid;
	var table =id;
	var prefix = groupname;
	var filename = document.getElementById('session_key_filename').value;
	var mappingcount = document.getElementById('h1').value;
	var core_count = document.getElementById(prefix+'_count').value;
	var url = (document.getElementById('pluginurl').value);
	var slug = (document.getElementById('slug').value);
	var realnm = document.getElementById('uploaded_csv_name').value;
	var reg_corecount = document.getElementById(prefix+'_reg_count').value;
	var reg_mappingcount = document.getElementById('reg_mapcount').value;
	document.getElementById(prefix+'_tdg_count'+core_count).style.display = '';
	document.getElementById(prefix+'_tdh_count'+core_count).style.display = '';
	document.getElementById(prefix+'_tdi_count'+core_count).style.display = '';
	document.getElementById(prefix+'newrow'+core_count).style.display = 'none';

	var inc = parseInt(core_count) + 1;
	document.getElementById(prefix+'_count').value = parseInt(inc);
	var mapping = parseInt(mappingcount) + 1;
	document.getElementById('h1').value = parseInt(mapping);
	document.getElementById(coreid).style.height="auto";

}


// function to check all in mapping section

function selectAll(id,groupname)
{
       var count = document.getElementById(groupname+'_count').value;
       for(var i=0;i<count;i++) {
               var check = document.getElementById(groupname+'_num_' + i).checked;
               if(check == true ) {
                       document.getElementById(groupname+'_num_' + i).checked = false;
               }
               else {
                       document.getElementById(groupname+'_num_' + i).checked = true;
               }       
       }
}


// function to display static content in custom fields

function static_button(id,prefix,mappingcount)
{
	var group    = prefix;
	var mapping  = mappingcount;
	var buttonid = id;
	//var panelid  = panelid;
        //document.getElementById(group+'__mapping'+mapping).value = "-- Select --";
       	//document.getElementById(group+'__mapping'+mapping).disabled = true;
       	document.getElementById(group+'_formulabutton_mapping'+mapping).disabled = true;
	mappingvalue = document.getElementById(group+'__mapping'+mapping).value;
	if(mappingvalue == 'header_manip'){
        jQuery.ajax({

                type: 'POST',
                url: ajaxurl,
                data: {
                        'action': 'smack_csv_importer_static_handler',
                        'group': group,
                        'mapping' : mapping,
			'buttonid' : buttonid,
                      },
                        success: function (data) {
				document.getElementById(group+'_customdispdiv_mapping'+mapping).innerHTML = data;
				jQuery('#'+group+'_customdispdiv_mapping'+mapping).show(400);
			      //  document.getElementById(panelid).style.height="auto";
                        },
                        error: function (errorThrown) {
                                console.log(errorThrown);
                        }
        });
	}
	else{
		alert("Choose the CSV Header option as Header Manipulation");
	}
}

// function for static button close

function staticdivclose(group, mapping) {
	jQuery('#'+group+'_customdispdiv_mapping'+mapping).hide(400);
//        document.getElementById(group+'_formulabutton_mapping'+mapping).disabled = false;
  //      document.getElementById(group+'__mapping'+mapping).disabled = false;
}

// function to display dynamic content in custom fields

function dynamic_button(id,prefix,mappingcount,panelid)
{
       var group = prefix;
       var mapping = mappingcount;
       var buttonid = id;
       var panelid = panelid;
       document.getElementById(group+'__mapping'+mapping).value = "-- Select --";
       document.getElementById(group+'__mapping'+mapping).disabled = true;
       document.getElementById(group+'_staticbutton_mapping'+mapping).disabled = true;
       document.getElementById(group+'_formulabutton_mapping'+mapping).disabled = true;
       jQuery.ajax({

                type: 'POST',
                url: ajaxurl,
                data: {
                        'action': 'smack_csv_importer_static_handler',
                        'group': group,
                       'mapping' : mapping,
			'buttonid' : buttonid,
                      },
                        success: function (data) {
				document.getElementById(group+'_customdispdiv_mapping'+mapping).innerHTML = data;
				jQuery('#'+group+'_customdispdiv_mapping'+mapping).show(400);
				document.getElementById(panelid).style.height="auto";
                        },
                        error: function (errorThrown) {
                                console.log(errorThrown);
                        }
        });    
}

// function for dynamic button close

function dynamicdivclose(group, mapping) {
	jQuery('#'+group+'_customdispdiv_mapping'+mapping).hide(400);
       	document.getElementById(group+'_staticbutton_mapping'+mapping).disabled = false;
       	document.getElementById(group+'_formulabutton_mapping'+mapping).disabled = false;
       	document.getElementById(group+'__mapping'+mapping).disabled = false;
}

// function to display static content in custom fields

function formula_button(id,prefix,mappingcount)
{
       var group = prefix;
       var mapping = mappingcount;
       var buttonid = id;
       var panelid = panelid;
       var mappingvalue = document.getElementById(group+'__mapping'+mapping).value
      // document.getElementById(group+'__mapping'+mapping).value = "-- Select --";
//       document.getElementById(group+'__mapping'+mapping).disabled = true;

    //   	document.getElementById(group+'_staticbutton_mapping'+mapping).disabled = true;
	if(mappingvalue == 'header_manip'){
        jQuery.ajax({

                type: 'POST',
                url: ajaxurl,
                data: {
                        'action': 'smack_csv_importer_static_handler',
                        'group': group,
                        'mapping' : mapping,
			'buttonid' : buttonid,
                      },
                        success: function (data) {
				document.getElementById(group+'_customdispdiv_mapping'+mapping).innerHTML = data;
				jQuery('#'+group+'_customdispdiv_mapping'+mapping).show(400);
		//		document.getElementById(panelid).style.height="auto";
                        },
                        error: function (errorThrown) {
                                console.log(errorThrown);
                        }
        });
	}
	else {
		alert("Choose the CSV Header option as Header Manipulation");
	}
}

// function for formula button close

function formuladivclose(group, mapping) {
	jQuery('#'+group+'_customdispdiv_mapping'+mapping).hide(400);
      //  document.getElementById(group+'_staticbutton_mapping'+mapping).disabled = false;
//        document.getElementById(group+'__mapping'+mapping).disabled = false;
} 

//Mapping section fields hide/close
function showmappingfields(id) {
	var dispdivision = id;
	document.getElementById(dispdivision+'_content').style.display = "block";
}

//Register the Core Custom Fields
function register_corefields(id,prefix,mappingcount,core_count){
      var fieldlabel = document.getElementById(prefix+'__CustomField'+mappingcount).value;
       var fieldnm = document.getElementById('CustomField'+mappingcount).textContent;
      fieldnm = fieldnm.slice(7,fieldnm.length-1);
       fieldnm = myString = fieldnm.replace(/^\]$/, '');
       var input = document.createElement("input");
       input.setAttribute("type", "hidden");
       input.setAttribute("name", prefix+'_check_'+fieldlabel);
       input.setAttribute("value", "off");
       document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
       var input = document.createElement("input");
       input.setAttribute("type", "hidden");
       input.setAttribute("name", prefix+'__fieldname'+mappingcount);
       input.setAttribute("id", prefix + '__'+fieldlabel);
       input.setAttribute("value", fieldlabel);
       document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
       document.getElementById('hdtitle'+mappingcount).value = fieldnm;
       //document.getElementById(mappingcount+'_CustomField').innerHTML = '<b> '+ fieldnm +'</b>';
       document.getElementById(prefix+'req__'+mappingcount).value = fieldlabel;
}



//Get the options of ACF Custom field
function show_typeoptions(id,prefix,mappingcount){
       var acf_option = document.getElementById(id);
       var get_acf_option = acf_option.options[acf_option.selectedIndex].value;
       if( get_acf_option == 'select' || get_acf_option == 'checkbox' || get_acf_option == 'radio button'){
 	       jQuery('#'+prefix+'_trchoice'+mappingcount).show();
               jQuery('#'+prefix+'_truser'+mappingcount).hide();
               jQuery('#'+prefix+'_trmsg'+mappingcount).hide();
               document.getElementById(prefix+'Register'+mappingcount).disabled=true;
	}
       else if(get_acf_option == 'user'){
               jQuery('#'+prefix+'_truser'+mappingcount).show();
               jQuery('#'+prefix+'_trchoice'+mappingcount).hide();
               jQuery('#'+prefix+'_trmsg'+mappingcount).hide();
               document.getElementById(prefix+'Register'+mappingcount).disabled=true;
       }
       /*else if(get_acf_option == 'message'){
               jQuery('#'+prefix+'_trmsg'+mappingcount).show();
               jQuery('#'+prefix+'_truser'+mappingcount).hide();
               jQuery('#'+prefix+'_trchoice'+mappingcount).hide();
               document.getElementById(prefix+'Register'+mappingcount).disabled=true;
       }*/
       else{
               jQuery('#'+prefix+'_trchoice'+mappingcount).hide();
               jQuery('#'+prefix+'_truser'+mappingcount).hide();
               jQuery('#'+prefix+'_trmsg'+mappingcount).hide();
               document.getElementById(prefix+'Register'+mappingcount).disabled = false;
       }
}

// Close the Registration UI
function close_ui(id,core_count,prefix){
        //jQuery('#'+prefix+'_tr_count'+core_count).slideUp(1000);
        var rowid = prefix+'_tr_count'+core_count;
        var row = document.getElementById(rowid);
        row.parentNode.removeChild(row);
}
//Validate and Close the ACF Options
function validate_options(prefix,mappingcount){
       var option_id = prefix + '_type_options'+mappingcount;
       var option_text = document.getElementById(option_id).value;
       var pattern = new RegExp('^([A-Za-z0-9]\s?)+([,]\s?([A-Za-z0-9]\s?)+)*$');
       var match = pattern.test(option_text);
       if(match){
		document.getElementById(prefix+'Register'+mappingcount).disabled=false;
               document.getElementById(option_id).style.removeProperty("border");      
       }
       else{
               document.getElementById(option_id).style.border = '3px solid #FF0000';
               document.getElementById(option_id).value = '';
	       document.getElementById(prefix+'Register'+mappingcount).disabled=true;
       }
}

//Check ACF fields is empty or not
function is_empty(prefix,mappingcount){
       var fdtype_id = prefix+'_datatype_'+mappingcount;
       fdname_ui = prefix+'ui__CustomFieldName'+mappingcount;
       fdlabel_ui = prefix+'ui__CustomFieldLabel'+mappingcount;
       var  fdlabel_id = prefix+'ui__CustomFieldLabel'+mappingcount;
       var fdname_id = prefix+'ui__CustomFieldName'+mappingcount;
       var fdname = document.getElementById(fdname_id).value;
       var fdtype = document.getElementById(fdtype_id).value;
       var fdlabel = document.getElementById(fdlabel_id).value;
       if(fdname == '' || fdtype == '--select--'  || fdlabel == ''){
               return false;
       }
       else{
               return true;
       }
}

// Disabled the ACF Pro Fieldtype Options
function disable_acf_fieldtype(id,findacf){
        if(findacf == 'free'){
	document.getElementById(id).options[5].disabled = true;
        document.getElementById(id).options[8].disabled = true;
        document.getElementById(id).options[26].disabled = true;
        document.getElementById(id).options[27].disabled = true;
        document.getElementById(id).options[5].style.backgroundColor = '#F1F1CB'; 
        document.getElementById(id).options[8].style.backgroundColor = '#F1F1CB';
        document.getElementById(id).options[26].style.backgroundColor = '#F1F1CB';
        document.getElementById(id).options[27].style.backgroundColor = '#F1F1CB';
	}
	else {
	document.getElementById(id).options[26].disabled = true;
        document.getElementById(id).options[27].disabled = true;
	document.getElementById(id).options[26].style.backgroundColor = '#F1F1CB';
        document.getElementById(id).options[27].style.backgroundColor = '#F1F1CB';
	}
}
//Register ACF Custom field
function register_acfcustomfield(id,import_type,prefix,mappingcount,core_count,findacf){
       if(findacf == 'none'){
	alert(translateAlertString('Activate the ACF plugin'));
	return false;
       }
       if(import_type == 'custompost'){
       var custompost = document.getElementById('custompostlist').value;
       var postlist= new Array();
       var list = document.getElementById('custompostlist');
               for (i = 1; i < list.options.length; i++) {
                  postlist[i] = list.options[i].value;
               }
       postlist.shift();
       }
       fdname_ui = prefix+'ui__CustomFieldName'+mappingcount;
       fdlabel_ui = prefix+'ui__CustomFieldLabel'+mappingcount;
       fdlabel = 'CustomField'+mappingcount;
       fdname = prefix+'__CustomField'+mappingcount;
       fdcontent = prefix+'__mapping_drop'+mappingcount;
       fdtype = prefix+'_datatype_'+mappingcount;
       var flag = is_empty(prefix,mappingcount);
       if(flag == true){
       if(confirm("Register the custom fields...?")==true){
               var fieldlabel = document.getElementById(fdname_ui).value;
	       var hdval = '' ;
               fieldlabel = fieldlabel.replace(/ /g,"_");
               var fieldnm = document.getElementById(fdlabel_ui).value;
               var fieldtype = document.getElementById(fdtype).value; 
               if(fieldtype == 'select' || fieldtype == 'checkbox' || fieldtype == 'radio button')
               var fieldoption = document.getElementById(prefix + '_type_options' + mappingcount).value;       
//               if(fieldtype == 'message')
  //              hdval = document.getElementById(prefix+'_msg'+mappingcount).value;
               if(fieldtype == 'user')
                hdval = document.getElementById(prefix+'_role'+mappingcount).value; 
		if(findacf == 'pro'){
		var action = 'register_acf_pro_fields';
		}
		else{
		var action = 'register_acf_free_fields'; 
		var postlist = custompost;
		}
	        var desc = document.getElementById(prefix+'ui__CustomFieldDesc'+mappingcount).value;
        	var req = document.getElementById(prefix+'ui__CustomFieldOption'+mappingcount).checked;
 jQuery.ajax({

            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
               'action': action,
               'import_type':import_type,
               'fdlabel':fieldlabel,
               'fdname': fieldnm,
               'fdtype': fieldtype,
               'fdoption': fieldoption,
               'hdvalue' : hdval,
  //             'custompost' : custompost,
               'postlist' : postlist,
               'desc' : desc,
               'fdreq' : req,          
            },
            success: function (response) {
               if(response == 'This feature is available only in ACF Pro. Please update the ACF Version .' || response == 'Field already registered'){
               alert(response);
               document.getElementById(fdname).value = '';
	       document.getElementById(fdtype).selectedIndex = '0';
	       document.getElementById(fdcontent).selectedIndex = '0';
               return false;
               }
                var id = "ACF_table";
                var registered = "true";
                var coreid = "acf_addcustom_panel";
		document.getElementById(prefix+'_reg_count').value = core_count;
                document.getElementById('reg_mapcount').value = mappingcount;

                disp(id,registered,prefix,coreid,import_type);
		if(fieldtype == 'message'){
			jQuery.ajax({
		            type: 'POST',
		            url: ajaxurl,
		            async: false,
		            data: {
				'action' : 'get_acfmsg_fieldkey',
				'fdname' : fieldnm,
				'findacf': findacf,
				'import_type': import_type, 
				'postlist': postlist,
			    },

			    success : function (res_data) {
				if(response == 'Field Added'){
		                        alert(response);
                		        jQuery('#'+prefix+'Delete'+mappingcount).show(300);
	                        }
				jQuery('#'+fdname).val(fieldnm);
		                jQuery('#'+fdlabel).html('[Name: ' + res_data + ']');
				var input = document.createElement("input");
		               input.setAttribute("type", "hidden");
		               input.setAttribute("name", prefix+'_check_'+fieldlabel);
		               input.setAttribute("value", "off");
		               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
		               var input = document.createElement("input");
		               input.setAttribute("type", "hidden");
		               input.setAttribute("name", prefix+'__fieldname'+mappingcount);
		               input.setAttribute("id", prefix + '__'+fieldlabel);
		               input.setAttribute("value", res_data);	
		               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
		               document.getElementById('hdtitle'+mappingcount).value = fieldnm;
		               document.getElementById(mappingcount+'_CustomField').innerHTML = '<b> '+ fieldnm +'</b>';

			    },
			    error: function (errorThrown) {
		                console.log(errorThrown);
		            }		
			});
			    
		}
		else {
			if(response == 'Field Added'){
                        //alert(response);
			//alert(document.getElementById(prefix+"_tdc_count"+core_count));
                        jQuery('#'+prefix+'Delete'+mappingcount).show(300);
                        }
		       jQuery('#'+fdname).val(fieldnm);
		       jQuery('#'+fdlabel).html('[Name: ' + fieldlabel + ']');
			if(response == 'Field Added'){
			alert(response);
			jQuery('#'+prefix+'Delete'+mappingcount).show(300);
			}


		       var input = document.createElement("input");
		       input.setAttribute("type", "hidden");
		       input.setAttribute("name", prefix+'_check_'+fieldlabel);
		       input.setAttribute("value", "off");
		       document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
		       var input = document.createElement("input");
		       input.setAttribute("type", "hidden");
		       input.setAttribute("name", prefix+'__fieldname'+mappingcount);
		       input.setAttribute("id", prefix + '__'+fieldlabel);
		       input.setAttribute("value", fieldlabel);
		       document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
		       document.getElementById('hdtitle'+mappingcount).value = fieldnm;        
		       document.getElementById(mappingcount+'_CustomField').innerHTML = '<b> '+ fieldnm +'</b>';       
		       document.getElementById(prefix+'req__'+mappingcount).value = fieldlabel; 
	       }
                   },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
});
       }
       else{
               alert(translateAlertString("You are cancel the field registration"));
       }
       }
       else{
               alert(translateAlertString("Please enter the values"));
               return false;
       }
}

// Delete the ACF custom fields
function delete_acfcustomfield(id,import_type,prefix,mappingcount,core_count,findacf){
       close_id=prefix+'_close_'+core_count;
       fieldnm = document.getElementById('hdtitle'+mappingcount).value;
       if(findacf == 'pro'){
	action = 'register_acf_pro_fields';
       }
       else{
	action = 'register_acf_free_fields';
       }
       jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': action,
                'import_type':import_type,
                'fdname': fieldnm,
               'remove' : 'true',
            },
            success: function (response) {
               if(response == 'Field Deleted')
                alert(translateAlertString('Field Deleted')); 
               closefield(close_id,prefix,core_count);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
	});
}
               
//check field data are empty
function check_fieldempty(id,mappingcount,prefix){
 var field_data = document.getElementById(id).value;
 if(field_data == ''){
     document.getElementById(id).style.border = '3px solid #FF0000';
     alert("Please fill the data");
     document.getElementById(prefix+'Register'+mappingcount).disabled = true;
 }
 else{
       document.getElementById(id).style.removeProperty("border");
       document.getElementById(prefix+'Register'+mappingcount).disabled = false;
 }
}

//Validate/Modify ACF Custom field name
function valid_fieldname(id,mappingcount,prefix){
       var fieldnm = document.getElementById(id).value;
       if(prefix == 'CORECUSTFIELDS' && fieldnm != ''){
               document.getElementById(prefix+'__mapping'+mappingcount).disabled = false;
       }
       else
       document.getElementById(prefix+'__mapping'+mappingcount).disabled = true;
       if(fieldnm != ''){
               document.getElementById(id).style.border = '1px solid #B0B0B0 ';
               fieldnm = fieldnm.toLowerCase();
               fieldnm = fieldnm.replace(/\s/g, "_").replace(/\./g,"_");
               var fieldlabel="CustomField"+mappingcount;
               document.getElementById(fieldlabel).innerHTML="[Name: "+fieldnm+"]";
       }
       else{
               document.getElementById(id).style.border = '3px solid #FF0000';
               alert(translateAlertString("Please enter the field name"));
	       document.getElementById(prefix+'Register'+mappingcount).disabled = false;
       }
}

function validate_types(id,prefix,mappingcount,import_type){
	import_type = typeof import_type !== 'undefined' ? import_type : '';
        var fdtype = document.getElementById(id).value;
        if(prefix == 'PODS'){
        var relfd_id = prefix + '_relatedtype_'+mappingcount;
	var imp_custompt = '';
        if(relfd_id == id){
                var relval = document.getElementById(relfd_id).value;
                if(document.getElementById(relfd_id).value == 'custom'){
                jQuery('#'+prefix+'_CDOfd'+mappingcount).show();
                return 'true';
                }
                else if(relval != 'custom' && relval != 'user_role' && relval != 'user_capability'  && relval != 'image_size' && relval != 'navigation' && relval != 'post_format' && relval != 'post_status' && relval != 'country' && relval != 'us_states' && relval != 'calendar_week' && relval != 'calendar_year'){
                        if(import_type == 'custompost'){
		                import_type = document.getElementById('custompostlist').value;
				imp_custompt = 'custompost';
			}
                jQuery('#'+prefix+'_CDOfd'+mappingcount).hide();
                jQuery('#'+prefix+'_bidirecfd'+mappingcount).show();
              jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    async: false,
                    datatype:'JSON',
                    data: {
                        'action': 'add_bidirectional_fds',
                        'relfd_val':relval,
                        'import_type':import_type,
			'imp_custompt' : imp_custompt,
                    },
                    success: function (response) {
                        data = JSON.parse(response);
			bireloptions = document.getElementById(prefix+"_bidirec"+mappingcount);
			for(i=1;i<bireloptions.length;i++){
				bireloptions.remove(i);
			}
                        if(data.length != 0){
                        document.getElementById(prefix+'_bidirec_op'+mappingcount).text = '-- Select Related Fields--';
                        for(i=0;i<data.length;i++){
                                for(j=0;j<data[i].length;j++){
                                var option = document.createElement("option");
                                option.text = data[i];
                                option.value = data[i];
                                var select = document.getElementById(prefix+"_bidirec"+mappingcount);
                                select.appendChild(option);
                                }
                        }
                        }
			else {
			document.getElementById(prefix+'_bidirec_op'+mappingcount).text = 'No Related Fields Found';
			}
                    },
                    error: function (errorThrown) {
                        console.log(errorThrown);
                    }
                });
                return 'true';
                }
                else{
                jQuery('#'+prefix+'_CDOfd'+mappingcount).hide();
                jQuery('#'+prefix+'_bidirecfd'+mappingcount).hide();
                return 'true';
                }
        }
        else {
         jQuery('#'+prefix+'_reltofd'+mappingcount).hide();
         jQuery('#'+prefix+'_CDOfd'+mappingcount).hide();
         jQuery('#'+prefix+'_bidirecfd'+mappingcount).hide();
        }
        }
        if(fdtype == '--select--'){
                document.getElementById(prefix+'Register'+mappingcount).disabled = true;
        }
        else{
                if(prefix == 'PODS'){
                show_relto_fields(id,prefix,mappingcount);
                document.getElementById(prefix+'Register'+mappingcount).disabled = false;
                }
                if(prefix == 'ACF'){
                document.getElementById(prefix+'Register'+mappingcount).disabled = false;
                if(id == prefix+'_datatype_'+mappingcount){
                show_typeoptions(id,prefix,mappingcount);
                }
                }
                if(prefix == 'TYPES'){
                        if(fdtype == 'select' || fdtype == 'checkboxes' || fdtype == 'radio'){
                                jQuery('#'+prefix+'_trchoice'+mappingcount).show();
                                jQuery('#'+prefix+'_ckbox'+mappingcount).hide();
                        }
                        else if(fdtype == 'checkbox'){
                                jQuery('#'+prefix+'_ckbox'+mappingcount).show();
                        }
                        else{
                                jQuery('#'+prefix+'_trchoice'+mappingcount).hide();
                                jQuery('#'+prefix+'_ckbox'+mappingcount).hide();
                        }
                }
        }
}
//Show the related to field of PODS
function show_relto_fields(id,prefix,mappingcount){
        var relto = document.getElementById(id).value;
        if(relto == 'relationship'){
        jQuery('#'+prefix+'_reltofd'+mappingcount).show(300);
        }
        else{
        jQuery('#'+prefix+'_reltofd'+mappingcount).hide(300);
        }
}

//Register the PODS Fields
function register_podscustomfield(id,import_type,prefix,mappingcount,core_count){
        close_id=prefix+'_close_'+core_count;
       fdname_ui = prefix+'ui__CustomFieldName'+mappingcount;
       fdlabel_ui = prefix+'ui__CustomFieldLabel'+mappingcount;
       fdname = 'CustomField'+mappingcount;
       fdlabel = prefix+'__CustomField'+mappingcount;
        relto = '';
        bidir = '';
       fdcontent = prefix+'__mapping_drop'+mappingcount;
       fdtype = prefix+'_datatype_'+mappingcount;
       var flag = is_empty(prefix,mappingcount);
        var fieldlabel_ui = document.getElementById(fdlabel_ui).value;
        var fieldnm_ui = document.getElementById(fdname_ui).value;
        custompost = '';
       if(flag == true){
       if(confirm("Register the custom fields...?")==true){
               if(import_type == 'custompost')
                        custompost = document.getElementById('custompostlist').value;
        var fieldlabel = document.getElementById(fdlabel_ui).value;
        var fieldnm = document.getElementById(fdname_ui).value;
        fieldnm = fieldnm.replace(/ /g,"_");
        var fieldtype = document.getElementById(fdtype).value;
        if(fieldtype == 'relationship'){
                        relto = document.getElementById(prefix+'_relatedtype_'+mappingcount).value;
                        bidir = document.getElementById(prefix+'_bidirec'+mappingcount).value;
        }
        var desc = document.getElementById(prefix+'ui__CustomFieldDesc'+mappingcount).value;
        var req = document.getElementById(prefix+'ui__CustomFieldOption'+mappingcount).checked;
jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'register_pods_fields',
               'import_type':import_type,
               'fdlabel':fieldlabel,
               'fdname': fieldnm,
               'fdtype': fieldtype,
               'desc': desc,
               'fdreq': req,
               'custompost' : custompost,
               'relto' : relto,
               'bidir' : bidir,
            },
            success: function (response) {
               if(response == 'Field already registered'){
               alert(response);
                return false;
                }
                var id = "PODS_table";
                var registered = "true";
                var coreid = "pods_addcustom_panel";
		document.getElementById(prefix+'_reg_count').value = core_count;
                document.getElementById('reg_mapcount').value = mappingcount;

                disp(id,registered,prefix,coreid,import_type);
	//	alert(fdlabel);
		if(response == 'Field Added'){
               		alert(response);
               		jQuery('#'+prefix+'Delete'+mappingcount).show(300);
                }

	        jQuery('#'+fdlabel).val(fieldlabel);
        	jQuery('#'+fdname).html('[Name: ' + fieldnm + ']');
               var input = document.createElement("input");
               input.setAttribute("type", "hidden");
               input.setAttribute("name", prefix+'_check_'+fieldnm);
               input.setAttribute("value", "off");
               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
               var input = document.createElement("input");
               input.setAttribute("type", "hidden");
               input.setAttribute("name", prefix+'__fieldname'+mappingcount);
               input.setAttribute("id", prefix + '__'+fieldnm);
               input.setAttribute("value", fieldnm);
               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
               document.getElementById('hdtitle'+mappingcount).value = fieldlabel;
               document.getElementById(mappingcount+'_CustomField').innerHTML = '<b> '+ fieldlabel +'</b>';
		document.getElementById(prefix+'req__'+mappingcount).value = fieldnm;
               /*if(response == 'Field Added'){
               alert(response);
               jQuery('#'+prefix+'Delete'+mappingcount).show(300);
                }
*/

            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });

}
       else{
               alert("You are cancel the field registration");
       }
       }
       else{
               alert("Please enter the values");
               return false;
       }

}

//Delete the PODS Fields
function delete_podscustomfield(id,import_type,prefix,mappingcount,core_count){
       close_id=prefix+'_close_'+core_count;
       fieldlabel = document.getElementById('hdtitle'+mappingcount).value;
        if(import_type == 'custompost')
       var custompost = document.getElementById('custompostlist').value;
       jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'register_pods_fields',
                'import_type':import_type,
                'fdlabel': fieldlabel,
                'remove' : 'true',
                'custompost' : custompost,
            },
            success: function (response) {
               if(response == 'Field Deleted')
                alert('Field Deleted');
               closefield(close_id,prefix,core_count);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
}
//register TYPES field
function register_typescustomfield(id,import_type,prefix,mappingcount,core_count) {
        close_id=prefix+'_close_'+core_count;
        fdname = 'CustomField'+mappingcount;
        fdname_ui = prefix+'ui__CustomFieldName'+mappingcount;
        fdlabel_ui = prefix+'ui__CustomFieldLabel'+mappingcount;
        fdlabel = prefix+'__CustomField'+mappingcount;
        fdcontent = prefix+'__mapping_drop'+mappingcount;
        fdtype = prefix+'_datatype_'+mappingcount;
        var flag = is_empty(prefix,mappingcount);
        var fieldlabel_ui = document.getElementById(fdlabel_ui).value;
        var fieldnm_ui = document.getElementById(fdname_ui).value;
        var custompost = '';
        if(flag == true){
        if(confirm("Register the custom fields...?") == true){
               if(import_type == 'custompost')
                        custompost = document.getElementById('custompostlist').value;
        var fieldlabel = document.getElementById(fdlabel_ui).value;
        var fieldnm = document.getElementById(fdname_ui).value;
        fieldnm = fieldnm.replace(/ /g,"_");
        var fieldtype = document.getElementById(fdtype).value;
        var desc = document.getElementById(prefix+'ui__CustomFieldDesc'+mappingcount).value;
        var req = document.getElementById(prefix+'ui__CustomFieldOption'+mappingcount).checked;
        var fieldoption = '';
        if(fieldtype == 'select' || fieldtype == 'checkboxes' || fieldtype == 'radio'){
                fieldoption = document.getElementById(prefix+'_type_options'+mappingcount).value;
        }
        if(fieldtype == 'checkbox'){
                fieldoption = document.getElementById(prefix+'chck_op'+mappingcount).value;
        }
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'register_types_fields',
               'import_type':import_type,
               'fdlabel':fieldlabel,
               'fdname': fieldnm,
               'fdtype': fieldtype,
               'desc': desc,
               'fdreq': req,
               'fdoption': fieldoption,
               'custompost' : custompost,
            },
            success: function (response) {
                if(response == 'Field already registered'){
                        alert(response);
                        return false;
                }
                var id = "TYPES_table";
                var registered = "true";
                var coreid = "types_addcustom_panel";
		document.getElementById(prefix+'_reg_count').value = core_count;
                document.getElementById('reg_mapcount').value = mappingcount;
                disp(id,registered,prefix,coreid,import_type);
  //              alert(fdname);
		if(response == 'Field Added'){
               		alert(response);
                	jQuery('#'+prefix+'Delete'+mappingcount).show(300);
                }
                jQuery('#'+fdlabel).val(fieldlabel);
                jQuery('#'+fdname).html('[Name: ' + fieldnm + ']');
                jQuery('#'+prefix+mappingcount+'name').value = fieldnm;
                var input = document.createElement("input");
               input.setAttribute("type", "hidden");
               input.setAttribute("name", prefix+'_check_'+fieldnm);
               input.setAttribute("value", "off");
               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
               var input = document.createElement("input");
               input.setAttribute("type", "hidden");
               input.setAttribute("name", prefix+'__fieldname'+mappingcount);
               input.setAttribute("id", prefix + '__'+fieldnm);
               input.setAttribute("value", fieldnm);
               document.getElementById(prefix+"_tdc_count"+core_count).appendChild(input);
               document.getElementById('hdtitle'+mappingcount).value = fieldlabel;
              document.getElementById(mappingcount+'_CustomField').innerHTML = '<b> '+ fieldlabel +'</b>';
		document.getElementById(prefix+'req__'+mappingcount).value = fieldnm;
           /*    if(response == 'Field Added'){
               alert(response);
                jQuery('#'+prefix+'Delete'+mappingcount).show(300);
                }
*/
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
        }
        else{
                alert("You are cancel the field registration");
        }
        }
        else{
                alert("Please enter the values");
               return false;
        }
}

//Delete the TYPES Fields
function delete_typescustomfield(id,import_type,prefix,mappingcount,core_count){
       close_id=prefix+'_close_'+core_count;
        fdname = 'CustomField'+mappingcount;
        fieldnm = jQuery('#'+fdname).text();
         fieldnm = fieldnm.substr(7);
        fieldnm = fieldnm.split(']').join(' ');
        fieldnm = fieldnm.trim();
        if(import_type == 'custompost')
       var custompost = document.getElementById('custompostlist').value;
       jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'register_types_fields',
                'import_type':import_type,
                'fdname': fieldnm,
                'remove' : 'true',
                'custompost' : custompost,
            },
            success: function (response) {
               if(response == 'Field Deleted')
                alert('Field Deleted');
               closefield(close_id,prefix,core_count);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
}

//Close Custom field
function closefield(id,prefix,core_count) {
	//jQuery('#'+prefix+'_tr_count'+core_count).slideUp(1000);
	var rowid = prefix+'_tr_count'+core_count;
	var row = document.getElementById(rowid);
    row.parentNode.removeChild(row);

}
// saving template name

function savetemplatename() {
       var txtid = document.getElementById('map_temp_name').value;
       var hdnid = document.getElementById('template_name').value;
/*       if((document.getElementById('template_name').value) == '') {
               document.getElementById('map_temp_name').value = document.getElementById('map_temp_name').value;
               //alert(document.getElementById('map_temp_name').value);
       } */
//       else {
/*	if((document.getElementById('map_temp_name').value) != '') {
               document.getElementById('map_temp_name').value = document.getElementById('template_name').value;
               //alert(document.getElementById('map_temp_name').value);
       } else { */
		document.getElementById('map_temp_name').value = document.getElementById('template_name').value;
//	}
}

function populate_shortcodes(eventid, id) {
	var get_eventid = eventid.split('populate_');
	var event_id = get_eventid[1];
	var pid = document.getElementById('pid').value;
	var events = document.getElementById('event').value;
	document.getElementById('eventst'+id+'_'+event_id).innerHTML = translateAlertString("In Progress");
        jQuery('#upload_blur').modal('show');
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                'action': 'replace_shortcodes',
		'eventKey': event_id,
		'row_id': id,
                },
                success: function (response) {
//alert(response);
			if(response == 1) {
				showMapMessages('success', translateAlertString('Successfully Replaced!'));
                                jQuery('#upload_blur').modal('hide');
				var newhtml = "<button type ='button' style='padding: 2px 7px; width:75px;' name='populate' id ='populate_"+events+"' class='btn btn-success' title='Populate all ShortCodes' data-toggle='modal' data-target='#myModal' onclick='populate_shortcodes(populate_"+events+","+id+")'>Success</button>";
				document.getElementById('eventst'+id+'_'+event_id).innerHTML = "Replaced";
				document.getElementById('statusmsg_'+id+'').innerHTML = newhtml;
			} else if(response == 2) {
				showMapMessages('error', translateAlertString('Partially Replaced!'));
                        	jQuery('#upload_blur').modal('hide');
				var newhtml = "<button type ='button' style='padding: 2px 7px; width:75px;' name='populate' id ='populate_"+events+"' class='btn btn-warning btn-sm' title='Populate all ShortCodes' data-toggle='modal' data-target='#myModal' onclick='populate_shortcodes(populate_"+events+","+id+")'>Continue</button>";
				document.getElementById('eventst'+id+'_'+event_id).innerHTML = translateAlertString("Partially");
				document.getElementById('statusmsg_'+id+'').innerHTML = newhtml;
			} else if (response == 'Images not available!') {
                                showMapMessages('error', translateAlertString('Images not available!'));
				jQuery('#upload_blur').modal('hide');
			}
		}
	}); 
}
function update_inlineimages(eventid, id) {
        var get_eventid = eventid.split('update_');
        var event_id = get_eventid[1];
        var doaction = new Array({eventid:event_id});
        jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                'action': 'replace_images',
                'postdata':doaction
                  },
//                dataType: 'json',
                success: function (response) {
                       //alert()
                     data = JSON.parse(response);
                     document.getElementById('upload_file').innerHTML =data;
                     jQuery('#upload_inline').modal('show');
                     //console.log(response);
                     //alert('Sucessfully Replaced');
                }
        });
 
         
         
}

function processgotostep(id) {
	var get_current_action = $( '#browsefile' ).attr( 'action' );
	var goto_url = '';
	var get_param_from_action = get_current_action.split('&');
	if(id == 'importfile') {
		goto_url = 'admin.php?page=wp-ultimate-csv-importer-pro/index.php&' + get_param_from_action[1] + '&' + get_param_from_action[2] + '&step=mapping_settings';
		jQuery('#browsefile').attr('action', goto_url).submit();
	} else {
		goto_url = 'admin.php?page=wp-ultimate-csv-importer-pro/index.php&' + get_param_from_action[1] + '&' + get_param_from_action[2] + '&step=templatelist';
		jQuery('#browsefile').attr('action', goto_url).submit();
	}
}

//Proceed to import
function proceedtoimport() {
document.getElementById('sec-three').style.display = "block";
document.getElementById('importoptions').style.display = "block";
document.getElementById('summarize_before_import').style.display = "none";
}

//Proceed to log
function proceedtolog(totrec) {
var given_rec = document.getElementById('importlimit').value;
if(given_rec > totrec){
showMapMessages('error', 'Only '+totrec+' records are available.');
return false;
}
document.getElementById('importoptions').style.display = "none";
document.getElementById('options').style.display = "none";
document.getElementById('sec-three').style.display = "block";
document.getElementById('importcontrol').style.display = "block";
document.getElementById('logtabs').style.display = "block";
document.getElementById('importsect').style.border = "none";
document.getElementById('importsect').style.backgroundColor = "transparent";
document.getElementById('importcontrol').style.backgroundColor = "transparent";
}
//Back to import options
function backtoimportscreen() {
document.getElementById('importcontrol').style.display = "none";
document.getElementById('logtabs').style.display = "none";
document.getElementById('sec-three').style.display = "block";
document.getElementById('importoptions').style.display = "block";
document.getElementById('options').style.display = "block";
}

function Update(id,siteurl){
	var imported   = document.getElementById('importedas'+id).value;
	var version_id = document.getElementById('version'+id).value;
	var ver = version_id.split('__'); 
	var ID = ver[1];
	var csv_name = document.getElementById('csv_name'+id).value;
	var csv = csv_name.split('.');
	var csv_fname = csv[0];
	var extension = csv[csv.length - 1];
	var uploadfilename = csv_fname+'-'+ID+'.'+extension;
	if(version_id == 'select') {
		alert(translateAlertString('Kindly Choose the Version Id !'));
		return false;
	}
	var eventKey = ver[0].split('/');
	var eKey  = eventKey[eventKey.length-1];
	var postdata = imported;
	var currmodule = '';
	 jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            async: false,
            data: {
                'action': 'get_current_module',
                'postdata': postdata,
            },
            success: function (data) {
		currmodule = data;
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });

	var re_url = siteurl+'&__module=ultimatecsvimporter&import_type='+currmodule+'&step=templatelist&eKey='+eKey+'&uploadfilename='+uploadfilename+'&csv_name='+csv_name+'&version='+ ID;
	window.location.assign(re_url);
}

function static_validator(id) {
       var val = jQuery('#'+id).val();
       var check = /{([0-9 a-z _]+)}([0-9 a-z _]*)([\+ \- \* \/]*)/; 
       if(val.match(check)) {
	     document.getElementById(id).style.width= '100%';
	     document.getElementById(id).style.border= '3px solid #33CC33'; 
       }
       else {
	     document.getElementById(id).style.width= '100%';
             document.getElementById(id).style.border= '3px solid #FF0000';
        }
}

/*function static_validator(id) {
       var val = jQuery('#'+id).val();
       var check = /{([0-9 a-z _]+)}([0-9 a-z _]*)([\+ \- \* \/]*)/;
       if(val.match(check)) {
             document.getElementById(id).style= "width:100%;border:3px solid #33CC33;"  
       }
       else {
             document.getElementById(id).style= "width:100%;border:3px solid #FF0000;" 
        }
}*/
function formula_validator(id) {
       var val = jQuery('#'+id).val();
       var check = /{([0-9 a-z _]+)}([^a-z 0-9])([\+ \- \* \/]*)/;
       if(val.match(check)) {
	     document.getElementById(id).style.width= '100%';
             document.getElementById(id).style.border= '3px solid #33CC33';
       }
      else {
	     document.getElementById(id).style.width= '100%';
             document.getElementById(id).style.border= '3px solid #FF0000';
        }
}

