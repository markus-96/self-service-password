<?php

namespace Ssp\Lang;

/**
 * 
 */
class Es {
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'es');
        parent::assign_smarty_messages($smarty);
    }
}
