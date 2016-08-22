function abreocierracabeza(objid)
{

    var is_regexp = (window.RegExp) ? true : false;
	
	if (!is_regexp)	return false;
	
	obj = fetch_object('collapseobj_' + objid);
	img = fetch_object('collapseimg_' + objid);
	
	if (!obj)
	{
		if (img)
			img.style.display = 'none';
		return false;
	}

	if (obj.style.display == 'none')
	{
		obj.style.display = '';
		save_collapsed(objid, false);
		if (img)
			img.src = 'recursos/colapsar.gif';
	}
	else
	{
		obj.style.display = 'none';
		save_collapsed(objid, true);
		if (img)
			img.src = 'recursos/colapsar_no.gif';
	}
	return false;
}

function abrecabeza(objid)
{

    var is_regexp = (window.RegExp) ? true : false;
	
	if (!is_regexp)	return false;

	obj = fetch_object('collapseobj_' + objid);
	img = fetch_object('collapseimg_' + objid);

	if (!obj)
	{
		if (img)
			img.style.display = 'none';
		return false;
	}
	else
	{
		obj.style.display = '';
		if (img)
   		  img.src = 'recursos/colapsar.gif';
	}
	
	return false;
}

function fetch_object(idname)
{
	if (document.getElementById)
		return document.getElementById(idname);
	else if (document.all)
		return document.all[idname];
	else if (document.layers)
		return document.layers[idname];
	else
		return null;
}

function save_collapsed(objid, addcollapsed)
{
	var collapsed = fetch_cookie('sistemaimagencolapsa');
	var tmp = new Array();

	if (collapsed != null)
	{
		collapsed = collapsed.split('\n');
		for (var i in collapsed)
		{
			if (collapsed[i] != objid && collapsed[i] != '')
			{
				tmp[tmp.length] = collapsed[i];
			}
		}
	}
	if (addcollapsed)
		tmp[tmp.length] = objid;
		
	expires = new Date();
	expires.setTime(expires.getTime() + (1000 * 86400 * 365));
	set_cookie('sistemaimagencolapsa', tmp.join('\n'), expires);

}

function fetch_cookie(name)
{
	cookie_name = name + '=';
	cookie_length = document.cookie.length;
	cookie_begin = 0;
	while (cookie_begin < cookie_length)
	{
		value_begin = cookie_begin + cookie_name.length;
		if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
		{
			var value_end = document.cookie.indexOf (';', value_begin);
			if (value_end == -1)
			{
				value_end = cookie_length;
			}
			var cookie_value = unescape(document.cookie.substring(value_begin, value_end));			
			return cookie_value;
		}
		cookie_begin = document.cookie.indexOf(' ', cookie_begin) + 1;
		if (cookie_begin == 0)
		{
			break;
		}
	}
	return null;
}

function set_cookie(name, value, expires)
{
	document.cookie = name + '=' + escape(value) + '; path=/' + (typeof expires != 'undefined' ? '; expires=' + expires.toGMTString() : '');
}