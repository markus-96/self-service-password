<?php

namespace Ssp\Lang;

/**
 * 
 */
class Ee extends Language{
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'ee');
        parent::assign_smarty_messages($smarty);
    }
}
