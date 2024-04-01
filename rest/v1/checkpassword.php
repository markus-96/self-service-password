<?php
require_once("./include.php");
use Ssp\ResultCode\ResultCode;

#==============================================================================
# Action
#==============================================================================

$result = ResultCode::SUCCESS;
$oldpassword = "";
$newpassword = "";
$login = "";
$entry_array=array();
$ret = "";
$return = [];

if (isset($_POST["login"]) and $_POST["login"]) {
    $login = $_POST["login"];

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
            error_log("LDAP - Search error $errno  (".ldap_error($ldap).")");
        } else {

            # Get user DN
            $entry = ldap_first_entry($ldap, $search);

            if( !$entry ) {
                $result = ResultCode::BAD_CREDENTIALS;
                error_log("LDAP - User $login not found");
            } else {

                $userdn = ldap_get_dn($ldap, $entry);

                $entry_array = ldap_get_attributes($ldap, $entry);
                $entry_array['dn'] = $userdn;

            }
        }
    }
}

if (isset($_POST["oldpassword"]) and $_POST["oldpassword"]) {
    $oldpassword = $_POST["oldpassword"];
}

if (isset($_POST["newpassword"]) and $_POST["newpassword"]) {
    $newpassword = $_POST["newpassword"];
    $result = check_password_strength($newpassword, $oldpassword, $pwd_policy_config, $login, $entry_array);
    $error_code = 0;
} else {
    $error_code = 1;
    $result = ResultCode::NEW_PASSWORD_REQUIRED;
}

$return['result'] = $result->value;
$return['error'] = $error_code;
$return['message'] = $lang_class->{$result->value};

echo json_encode($return, JSON_UNESCAPED_UNICODE);
