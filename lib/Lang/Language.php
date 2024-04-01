<?php
namespace Ssp\Lang;
use Ssp\ResultCode\ResultCode;

/**
 * 
 */
abstract class Language {
    public $phpupgraderequired = "PHP upgrade required";
    public $nophpldap = "You should install PHP LDAP to use this tool";
    public $nophpmhash = "You should install PHP mhash to use Samba mode";
    public $nokeyphrase = "Token encryption requires a random string in keyphrase setting";
    public $nocrypttokens = "Crypted tokens are mandatory for reset by SMS feature";
    public $noreseturl = "Reset by mail tokens feature requires configuration of reset URL";
    public $questions = [
        'birthday' => "When is your birthday?",
        'color' => "What is your favorite color?"
    ];
    public $ldaperror = "Cannot access LDAP directory";
    public $loginrequired = "Your login is required";
    public $oldpasswordrequired = "Your old password is required";
    public $newpasswordrequired = "Your new password is required";
    public $confirmpasswordrequired = "Please confirm your new password";
    public $passwordchanged = "Your password was changed";
    public $sshkeychanged = "Your SSH Key was changed";
    public $nomatch = "Passwords mismatch";
    public $insufficiententropy = "Insufficient entropy for new password";
    public $badcredentials = "Login and/or password incorrect";
    public $passworderror = "Password was refused by the LDAP directory";
    public $sshkeyerror = "SSH Key was refused by the LDAP directory";
    public $title = "Self service password";
    public $login = "Login";
    public $oldpassword = "Old password";
    public $newpassword = "New password";
    public $confirmpassword = "Confirm";
    public $submit = "Send";
    public $getuser = "Get user";
    public $tooshort = "Your password is too short";
    public $toobig = "Your password is too long";
    public $minlower = "Your password does not have enough lowercase characters";
    public $minupper = "Your password does not have enough uppercase characters";
    public $mindigit = "Your password does not have enough digits";
    public $minspecial = "Your password does not have enough special characters";
    public $sameasold = "Your new password is identical to your old password";
    public $policy = "Your password must conform to the following constraints:";
    public $policyminlength = "Minimum length:";
    public $policymaxlength = "Maximum length:";
    public $policyminlower = "Minimum number of lowercase characters:";
    public $policyminupper = "Minimum number of uppercase characters:";
    public $policymindigit = "Minimum number of digits:";
    public $policyminspecial = "Minimum number of special characters:";
    public $forbiddenchars = "You password contains forbidden characters";
    public $policyforbiddenchars = "Forbidden characters:";
    public $policynoreuse = "Your new password may not be the same as your old password";
    public $password = "Password";
    public $question = "Question";
    public $answer = "Answer";
    public $answerrequired = "No answer given";
    public $questionrequired = "No question selected";
    public $passwordrequired = "Your password is required";
    public $sshkeyrequired = "SSH Key is required";
    public $invalidsshkey = "Input SSH Key looks invalid";
    public $answermoderror = "Your answer has not been registered";
    public $answerchanged = "Your answer has been registered";
    public $answernomatch = "Your answer is incorrect";
    public $resetbyquestionshelp = "Choose a question and answer it to reset your password. This requires that you have already <a href=\"?action=setquestions\">registered an answer</a>.";
    public $setquestionshelp = "Initialize or change your password reset question and answer. You will then be able to reset your password <a href=\"?action=resetbyquestions\">here</a>.";
    public $changehelp = "Enter your old password and choose a new one.";
    public $changehelpreset = "Forgot your password?";
    public $changehelpquestions = "<a href=\"?action=resetbyquestions\">Reset your password by answering questions</a>";
    public $changehelptoken = "<a href=\"?action=sendtoken\">Email a password reset link</a>";
    public $changehelpsms = "<a href=\"?action=sendsms\">Reset your password with a SMS</a>";
    public $changehelpsshkey = "<a href=\"?action=changesshkey\">Change your SSH Key</a>";
    public $changesshkeyhelp = "Enter your password and new SSH key.";
    public $resetmessage = "Hello {login},\n\nClick here to reset your password:\n{url}\n\nIf you didn't request a password reset, please ignore this email.";
    public $resetsubject = "Reset your password";
    public $sendtokenhelp = "Enter your login and your email address to reset your password. When you receive the email, click the link inside to complete the password reset.";
    public $sendtokenhelpnomail = "Enter your login to reset your password. An email will be sent to the address associated with the supplied user name. When you receive this email, click the link inside to complete the password reset.";
    public $mail = "Mail";
    public $mailrequired = "Your email address is required";
    public $mailnomatch = "The email address does not match the submitted login";
    public $tokensent = "A confirmation email has been sent";
    public $tokensent_ifexists = "If the account exists, a confirmation email has been sent to the associated email address";
    public $tokennotsent = "Error when sending confirmation email";
    public $tokenrequired = "Token is required";
    public $tokennotvalid = "Token is not valid";
    public $resetbytokenhelp = "The link sent by email allows you to reset your password. To request a new link via email, <a href=\"?action=sendtoken\">click here</a>.";
    public $resetbysmshelp = "The token sent by sms allows you to reset your password. To get a new token, <a href=\"?action=sendsms\">click here</a>.";
    public $changemessage = "Hello {login},\n\nYour password has been changed.\n\nIf you didn't request a password reset, please contact your administrator immediately.";
    public $changesubject = "Your password has been changed";
    public $changesshkeymessage = "Hello {login},\n\nYour SSH Key has been changed.\n\nIf you didn't initiate this change, please contact your administrator immediately.";
    public $changesshkeysubject = "Your SSH Key has been changed";
    public $badcaptcha = "The captcha was not entered correctly. Try again.";
    public $captcharequired = "The captcha is required.";
    public $captcha = "Captcha";
    public $notcomplex = "Your password does not have enough different classes of characters";
    public $policycomplex = "Minimum number of different classes of characters:";
    public $sms = "SMS number";
    public $smsresetmessage = "Your password reset token is:";
    public $smssent = "A confirmation code has been send by SMS";
    public $smssent_ifexists = "If account exists, a confirmation code has been send by SMS";
    public $smsnotsent = "Error when sending SMS";
    public $smsnonumber = "Can't find mobile number";
    public $userfullname = "User full name";
    public $username = "Username";
    public $smscrypttokensrequired = "You can't use reset by SMS without crypt_tokens setting";
    public $smsuserfound = "Check that user information are correct and press Send to get SMS token";
    public $smstoken = "SMS token";
    public $sshkey = "SSH Key";
    public $nophpmbstring = "You should install PHP mbstring";
    public $menuquestions = "Question";
    public $menutoken = "Email";
    public $menusms = "SMS";
    public $menusshkey = "SSH Key";
    public $nophpxml = "You should install PHP XML to use this tool";
    public $tokenattempts = "Invalid token, try again";
    public $emptychangeform = "Change your password";
    public $emptysshkeychangeform = "Change your SSH Key";
    public $emptysendtokenform = "Email a password reset link";
    public $emptyresetbyquestionsform = "Reset your password";
    public $emptysetquestionsform = "Set your password reset questions";
    public $emptysendsmsform = "Get a reset code";
    public $sameaslogin = "Your new password is identical to your login";
    public $policydifflogin = "Your new password may not be the same as your login";
    public $pwned = "Your new password has already been published on leaks, you should consider changing it on any other service that it is in use";
    public $policypwned = "Your new password may not be published on any previous public password leak from any site";
    public $throttle = "Too fast! Please try again later (if ever you are human)";
    public $policydiffminchars = "Minimum number of new unique characters:";
    public $diffminchars = "Your new password is too similar to your old password";
    public $specialatends = "Your new password has its only special character at the beginning or end";
    public $policyspecialatends = "Your new password may not have its only special character at the beginning or end";
    public $checkdatabeforesubmit = "Please check your information before submitting the form";
    public $forbiddenwords = "Your passwords contains forbidden words or strings";
    public $policyforbiddenwords = "Your password must not contain:";
    public $forbiddenldapfields = "Your password contains values from your LDAP entry";
    public $policyforbiddenldapfields = "Your password may not contain values from the following LDAP fields:";
    public $policyentropy = "Password strength";
    public $ldap_cn = "common name";
    public $ldap_givenName = "given name";
    public $ldap_sn = "surname";
    public $ldap_mail = "mail address";
    public $questionspopulatehint = "Enter only your login to retrieve the questions you've registered.";
    public $badquality = "Password quality is too low";
    public $tooyoung = "Password was changed too recently";
    public $inhistory = "Password is in history of old passwords";
    public $attributesmoderror = "Your information have not been updated";
    public $attributeschanged = "Your information have been updated";
    public $setattributeshelp = "You can update the information used to reset your password. Enter your login and password and set your new details.";
    public $phone = "Telephone number";
    public $sendtokenhelpupdatemail = "You can udate your email address on <a href=\"?action=setattributes\">this page</a>.";
    public $sendsmshelpupdatephone = "You can update your phone number on <a href=\"?action=setattributes\">this page</a>.";
    public $sendsmshelp = "Enter your login and your SMS number to get password reset token. Then type token sent in SMS.";
    public $sendsmshelpnosms ="Enter your login to get password reset token. Then type token sent in SMS.";
    public $smsrequired = "Your SMS phone is required.";
    public $smsnomatch = "The SMS number does not match the submitted login.";
    public $changehelpextramessage = "";

