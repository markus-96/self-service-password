<?php

namespace Ssp\Lang;

/**
 * 
 */
class Ca extends Language{
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'ca');
        parent::assign_smarty_messages($smarty);
    }
}
