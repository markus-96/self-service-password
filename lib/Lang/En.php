<?php
namespace Ssp\Lang;

/**
 * 
 */
class En extends Language {
    public function assign_smarty_messages(&$smarty): void {
        $smarty->assign('lang', 'en');
        parent::assign_smarty_messages($smarty);
    }
}
