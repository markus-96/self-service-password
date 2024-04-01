<?php

namespace Ssp\ResultCode;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ErrorCodes
 *
 * @author m_beckschulte
 */
enum ResultCode: string {
    
    // Criticity: Danger
    case PASSWORD_CHANGED = "passwordchanged";
    case NO_PHP_LDAP = "nophpldap";
    case PHP_UPGRADE_REQUIRED = "phpupgraderequired";
    case NO_PHP_MHASH = "nophpmhash";
    case NO_KEY_PHRASE = "nokeyphrase";
    case LDAP_ERROR = "ldaperror";
    case NO_MATCH = "nomatch";
    case BAD_CREDENTIALS = "badcredentials";
    case PASSWORD_ERROR = "passworderror";
    case TOO_SHORT = "tooshort";
    case TOO_BIG = "toobig";
    case MIN_LOWER = "minlower";
    case MIN_UPPER = "minupper";
    case MIN_DIGIT = "mindigit";
    case MIN_SPECIAL = "minspecial";
    case FORBIDDEN_CHARS = "forbiddenchars";
    case SAME_AS_OLD = "sameasold";
    case ANSWER_MOD_ERROR = "answermoderror";
    case ANSWER_NO_MATCH = "answernomatch";
    case TOKEN_NOT_SEND = "tokennotsend";
    case TOKEN_NOT_VALID = "tokennotvalid";
    case NOT_COMPLEX = "notcomplex";
    case SMS_NO_NUMBER = "smsnonumber";
    case SMS_CRYPT_TOKENS_REQUIRED = "smscrypttokensrequired";
    case NO_PHP_MBSTRING = "nophpmbstring";
    case NO_PHP_XML = "nophpxml";
    case SMS_NOT_SEND = "smsnotsend";
    case SAME_AS_LOGIN = "sameaslogin";
    case PWNED = "pwned";
    case INVALID_SSH_KEY = "invalidsshkey";
    case SSH_KEY_ERROR = "sshkeyerror";
    case SPECIAL_AT_ENDS = "specialatends";
    case FORBIDDEN_WORDS = "forbiddenwords";
    case FORBIDDEN_LDAP_FIELDS = "forbiddenldapfields";
    case DIFF_MIN_CHARS = "diffminchars";
    case BAD_QUALITY = "badquality";
    case TOO_YOUNG = "tooyoung";
    case IN_HISTORY = "inhistory";
    case THROTTLE = "throttle";
    case ATTRIBUTES_MOD_ERROR = "attributesmoderror";
    case INSUFFICIENT_ENTROPY = "insufficiententropy";
    case NO_RESET_URL = "noreseturl";
    case NO_CRYPT_TOKENS = "nocrypttokens";
    case SMS_NO_MATCH = "smsnomatch";
    case UNKNOWN_CUSTOM_PWD_FIELD = "unknowncustompwdfield";
    case SAME_AS_CUSTOM_PWD = "sameascustompwd";
    
    // Criticity: Warning
    case LOGIN_REQUIRED = "loginrequired";
    case OLD_PASSWORD_REQUIRED = "oldpasswordrequired";
    case NEW_PASSWORD_REQUIRED = "newpasswordrequired";
    case CONFIRM_PASSWORD_REQUIRED = "confirmpasswordrequired";
    case ANSWER_REQUIRED = "answerrequired";
    case QUESTION_REQUIRED = "questionrequired";
    case PASSWORD_REQUIRED = "passwordrequired";
    case MAIL_REQUIRED = "mailrequired";
    case TOKEN_REQUIRED = "tokenrequired";
    case SSHKEY_REQUIRED = "sshkeyrequired";
    case CAPTCHA_REQUIRED = "captcharequired";
    case BAD_CAPTCHA = "badcaptcha";
    case TOKEN_ATTEMPTS = "tokenattempts";
    case CHECK_DATA_BEFORE_SUBMIT = "checkdatabeforesubmit";
    
    // Criticyty: Success
    case SUCCESS = "success";
    
