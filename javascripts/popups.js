function popupHint(keyword) {
	var url = '/includes/hints_page.php';
	var title = '';
	var popup = window.open(url+'?keyword='+keyword, title, "scrollbars=yes,width=400px,height=300px,left=200px,top=300px");
}
function popupAgency() {
	var url = '/includes/inlines/agency.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=400px,height=300px,left=200px,top=300px");
}
function popupAgent() {
	var url = '/includes/inlines/agent.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=400px,height=300px,left=200px,top=300px");
}
function setParentField(self, parent, callback) {
	window.opener.document.getElementById(parent).value=document.getElementById(self).value;
}
function setParentFieldOptionText(self, parent, callback) {
	var select = document.getElementById(self);
	window.opener.document.getElementById(parent).value=select.options[select.selectedIndex].text; 
}
function setAddress(parent) {
	var adr="";
	var region_code=document.getElementById('region').value;
	region_code=region_code.substring(0,2);
	adr+=",,"+region_code+",";
	var region = document.getElementById('area')==null ? "" : (document.getElementById('area').options[document.getElementById('area').selectedIndex].text!="Выбрать район" ? document.getElementById('area').options[document.getElementById('area').selectedIndex].text : "");
	var city = document.getElementById('city')==null ? "" : (document.getElementById('city').options[document.getElementById('city').selectedIndex].text!="Выбрать город" ? document.getElementById('city').options[document.getElementById('city').selectedIndex].text : "");
	var city_raion = document.getElementById('city_area')==null ? "" : document.getElementById('city_area').value;
	var town = document.getElementById('town')==null ? "" : (document.getElementById('town').options[document.getElementById('town').selectedIndex].text!="Выбрать нас. пункт" ? document.getElementById('town').options[document.getElementById('town').selectedIndex].text : "");
	var street = document.getElementById('street')==null ? "" : (document.getElementById('street').options[document.getElementById('street').selectedIndex].text!="Выбрать улицу" ? document.getElementById('street').options[document.getElementById('street').selectedIndex].text : "");
	adr+=region+","+city+","+town+","+city_raion+","+street+","+document.getElementById('house').value+","+document.getElementById('m_area').value;
	window.opener.document.getElementById(parent).value=adr;
	window.opener.document.getElementById('address_code').value=document.getElementById('code').value;
}
function popupObjectType() {
	var url = '/includes/inlines/object_type.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=400px,height=300px,left=200px,top=300px");
}
function popupBargainType() {
	var url = '/includes/inlines/bargain_type.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=400px,height=300px,left=200px,top=300px");
}
function popupAddress(address_code) {
	var url = '/includes/inlines/address.php?code='+address_code;
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=600,height=350,left=200,top=300");
}
function popupCityAreas() {
	var url = '/includes/inlines/city_areas.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=400,height=300,left=200,top=300");
}
function popupObject(tip) {
	var url = '/includes/inlines/object.php?tip='+tip.value;
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=600,height=300,left=200,top=300");
}
function popupAddPhoto() {
	var url = '/includes/inlines/add_photo.php';
	var title = '';
	var popup = window.open(url, title, "scrollbars=yes,width=600,height=300,left=200,top=300");
}