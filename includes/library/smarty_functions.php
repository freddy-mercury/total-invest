<?php

function get_menu($params) {
	$out = '';
	extract($params);
	$prefix = empty($prefix) ? '' : $prefix;
	$suffix = empty($suffix) ? '' : $suffix;
	$pre_tag = empty($pre_tag) ? '' : $pre_tag;
	$after_tag = empty($after_tag) ? '' : $after_tag;
	$out = '';
	include_once(LIB_ROOT.'/pages/page.class.php');
	$out.= $prefix.'<a href="/">'._('Home').'</a>'.$suffix;
	if (!AuthController::getInstance()->isAuthorized()) {
		$out.= $prefix.'<a href="/signup.php">'._('Sign Up').'</a>'.$suffix;
	}
	$out.= $prefix.'<a href="/user/account.php">'._('Member\'s area').'</a>'.$suffix;
	$result = sql_query('
		SELECT *
		FROM html_pages
	');
	while ($menu_page = mysql_fetch_assoc($result)) {
		$out.= $menu_page['id'] != get_setting('home_page_id') ? $prefix.'<a href="/index.php?page='.$menu_page['id'].'">'.$menu_page['name'].'</a>'.$suffix : '';
	}
	$out.= $prefix.'<a href="/contactus.php">'._('Contact Us').'</a>'.$suffix;
	return $pre_tag.$out.$after_tag;
}
Project::getInstance()->getSmarty()->register_function('get_menu', 'get_menu');

function get_user_menu($params) {
	$out = '';
	extract($params);
	$separator = empty($separator) ? '' : $separator;
	$prefix = empty($prefix) ? '' : $prefix;
	$suffix = empty($suffix) ? '' : $suffix;
	$pre_tag = empty($pre_tag) ? '' : $pre_tag;
	$after_tag = empty($after_tag) ? '' : $after_tag;
	if (AuthController::getInstance()->isAuthorized()) {
		if (Project::getInstance()->getCurUser()->access == ACCESS_LEVEL_ADMIN) {
			$out.= '' . $prefix . '<a href="/admin/users.php">Users</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/plans.php">Plans</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/statistics.php?ofc=chart-data.php">Statistics</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/pages.php">Edit pages</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/news.php">News</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/emails.php">E-mail templates</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/settings.php">Settings</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/find_deposit.php">Find deposit</a>' . $suffix . '' . $separator . '
					' . $prefix . '<a href="/admin/messages.php">Sent messages</a>' . $suffix . '<br>';
		}
		$user_messages_list = new UserMessageList(Project::getInstance()->getCurUser());
		$out.= '' . $prefix . '<a href="/user/account.php">' . _('Account Summary') . '</a>' . $suffix . '' . $separator . '
				' . $prefix . '<a href="/user/profile.php">' . _('Account Edit') . '</a>' . $suffix . '' . $separator . '
				' . /* $prefix.'<a href="/user/settings.php">'._('Settings').'</a>'.$suffix.''.$separator. */'
				' . $prefix . '<a href="/user/deposit.php">' . _('Make deposit') . '</a>' . $suffix . '' . $separator . '
				' . $prefix . '<a href="/user/withdraw.php">' . _('Withdraw') . '</a>' . $suffix . '' . $separator . '
				' . $prefix . '<a href="/user/statistics.php">' . _('History') . '</a>' . $suffix . '' . $separator . '
				' . $prefix . '<a href="/user/messages.php">' . _('Messages') . ' (' . $user_messages_list->getCountUnread() . ')</a>' . $suffix . '' . $separator . '
				' . $prefix . '<a href="/index.php?action=logout">' . _('Logout') . '</a>' . $suffix . '';
		$out = $pre_tag . $out . $after_tag;
	}
	return $out;
}

Project::getInstance()->getSmarty()->register_function('get_user_menu', 'get_user_menu');

function get_hint($params) {
	$out = '';
	extract($params);
	if (empty($keyword)) {
		return '';
	}
	$lang = !empty(Project::getInstance()->getCurUser()->lang) ? Project::getInstance()->getCurUser()->lang : 'en';
	$hint = sql_row('SELECT * FROM hints WHERE keyword="' . $keyword . '" AND lang="' . $lang . '"');
	if (!empty($hint)) {
		$out = htmlspecialchars($hint['value']);
	}
	if (Project::getInstance()->getCurUser()->access == ACCESS_LEVEL_ADMIN) {
		$out.= ' <span style="font-weight:normal;">(<a href="#" style="text-decoration:none;">?</a>)</span>';
	}
	return $out;
}

Project::getInstance()->getSmarty()->register_function('get_hint', 'get_hint');

function get_lang_switcher($params) {
	extract($params);
	$langs = explode(',', get_setting('langs'));
	$out = '<table cellpadding="5" cellspacing="1"><tr>';
	foreach ($langs as $lang) {
		$lang = trim($lang);
		$class = $_COOKIE['lang'] == $lang ? 'cur_lang' : 'lang';
		$out.= '<td class="' . $class . '"><a href="' . url($_SERVER['REQUEST_URI'], array('lang' => $lang)) . '">' . $lang . '</a></td>';
	}
	$out.= '</tr></table>';
	return '<div class="lang_switcher">' . $out . '</div>';
}

Project::getInstance()->getSmarty()->register_function('get_lang_switcher', 'get_lang_switcher');

function get_chat($params) {
	$OUT = '';
	$result = sql_query('select * from chat order by stamp desc limit 30');
	while ($post = mysql_fetch_assoc($result)) {
		$user = new User($post['user_id']);
		$user_name = $user->id ? $user->login : 'guest_' . substr($post['session'], 0, 4);
		$OUT.= '<div><b>(' . $user_name . ')[' . date('H:i', $post['stamp']) . ']:</b> ' . htmlspecialchars(stripslashes(iconv('utf-8', 'windows-1251', urldecode($post['message'])))) . '</div>';
	}
	return $OUT;
}

Project::getInstance()->getSmarty()->register_function('get_chat', 'get_chat');

function get_notifications() {
	return Project::getInstance()->getNotification();
}

Project::getInstance()->getSmarty()->register_function('get_notification', 'get_notifications');

function get_setting($params) {
	if (is_array($params)) {
		extract($params);
	} else {
		$name = $params;
	}
	foreach (Project::getInstance()->getSettings() as $setting) {
		if ($setting['name'] == $name) {
			return $setting['value'];
		}
	}
	if (Project::getInstance()->getCurUser()->isAdmin()) {
		$add_link = '<a href="/admin/settings.php?set='.$name.'#set" target="_blank" title="'.$name.'">(?)</a>';
	}
	return ''.$add_link;
}

Project::getInstance()->getSmarty()->register_function('get_setting', 'get_setting');

function get_page_link($params) {
	extract($params);
//	if (
//			Project::getInstance()->getCurUser()->isAdmin()
//			&& !sql_get('SELECT id FROM pages WHERE id="'.intval($id).'"')
//	) {
//		return '/admin/pages.php?action=edit&id='.intval($id).'" target="_blank';
//	}
	return '/index.php?page=' . $id;
}

Project::getInstance()->getSmarty()->register_function('get_page_link', 'get_page_link');

function get_news($params) {
	extract($params);
	$from = intval($from);
	$limit = intval($limit);
	$result = sql_query('SELECT * FROM news ORDER BY datetime DESC' . ($limit && ($from < $limit) ? ' LIMIT ' . $from . ',' . $limit : ''));
	$out = '<table width="100%">';
	while ($row = mysql_fetch_assoc($result)) {
		$row = stripslashes_array($row);
		$out.= '<tr><td class="date" width="50">' . date('m/d/Y', $row['datetime']) . '</td><td class="news">' . htmlspecialchars($row['title']) . '</td></tr>';
		$out.= $full ? '<tr><td colspan="2" style="padding-bottom:20px;">' . htmlspecialchars($row['text']) . '</td></tr>' : '';
	}
	$out.= '</table>';
	return $out;
}

Project::getInstance()->getSmarty()->register_function('get_news', 'get_news');

function get_pin_input_field($params) {
	extract($params);
	$direction = !$direction ? 1 : $direction;
	return pin_input_field($name, intval($length), $direction);
}

Project::getInstance()->getSmarty()->register_function('get_pin_input_field', 'get_pin_input_field');

function get_cur_user_login($params) {
	extract($params);
	return Project::getInstance()->getCurUser()->login;
}

Project::getInstance()->getSmarty()->register_function('get_cur_user_login', 'get_cur_user_login');

function smarty_gettext($params, $content, &$smarty, &$repeat) {
	return $content;
}

function get_theme_dir($params) {
	return '/themes/'.get_setting('theme');
}

Project::getInstance()->getSmarty()->register_function('get_theme_dir', 'get_theme_dir');

function get_active_page_class($params) {
	extract($params);
	$id = intval($id);
	if ($id && $id == intval($_REQUEST['page']))  {
		return $class;
	}
	elseif (empty($_SERVER['QUERY_STRING']) && strpos($_SERVER['REQUEST_URI'], $name_part) !== FALSE) {
		return $class;
	}
	return '';
}

Project::getInstance()->getSmarty()->register_function('get_active_page_class', 'get_active_page_class');