    // Criticity: Unknown / not needed
    case SMS_USER_FOUND = "smsuserfound";
    case SMS_SENT = "smssent";
    case SMS_SENT_IF_EXISTS = "smssent_ifexists";
    case EMPTY_CHANGE_FORM = "emptychangeform";
    case EMPTY_SSH_KEY_CHANGE_FORM = "emptysshkeychangeform";
    case SSH_KEY_CHANGED = "sshkeychanged";
    case EMPTY_RESET_BY_QUESTIONS_FORM = "emptyresetbyquestionsform";
    case CRYPT_TOKENS_REQUIRED = "crypttokensrequired";
    case SMS_REQUIRED = "smsrequired";
    case EMPTY_SEND_SMS_FORM = "emptysendsmsform";
    case BUILD_TOKEN = "buildtoken";
    case SEND_SMS = "sendsms";
    case REDIRECT = "redirect";
    case EMPTY_SEND_TOKEN_FORM = "emptysendtokenform";
    case TOKEN_SENT_IF_EXISTS = "tokensent_ifexists";
    case MAIL_NO_MATCH = "mailnomatch";
    case TOKEN_SENT = "tokensent";
    case EMPTY_ATTRIBUTES_FORM = "emptyattributesform";
    case ATTRIBUTES_CHANGED = "attributeschanged";
    case EMPTY_SET_QUESTIONS_FORM = "emptysetquestionsform";
    case ANSWER_CHANGED = "answerchanged";
    
    function get_criticity() {
        return match($this) {
            ResultCode::PASSWORD_CHANGED,
            ResultCode::NO_PHP_LDAP,
            ResultCode::PHP_UPGRADE_REQUIRED,
            ResultCode::NO_PHP_MHASH,
            ResultCode::NO_KEY_PHRASE,
            ResultCode::LDAP_ERROR,
            ResultCode::NO_MATCH,
            ResultCode::BAD_CREDENTIALS,
            ResultCode::PASSWORD_ERROR,
            ResultCode::TOO_SHORT,
            ResultCode::TOO_BIG,
            ResultCode::MIN_LOWER,
            ResultCode::MIN_UPPER,
            ResultCode::MIN_DIGIT,
            ResultCode::MIN_SPECIAL,
            ResultCode::FORBIDDEN_CHARS,
            ResultCode::SAME_AS_OLD,
            ResultCode::ANSWER_MOD_ERROR,
            ResultCode::ANSWER_NO_MATCH,
            ResultCode::TOKEN_NOT_SEND,
            ResultCode::TOKEN_NOT_VALID,
            ResultCode::NOT_COMPLEX,
            ResultCode::SMS_NO_NUMBER,
            ResultCode::SMS_CRYPT_TOKENS_REQUIRED,
            ResultCode::NO_PHP_MBSTRING,
            ResultCode::NO_PHP_XML,
            ResultCode::SMS_NOT_SEND,
            ResultCode::SAME_AS_LOGIN,
            ResultCode::PWNED,
            ResultCode::INVALID_SSH_KEY,
            ResultCode::SSH_KEY_ERROR,
            ResultCode::SPECIAL_AT_ENDS,
            ResultCode::FORBIDDEN_WORDS,
            ResultCode::FORBIDDEN_LDAP_FIELDS,
            ResultCode::DIFF_MIN_CHARS,
            ResultCode::BAD_QUALITY,
            ResultCode::TOO_YOUNG,
            ResultCode::IN_HISTORY,
            ResultCode::THROTTLE,
            ResultCode::ATTRIBUTES_MOD_ERROR,
            ResultCode::INSUFFICIENT_ENTROPY,
            ResultCode::UNKNOWN_CUSTOM_PWD_FIELD,
            ResultCode::SAME_AS_CUSTOM_PWD => Criticity::DANGER,
            
            ResultCode::LOGIN_REQUIRED,
            ResultCode::OLD_PASSWORD_REQUIRED,
            ResultCode::NEW_PASSWORD_REQUIRED,
            ResultCode::CONFIRM_PASSWORD_REQUIRED,
            ResultCode::ANSWER_REQUIRED,
            ResultCode::QUESTION_REQUIRED,
            ResultCode::PASSWORD_REQUIRED,
            ResultCode::MAIL_REQUIRED,
            ResultCode::TOKEN_REQUIRED,
            ResultCode::SSHKEY_REQUIRED,
            ResultCode::CAPTCHA_REQUIRED,
            ResultCode::BAD_CAPTCHA,
            ResultCode::TOKEN_ATTEMPTS,
            ResultCode::CHECK_DATA_BEFORE_SUBMIT => Criticity::WARNING,
            
            ResultCode::SUCCESS => Criticity::SUCCESS,
            
            default => Criticity::SUCCESS
        };
    }
    
    function get_fa_class() {
        return $this->get_criticity()->get_fa_class();
    }
}

