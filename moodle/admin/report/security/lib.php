<?php  //$Id: lib.php,v 1.3.2.7 2009/02/02 13:15:43 skodak Exp $

///////////////////////////////////////////////////////////////////////////
//																	   //
// NOTICE OF COPYRIGHT												   //
//																	   //
// Moodle - Modular Object-Oriented Dynamic Learning Environment		 //
//		  http://moodle.org											//
//																	   //
// Copyright (C) 1999 onwards Martin Dougiamas  http://dougiamas.com	 //
//																	   //
// This program is free software; you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation; either version 2 of the License, or	 //
// (at your option) any later version.								   //
//																	   //
// This program is distributed in the hope that it will be useful,	   //
// but WITHOUT ANY WARRANTY; without even the implied warranty of		//
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the		 //
// GNU General Public License for more details:						  //
//																	   //
//		  http://www.gnu.org/copyleft/gpl.html						 //
//																	   //
///////////////////////////////////////////////////////////////////////////

require_once("$CFG->libdir/adminlib.php");


define('REPORT_SECURITY_OK', 'ok');
define('REPORT_SECURITY_INFO', 'info');
define('REPORT_SECURITY_WARNING', 'warning');
define('REPORT_SECURITY_SERIOUS', 'serious');
define('REPORT_SECURITY_CRITICAL', 'critical');

function report_security_hide_timearning() {
	 echo '<script type="text/javascript">
//<![CDATA[
	var el = document.getElementById("timewarning");
	el.setAttribute("class", "timewarninghidden");
//]]>
</script>';

}

function report_security_get_issue_list() {
	return array(
		'report_security_check_globals',
		'report_security_check_unsecuredataroot',
		'report_security_check_displayerrors',
		'report_security_check_noauth',
		'report_security_check_embed',
		'report_security_check_mediafilterswf',
		'report_security_check_openprofiles',
		'report_security_check_google',
		'report_security_check_passwordpolicy',
		'report_security_check_emailchangeconfirmation',
		'report_security_check_cookiesecure',
		'report_security_check_configrw',
		'report_security_check_riskxss',
		'report_security_check_riskadmin',
		'report_security_check_defaultuserrole',
		'report_security_check_guestrole',
		'report_security_check_frontpagerole',
		'report_security_check_defaultcourserole',
		'report_security_check_courserole',

	);
}

///=============================================
///			   Issue checks
///=============================================


/**
 * Verifies register globals PHP setting.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_globals($detailed=false) {
	$result = new object();
	$result->issue   = 'report_security_check_globals';
	$result->name	= get_string('check_globals_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	if (ini_get_bool('register_globals')) {
		$result->status = REPORT_SECURITY_CRITICAL;
		$result->info   = get_string('check_globals_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_globals_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_globals_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies unsupported noauth setting
 * @param bool $detailed
 * @return object result
 */