    public function assign_smarty_messages(&$smarty): void {
        $smarty->assign("msg_questions", $this->questions);
        $smarty->assign("msg_title", $this->title);
        $smarty->assign("msg_login", $this->login);
        $smarty->assign("msg_oldpassword", $this->oldpassword);
        $smarty->assign("msg_newpassword", $this->newpassword);
        $smarty->assign("msg_confirmpassword", $this->confirmpassword);
        $smarty->assign("msg_submit", $this->submit);
        $smarty->assign("msg_getuser", $this->getuser);
        $smarty->assign("msg_policy", $this->policy);
        $smarty->assign("msg_policyminlength", $this->policyminlength);
        $smarty->assign("msg_policymaxlength", $this->policymaxlength);
        $smarty->assign("msg_policyminlower", $this->policyminlower);
        $smarty->assign("msg_policyminupper", $this->policyminupper);
        $smarty->assign("msg_policymindigit", $this->policymindigit);
        $smarty->assign("msg_policyminspecial", $this->policyminspecial);
        $smarty->assign("msg_policyforbiddenchars", $this->policyforbiddenchars);
        $smarty->assign("msg_policynoreuse", $this->policynoreuse);
        $smarty->assign("msg_password", $this->password);
        $smarty->assign("msg_question", $this->question);
        $smarty->assign("msg_answer", $this->answer);
        $smarty->assign("msg_answerchanged", $this->answerchanged);
        $smarty->assign("msg_resetbyquestionshelp", $this->resetbyquestionshelp);
        $smarty->assign("msg_setquestionshelp", $this->setquestionshelp);
        $smarty->assign("msg_changehelp", $this->changehelp);
        $smarty->assign("msg_changehelpreset", $this->changehelpreset);
        $smarty->assign("msg_changehelpquestions", $this->changehelpquestions);
        $smarty->assign("msg_changehelptoken", $this->changehelptoken);
        $smarty->assign("msg_changehelpsms", $this->changehelpsms);
        $smarty->assign("msg_changehelpsshkey", $this->changehelpsshkey);
        $smarty->assign("msg_changesshkeyhelp", $this->changesshkeyhelp);
        $smarty->assign("msg_resetmessage", $this->resetmessage);
        $smarty->assign("msg_resetsubject", $this->resetsubject);
        $smarty->assign("msg_sendtokenhelp", $this->sendtokenhelp);
        $smarty->assign("msg_sendtokenhelpnomail", $this->sendtokenhelpnomail);
        $smarty->assign("msg_mail", $this->mail);
        $smarty->assign("msg_mailnomatch", $this->mailnomatch);
        $smarty->assign("msg_tokensent", $this->tokensent);
        $smarty->assign("msg_tokensent_ifexists", $this->tokensent_ifexists);
        $smarty->assign("msg_resetbytokenhelp", $this->resetbytokenhelp);
        $smarty->assign("msg_resetbysmshelp", $this->resetbysmshelp);
        $smarty->assign("msg_changemessage", $this->changemessage);
        $smarty->assign("msg_changesubject", $this->changesubject);
        $smarty->assign("msg_changesshkeymessage", $this->changesshkeymessage);
        $smarty->assign("msg_changesshkeysubject", $this->changesshkeysubject);
        $smarty->assign("msg_captcha", $this->captcha);
        $smarty->assign("msg_policycomplex", $this->policycomplex);
        $smarty->assign("msg_sms", $this->sms);
        $smarty->assign("msg_smsresetmessage", $this->smsresetmessage);
        $smarty->assign("msg_userfullname", $this->userfullname);
        $smarty->assign("msg_smstoken", $this->smstoken);
        $smarty->assign("msg_sshkey", $this->sshkey);
        $smarty->assign("msg_menuquestions", $this->menuquestions);
        $smarty->assign("msg_menutoken", $this->menutoken);
        $smarty->assign("msg_menusms", $this->menusms);
        $smarty->assign("msg_menusshkey", $this->menusshkey);
        $smarty->assign("msg_emptysshkeychangeform", $this->emptysshkeychangeform);
        $smarty->assign("msg_emptysendtokenform", $this->emptysendtokenform);
        $smarty->assign("msg_emptyresetbyquestionsform", $this->emptyresetbyquestionsform);
        $smarty->assign("msg_emptysetquestionsform", $this->emptysetquestionsform);
        $smarty->assign("msg_emptysendsmsform", $this->emptysendsmsform);
        $smarty->assign("msg_policydifflogin", $this->policydifflogin);
        $smarty->assign("msg_policypwned", $this->policypwned);
        $smarty->assign("msg_policydiffminchars", $this->policydiffminchars);
        $smarty->assign("msg_policyspecialatends", $this->policyspecialatends);
        $smarty->assign("msg_policyforbiddenwords", $this->policyforbiddenwords);
        $smarty->assign("msg_policyforbiddenldapfields", $this->policyforbiddenldapfields);
        $smarty->assign("msg_policyentropy", $this->policyentropy);
        $smarty->assign("msg_ldap_cn", $this->ldap_cn);
        $smarty->assign("msg_ldap_givenName", $this->ldap_givenName);
        $smarty->assign("msg_ldap_sn", $this->ldap_sn);
        $smarty->assign("msg_ldap_mail", $this->ldap_mail);
        $smarty->assign("msg_questionspopulatehint", $this->questionspopulatehint);
        $smarty->assign("msg_attributeschanged", $this->attributeschanged);
        $smarty->assign("msg_setattributeshelp", $this->setattributeshelp);
        $smarty->assign("msg_phone", $this->phone);
        $smarty->assign("msg_sendtokenhelpupdatemail", $this->sendtokenhelpupdatemail);
        $smarty->assign("msg_sendsmshelpupdatephone", $this->sendsmshelpupdatephone);
        $smarty->assign("msg_sendsmshelp", $this->sendsmshelp);
        $smarty->assign("msg_sendsmshelpnosms", $this->sendsmshelpnosms);
        $smarty->assign("msg_smsrequired", $this->smsrequired);
        $smarty->assign("msg_smsnomatch", $this->smsnomatch);
        $smarty->assign("msg_changehelpextramessage", $this->changehelpextramessage);
    }
    
