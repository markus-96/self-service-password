<?php

namespace Ssp\Lang;
/**
 * 
 */
class Languages {
    
    private static $available_languages = [
        "ar",
        "ca",
        "cn",
        "cs",
        "de",
        "ee",
        "el",
        "en",
        "es"
    ];
    
    public static function get_language_class($lang): Language {
        return match ($lang) {
            "ar" => new Ar(),
            "ca" => new Ca(),
            "cn" => new Cn(),
            "cs" => new Cs(),
            "de" => new De(),
            "ee" => new Ee(),
            "el" => new El(),
            "en" => new En(),
            "es" => new Es()
        };
    }
    
    /**
    * split request header Accept-Language to determine the UserAgent's
    * prefered language
    *
    * @param string $defaultLanguage preselected default language
    * @return string returns the default language or a match from $availableLanguages
    */
    static function detectLanguage($defaultLanguage, $allowed_lang, $accepted_lang): string
    {
        $languages = self::$available_languages;
        $availableLanguages = array_intersect($allowed_lang, $languages);
        $languageList      = explode(',', $accepted_lang);
        $choosenLanguage= $defaultLanguage;
        foreach($languageList as $currentLanguage) {
            $currentLanguage = explode(';', $currentLanguage);
            if (preg_match('/(..)-?.*/', $currentLanguage[0], $reg)) {
                foreach($reg as $checkLang) {
                    if ($match = preg_grep('/'.$checkLang.'/i', $availableLanguages)) {
                        $choosenLanguage= $match[key($match)];
                        break 2;
                    }
                }
            }
        }
        return $choosenLanguage;
    }
}
