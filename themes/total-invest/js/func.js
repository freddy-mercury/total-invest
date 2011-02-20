//Открыть изображение в новом окне 
function openPic(sName,iW,iH)
{ if(sName=='') return;
  window.open(sName,
              '_blank',
              "width="+(iW+20)+
              ",height="+(iH+20)+
              ",toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,location=no");

}

//Открыть новое окно заданных размеров 
function openWin(url,l,t,w,h)
{
 newWin=null

 chkTimer=null

  if(newWin&&newWin.open&&!newWin.closed)
  {
    newWin.close()
  }

//  newWin=window.open(url,'win1', "left='+l+',top='+t+',width='+w+',height='+h+',toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,location=no")
  newWin=window.open(url,'win1','left='+l+',top='+t+',width='+w+',height='+h+'')

  clearTimeout(chkTimer)
  
//  return false

}

//Смена изображения при наведении мыши  
function changePic(img,ref)
{
  var browser_name = navigator.appName;
  var browser_version = parseFloat(navigator.appVersion);
  var browser_ok = false;

  if (browser_name == "Netscape" && browser_version >= 4.0)
    browser_ok = 'true';
  else if (browser_name == "Microsoft Internet Explorer" && browser_version >= 4.0)
    browser_ok = 'true';
  else if (browser_name == "Opera" && browser_version >= 9.0)
    browser_ok = 'true';

  if (browser_ok == 'true')
  {
    document.images[img].src = ref;
  }
}
