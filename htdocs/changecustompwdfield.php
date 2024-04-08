<?php
#==============================================================================
# LTB Self Service Password
#
# Copyright (C) 2009 Clement OUDOT
# Copyright (C) 2009 LTB-project.org
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# GPL License: http://www.gnu.org/licenses/gpl.txt
#
#==============================================================================

# require_once("../lib/LtbAttributeValue_class.php");

#==============================================================================
# POST parameters
#==============================================================================
# Initiate vars
$result = "";
$login = $presetLogin;
$confirmcustompwd = "";
$newcustompwd = "";
$password = "";
$ldap = "";
$userdn = "";
if (!isset($pwd_forbidden_chars)) { $pwd_forbidden_chars=""; }
$mail = "";
$extended_error_msg = "";

$post = filter_input_array(INPUT_POST);

if(isset($INPUT_REQUEST)) { $request = filter_input_array(INPUT_REQUEST); }
if (isset($post["confirmpassword"]) and $post["confirmpassword"]) { $confirmcustompwd = strval($post["confirmpassword"]); }
else { $result = "confirmpasswordrequired"; }
if (isset($post["newpassword"]) and $post["newpassword"]) { $newcustompwd = strval($post["newpassword"]); }
else { $result = "newpasswordrequired"; }
if (isset($post["oldpassword"]) and $post["oldpassword"]) { $password = strval($post["oldpassword"]); }
else { $result = "passwordrequired"; }
if (isset($_REQUEST["login"]) and $_REQUEST["login"]) { $login = strval($_REQUEST["login"]); }
else { $result = "loginrequired"; }
if (! isset($_REQUEST["login"]) and ! isset($post["confirmpassword"]) and ! isset($post["newpassword"]) and ! isset($post["oldpassword"])) {
    $result = "emptychangeform";
}


$custompwdindex = 0;
if (isset($default_custompwdindex)) { $custompwdindex = $default_custompwdindex; }
if (isset($_GET["custompwdindex"])) {
    if (isset($change_custompwdfield[$_GET["custompwdindex"]])) {
        $custompwdindex = $_GET["custompwdindex"];
    } else {
        $result = "unknowncustompwdfield";
    }
}

$custompwdfield = $change_custompwdfield[$custompwdindex];

# Check the entered username for characters that our installation doesn't support
if ( $result === "" ) {
    $result = check_username_validity($login,$login_forbidden_chars);
}

# Match new and confirm password
if ( $newcustompwd != $confirmcustompwd ) { $result="nomatch"; }

#==============================================================================
# Check captcha
#==============================================================================
if ( ( $result === "" ) and $use_captcha ) { $result = global_captcha_check();}

