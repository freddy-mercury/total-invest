<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{get_setting name="project_title"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="description" content="Home page - free business website template available at TemplateMonster.com for free download."/>
<link href="{get_theme_dir}/styles/style.css" rel="stylesheet" type="text/css" />
<link href="{get_theme_dir}/styles/layout.css" rel="stylesheet" type="text/css" />
<script src="{get_theme_dir}/maxheight.js" type="text/javascript"></script>
<!--[if lt IE 7]>
	<link href="{get_theme_dir}/styles/ie_style.css" rel="stylesheet" type="text/css" />
<![endif]-->
	<!-- jQuery -->
	<link type="text/css" href="{get_theme_dir}/jquery/css/blitzer/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="{get_theme_dir}/jquery/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="{get_theme_dir}/jquery/js/jquery-ui-1.8.4.custom.min.js"></script>
	<!-- end jQuery -->
	<script src="/javascripts/custom.js" type="text/javascript"></script>
</head>

<body id="page1" onload="new ElementMaxHeight();$('input[type=checkbox]').css('width', 'auto');">
   <!-- header -->
   <div id="header">
      <div class="container">
         <div class="row-1">
            <div class="logo"><a href="/index.php"><img alt="" src="{get_theme_dir}/images/logo.jpg" /></a></div>
            <ul class="top-links">
               <li><a href="/index.php"><img alt="" src="{get_theme_dir}/images/top-icon1.jpg" /></a></li>
               <li><a href="/contactus.php"> <img alt="" src="{get_theme_dir}/images/top-icon3.jpg" /></a></li>
            </ul>
         </div>
         <div class="row-2">
         	<!-- nav box begin -->
            <div class="nav-box">
            	<div class="left">
               	<div class="right">
                  	<ul>
                     	<li><a href="/index.php" class="first-current"><em><b>HOME</b></em></a></li>
                        <li><a href="/signup.php"><em><b>SIGNUP</b></em></a></li>
                        <li><a href="{get_page_link id='3'}"><em><b>F.A.Q.</b></em></a></li>
                        <li><a href="{get_page_link id='4'}"><em><b>PARTNERS</b></em></a></li>
                        <li><a href="{get_page_link id='5'}"><em><b>Services</b></em></a></li>
                        <li><a href="/contactus.php" class="last"><em><b>CONTACT US</b></em></a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <!-- nav box end -->
         </div>
      </div>
   </div>
   <!-- content -->
   <div id="content">
      <div class="container page_content">
		{get_user_menu
			prefix=''
			suffix=''
			pre_tag='<div style="position:relative;"><span class="ui-corner-bl ui-corner-br button2" style="display: inline-block; width:700px; margin-left:125px;">'
			after_tag="</span></div>"
			separator=' :: '
		}
      	{$CONTENT}
      </div>
   </div>
   <!-- extra-content -->
   <div id="extra-content">
   	 <div class="container"></div>
   </div>
   <!-- footer -->
   <div id="footer">
   	<div class="container">
      	<ul class="nav">
         	<li><a href="/index.php">Home</a>|</li>
            <li><a href="{get_page_link id='2'}">About Us</a>|</li>
            <li><a href="{get_page_link id='3'}">F. A. Q.</a>|</li>
            <li><a href="{get_page_link id='4'}">Partners</a>|</li>
            <li><a href="{get_page_link id='5'}">Services</a>|</li>
            <li><a href="/contactus.php">Contact Us</a></li>
         </ul>
         <div class="wrapper">
         	<div class="fleft">Copyright &copy; 2011 Majeto.com </div>
            <div class="fright">All rights reserved.</div>
         </div>
      </div>
   </div>
</body>
</html>