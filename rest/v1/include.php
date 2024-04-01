<?php

#==============================================================================
# Configuration
#==============================================================================
require_once("../../conf/config.inc.php");

use Ssp\ResultCode\ResultCode;
#==============================================================================
# Includes
#==============================================================================
require_once(__DIR__."/../../lib/functions.inc.php");
require_once(__DIR__."/../../vendor/autoload.php");

#==============================================================================
# VARIABLES
#==============================================================================
# Get source for menu
if (isset($_REQUEST["source"]) and $_REQUEST["source"]) { $source = $_REQUEST["source"]; }
else { $source="unknown"; }

#==============================================================================
# Language
#==============================================================================

use Ssp\Lang\Languages;
# Available languages
$accepted_lang = filter_input(INPUT_SERVER, 'HTTP_ACCEPT_LANGUAGE', FILTER_SANITIZE_STRING);
$lang = Languages::detectLanguage($lang, $allowed_lang, $accepted_lang);
$lang_class = Languages::get_language_class($lang);

#==============================================================================
# PHP modules
#==============================================================================
# Init dependency check results variable
$dependency_check_results = array();

# Check PHP-LDAP presence
if ( ! function_exists('ldap_connect') ) { $dependency_check_results[] = ResultCode::NO_PHP_LDAP; }
else {
    # Check ldap_modify_batch presence if AD mode and password change as user
    if ( $ad_mode and $who_change_password === "user" and ! function_exists('ldap_modify_batch') ) { $dependency_check_results[] = ResultCode::PHP_UPGRADE_REQUIRED; }
    # Check ldap_exop_passwd if LDAP exop password modify enabled
    if ( $ldap_use_exop_passwd and ! function_exists('ldap_exop_passwd') ) { $dependency_check_results[] = ResultCode::PHP_UPGRADE_REQUIRED; }
}

# Check PHP mhash presence if Samba mode active
if ( $samba_mode and ! function_exists('hash') and ! function_exists('mhash') ) { $dependency_check_results[] = ResultCode::NO_PHP_MHASH; }

# Check PHP mbstring presence
if ( ! function_exists('mb_internal_encoding') ) { $dependency_check_results[] = ResultCode::NO_PHP_MBSTRING; }

# Check PHP xml presence
if ( ! function_exists('utf8_decode') ) { $dependency_check_results[] = ResultCode::NO_PHP_XML; }

# Check keyphrase setting
if ( ( ( $use_tokens and $crypt_tokens ) or $use_sms or $crypt_answers ) and ( empty($keyphrase) or $keyphrase == "secret") ) { $dependency_check_results[] = ResultCode::NO_KEY_PHRASE; }


#==============================================================================
# Email Config
#==============================================================================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
$mailer = new PHPMailer;
$mailer->Priority      = $mail_priority;
$mailer->CharSet       = $mail_charset;
$mailer->ContentType   = $mail_contenttype;
$mailer->WordWrap      = $mail_wordwrap;
$mailer->Sendmail      = $mail_sendmailpath;
$mailer->Mailer        = $mail_protocol;
$mailer->SMTPDebug     = $mail_smtp_debug;
$mailer->Debugoutput   = $mail_debug_format;
$mailer->Host          = $mail_smtp_host;
$mailer->Port          = $mail_smtp_port;
$mailer->SMTPSecure    = $mail_smtp_secure;
$mailer->SMTPAutoTLS   = $mail_smtp_autotls;
$mailer->SMTPAuth      = $mail_smtp_auth;
$mailer->Username      = $mail_smtp_user;
$mailer->Password      = $mail_smtp_pass;
$mailer->SMTPKeepAlive = $mail_smtp_keepalive;
$mailer->SMTPOptions   = $mail_smtp_options;
$mailer->Timeout       = $mail_smtp_timeout;

#==============================================================================
# Other default values
#==============================================================================
if (!isset($ldap_login_attribute)) { $ldap_login_attribute = "uid"; }
if (!isset($ldap_fullname_attribute)) { $ldap_fullname_attribute = "cn"; }
if (!isset($pwd_forbidden_chars)) { $pwd_forbidden_chars = ""; }
if (!isset($hash_options)) { $hash_options = array(); }
if (!isset($samba_options)) { $samba_options = array(); }
if (!isset($ldap_starttls)) { $ldap_starttls = false; }

# Password policy array
$pwd_policy_config = array(
    "pwd_show_policy"           => $pwd_show_policy,
    "pwd_min_length"            => $pwd_min_length,
    "pwd_max_length"            => $pwd_max_length,
    "pwd_min_lower"             => $pwd_min_lower,
    "pwd_min_upper"             => $pwd_min_upper,
    "pwd_min_digit"             => $pwd_min_digit,
    "pwd_min_special"           => $pwd_min_special,
    "pwd_special_chars"         => $pwd_special_chars,
    "pwd_forbidden_chars"       => $pwd_forbidden_chars,
    "pwd_no_reuse"              => $pwd_no_reuse,
    "pwd_diff_last_min_chars"   => $pwd_diff_last_min_chars,
    "pwd_diff_login"            => $pwd_diff_login,
    "pwd_complexity"            => $pwd_complexity,
    "use_pwnedpasswords"        => $use_pwnedpasswords,
    "pwd_no_special_at_ends"    => $pwd_no_special_at_ends,
    "pwd_forbidden_words"       => $pwd_forbidden_words,
    "pwd_forbidden_ldap_fields" => $pwd_forbidden_ldap_fields,
    "pwd_display_entropy"       => $pwd_display_entropy,
    "pwd_check_entropy"         => $pwd_check_entropy,
    "pwd_min_entropy"           => $pwd_min_entropy
);

if (!isset($pwd_show_policy_pos)) { $pwd_show_policy_pos = "above"; }

if (!$use_restapi) {
    die("Rest API disabled");
}
