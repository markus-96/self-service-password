<?php

namespace Ssp\Lang;

/**
 * 
 */
class Cn {
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'cn');
        parent::assign_smarty_messages($smarty);
    }
}
