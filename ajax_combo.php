<?php


	$start_ts = microtime(true);

	// how many results to return per call, in case of json output
	$results_per_page = 50;

	$curr_dir = dirname(__FILE__);
	include("$curr_dir/defaultLang.php");
	include("$curr_dir/language.php");
	include("$curr_dir/lib.php");

	handle_maintenance();

	// drop-downs config
	$lookups = array(   
		'students' => array(   
			'Class' => array(
				'parent_table' => 'classes',
				'parent_pk_field' => 'id',
				'parent_caption' => '`classes`.`Name`',
				'parent_from' => '`classes` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'Stream' => array(
				'parent_table' => 'streams',
				'parent_pk_field' => 'id',
				'parent_caption' => '`streams`.`Name`',
				'parent_from' => '`streams` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false
			),
			
			),
			'Category' => array(
				'parent_table' => 'studentcategories',
				'parent_pk_field' => 'id',
				'parent_caption' => '`studentcategories`.`Name`',
				'parent_from' => '`studentcategories` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false
			),
			'AcademicYear' => array(
				'parent_table' => 'sessions',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`sessions`.`Year`) || CHAR_LENGTH(`sessions`.`Term`), CONCAT_WS(\'\', `sessions`.`Year`, \' :Term \', `sessions`.`Term`), \'\')',
				'parent_from' => '`sessions` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `sessions`.`id`, IF(CHAR_LENGTH(`sessions`.`Year`) || CHAR_LENGTH(`sessions`.`Term`), CONCAT_WS(\'\', `sessions`.`Year`, \' :Term \', `sessions`.`Term`), \'\') FROM `sessions` WHERE status=\'active\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'TotalFees' => array(
				'parent_table' => 'schoolmoney',
				'parent_pk_field' => 'id',
				'parent_caption' => '`schoolmoney`.`Total`',
				'parent_from' => '`schoolmoney` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`schoolmoney`.`Class` ',
				'filterers' => array('Class' => 'Class'),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'Parent' => array(
				'parent_table' => 'parents',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`parents`.`Name`) || CHAR_LENGTH(`parents`.`Phone`), CONCAT_WS(\'\', `parents`.`Name`, \' :Phone: \', `parents`.`Phone`), \'\')',
				'parent_from' => '`parents` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'feescollection' => array(   
			'Student' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`students`.`FullName`) || CHAR_LENGTH(`students`.`RegNo`), CONCAT_WS(\'\', `students`.`FullName`, \' :RegNo: \', `students`.`RegNo`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'Class' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`students`.`Class`) || CHAR_LENGTH(`students`.`Stream`), CONCAT_WS(\'\', IF(    CHAR_LENGTH(`classes1`.`Name`), CONCAT_WS(\'\',   `classes1`.`Name`), \'\'), \' :Stream \', IF(    CHAR_LENGTH(`streams1`.`Name`), CONCAT_WS(\'\',   `streams1`.`Name`), \'\')), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Session' => array(
				'parent_table' => 'sessions',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(CHAR_LENGTH(`sessions`.`Year`) || CHAR_LENGTH(`sessions`.`Term`), CONCAT_WS(\'\', `sessions`.`Year`, \' :Term \', `sessions`.`Term`), \'\')',
				'parent_from' => '`sessions` ',
				'filterers' => array(),
				'custom_query' => 'SELECT `sessions`.`id`, IF(CHAR_LENGTH(`sessions`.`Year`) || CHAR_LENGTH(`sessions`.`Term`), CONCAT_WS(\'\', `sessions`.`Year`, \' :Term \', `sessions`.`Term`), \'\') FROM `sessions` WHERE status=\'active\' ORDER BY 2',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'Balance' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => '`students`.`Balance`',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array('Session' => 'AcademicYear'),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			
		
		
		'teachers' => array(  
		),
		'subjects' => array(  
		),
		'classes' => array(  
		),
		'streams' => array(  
		),
		
		),
		'timetable' => array(   
			'Class' => array(
				'parent_table' => 'classes',
				'parent_pk_field' => 'id',
				'parent_caption' => '`classes`.`Name`',
				'parent_from' => '`classes` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'Stream' => array(
				'parent_table' => 'streams',
				'parent_pk_field' => 'id',
				'parent_caption' => '`streams`.`Name`',
				'parent_from' => '`streams` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'events' => array(  
		),
		'notices' => array(  
		),
		'examresults' => array(   
			'student' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => '`students`.`FullName`',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'RegNo' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => '`students`.`RegNo`',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Class' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(    CHAR_LENGTH(`classes1`.`Name`), CONCAT_WS(\'\',   `classes1`.`Name`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Stream' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(    CHAR_LENGTH(`streams1`.`Name`), CONCAT_WS(\'\',   `streams1`.`Name`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Category' => array(
				'parent_table' => 'examcategories',
				'parent_pk_field' => 'id',
				'parent_caption' => '`examcategories`.`Name`',
				'parent_from' => '`examcategories` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Subject' => array(
				'parent_table' => 'subjects',
				'parent_pk_field' => 'id',
				'parent_caption' => '`subjects`.`Name`',
				'parent_from' => '`subjects` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => false
			),
			'Term' => array(
				'parent_table' => 'sessions',
				'parent_pk_field' => 'id',
				'parent_caption' => '`sessions`.`Year`',
				'parent_from' => '`sessions` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'AcademicYear' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(    CHAR_LENGTH(`sessions1`.`Year`) || CHAR_LENGTH(`sessions1`.`Term`), CONCAT_WS(\'\',   `sessions1`.`Year`, \' :Term \', `sessions1`.`Term`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'parents' => array(  
		),
		'examcategories' => array(  
		),
		'sessions' => array(  
		),
		'studentcategories' => array(  
		),
		'classattendance' => array(   
			'Subject' => array(
				'parent_table' => 'subjects',
				'parent_pk_field' => 'id',
				'parent_caption' => '`subjects`.`Name`',
				'parent_from' => '`subjects` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => true,
				'list_type' => 0,
				'not_null' => true
			),
			'Student' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => '`students`.`FullName`',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			),
			'RegNo' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => '`students`.`RegNo`',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Class' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(    CHAR_LENGTH(`classes1`.`Name`), CONCAT_WS(\'\',   `classes1`.`Name`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			),
			'Stream' => array(
				'parent_table' => 'students',
				'parent_pk_field' => 'id',
				'parent_caption' => 'IF(    CHAR_LENGTH(`streams1`.`Name`), CONCAT_WS(\'\',   `streams1`.`Name`), \'\')',
				'parent_from' => '`students` LEFT JOIN `classes` as classes1 ON `classes1`.`id`=`students`.`Class` LEFT JOIN `streams` as streams1 ON `streams1`.`id`=`students`.`Stream` LEFT JOIN `hostels` as hostels1 ON `hostels1`.`id`=`students`.`Hostel` LEFT JOIN `studentcategories` as studentcategories1 ON `studentcategories1`.`id`=`students`.`Category` LEFT JOIN `sessions` as sessions1 ON `sessions1`.`id`=`students`.`AcademicYear` LEFT JOIN `schoolmoney` as schoolmoney1 ON `schoolmoney1`.`id`=`students`.`TotalFees` LEFT JOIN `parents` as parents1 ON `parents1`.`id`=`students`.`Parent` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => false
			)
		),
		'schoolmoney' => array(   
			'Class' => array(
				'parent_table' => 'classes',
				'parent_pk_field' => 'id',
				'parent_caption' => '`classes`.`Name`',
				'parent_from' => '`classes` ',
				'filterers' => array(),
				'custom_query' => '',
				'inherit_permissions' => false,
				'list_type' => 0,
				'not_null' => true
			)
		)
	);

	// XSS prevention
	$xss = new CI_Input();
	$xss->charset = datalist_db_encoding;

	// receive and verify user input
	$table_name = $_REQUEST['t'];
	$field_name = $_REQUEST['f'];
	$search_id = makeSafe(iconv('UTF-8', datalist_db_encoding, $_REQUEST['id']));
	$selected_text = iconv('UTF-8', datalist_db_encoding, $_REQUEST['text']);
	$returnOptions = ($_REQUEST['o'] == 1 ? true : false);
	$page = intval($_REQUEST['p']);
	if($page < 1)  $page = 1;
	$skip = $results_per_page * ($page - 1);
	$search_term = makeSafe(iconv('UTF-8', datalist_db_encoding, $_REQUEST['s']));

	if(!isset($lookups[$table_name][$field_name])) die('{ "error": "Invalid table or field." }');

	// can user access the requested table?
	$perm = getTablePermissions($table_name);
	if(!$perm[0] && !$search_id) die('{ "error": "' . addslashes($Translation['tableAccessDenied']) . '" }');

	$field = $lookups[$table_name][$field_name];

	$wheres = array();

	// search term provided?
	if($search_term){
		$wheres[] = "{$field['parent_caption']} like '%{$search_term}%'";
	}

	// any filterers specified?
	if(is_array($field['filterers'])){
		foreach($field['filterers'] as $filterer => $filterer_parent){
			$get = (isset($_REQUEST["filterer_{$filterer}"]) ? $_REQUEST["filterer_{$filterer}"] : false);
			if($get){
				$wheres[] = "`{$field['parent_table']}`.`$filterer_parent`='" . makeSafe($get) . "'";
			}
		}
	}

	// inherit permissions?
	if($field['inherit_permissions']){
		$inherit = permissions_sql($field['parent_table']);
		if($inherit === false && !$search_id) die($Translation['tableAccessDenied']);

		if($inherit['where']) $wheres[] = $inherit['where'];
		if($inherit['from']) $field['parent_from'] .= ", {$inherit['from']}";
	}

	// single value?
	if($field['list_type'] != 2 && $search_id){
		$wheres[] = "`{$field['parent_table']}`.`{$field['parent_pk_field']}`='{$search_id}'";
	}

	if(count($wheres)){
		$where = 'WHERE ' . implode(' AND ', $wheres);
	}

	// define the combo and return the code
	$combo = new DataCombo;
	if($field['custom_query']){
		$qm = array(); $custom_where = ''; $custom_order_by = '2';
		$combo->Query = $field['custom_query'];

		if(preg_match('/ order by (.*)$/i', $combo->Query, $qm)){
			$custom_order_by = $qm[1];
			$combo->Query = preg_replace('/ order by .*$/i', '', $combo->Query);
		}

		if(preg_match('/ where (.*)$/i', $combo->Query, $qm)){
			$custom_where = $qm[1];
			$combo->Query = preg_replace('/ where .*$/i', '', $combo->Query);
		}

		if($where && $custom_where){
			$combo->Query .=  " {$where} AND ({$custom_where}) ORDER BY {$custom_order_by}";
		}elseif($custom_where){
			$combo->Query .=  " WHERE {$custom_where} ORDER BY {$custom_order_by}";
		}else{
			$combo->Query .=  " {$where} ORDER BY {$custom_order_by}";
		}

		$query_match = array();
		preg_match('/select (.*) from (.*)$/i', $combo->Query, $query_match);

		if(isset($query_match[2])){
			$count_query = "SELECT count(1) FROM {$query_match[2]}";
		}else{
			$count_query = '';
		}
	}else{
		$combo->Query = "SELECT " . ($field['inherit_permissions'] ? 'DISTINCT ' : '') . "`{$field['parent_table']}`.`{$field['parent_pk_field']}`, {$field['parent_caption']} FROM {$field['parent_from']} {$where} ORDER BY 2";
		$count_query = "SELECT count(1) FROM {$field['parent_from']} {$where}";
	}
	$combo->table = $table_name;
	$combo->parent_table = $field['parent_table'];
	$combo->SelectName = $field_name;
	$combo->ListType = $field['list_type'];
	if($search_id){
		$combo->SelectedData = $search_id;
	}elseif($selected_text){
		$combo->SelectedData = getValueGivenCaption($combo->Query, $selected_text);
	}

	if($field['list_type'] == 2){
		$combo->Render();
		$combo->HTML = str_replace('<select ', '<select onchange="' . $field_name . '_changed();" ', $combo->HTML);

		// return response
		if($returnOptions){
			?><span id="<?php echo $field_name; ?>-combo-list"><?php echo $combo->HTML; ?></span><?php
		}else{
			?>
				<span id="<?php echo $field_name; ?>-match-text"><?php echo $combo->MatchText; ?></span>
				<input type="hidden" id="<?php echo $field_name; ?>" value="<?php echo html_attr($combo->SelectedData); ?>" />
			<?php
		}
	}else{
		/* return json */
		header('Content-type: application/json');

		if(!preg_match('/ limit .+/i', $combo->Query)){
			if(!$search_id) $combo->Query .= " LIMIT {$skip}, {$results_per_page}";
			if($search_id) $combo->Query .= " LIMIT 1";
		}

		$prepared_data = array();

		// specific caption provided and list_type is not radio?
		if(!$search_id && $selected_text){
			$search_id = getValueGivenCaption($combo->Query, $selected_text);
			if($search_id) $prepared_data[] = array('id' => $search_id, 'text' => $xss->xss_clean($selected_text));
		}else{
			$res = sql($combo->Query, $eo);
			while($row = db_fetch_row($res)){
				if(empty($prepared_data) && $page == 1 && !$search_id && !$field['not_null']){
					$prepared_data[] = array('id' => empty_lookup_value, 'text' => "<{$Translation['none']}>");
				}

				$prepared_data[] = array('id' => iconv(datalist_db_encoding, 'UTF-8', $row[0]), 'text' => iconv(datalist_db_encoding, 'UTF-8', $xss->xss_clean($row[1])));
			}
		}

		if(empty($prepared_data)){ $prepared_data[] = array('id' => '', 'text' => $Translation['No matches found!']); }

		echo json_encode(array(
			'results' => $prepared_data,
			'more' => (@db_num_rows($res) >= $results_per_page),
			'elapsed' => round(microtime(true) - $start_ts, 3)
		));
	}

