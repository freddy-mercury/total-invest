<?php
$ACCESS_LEVEL = ACCESS_LEVEL_ADMIN;
include_once(DOC_ROOT.'/includes/authorization.php');

include_once(LIB_ROOT.'/plans/plan.class.php');
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch ($action) {
	case 'edit':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
			$_POST = sql_escapeArray($_POST);
			sql_query('
				UPDATE plans SET
					name="'.$_POST['name'].'",
					min="'.$_POST['min'].'",
					max="'.$_POST['max'].'",
					percent="'.$_POST['percent'].'",
					percent_per="'.$_POST['percent_per'].'",
					periodicy_value="'.$_POST['periodicy_value'].'",
					periodicy="'.$_POST['periodicy'].'",
					term="'.$_POST['term'].'",
					attempts="'.$_POST['attempts'].'",
					comment="'.$_POST['comment'].'",
					type="'.$_POST['type'].'",
					working_days="'.$_POST['working_days'].'"
				WHERE id="'.$_POST['id'].'"
			');
			location($_SERVER['PHP_SELF'], '<p class=imp>Plan <u>'.htmlspecialchars($_POST['name']).'</u> has been saved!</p>');
		}
		$plan = sql_row('SELECT * FROM plans WHERE id="'.intval($_REQUEST['id']).'"');
		App::get()->smarty->assign('plan', stripslashes_array($plan));
		App::get()->smarty->display('../default/admin/plan_profile.tpl');
	break;
	case 'add':
		if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'save') {
			$_POST = sql_escapeArray($_POST);
			sql_query('
				INSERT INTO plans
				SET
					id=0, 
					name="'.$_POST['name'].'", 
					min="'.$_POST['min'].'", 
					max="'.$_POST['max'].'", 
					percent="'.$_POST['percent'].'", 
					percent_per="'.$_POST['percent_per'].'",
					periodicy="'.$_POST['periodicy'].'", 
					periodicy_value="'.$_POST['periodicy_value'].'", 
					term="'.$_POST['term'].'", 
					attempts="'.$_POST['attempts'].'",  
					status="1", 
					comment="'.$_POST['comment'].'", 
					type="'.$_POST['type'].'",
					working_days="'.$_POST['working_days'].'"
			');
			location($_SERVER['PHP_SELF'], '<p class=imp>Plan <u>'.$_POST['name'].'</u> has been added!</p>');
		}
		App::get()->smarty->display('../default/admin/plan_profile.tpl');
	break;
	case 'status':
		$plan = new Plan(intval($_REQUEST['id']));
		$plan->changeStatus();
		location($_SERVER['PHP_SELF'], '<p class=imp>Plan <u>'.$plan->name.'</u> status has been changed!</p>');
	break;
	case 'delete':
		sql_query('delete from plans where id="'.intval($_REQUEST['id']).'"');
	default:
		$plans = array();
		$result = sql_query('
			SELECT * FROM plans ORDER BY id
		');
		while ($row = mysql_fetch_assoc($result)) {
			$plans[] = $row;
		}
		App::get()->smarty->assign('plans', stripslashes_array($plans));
		App::get()->smarty->display('../default/admin/plans.tpl');
}