function report_security_check_noauth($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_noauth';
	$result->name	= get_string('check_noauth_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=manageauths\">".get_string('authsettings', 'admin').'</a>';

	if (is_enabled_auth('none')) {
		$result->status = REPORT_SECURITY_CRITICAL;
		$result->info   = get_string('check_noauth_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_noauth_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_noauth_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies if password policy set
 * @param bool $detailed
 * @return object result
 */
function report_security_check_passwordpolicy($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_passwordpolicy';
	$result->name	= get_string('check_passwordpolicy_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=sitepolicies\">".get_string('sitepolicies', 'admin').'</a>';

	if (empty($CFG->passwordpolicy)) {
		$result->status = REPORT_SECURITY_WARNING;
		$result->info   = get_string('check_passwordpolicy_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_passwordpolicy_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_passwordpolicy_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies sloppy embedding - this should have been removed long ago!!
 * @param bool $detailed
 * @return object result
 */
function report_security_check_embed($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_embed';
	$result->name	= get_string('check_embed_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=sitepolicies\">".get_string('sitepolicies', 'admin').'</a>';

	if (!empty($CFG->allowobjectembed)) {
		$result->status = REPORT_SECURITY_CRITICAL;
		$result->info   = get_string('check_embed_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_embed_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_embed_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies sloppy swf embedding - this should have been removed long ago!!
 * @param bool $detailed
 * @return object result
 */
function report_security_check_mediafilterswf($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_mediafilterswf';
	$result->name	= get_string('check_mediafilterswf_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=filtersettingfiltermediaplugin\">".get_string('filtersettings', 'admin').'</a>';

	if (!empty($CFG->textfilters)) {
		$activefilters = explode(',', $CFG->textfilters);
	} else {
		$activefilters = array();
	}

	if (array_search('filter/mediaplugin', $activefilters) !== false and !empty($CFG->filter_mediaplugin_enable_swf)) {
		$result->status = REPORT_SECURITY_CRITICAL;
		$result->info   = get_string('check_mediafilterswf_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_mediafilterswf_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_mediafilterswf_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies fatal misconfiguration of dataroot
 * @param bool $detailed
 * @return object result
 */
function report_security_check_unsecuredataroot($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_unsecuredataroot';
	$result->name	= get_string('check_unsecuredataroot_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	$insecuredataroot = is_dataroot_insecure(true);

	if ($insecuredataroot == INSECURE_DATAROOT_WARNING) {
		$result->status = REPORT_SECURITY_SERIOUS;
		$result->info   = get_string('check_unsecuredataroot_warning', 'report_security', $CFG->dataroot);

	} else if ($insecuredataroot == INSECURE_DATAROOT_ERROR) {
		$result->status = REPORT_SECURITY_CRITICAL;
		$result->info   = get_string('check_unsecuredataroot_error', 'report_security', $CFG->dataroot);

	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_unsecuredataroot_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_unsecuredataroot_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies disaplying of errors - problem for lib files and 3rd party code
 * because we can not disable debugging in these scripts (they do not include config.php)
 * @param bool $detailed
 * @return object result
 */
function report_security_check_displayerrors($detailed=false) {
	$result = new object();
	$result->issue   = 'report_security_check_displayerrors';
	$result->name	= get_string('check_displayerrors_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	if (defined('WARN_DISPLAY_ERRORS_ENABLED')) {
		$result->status = REPORT_SECURITY_WARNING;
		$result->info   = get_string('check_displayerrors_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_displayerrors_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_displayerrors_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies open profiles - originaly open by default, not anymore because spammer abused it a lot
 * @param bool $detailed
 * @return object result
 */
function report_security_check_openprofiles($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_openprofiles';
	$result->name	= get_string('check_openprofiles_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=sitepolicies\">".get_string('sitepolicies', 'admin').'</a>';

	if (empty($CFG->forcelogin) and empty($CFG->forceloginforprofiles)) {
		$result->status = REPORT_SECURITY_WARNING;
		$result->info   = get_string('check_openprofiles_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_openprofiles_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_openprofiles_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies google access not combined with disabled guest access
 * because attackers might gain guest access by modifying browser signature.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_google($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_google';
	$result->name	= get_string('check_google_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=sitepolicies\">".get_string('sitepolicies', 'admin').'</a>';

	if (empty($CFG->opentogoogle)) {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_google_ok', 'report_security');
	} else if (!empty($CFG->guestloginbutton)) {
		$result->status = REPORT_SECURITY_INFO;
		$result->info   = get_string('check_google_info', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_SERIOUS;
		$result->info   = get_string('check_google_error', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_google_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies email confirmation - spammers were changing mails very often
 * @param bool $detailed
 * @return object result
 */
function report_security_check_emailchangeconfirmation($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_emailchangeconfirmation';
	$result->name	= get_string('check_emailchangeconfirmation_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=sitepolicies\">".get_string('sitepolicies', 'admin').'</a>';

	if (empty($CFG->emailchangeconfirmation)) {
		$result->status = REPORT_SECURITY_WARNING;
		$result->info   = get_string('check_emailchangeconfirmation_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_emailchangeconfirmation_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_emailchangeconfirmation_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies if https enabled only secure cookies allowed,
 * this prevents redirections and sending of cookies to unsecure port.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_cookiesecure($detailed=false) {
	global $CFG;

	if (strpos($CFG->wwwroot, 'https://') !== 0) {
		return null;
	}

	$result = new object();
	$result->issue   = 'report_security_check_cookiesecure';
	$result->name	= get_string('check_cookiesecure_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=httpsecurity\">".get_string('httpsecurity', 'admin').'</a>';

	if (empty($CFG->cookiesecure)) {
		$result->status = REPORT_SECURITY_SERIOUS;
		$result->info   = get_string('check_cookiesecure_error', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_cookiesecure_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_cookiesecure_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies config.php is not writable anymore after installation,
 * config files were changed on several outdated server.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_configrw($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_configrw';
	$result->name	= get_string('check_configrw_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	if (is_writable($CFG->dirroot.'/config.php')) {
		$result->status = REPORT_SECURITY_WARNING;
		$result->info   = get_string('check_configrw_warning', 'report_security');
	} else {
		$result->status = REPORT_SECURITY_OK;
		$result->info   = get_string('check_configrw_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_configrw_details', 'report_security');
	}

	return $result;
}

/**
 * Lists all users with XSS risk, it would be great to combine this with risk trusts in user table,
 * unfortunately nobody implemented user trust UI yet :-(
 * @param bool $detailed
 * @return object result
 */
function report_security_check_riskxss($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_riskxss';
	$result->name	= get_string('check_riskxss_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = REPORT_SECURITY_WARNING;
	$result->link	= null;

	$sqlfrom = "FROM (SELECT rcx.*
						FROM {$CFG->prefix}role_capabilities rcx
						JOIN {$CFG->prefix}capabilities cap ON (cap.name = rcx.capability AND ".sql_bitand('cap.riskbitmask', RISK_XSS)." <> 0)
					   WHERE rcx.permission = ".CAP_ALLOW.") rc,
					 {$CFG->prefix}context c,
					 {$CFG->prefix}context sc,
					 {$CFG->prefix}role_assignments ra,
					 {$CFG->prefix}user u
			   WHERE c.id = rc.contextid
					 AND (sc.path = c.path OR sc.path LIKE ".sql_concat('c.path', "'/%'")." OR c.path LIKE ".sql_concat('sc.path', "'/%'").")
					 AND u.id = ra.userid AND u.deleted = 0
					 AND ra.contextid = sc.id AND ra.roleid = rc.roleid";

	$count = count_records_sql("SELECT COUNT(DISTINCT u.id) $sqlfrom");

	$result->info = get_string('check_riskxss_warning', 'report_security', $count);

	if ($detailed) {
		$users = get_records_sql("SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt $sqlfrom");
		foreach ($users as $uid=>$user) {
			$users[$uid] = fullname($user);
		}
		$users = implode(', ', $users);
		$result->details = get_string('check_riskxss_details', 'report_security', $users);
	}

	return $result;
}

/**
 * Verifies sanity of default user role.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_defaultuserrole($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_defaultuserrole';
	$result->name	= get_string('check_defaultuserrole_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=userpolicies\">".get_string('userpolicies', 'admin').'</a>';;

	if (!$default_role = get_record('role', 'id', $CFG->defaultuserroleid)) {
		$result->status  = REPORT_SECURITY_WARNING;
		$result->info	= get_string('check_defaultuserrole_notset', 'report_security');
		$result->details = $result->info;

		return $result;
	}

	// first test if do anything enabled - that would be really crazy!
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $default_role->id";

	$anythingcount = count_records_sql($sql);

	// risky caps - usually very dangerous
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}capabilities cap ON cap.name = rc.capability
			 WHERE ".sql_bitand('cap.riskbitmask', (RISK_XSS | RISK_CONFIG | RISK_DATALOSS))." <> 0
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $default_role->id";

	$riskycount = count_records_sql($sql);

	// default role can not have view cap in all courses - this would break moodle badly
	$viewcap = record_exists('role_capabilities', 'roleid', $default_role->id, 'permission', CAP_ALLOW, 'capability', 'moodle/course:view');

	// it may have either no or 'user' legacy type - nothing else, or else it would break during upgrades badly
	$legacyok = false;
	$sql = "SELECT rc.capability, 1
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability LIKE 'moodle/legacy:%'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $default_role->id";
	$legacycaps = get_records_sql($sql);
	if (!$legacycaps) {
		$legacyok = true;
	} else if (count($legacycaps) == 1 and isset($legacycaps['moodle/legacy:user'])) {
		$legacyok = true;
	}

	if ($anythingcount or $riskycount or $viewcap or !$legacyok) {
		$result->status  = REPORT_SECURITY_CRITICAL;
		$result->info	= get_string('check_defaultuserrole_error', 'report_security', format_string($default_role->name));

	} else {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_defaultuserrole_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_defaultuserrole_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies sanity of guest role
 * @param bool $detailed
 * @return object result
 */
function report_security_check_guestrole($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_guestrole';
	$result->name	= get_string('check_guestrole_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=userpolicies\">".get_string('userpolicies', 'admin').'</a>';;

	if (!$guest_role = get_record('role', 'id', $CFG->guestroleid)) {
		$result->status  = REPORT_SECURITY_WARNING;
		$result->info	= get_string('check_guestrole_notset', 'report_security');
		$result->details = $result->info;

		return $result;
	}

	// first test if do anything enabled - that would be really crazy!
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $guest_role->id";

	$anythingcount = count_records_sql($sql);

	// risky caps - usually very dangerous
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}capabilities cap ON cap.name = rc.capability
			 WHERE ".sql_bitand('cap.riskbitmask', (RISK_XSS | RISK_CONFIG | RISK_DATALOSS))." <> 0
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $guest_role->id";

	$riskycount = count_records_sql($sql);

	// it may have either no or 'guest' legacy type - nothing else, or else it would break during upgrades badly
	$legacyok = false;
	$sql = "SELECT rc.capability, 1
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability LIKE 'moodle/legacy:%'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $guest_role->id";
	$legacycaps = get_records_sql($sql);
	if (!$legacycaps) {
		$legacyok = true;
	} else if (count($legacycaps) == 1 and isset($legacycaps['moodle/legacy:guest'])) {
		$legacyok = true;
	}

	if ($anythingcount or $riskycount or !$legacyok) {
		$result->status  = REPORT_SECURITY_CRITICAL;
		$result->info	= get_string('check_guestrole_error', 'report_security', format_string($guest_role->name));

	} else {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_guestrole_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_guestrole_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies sanity of frontpage role
 * @param bool $detailed
 * @return object result
 */
function report_security_check_frontpagerole($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_frontpagerole';
	$result->name	= get_string('check_frontpagerole_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=frontpagesettings\">".get_string('frontpagesettings','admin').'</a>';;

	if (!$frontpage_role = get_record('role', 'id', $CFG->defaultfrontpageroleid)) {
		$result->status  = REPORT_SECURITY_INFO;
		$result->info	= get_string('check_frontpagerole_notset', 'report_security');
		$result->details = get_string('check_frontpagerole_details', 'report_security');

		return $result;
	}

	// first test if do anything enabled - that would be really crazy!
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $frontpage_role->id";

	$anythingcount = count_records_sql($sql);

	// risky caps - usually very dangerous
	$sql = "SELECT COUNT(DISTINCT rc.contextid)
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}capabilities cap ON cap.name = rc.capability
			 WHERE ".sql_bitand('cap.riskbitmask', (RISK_XSS | RISK_CONFIG | RISK_DATALOSS))." <> 0
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $frontpage_role->id";

	$riskycount = count_records_sql($sql);

	// there is no legacy role type for frontpage yet - anyway we can not allow teachers or admins there!
	$sql = "SELECT rc.capability, 1
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability LIKE 'moodle/legacy:%'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $frontpage_role->id";
	$legacycaps = get_records_sql($sql);
	$legacyok = (!isset($legacycaps['moodle/legacy:teacher'])
				 and !isset($legacycaps['moodle/legacy:editingteacher'])
				 and !isset($legacycaps['moodle/legacy:coursecreator'])
				 and !isset($legacycaps['moodle/legacy:admin']));

	if ($anythingcount or $riskycount or !$legacyok) {
		$result->status  = REPORT_SECURITY_CRITICAL;
		$result->info	= get_string('check_frontpagerole_error', 'report_security', format_string($frontpage_role->name));

	} else {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_frontpagerole_ok', 'report_security');
	}

	if ($detailed) {
		$result->details = get_string('check_frontpagerole_details', 'report_security');
	}

	return $result;
}

/**
 * Verifies sanity of site default course role.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_defaultcourserole($detailed=false) {
	global $CFG;

	$problems = array();

	$result = new object();
	$result->issue   = 'report_security_check_defaultcourserole';
	$result->name	= get_string('check_defaultcourserole_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= "<a href=\"$CFG->wwwroot/$CFG->admin/settings.php?section=userpolicies\">".get_string('userpolicies', 'admin').'</a>';;

	if ($detailed) {
		$result->details = get_string('check_defaultcourserole_details', 'report_security');
	}

	if (!$student_role = get_record('role', 'id', $CFG->defaultcourseroleid)) {
		$result->status  = REPORT_SECURITY_WARNING;
		$result->info	= get_string('check_defaultcourserole_notset', 'report_security');
		$result->details = get_string('check_defaultcourserole_details', 'report_security');

		return $result;
	}

	// first test if do anything enabled - that would be really crazy!
	$sql = "SELECT DISTINCT rc.contextid
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $student_role->id";

	if ($anything_contexts = get_records_sql($sql)) {
		foreach($anything_contexts as $contextid) {
			if ($contextid == SYSCONTEXTID) {
				$a = "$CFG->wwwroot/$CFG->admin/roles/manage.php?action=view&roleid=$CFG->defaultcourseroleid";
			} else {
				$a = "$CFG->wwwroot/$CFG->admin/roles/override.php?contextid=$contextid&roleid=$CFG->defaultcourseroleid";
			}
			$problems[] = get_string('check_defaultcourserole_anything', 'report_security', $a);
		}
	}

	// risky caps - usually very dangerous
	$sql = "SELECT DISTINCT rc.contextid
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}capabilities cap ON cap.name = rc.capability
			 WHERE ".sql_bitand('cap.riskbitmask', (RISK_XSS | RISK_CONFIG | RISK_DATALOSS))." <> 0
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $student_role->id";

	if ($riskycontexts = get_records_sql($sql)) {
		foreach($riskycontexts as $contextid=>$unused) {
			if ($contextid == SYSCONTEXTID) {
				$a = "$CFG->wwwroot/$CFG->admin/roles/manage.php?action=view&roleid=$CFG->defaultcourseroleid";
			} else {
				$a = "$CFG->wwwroot/$CFG->admin/roles/override.php?contextid=$contextid&roleid=$CFG->defaultcourseroleid";
			}
			$problems[] = get_string('check_defaultcourserole_risky', 'report_security', $a);
		}
	}

	// course creator or administrator does not make any sense here
	$sql = "SELECT rc.capability, 1
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability LIKE 'moodle/legacy:%'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid = $student_role->id";
	$legacycaps = get_records_sql($sql);
	if (isset($legacycaps['moodle/legacy:coursecreator']) or isset($legacycaps['moodle/legacy:admin'])) {
		$problems[] = get_string('check_defaultcourserole_legacy', 'report_security');
	}

	if ($problems) {
		$result->status  = REPORT_SECURITY_CRITICAL;
		$result->info	= get_string('check_defaultcourserole_error', 'report_security', format_string($student_role->name));
		if ($detailed) {
			$result->details .= "<ul>";
			foreach ($problems as $problem) {
				$result->details .= "<li>$problem</li>";
			}
			$result->details .= "</ul>";
		}

	} else {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_defaultcourserole_ok', 'report_security');
	}

	return $result;
}

/**
 * Verifies sanity of default roles in courses.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_courserole($detailed=false) {
	global $CFG, $SITE;

	$problems = array();

	$result = new object();
	$result->issue   = 'report_security_check_courserole';
	$result->name	= get_string('check_courserole_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	if ($detailed) {
		$result->details = get_string('check_courserole_details', 'report_security');
	}

	// get list of all student roles selected in courses excluding the default course role
	$sql = "SELECT r.*
			  FROM {$CFG->prefix}role r
			  JOIN {$CFG->prefix}course c ON c.defaultrole = r.id
			 WHERE c.id <> $SITE->id AND r.id <> $CFG->defaultcourseroleid";

	if (!$student_roles = get_records_sql($sql)) {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_courserole_notyet', 'report_security');
		$result->details = get_string('check_courserole_details', 'report_security');

		return $result;
	}

	$roleids = array_keys($student_roles);

	// first test if do anything enabled - that would be really crazy!!!!!!
	$inroles = implode(',', $roleids);
	$sql = "SELECT rc.roleid, rc.contextid
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid IN ($inroles)
		  GROUP BY rc.roleid, rc.contextid
		  ORDER BY rc.roleid, rc.contextid";

	$rs = get_recordset_sql($sql);
	while ($res = rs_fetch_next_record($rs)) {
		$roleid	= $res->roleid;
		$contextid = $res->contextid;
		if ($contextid == SYSCONTEXTID) {
			$a = "$CFG->wwwroot/$CFG->admin/roles/manage.php?action=view&roleid=$roleid";
		} else {
			$a = "$CFG->wwwroot/$CFG->admin/roles/override.php?contextid=$contextid&roleid=$roleid";
		}
		$problems[] = get_string('check_courserole_anything', 'report_security', $a);
	}
	$rs->close();

	// risky caps in any level - usually very dangerous!!
	$inroles = implode(',', $roleids);
	$sql = "SELECT rc.roleid, rc.contextid
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}capabilities cap ON cap.name = rc.capability
			 WHERE ".sql_bitand('cap.riskbitmask', (RISK_XSS | RISK_CONFIG | RISK_DATALOSS))." <> 0
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid IN ($inroles)
		  GROUP BY rc.roleid, rc.contextid
		  ORDER BY rc.roleid, rc.contextid";
	$rs = get_recordset_sql($sql);
	while ($res = rs_fetch_next_record($rs)) {
		$roleid	= $res->roleid;
		$contextid = $res->contextid;
		if ($contextid == SYSCONTEXTID) {
			$a = "$CFG->wwwroot/$CFG->admin/roles/manage.php?action=view&roleid=$roleid";
		} else {
			$a = "$CFG->wwwroot/$CFG->admin/roles/override.php?contextid=$contextid&roleid=$roleid";
		}
		$problems[] = get_string('check_courserole_risky', 'report_security', $a);
	}
	$rs->close();

	// course creator or administrator does not make any sense here!
	$inroles = implode(',', $roleids);
	$sql = "SELECT DISTINCT rc.roleid
			  FROM {$CFG->prefix}role_capabilities rc
			 WHERE (rc.capability = 'moodle/legacy:coursecreator' OR rc.capability = 'moodle/legacy:admin')
				   AND rc.permission = ".CAP_ALLOW."
				   AND rc.roleid IN ($inroles)";
	if ($legacys = get_records_sql($sql)) {
		foreach ($legacys as $roleid=>$unused) {
			$a = "$CFG->wwwroot/$CFG->admin/roles/manage.php?action=view&roleid=$roleid";
			$problems[] = get_string('check_defaultcourserole_legacy', 'report_security', $a);
		}
	}


	if ($problems) {
		$result->status  = REPORT_SECURITY_CRITICAL;
		$result->info	= get_string('check_courserole_error', 'report_security');
		if ($detailed) {
			$result->details .= "<ul>";
			foreach ($problems as $problem) {
				$result->details .= "<li>$problem</li>";
			}
			$result->details .= "</ul>";
		}

	} else {
		$result->status  = REPORT_SECURITY_OK;
		$result->info	= get_string('check_courserole_ok', 'report_security');
	}

	return $result;
}

/**
 * Lists all admins.
 * @param bool $detailed
 * @return object result
 */
function report_security_check_riskadmin($detailed=false) {
	global $CFG;

	$result = new object();
	$result->issue   = 'report_security_check_riskadmin';
	$result->name	= get_string('check_riskadmin_name', 'report_security');
	$result->info	= null;
	$result->details = null;
	$result->status  = null;
	$result->link	= null;

	$sql = "SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt
			  FROM {$CFG->prefix}role_capabilities rc
			  JOIN {$CFG->prefix}role_assignments ra ON (ra.contextid = rc.contextid AND ra.roleid = rc.roleid)
			  JOIN {$CFG->prefix}user u ON u.id = ra.userid
			 WHERE rc.capability = 'moodle/site:doanything'
				   AND rc.permission = ".CAP_ALLOW."
				   AND u.deleted = 0
				   AND rc.contextid = ".SYSCONTEXTID."";

	$admins = get_records_sql($sql);

	$sqlfrom = "FROM (SELECT rcx.*
						FROM {$CFG->prefix}role_capabilities rcx
					   WHERE rcx.capability = 'moodle/site:doanything' AND rcx.permission = ".CAP_ALLOW.") rc,
					 {$CFG->prefix}context c,
					 {$CFG->prefix}context sc,
					 {$CFG->prefix}role_assignments ra,
					 {$CFG->prefix}user u
			   WHERE c.id = rc.contextid
					 AND (sc.path = c.path OR sc.path LIKE ".sql_concat('c.path', "'/%'")." OR c.path LIKE ".sql_concat('sc.path', "'/%'").")
					 AND u.id = ra.userid AND u.deleted = 0
					 AND ra.contextid = sc.id AND ra.roleid = rc.roleid AND ra.contextid <> ".SYSCONTEXTID."";

	$count = count_records_sql("SELECT COUNT(DISTINCT u.id) $sqlfrom");

	if (!$count) {
		$result->status  = REPORT_SECURITY_OK;
		$result->info = get_string('check_riskadmin_ok', 'report_security', count($admins));

		if ($detailed) {
			foreach ($admins as $uid=>$user) {
				$admins[$uid] = fullname($user);
			}
			$admins = implode(', ', $admins);
			$result->details = get_string('check_riskadmin_detailsok', 'report_security', $admins);
		}

	} else {
		$result->status  = REPORT_SECURITY_WARNING;
		$a = (object)array('admincount'=>count($admins), 'unsupcount'=>$count);
		$result->info = get_string('check_riskadmin_warning', 'report_security', $a);

		if ($detailed) {
			foreach ($admins as $uid=>$user) {
				$admins[$uid] = fullname($user);
			}
			$admins = implode(', ', $admins);
			$users = get_records_sql("SELECT DISTINCT u.id, u.firstname, u.lastname, u.picture, u.imagealt $sqlfrom");
			foreach ($users as $uid=>$user) {
				$users[$uid] = fullname($user);
			}
			$users = implode(', ', $users);
			$a = (object)array('admins'=>$admins, 'unsupported'=>$users);
			$result->details = get_string('check_riskadmin_detailswarning', 'report_security', $a);
		}
	}

	return $result;
}
