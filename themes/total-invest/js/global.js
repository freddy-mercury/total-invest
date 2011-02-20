///////////////////////////////////////////////////////////
// request to do something
function request(message, url)
{
  if(confirm(message)) location.href = url;
}

///////////////////////////////////////////////////////////
// open & close contents
function contents_open(id)
{
 document.getElementById(id+'_opened').style.display = 'none';
 document.getElementById(id+'_closed').style.display = '';
}
function contents_close(id)
{
 document.getElementById(id+'_opened').style.display = '';
 document.getElementById(id+'_closed').style.display = 'none';
}
///////////////////////////////////////////////////////////
// open & close tips
function tips_open(id)
{
	var el = document.getElementById('tips');
	if(id != '' && el.style.display == 'none') el.innerHTML = id;
	var x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft - el.offsetWidth + 5;
	var y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop+20;
	el.style.left = x + 'px';
	el.style.top = y + 'px';
	if(el.style.display == 'none') el.style.display = '';
}
function tips_close()
{
	document.getElementById('tips').style.display = 'none';
}


///////////////////////////////////////////////////////////
// open w2 window
function w2(url, name, width, height, scroll)
{
  var w2 = window.open(url, name, 'marginheight=0,marginweight=0,toolbar=no,width='+width+',height='+height+',left=20,top=20,resizable=no,scrollbars='+scroll);
  w2.focus();
}

///////////////////////////////////////////////////////////
// change image
function ci(id, iif, cond)
{
  if(cond==1) id.src = id.src.substr(0, id.src.length-7)+'-up.gif';
  else
  {
    if(iif==1) id.src = id.src.substr(0, id.src.length-4)+'-up.gif';
    else id.src = id.src.substr(0, id.src.length-7)+'.gif';
  }
  return true;
}

///////////////////////////////////////////////////////////
// preload images
function preload(i)
{ 
	var img = new Image(); 
	img.src = '/images/en/'+i;
  
  return img; 
}

preload('menu/begin/company.gif');
preload('menu/begin/company-up.gif');
preload('menu/begin/contacts.gif');
preload('menu/begin/contacts-up.gif');
preload('menu/begin/portfolio.gif');
preload('menu/begin/portfolio-up.gif');
preload('menu/begin/services.gif');
preload('menu/begin/services-up.gif');
preload('menu/begin/testim.gif');
preload('menu/begin/testim-up.gif');

preload('menu/end/home.gif');
preload('menu/end/home-up.gif');
preload('menu/end/mail.gif');
preload('menu/end/mail-up.gif');
preload('menu/end/sitemap.gif');
preload('menu/end/sitemap-up.gif');

preload('users/customers/login.gif');
preload('users/customers/login-up.gif');
preload('users/customers/marea.gif');
preload('users/customers/marea-up.gif');

preload('users/affiliates/login.gif');
preload('users/affiliates/login-up.gif');
preload('users/affiliates/marea.gif');
preload('users/affiliates/marea-up.gif');