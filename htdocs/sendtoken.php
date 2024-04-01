<?php
#==============================================================================
# LTB Self Service Password
#
# Copyright (C) 2024 Clement OUDOT
# Copyright (C) 2024 LTB-project.org
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

# This page is called to send a reset token by mail

use Ssp\ResultCode\ResultCode;
#==============================================================================
# POST parameters
#==============================================================================
# Initiate vars
$result = ResultCode::SUCCESS;
$login = $presetLogin;
$mail = "";
$ldap = "";
$userdn = "";
$token = "";
$usermail = "";

if (!$mail_address_use_ldap) {
    if (isset($_POST["mail"]) and $_POST["mail"]) {
        $mail = strval($_POST["mail"]);
        $usermail = strval($_POST["mail"]);
    } elseif (isset($_GET["usermail"]) and $_GET["usermail"]) {
        $usermail = strval($_GET["usermail"]);
        $result = ResultCode::CHECK_DATA_BEFORE_SUBMIT;
    } else {
        $result = ResultCode::MAIL_REQUIRED;
    }
}

if (isset($_REQUEST["login"]) and $_REQUEST["login"]) { $login = strval($_REQUEST["login"]);}
else { $result = ResultCode::LOGIN_REQUIRED;}

if (! isset($_POST["mail"]) and ! isset($_REQUEST["login"])) { $result = ResultCode::EMPTY_SEND_TOKEN_FORM; }

# Check the entered username for characters that our installation doesn't support
if ( $result === ResultCode::SUCCESS ) {
    $result = check_username_validity($login,$login_forbidden_chars);
}

#==============================================================================
# Check captcha
#==============================================================================
if ( ( $result === ResultCode::SUCCESS ) and $use_captcha) {
    $result = global_captcha_check();
}

#==============================================================================
# Check mail
#==============================================================================
if ( $result === ResultCode::SUCCESS ) {

    # Connect to LDAP
    $ldap_connection = \Ltb\Ldap::connect($ldap_url, $ldap_starttls, $ldap_binddn, $ldap_bindpw, $ldap_network_timeout, $ldap_krb5ccname);

    $ldap = $ldap_connection[0];
    $result = !($ldap_connection[1]) ? ResultCode::SUCCESS : ResultCode::from($ldap_connection[1]);

    if ( $ldap ) {

        # Search for user
        $ldap_filter = str_replace("{login}", $login, $ldap_filter);
        $search = ldap_search($ldap, $ldap_base, $ldap_filter);

        $errno = ldap_errno($ldap);
        if ( $errno ) {
            $result = ResultCode::LDAP_ERROR;
            error_log("LDAP - Search error $errno (".ldap_error($ldap).")");
        } else {

            # Get user DN
            $entry = ldap_first_entry($ldap, $search);

            if( !$entry ) {
                $result = $obscure_usernotfound_sendtoken ? ResultCode::TOKEN_SENT_IF_EXISTS : ResultCode::BAD_CREDENTIALS;
                error_log("LDAP - User $login not found");
            } else {

                $userdn = ldap_get_dn($ldap, $entry);

                # Compare mail values
                $entry_attributes = ldap_get_attributes($ldap, $entry);
                for ($match = false, $i = 0; $i < sizeof($mail_attributes) and ! $match; $i++) {
                    $mail_attribute = $mail_attributes[$i];
                    if ( in_array($mail_attribute, $entry_attributes) ) {
                        $mailValues = ldap_get_values($ldap, $entry, $mail_attribute);
                        unset($mailValues["count"]);
                        if (! $mail_address_use_ldap) {
                            # Match with user submitted values
                            foreach ($mailValues as $mailValue) {
                                if (strcasecmp($mail_attribute, "proxyAddresses") == 0) {
                                    $mailValue = str_ireplace("smtp:", "", $mailValue);
                                }
                                if (strcasecmp($mail, $mailValue) == 0) {
                                    $match = true;
                                }
                            }
                        } else {
                            # Use first available mail adress in ldap
                            if (count($mailValues) > 0) {
                                $mailValue = $mailValues[0];
                                if (strcasecmp($mail_attribute, "proxyAddresses") == 0) {
                                    $mailValue = str_ireplace("smtp:", "", $mailValue);
                                }
                                $mail = $mailValue;
                                $match = true;
                            }
                        }
                    }
                }

                if (! $match) {
                    if (! $mail_address_use_ldap) {
                        $result = $obscure_usernotfound_sendtoken ? ResultCode::TOKEN_SENT_IF_EXISTS : ResultCode::MAIL_NO_MATCH;
                        error_log("Mail $mail does not match for user $login");
                    } else {
                        $result = $obscure_usernotfound_sendtoken ? ResultCode::TOKEN_SENT_IF_EXISTS : ResultCode::MAIL_NO_MATCH;
                        error_log("Mail not found for user $login");
                    }
                }
                if ($use_ratelimit) {
                    if (! allowed_rate($login, $_SERVER[$client_ip_header], $rrl_config)) {
                        $result = ResultCode::THROTTLE;
                        error_log("Mail - User $login too fast");
                    }
                }
            }
        }
    }
}


#==============================================================================
# Build and store token
#==============================================================================
if ( $result === ResultCode::SUCCESS ) {

    # Use PHP session to register token
    # We do not generate cookie
    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies",1);

    session_name("token");
    session_start();
    $_SESSION['login'] = $login;
    $_SESSION['time']  = time();

    if ( $crypt_tokens ) {
        $token = encrypt(session_id(), $keyphrase);
    } else {
        $token = session_id();
    }

}

#==============================================================================
# Send token by mail
#==============================================================================
if ( $result === ResultCode::SUCCESS ) {

    $reset_url .= "?action=resetbytoken&token=".urlencode($token);

    if ( !empty($reset_request_log) ) {
        error_log("Send reset URL " . ( $debug ? "$reset_url" : "HIDDEN") . "\n\n", 3, $reset_request_log);
    } else {
        error_log("Send reset URL " . ( $debug ? "$reset_url" : "HIDDEN"));
    }

    $data = array( "login" => $login, "mail" => $mail, "url" => $reset_url ) ;

    # Send message
    if ( send_mail($mailer, $mail, $mail_from, $mail_from_name, $messages["resetsubject"], $messages["resetmessage"].$mail_signature, $data) ) {
        $result = $obscure_usernotfound_sendtoken ? ResultCode::TOKEN_SENT_IF_EXISTS : ResultCode::TOKEN_SENT;
    } else {
        $result = ResultCode::TOKEN_NOT_SEND;
        error_log("Error while sending token to $mail (user $login)");
    }
}
