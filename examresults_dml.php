<?php

// Data functions (insert, update, delete, form) for table examresults



function examresults_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('examresults');
	if(!$arrPerm[1]){
		return false;
	}

	$data['student'] = makeSafe($_REQUEST['student']);
		if($data['student'] == empty_lookup_value){ $data['student'] = ''; }
	$data['RegNo'] = makeSafe($_REQUEST['student']);
		if($data['RegNo'] == empty_lookup_value){ $data['RegNo'] = ''; }
	$data['Class'] = makeSafe($_REQUEST['student']);
		if($data['Class'] == empty_lookup_value){ $data['Class'] = ''; }
	$data['Stream'] = makeSafe($_REQUEST['student']);
		if($data['Stream'] == empty_lookup_value){ $data['Stream'] = ''; }
	$data['Category'] = makeSafe($_REQUEST['Category']);
		if($data['Category'] == empty_lookup_value){ $data['Category'] = ''; }
	$data['Subject'] = makeSafe($_REQUEST['Subject']);
		if($data['Subject'] == empty_lookup_value){ $data['Subject'] = ''; }
	$data['Marks'] = makeSafe($_REQUEST['Marks']);
		if($data['Marks'] == empty_lookup_value){ $data['Marks'] = ''; }
	$data['Term'] = makeSafe($_REQUEST['Term']);
		if($data['Term'] == empty_lookup_value){ $data['Term'] = ''; }
	$data['AcademicYear'] = makeSafe($_REQUEST['student']);
		if($data['AcademicYear'] == empty_lookup_value){ $data['AcademicYear'] = ''; }
	if($data['student']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Student': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['Marks']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Marks': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['Term']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Term': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: examresults_before_insert
	if(function_exists('examresults_before_insert')){
		$args=array();
		if(!examresults_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `examresults` set       `student`=' . (($data['student'] !== '' && $data['student'] !== NULL) ? "'{$data['student']}'" : 'NULL') . ', `RegNo`=' . (($data['RegNo'] !== '' && $data['RegNo'] !== NULL) ? "'{$data['RegNo']}'" : 'NULL') . ', `Class`=' . (($data['Class'] !== '' && $data['Class'] !== NULL) ? "'{$data['Class']}'" : 'NULL') . ', `Stream`=' . (($data['Stream'] !== '' && $data['Stream'] !== NULL) ? "'{$data['Stream']}'" : 'NULL') . ', `Category`=' . (($data['Category'] !== '' && $data['Category'] !== NULL) ? "'{$data['Category']}'" : 'NULL') . ', `Subject`=' . (($data['Subject'] !== '' && $data['Subject'] !== NULL) ? "'{$data['Subject']}'" : 'NULL') . ', `Marks`=' . (($data['Marks'] !== '' && $data['Marks'] !== NULL) ? "'{$data['Marks']}'" : 'NULL') . ', `Term`=' . (($data['Term'] !== '' && $data['Term'] !== NULL) ? "'{$data['Term']}'" : 'NULL') . ', `AcademicYear`=' . (($data['AcademicYear'] !== '' && $data['AcademicYear'] !== NULL) ? "'{$data['AcademicYear']}'" : 'NULL'), $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"examresults_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: examresults_after_insert
	if(function_exists('examresults_after_insert')){
		$res = sql("select * from `examresults` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!examresults_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	set_record_owner('examresults', $recID, getLoggedMemberID());

	return $recID;
}

function examresults_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('examresults');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='examresults' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='examresults' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: examresults_before_delete
	if(function_exists('examresults_before_delete')){
		$args=array();
		if(!examresults_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	sql("delete from `examresults` where `id`='$selected_id'", $eo);

	// hook: examresults_after_delete
	if(function_exists('examresults_after_delete')){
		$args=array();
		examresults_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='examresults' and pkValue='$selected_id'", $eo);
}

function examresults_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('examresults');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='examresults' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='examresults' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['student'] = makeSafe($_REQUEST['student']);
		if($data['student'] == empty_lookup_value){ $data['student'] = ''; }
	if($data['student']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Student': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['RegNo'] = makeSafe($_REQUEST['student']);
		if($data['RegNo'] == empty_lookup_value){ $data['RegNo'] = ''; }
	$data['Class'] = makeSafe($_REQUEST['student']);
		if($data['Class'] == empty_lookup_value){ $data['Class'] = ''; }
	$data['Stream'] = makeSafe($_REQUEST['student']);
		if($data['Stream'] == empty_lookup_value){ $data['Stream'] = ''; }
	$data['Category'] = makeSafe($_REQUEST['Category']);
		if($data['Category'] == empty_lookup_value){ $data['Category'] = ''; }
	$data['Subject'] = makeSafe($_REQUEST['Subject']);
		if($data['Subject'] == empty_lookup_value){ $data['Subject'] = ''; }
	$data['Marks'] = makeSafe($_REQUEST['Marks']);
		if($data['Marks'] == empty_lookup_value){ $data['Marks'] = ''; }
	if($data['Marks']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Marks': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['Term'] = makeSafe($_REQUEST['Term']);
		if($data['Term'] == empty_lookup_value){ $data['Term'] = ''; }
	if($data['Term']==''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">{$Translation['error:']} 'Term': {$Translation['field not null']}<br><br>";
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	$data['AcademicYear'] = makeSafe($_REQUEST['student']);
		if($data['AcademicYear'] == empty_lookup_value){ $data['AcademicYear'] = ''; }
	$data['selectedID']=makeSafe($selected_id);

	// hook: examresults_before_update
	if(function_exists('examresults_before_update')){
		$args=array();
		if(!examresults_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `examresults` set       `student`=' . (($data['student'] !== '' && $data['student'] !== NULL) ? "'{$data['student']}'" : 'NULL') . ', `RegNo`=' . (($data['RegNo'] !== '' && $data['RegNo'] !== NULL) ? "'{$data['RegNo']}'" : 'NULL') . ', `Class`=' . (($data['Class'] !== '' && $data['Class'] !== NULL) ? "'{$data['Class']}'" : 'NULL') . ', `Stream`=' . (($data['Stream'] !== '' && $data['Stream'] !== NULL) ? "'{$data['Stream']}'" : 'NULL') . ', `Category`=' . (($data['Category'] !== '' && $data['Category'] !== NULL) ? "'{$data['Category']}'" : 'NULL') . ', `Subject`=' . (($data['Subject'] !== '' && $data['Subject'] !== NULL) ? "'{$data['Subject']}'" : 'NULL') . ', `Marks`=' . (($data['Marks'] !== '' && $data['Marks'] !== NULL) ? "'{$data['Marks']}'" : 'NULL') . ', `Term`=' . (($data['Term'] !== '' && $data['Term'] !== NULL) ? "'{$data['Term']}'" : 'NULL') . ', `AcademicYear`=' . (($data['AcademicYear'] !== '' && $data['AcademicYear'] !== NULL) ? "'{$data['AcademicYear']}'" : 'NULL') . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="examresults_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: examresults_after_update
	if(function_exists('examresults_after_update')){
		$res = sql("SELECT * FROM `examresults` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!examresults_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='examresults' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function examresults_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('examresults');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}

	$filterer_student = thisOr(undo_magic_quotes($_REQUEST['filterer_student']), '');
	$filterer_Category = thisOr(undo_magic_quotes($_REQUEST['filterer_Category']), '');
	$filterer_Subject = thisOr(undo_magic_quotes($_REQUEST['filterer_Subject']), '');
	$filterer_Term = thisOr(undo_magic_quotes($_REQUEST['filterer_Term']), '');

	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: student
	$combo_student = new DataCombo;
	// combobox: Category
	$combo_Category = new DataCombo;
	// combobox: Subject
	$combo_Subject = new DataCombo;
	// combobox: Term
	$combo_Term = new DataCombo;

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='examresults' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='examresults' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `examresults` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'examresults_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_student->SelectedData = $row['student'];
		$combo_Category->SelectedData = $row['Category'];
		$combo_Subject->SelectedData = $row['Subject'];
		$combo_Term->SelectedData = $row['Term'];
	}else{
		$combo_student->SelectedData = $filterer_student;
		$combo_Category->SelectedData = $filterer_Category;
		$combo_Subject->SelectedData = $filterer_Subject;
		$combo_Term->SelectedData = $filterer_Term;
	}
	$combo_student->HTML = '<span id="student-container' . $rnd1 . '"></span><input type="hidden" name="student" id="student' . $rnd1 . '" value="' . html_attr($combo_student->SelectedData) . '">';
	$combo_student->MatchText = '<span id="student-container-readonly' . $rnd1 . '"></span><input type="hidden" name="student" id="student' . $rnd1 . '" value="' . html_attr($combo_student->SelectedData) . '">';
	$combo_Category->HTML = '<span id="Category-container' . $rnd1 . '"></span><input type="hidden" name="Category" id="Category' . $rnd1 . '" value="' . html_attr($combo_Category->SelectedData) . '">';
	$combo_Category->MatchText = '<span id="Category-container-readonly' . $rnd1 . '"></span><input type="hidden" name="Category" id="Category' . $rnd1 . '" value="' . html_attr($combo_Category->SelectedData) . '">';
	$combo_Subject->HTML = '<span id="Subject-container' . $rnd1 . '"></span><input type="hidden" name="Subject" id="Subject' . $rnd1 . '" value="' . html_attr($combo_Subject->SelectedData) . '">';
	$combo_Subject->MatchText = '<span id="Subject-container-readonly' . $rnd1 . '"></span><input type="hidden" name="Subject" id="Subject' . $rnd1 . '" value="' . html_attr($combo_Subject->SelectedData) . '">';
	$combo_Term->HTML = '<span id="Term-container' . $rnd1 . '"></span><input type="hidden" name="Term" id="Term' . $rnd1 . '" value="' . html_attr($combo_Term->SelectedData) . '">';
	$combo_Term->MatchText = '<span id="Term-container-readonly' . $rnd1 . '"></span><input type="hidden" name="Term" id="Term' . $rnd1 . '" value="' . html_attr($combo_Term->SelectedData) . '">';

	ob_start();
	?>

	<script>
		// initial lookup values
		AppGini.current_student__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['student'] : $filterer_student); ?>"};
		AppGini.current_Category__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['Category'] : $filterer_Category); ?>"};
		AppGini.current_Subject__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['Subject'] : $filterer_Subject); ?>"};
		AppGini.current_Term__RAND__ = { text: "", value: "<?php echo addslashes($selected_id ? $urow['Term'] : $filterer_Term); ?>"};

		jQuery(function() {
			setTimeout(function(){
				if(typeof(student_reload__RAND__) == 'function') student_reload__RAND__();
				if(typeof(Category_reload__RAND__) == 'function') Category_reload__RAND__();
				if(typeof(Subject_reload__RAND__) == 'function') Subject_reload__RAND__();
				if(typeof(Term_reload__RAND__) == 'function') Term_reload__RAND__();
			}, 10); /* we need to slightly delay client-side execution of the above code to allow AppGini.ajaxCache to work */
		});
		function student_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#student-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_student__RAND__.value, t: 'examresults', f: 'student' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="student"]').val(resp.results[0].id);
							$j('[id=student-container-readonly__RAND__]').html('<span id="student-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=students_view_parent]').hide(); }else{ $j('.btn[id=students_view_parent]').show(); }


							if(typeof(student_update_autofills__RAND__) == 'function') student_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ return { s: term, p: page, t: 'examresults', f: 'student' }; },
					results: function(resp, page){ return resp; }
				},
				escapeMarkup: function(str){ return str; }
			}).on('change', function(e){
				AppGini.current_student__RAND__.value = e.added.id;
				AppGini.current_student__RAND__.text = e.added.text;
				$j('[name="student"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=students_view_parent]').hide(); }else{ $j('.btn[id=students_view_parent]').show(); }


				if(typeof(student_update_autofills__RAND__) == 'function') student_update_autofills__RAND__();
			});

			if(!$j("#student-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_student__RAND__.value, t: 'examresults', f: 'student' },
					success: function(resp){
						$j('[name="student"]').val(resp.results[0].id);
						$j('[id=student-container-readonly__RAND__]').html('<span id="student-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=students_view_parent]').hide(); }else{ $j('.btn[id=students_view_parent]').show(); }

						if(typeof(student_update_autofills__RAND__) == 'function') student_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_student__RAND__.value, t: 'examresults', f: 'student' },
				success: function(resp){
					$j('[id=student-container__RAND__], [id=student-container-readonly__RAND__]').html('<span id="student-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=students_view_parent]').hide(); }else{ $j('.btn[id=students_view_parent]').show(); }

					if(typeof(student_update_autofills__RAND__) == 'function') student_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function Category_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#Category-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_Category__RAND__.value, t: 'examresults', f: 'Category' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="Category"]').val(resp.results[0].id);
							$j('[id=Category-container-readonly__RAND__]').html('<span id="Category-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=examcategories_view_parent]').hide(); }else{ $j('.btn[id=examcategories_view_parent]').show(); }


							if(typeof(Category_update_autofills__RAND__) == 'function') Category_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ return { s: term, p: page, t: 'examresults', f: 'Category' }; },
					results: function(resp, page){ return resp; }
				},
				escapeMarkup: function(str){ return str; }
			}).on('change', function(e){
				AppGini.current_Category__RAND__.value = e.added.id;
				AppGini.current_Category__RAND__.text = e.added.text;
				$j('[name="Category"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=examcategories_view_parent]').hide(); }else{ $j('.btn[id=examcategories_view_parent]').show(); }


				if(typeof(Category_update_autofills__RAND__) == 'function') Category_update_autofills__RAND__();
			});

			if(!$j("#Category-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_Category__RAND__.value, t: 'examresults', f: 'Category' },
					success: function(resp){
						$j('[name="Category"]').val(resp.results[0].id);
						$j('[id=Category-container-readonly__RAND__]').html('<span id="Category-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=examcategories_view_parent]').hide(); }else{ $j('.btn[id=examcategories_view_parent]').show(); }

						if(typeof(Category_update_autofills__RAND__) == 'function') Category_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_Category__RAND__.value, t: 'examresults', f: 'Category' },
				success: function(resp){
					$j('[id=Category-container__RAND__], [id=Category-container-readonly__RAND__]').html('<span id="Category-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=examcategories_view_parent]').hide(); }else{ $j('.btn[id=examcategories_view_parent]').show(); }

					if(typeof(Category_update_autofills__RAND__) == 'function') Category_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function Subject_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#Subject-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_Subject__RAND__.value, t: 'examresults', f: 'Subject' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="Subject"]').val(resp.results[0].id);
							$j('[id=Subject-container-readonly__RAND__]').html('<span id="Subject-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=subjects_view_parent]').hide(); }else{ $j('.btn[id=subjects_view_parent]').show(); }


							if(typeof(Subject_update_autofills__RAND__) == 'function') Subject_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ return { s: term, p: page, t: 'examresults', f: 'Subject' }; },
					results: function(resp, page){ return resp; }
				},
				escapeMarkup: function(str){ return str; }
			}).on('change', function(e){
				AppGini.current_Subject__RAND__.value = e.added.id;
				AppGini.current_Subject__RAND__.text = e.added.text;
				$j('[name="Subject"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=subjects_view_parent]').hide(); }else{ $j('.btn[id=subjects_view_parent]').show(); }


				if(typeof(Subject_update_autofills__RAND__) == 'function') Subject_update_autofills__RAND__();
			});

			if(!$j("#Subject-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_Subject__RAND__.value, t: 'examresults', f: 'Subject' },
					success: function(resp){
						$j('[name="Subject"]').val(resp.results[0].id);
						$j('[id=Subject-container-readonly__RAND__]').html('<span id="Subject-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=subjects_view_parent]').hide(); }else{ $j('.btn[id=subjects_view_parent]').show(); }

						if(typeof(Subject_update_autofills__RAND__) == 'function') Subject_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_Subject__RAND__.value, t: 'examresults', f: 'Subject' },
				success: function(resp){
					$j('[id=Subject-container__RAND__], [id=Subject-container-readonly__RAND__]').html('<span id="Subject-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=subjects_view_parent]').hide(); }else{ $j('.btn[id=subjects_view_parent]').show(); }

					if(typeof(Subject_update_autofills__RAND__) == 'function') Subject_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
		function Term_reload__RAND__(){
		<?php if(($AllowUpdate || $AllowInsert) && !$dvprint){ ?>

			$j("#Term-container__RAND__").select2({
				/* initial default value */
				initSelection: function(e, c){
					$j.ajax({
						url: 'ajax_combo.php',
						dataType: 'json',
						data: { id: AppGini.current_Term__RAND__.value, t: 'examresults', f: 'Term' },
						success: function(resp){
							c({
								id: resp.results[0].id,
								text: resp.results[0].text
							});
							$j('[name="Term"]').val(resp.results[0].id);
							$j('[id=Term-container-readonly__RAND__]').html('<span id="Term-match-text">' + resp.results[0].text + '</span>');
							if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=sessions_view_parent]').hide(); }else{ $j('.btn[id=sessions_view_parent]').show(); }


							if(typeof(Term_update_autofills__RAND__) == 'function') Term_update_autofills__RAND__();
						}
					});
				},
				width: '100%',
				formatNoMatches: function(term){ return '<?php echo addslashes($Translation['No matches found!']); ?>'; },
				minimumResultsForSearch: 10,
				loadMorePadding: 200,
				ajax: {
					url: 'ajax_combo.php',
					dataType: 'json',
					cache: true,
					data: function(term, page){ return { s: term, p: page, t: 'examresults', f: 'Term' }; },
					results: function(resp, page){ return resp; }
				},
				escapeMarkup: function(str){ return str; }
			}).on('change', function(e){
				AppGini.current_Term__RAND__.value = e.added.id;
				AppGini.current_Term__RAND__.text = e.added.text;
				$j('[name="Term"]').val(e.added.id);
				if(e.added.id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=sessions_view_parent]').hide(); }else{ $j('.btn[id=sessions_view_parent]').show(); }


				if(typeof(Term_update_autofills__RAND__) == 'function') Term_update_autofills__RAND__();
			});

			if(!$j("#Term-container__RAND__").length){
				$j.ajax({
					url: 'ajax_combo.php',
					dataType: 'json',
					data: { id: AppGini.current_Term__RAND__.value, t: 'examresults', f: 'Term' },
					success: function(resp){
						$j('[name="Term"]').val(resp.results[0].id);
						$j('[id=Term-container-readonly__RAND__]').html('<span id="Term-match-text">' + resp.results[0].text + '</span>');
						if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=sessions_view_parent]').hide(); }else{ $j('.btn[id=sessions_view_parent]').show(); }

						if(typeof(Term_update_autofills__RAND__) == 'function') Term_update_autofills__RAND__();
					}
				});
			}

		<?php }else{ ?>

			$j.ajax({
				url: 'ajax_combo.php',
				dataType: 'json',
				data: { id: AppGini.current_Term__RAND__.value, t: 'examresults', f: 'Term' },
				success: function(resp){
					$j('[id=Term-container__RAND__], [id=Term-container-readonly__RAND__]').html('<span id="Term-match-text">' + resp.results[0].text + '</span>');
					if(resp.results[0].id == '<?php echo empty_lookup_value; ?>'){ $j('.btn[id=sessions_view_parent]').hide(); }else{ $j('.btn[id=sessions_view_parent]').show(); }

					if(typeof(Term_update_autofills__RAND__) == 'function') Term_update_autofills__RAND__();
				}
			});
		<?php } ?>

		}
	</script>
	<?php

	$lookups = str_replace('__RAND__', $rnd1, ob_get_contents());
	ob_end_clean();


	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/examresults_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/examresults_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'ExamResulta details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return examresults_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return examresults_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'AppGini.closeParentModal(); return false;';
	}else{
		$backAction = '$j(\'form\').eq(0).attr(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode = str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return examresults_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode = str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode = str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#student').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#student_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#Category').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#Category_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#Subject').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#Subject_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('#Marks').replaceWith('<div class=\"form-control-static\" id=\"Marks\">' + (jQuery('#Marks').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#Term').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#Term_caption').prop('disabled', true).css({ color: '#555', backgroundColor: 'white' });\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif(($AllowInsert && !$selected_id) || ($AllowUpdate && $selected_id)){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode = str_replace('<%%COMBO(student)%%>', $combo_student->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(student)%%>', $combo_student->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(student)%%>', urlencode($combo_student->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(Category)%%>', $combo_Category->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(Category)%%>', $combo_Category->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(Category)%%>', urlencode($combo_Category->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(Subject)%%>', $combo_Subject->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(Subject)%%>', $combo_Subject->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(Subject)%%>', urlencode($combo_Subject->MatchText), $templateCode);
	$templateCode = str_replace('<%%COMBO(Term)%%>', $combo_Term->HTML, $templateCode);
	$templateCode = str_replace('<%%COMBOTEXT(Term)%%>', $combo_Term->MatchText, $templateCode);
	$templateCode = str_replace('<%%URLCOMBOTEXT(Term)%%>', urlencode($combo_Term->MatchText), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array(  'student' => array('students', 'Student'), 'Category' => array('examcategories', 'Category'), 'Subject' => array('subjects', 'Subject'), 'Term' => array('sessions', 'Term'));
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode = str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(student)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Category)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Subject)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Marks)%%>', '', $templateCode);
	$templateCode = str_replace('<%%UPLOADFILE(Term)%%>', '', $templateCode);

	// process values
	if($selected_id){
		if( $dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', safe_html($urow['id']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(student)%%>', safe_html($urow['student']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(student)%%>', html_attr($row['student']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(student)%%>', urlencode($urow['student']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Category)%%>', safe_html($urow['Category']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Category)%%>', html_attr($row['Category']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Category)%%>', urlencode($urow['Category']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Subject)%%>', safe_html($urow['Subject']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Subject)%%>', html_attr($row['Subject']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Subject)%%>', urlencode($urow['Subject']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Marks)%%>', safe_html($urow['Marks']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Marks)%%>', html_attr($row['Marks']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Marks)%%>', urlencode($urow['Marks']), $templateCode);
		if( $dvprint) $templateCode = str_replace('<%%VALUE(Term)%%>', safe_html($urow['Term']), $templateCode);
		if(!$dvprint) $templateCode = str_replace('<%%VALUE(Term)%%>', html_attr($row['Term']), $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Term)%%>', urlencode($urow['Term']), $templateCode);
	}else{
		$templateCode = str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(student)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(student)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Category)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Category)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Subject)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Subject)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Marks)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Marks)%%>', urlencode(''), $templateCode);
		$templateCode = str_replace('<%%VALUE(Term)%%>', '', $templateCode);
		$templateCode = str_replace('<%%URLVALUE(Term)%%>', urlencode(''), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode = str_replace('<%%', '<!-- ', $templateCode);
	$templateCode = str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';

	$templateCode .= "\tstudent_update_autofills$rnd1 = function(){\n";
	$templateCode .= "\t\t\$j.ajax({\n";
	if($dvprint){
		$templateCode .= "\t\t\turl: 'examresults_autofill.php?rnd1=$rnd1&mfk=student&id=' + encodeURIComponent('".addslashes($row['student'])."'),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "', type: 'GET'\n";
	}else{
		$templateCode .= "\t\t\turl: 'examresults_autofill.php?rnd1=$rnd1&mfk=student&id=' + encodeURIComponent(AppGini.current_student{$rnd1}.value),\n";
		$templateCode .= "\t\t\tcontentType: 'application/x-www-form-urlencoded; charset=" . datalist_db_encoding . "', type: 'GET', beforeSend: function(){ \$j('#student$rnd1').prop('disabled', true); \$j('#studentLoading').html('<img src=loading.gif align=top>'); }, complete: function(){".(($arrPerm[1] || (($arrPerm[3] == 1 && $ownerMemberID == getLoggedMemberID()) || ($arrPerm[3] == 2 && $ownerGroupID == getLoggedGroupID()) || $arrPerm[3] == 3)) ? "\$j('#student$rnd1').prop('disabled', false); " : "\$j('#student$rnd1').prop('disabled', true); ")."\$j('#studentLoading').html('');}\n";
	}
	$templateCode.="\t\t});\n";
	$templateCode.="\t};\n";
	if(!$dvprint) $templateCode.="\tif(\$j('#student_caption').length) \$j('#student_caption').click(function(){ student_update_autofills$rnd1(); });\n";


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('examresults');
	if($selected_id){
		$jdata = get_joined_record('examresults', $selected_id);
		if($jdata === false) $jdata = get_defaults('examresults');
		$rdata = $row;
	}
	$cache_data = array(
		'rdata' => array_map('nl2br', array_map('addslashes', $rdata)),
		'jdata' => array_map('nl2br', array_map('addslashes', $jdata))
	);
	$templateCode .= loadView('examresults-ajax-cache', $cache_data);

	// hook: examresults_dv
	if(function_exists('examresults_dv')){
		$args=array();
		examresults_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>