    public function unset_default_questions(): void {
        unset($this->questions['birthday']);
        unset($this->questions['color']);
    }
    
    public function update_questions($new_questions): void {
        foreach ($new_questions as $question_key => $question_value) {
            $this->questions[$question_key] = $question_value;
        }
        unset($question_key);
        unset($question_value);
    }
    
    function get_result_message($result): string {
        return match($result) {
            ResultCode::PHP_UPGRADE_REQUIRED => $this->phpupgraderequired,
            ResultCode::NO_PHP_LDAP => $this->nophpldap,
            ResultCode::NO_PHP_MHASH => $this->nophpmhash,
            ResultCode::NO_KEY_PHRASE => $this->nokeyphrase,
            ResultCode::NO_CRYPT_TOKENS => $this->nocrypttokens,
            ResultCode::NO_RESET_URL => $this->noreseturl,
            default => ""
        };
    }
    
    function assign_smarty_result_message($result, &$smarty): void {
        $smarty->assign('error', $this->get_result_message($result));
    }
    
    function get_sms_result_message($result): string {
        return match($result) {
            ResultCode::SMS_CRYPT_TOKENS_REQUIRED => $this->smscrypttokensrequired,
            ResultCode::SMS_NOT_SEND => $this->smsnotsent,
            ResultCode::SMS_NO_MATCH => $this->smsnomatch,
            ResultCode::SMS_NO_NUMBER => $this->smsnonumber,
            ResultCode::SMS_SENT => $this->smssent,
            ResultCode::SMS_SENT_IF_EXISTS => $this->smssent_ifexists,
            ResultCode::SMS_USER_FOUND => $this->smsuserfound,
            ResultCode::TOKEN_ATTEMPTS => $this->tokenattempts,
            default => ""
        };
    }
    
    function assign_smarty_sms_error_message($result, &$smarty): void {
        $result_message = $this->get_sms_result_message($result);
        if ($result_message === "") {
            $smarty->assign('error_sms', false);
        } else {
            $smarty->assign('error_sms', $result_message);
        }
    }
    
    function update_messages($custom_messages): void {
        foreach ($custom_messages as $custom_message_key => $custom_message_value) {
            $this->{$custom_message_key} = $custom_message_value;
        }
    }
}
