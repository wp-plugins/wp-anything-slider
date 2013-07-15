/**
 *     Wp anything slider
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function wpanything_setting_redirect()
{
	window.location = "options-general.php?page=wp-anything-slider&ac=showcycle";
}

function wpanything_help()
{
	window.open("http://www.gopiplus.com/work/2012/04/20/wordpress-plugin-wp-anything-slider/");
}

function wpanything_setting_submit()
{
	if(document.wpanything_setting_form.wpanything_sspeed.value=="" || isNaN(document.wpanything_setting_form.wpanything_sspeed.value))
	{
		alert("Please enter the slider speed, only number.")
		document.wpanything_setting_form.wpanything_sspeed.focus();
		return false;
	}
	else if(document.wpanything_setting_form.wpanything_stimeout.value=="" || isNaN(document.wpanything_setting_form.wpanything_stimeout.value))
	{
		alert("Please enter the slider timeout, only number.")
		document.wpanything_setting_form.wpanything_stimeout.focus();
		return false;
	}
	else if(document.wpanything_setting_form.wpanything_sdirection.value=="")
	{
		alert("Please select the slider direction")
		document.wpanything_setting_form.wpanything_sdirection.focus();
		return false;
	}
}

function wpanything_content_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_wpanything_display.action="options-general.php?page=wp-anything-slider&ac=del&did="+id;
		document.frm_wpanything_display.submit();
	}
}	

function wpanything_content_redirect()
{
	window.location = "options-general.php?page=wp-anything-slider";
}

function wpanything_content_submit()
{
	if(document.wpanything_content_form.content.value=="")
	{
		alert("Please enter the content.")
		document.wpanything_content_form.content.focus();
		return false;
	}
	else if(document.wpanything_content_form.wpanything_csetting.value=="")
	{
		alert("Please select the setting name.")
		document.wpanything_content_form.wpanything_csetting.focus();
		return false;
	}
}
