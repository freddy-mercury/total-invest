<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{get_setting name="project_title"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="description" content=""/>
<link href="{get_theme_dir}/style.css" rel="stylesheet" type="text/css" />
	<!-- jQuery -->
	<link type="text/css" href="{get_theme_dir}/jquery/css/blitzer/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="{get_theme_dir}/jquery/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="{get_theme_dir}/jquery/js/jquery-ui-1.8.4.custom.min.js"></script>
	<!-- end jQuery -->
	<script src="/javascripts/custom.js" type="text/javascript"></script>
</head>

<body>
	<table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
		<tr>
			<td background="{get_theme_dir}/images/logo.jpg" height="181">
			</td>
		</tr>
		<tr>
			<td>
				{get_menu pre_tag='<div id="menu">' after_tag="</div>"}
			</td>
		</tr>
		{get_user_menu pre_tag='<tr><td><div id="user_menu">' after_tag="</div></td></tr>"}
		<tr>
			<td>
				<div id="content">
					{$CONTENT}
				</div>
			</td>
		</tr>
		<tr>
			<td>
				{get_menu pre_tag='<div id="footer_menu">' after_tag="</div>"}
			</td>
		</tr>
		<tr>
			<td>
				<div id="footer">
					{get_setting name="page_footer"}
				</div>
			</td>
		</tr>
	</table>
</body>
</html>