#==============================================================================
# Default configuration
#==============================================================================
if (!isset($custompwdfield['ldap_use_ppolicy_control'])) {
    $custompwdfield['ldap_use_ppolicy_control'] = false;
} //it is possible to define different password policies for multiple attributes, as far as I know only in OpenLDAP
if (!isset($custompwdfield['pwd_policy_config'])) {
    $custompwdfield['pwd_policy_config'] = array();
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_show_policy'])) {
    $custompwdfield['pwd_policy_config']['pwd_show_policy'] = $pwd_show_policy;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_length'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_length'] = $pwd_min_length;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_max_length'])) {
    $custompwdfield['pwd_policy_config']['pwd_max_length'] = $pwd_max_length;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_lower'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_lower'] = $pwd_min_lower;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_upper'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_upper'] = $pwd_min_upper;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_digit'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_digit'] = $pwd_min_digit;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_special'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_special'] = $pwd_min_special;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_special_chars'])) {
    $custompwdfield['pwd_policy_config']['pwd_special_chars'] = $pwd_special_chars;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_forbidden_chars'])) {
    $custompwdfield['pwd_policy_config']['pwd_forbidden_chars'] = "";
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_no_reuse'])) {
    $custompwdfield['pwd_policy_config']['pwd_no_reuse'] = $pwd_no_reuse;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_diff_last_min_chars'])) {
    $custompwdfield['pwd_policy_config']['pwd_diff_last_min_chars'] = $pwd_diff_last_min_chars;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_diff_login'])) {
    $custompwdfield['pwd_policy_config']['pwd_diff_login'] = $pwd_diff_login;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_complexity'])) {
    $custompwdfield['pwd_policy_config']['pwd_complexity'] = $pwd_complexity;
}
if (!isset($custompwdfield['pwd_policy_config']['use_pwnedpasswords'])) {
    $custompwdfield['pwd_policy_config']['use_pwnedpasswords'] = $use_pwnedpasswords;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_no_special_at_ends'])) {
    $custompwdfield['pwd_policy_config']['pwd_no_special_at_ends'] = $pwd_no_special_at_ends;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_forbidden_words'])) {
    $custompwdfield['pwd_policy_config']['pwd_forbidden_words'] = $pwd_forbidden_words;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_forbidden_ldap_fields'])) {
    $custompwdfield['pwd_policy_config']['pwd_forbidden_ldap_fields'] = $pwd_forbidden_ldap_fields;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_show_policy_pos'])) {
    $custompwdfield['pwd_policy_config']['pwd_show_policy_pos'] = $pwd_show_policy_pos;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_display_entropy'])) {
    $custompwdfield['pwd_policy_config']['pwd_display_entropy'] = $pwd_display_entropy;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_check_entropy'])) {
    $custompwdfield['pwd_policy_config']['pwd_check_entropy'] = $pwd_check_entropy;
}
if (!isset($custompwdfield['pwd_policy_config']['pwd_min_entropy'])) {
    $custompwdfield['pwd_policy_config']['pwd_min_entropy'] = $pwd_min_entropy;
}
if (!isset($custompwdfield['who_change_password'])) {
    $custompwdfield['who_change_password'] = $who_change_password;
}
if (!isset($custompwdfield['msg_changehelpextramessage'])) {
    $custompwdfield['msg_changehelpextramessage'] = "";
}
if (!isset($custompwdfield['notify_on_change'])) {
    $custompwdfield['notify_on_change'] = $notify_on_change;
}
if (!isset($custompwdfield['hash_options'])) {
    $custompwdfield['hash_options'] = $hash_options;
}
if (!isset($custompwdfield['msg_passwordchangedextramessage'])) {
    $custompwdfield['msg_passwordchangedextramessage'] = "";
}
if (!isset($custompwdfield['samba_mode'])) {
    $custompwdfield['samba_mode'] = false;
}
if (!isset($custompwdfield['samba_options'])) {
    $custompwdfield['samba_options'] = array();
}
if (!isset($custompwdfield['shadow_options'])) {
    $custompwdfield['shadow_options'] = array();
}
if (!isset($custompwdfield['shadow_options']['update_shadowLastChange'])) {
    $custompwdfield['sha$dow_options']['update_shadowLastChange'] = false;
}
if (!isset($custompwdfield['shadow_options']['update_shadowExpire'])) {
    $custompwdfield['shadow_options']['update_shadowExpire'] = false;
}
if (!isset($custompwdfield['shadow_options']['shadow_expire_days'])) {
    $custompwdfield['shadow_options']['shadow_expire_days'] = -1;
}

