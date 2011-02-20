<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="keywords" content="money, investment, capital, group, bank, hyip, high, yield, program, monitor, Liberty, Perfect, profit, earn, earning, market, marketing, forex, referral, bonus, withdraw, deposit, invest, booking, bill, credit, debit" />
		<title>{get_setting name="project_title"}</title>
		<link href="/themes/{get_setting name="theme"}/styles/style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> 
		<script src="/javascripts/popups.js" type="text/javascript"></script>
		<script src="/javascripts/countdown.js" type="text/javascript"></script>
		<script src="/javascripts/cssmenu.js" type="text/javascript"></script>
		<script src="/javascripts/custom.js" type="text/javascript"></script>
		<!-- jQuery -->
		<link type="text/css" href="/themes/{get_setting name="theme"}/jquery/css/cupertino/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="/themes/{get_setting name="theme"}/jquery/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="/themes/{get_setting name="theme"}/jquery/js/jquery-ui-1.7.2.custom.min.js"></script>
		<!-- end jQuery -->
		
</head>
<body bgcolor="#fff4f3">
<table border="0" width="1035" height="100%" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid black;">
	<tr valign="top">
		<td colspan="2" background="/themes/{get_setting name='theme'}/images/logo.jpg" height="262">
				{get_lang_switcher}
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="#B0DEF6" style="border-top:1px solid black;border-bottom:1px solid black;">
			<div class="menu">
				{get_menu pre_tag="<ul>" after_tag="</ul>" prefix="<li>" suffix="</li>"}
			</div>
		</td>
	</tr>
	{* User menu *}
	{php}
	if (AuthController::getInstance()->isAuthorized()) {
	{/php}
	<tr>
		<td colspan="2" align="center" height="25" class="menu2">
		{get_user_menu pre_tag="<ul>" after_tag="</ul>" prefix="<li>" suffix="</li>"}
		</td>
	</tr>
	{php}
	}
	{/php}
	
	<tr valign="top">
