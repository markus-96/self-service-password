<?php

namespace Ssp\Lang;

/**
 * 
 */
class Cs extends Language{
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'cs');
        parent::assign_smarty_messages($smarty);
    }
}