#==============================================================================
# Check password
#==============================================================================
if ( $result === "" ) {

    # Connect to LDAP
    $ldap_connection = $ldapInstance->connect();

    $ldap = $ldap_connection[0];
    $result = $ldap_connection[1];

    if ($ldap) {

        # Search for user
        $ldap_filter = str_replace("{login}", $login, $ldap_filter);
        $search = ldap_search($ldap, $ldap_base, $ldap_filter);

        $errno = ldap_errno($ldap);
        if ( $errno ) {
            $result = "ldaperror";
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {

            # Get user DN
            $entry = ldap_first_entry($ldap, $search);

            if( !$entry ) {
                $result = "badcredentials";
                error_log("LDAP - User $login not found");
            } else {
                # Get user email for notification
                if ($custompwdfield['notify_on_change']) {
                    $mail = \Ltb\AttributeValue::ldap_get_mail_for_notification($ldap, $entry, $mail_attributes);
                }

                $userdn = ldap_get_dn($ldap, $entry);
                $entry_array = ldap_get_attributes($ldap, $entry);
                $entry_array['dn'] = $userdn;

                # Bind with current password
                $bind = ldap_bind($ldap, $userdn, $password);
                if ( !$bind ) {
                    $result = "badcredentials";
                    $errno = ldap_errno($ldap);
                    if ( $errno ) {
                        error_log("LDAP - Bind user error $errno  (".ldap_error($ldap).")");
                    }
                    if ( ($errno == 49) && $ad_mode ) {
                        if ( ldap_get_option($ldap, 0x0032, $extended_error) ) {
                            error_log("LDAP - Bind user extended_error $extended_error  (".ldap_error($ldap).")");
                            $extended_error = explode(', ', $extended_error);
                            if ( strpos($extended_error[2], '773') or strpos($extended_error[0], 'NT_STATUS_PASSWORD_MUST_CHANGE') ) {
                                error_log("LDAP - Bind user password needs to be changed");
                                $result = "accountexpired";
                            }
                            if ( ( strpos($extended_error[2], '532') or strpos($extended_error[0], 'NT_STATUS_ACCOUNT_EXPIRED') ) and $ad_options['change_expired_password'] ) {
                                error_log("LDAP - Bind user password is expired");
                                $result = "accountexpired";
                            }
                            unset($extended_error);
                        }
                    }
                }
                if ( !$result )  {
                    # Rebind as Manager if needed
                    if ( $custompwdfield['who_change_password'] == "manager" ) {
                        $bind = ldap_bind($ldap, $ldap_binddn, $ldap_bindpw);
                    }
                }
            }

            if ( $use_ratelimit ) {
                if ( ! allowed_rate($login,$_SERVER[$client_ip_header],$rrl_config) ) {
                    $result = "throttle";
                    error_log("LDAP - User $login too fast");
                }
            }

        }
    }
}

#==============================================================================
# Check password strength
#==============================================================================
if ( !$result ) {
    $result = check_password_strength( $newcustompwd, $password, $custompwdfield['pwd_policy_config'], $login, $entry_array, $change_custompwdfield );
}

#==============================================================================
# Change password
#==============================================================================
if ( !$result ) {
    if ( isset($custompwdfield['prehook']) ) {
        $command = hook_command($custompwdfield['prehook'], $login, $newcustompwd, $password, $custompwdfield['prehook_password_encodebase64']);
        exec($command, $prehook_output, $prehook_return);
    }
    if ( ! isset($prehook_return) || $prehook_return === 0 || $custompwdfield['ignore_prehook_error'] ) {
        $result = change_password($ldapInstance, $userdn, $newcustompwd, false, array(), $custompwdfield['samba_mode'], $custompwdfield['samba_options'], $custompwdfield['shadow_options'], $custompwdfield['hash'], $custompwdfield['hash_options'], $custompwdfield['who_change_password'], $password, false, $custompwdfield['ldap_use_ppolicy_control'], true, $custompwdfield['attribute']);
        if ( $result === "passwordchanged" && isset($custompwdfield['posthook']) ) {
            $command = hook_command($custompwdfield['posthook'], $login, $newcustompwd, $password, $custompwdfield['posthook_password_encodebase64']);
            exec($command, $posthook_output, $posthook_return);
        }
        if ( $result !== "passwordchanged" ) {
            if ( $show_extended_error ) {
                ldap_get_option($ldap, 0x0032, $extended_error_msg);
            }
        }
    }
} else {
    error_log($result);
}

#==============================================================================
# Notify password change
#==============================================================================

if ($result === "passwordchanged") {
    if ($mail and $notify_on_change) {
        $data = array( "login" => $login, "mail" => $mail, "password" => $newcustompwd);
        if ( !$mailer->send_mail($mail, $mail_from, $mail_from_name, $messages["changesubject"], $messages["changemessage"].$mail_signature, $data) ) {
            error_log("Error while sending change email to $mail (user $login)");
        }
    }
}

#==============================================================================
# Reuse config-variables and message-variables
#==============================================================================

$pwd_show_policy_pos = $custompwdfield['pwd_policy_config']['pwd_show_policy_pos'];
$pwd_show_policy = $custompwdfield['pwd_policy_config']['pwd_show_policy'];
$pwd_min_length = $custompwdfield['pwd_policy_config']['pwd_min_length'];
$pwd_max_length = $custompwdfield['pwd_policy_config']['pwd_max_length'];
$pwd_min_lower = $custompwdfield['pwd_policy_config']['pwd_min_lower'];
$pwd_min_upper = $custompwdfield['pwd_policy_config']['pwd_min_upper'];
$pwd_min_digit = $custompwdfield['pwd_policy_config']['pwd_min_digit'];
$pwd_min_special = $custompwdfield['pwd_policy_config']['pwd_min_special'];
$pwd_complexity = $custompwdfield['pwd_policy_config']['pwd_complexity'];
$pwd_diff_last_min_chars = $custompwdfield['pwd_policy_config']['pwd_diff_last_min_chars'];
$pwd_forbidden_chars = $custompwdfield['pwd_policy_config']['pwd_forbidden_chars'];
$pwd_no_reuse = $custompwdfield['pwd_policy_config']['pwd_no_reuse'];
$pwd_diff_login = $custompwdfield['pwd_policy_config']['pwd_diff_login'];
$pwd_display_entropy = $custompwdfield['pwd_policy_config']['pwd_display_entropy'];
$pwd_check_entropy = $custompwdfield['pwd_policy_config']['pwd_check_entropy'];
$pwd_min_entropy = $custompwdfield['pwd_policy_config']['pwd_min_entropy'];
$use_pwnedpasswords = $custompwdfield['pwd_policy_config']['use_pwnedpasswords'];
$pwd_no_special_at_ends = $custompwdfield['pwd_policy_config']['pwd_no_special_at_ends'];

$messages['sameasold'] = $messages['sameasaccountpassword'];
$messages['policynoreuse'] = $messages['policynoreusecustompwdfield'];
if (!isset($custompwdfield['label'])) {
    $messages['newcustompassword'] = $messages['changehelpcustompwdfield']."custom password"; # default generic label
} else {
    $messages['newcustompassword'] = $messages['changehelpcustompwdfield'].$custompwdfield['label'];
}
