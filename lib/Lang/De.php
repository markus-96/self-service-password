<?php

namespace Ssp\Lang;

/**
 * 
 */
class De extends Language{
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'de');
        parent::assign_smarty_messages($smarty);
    }
}
