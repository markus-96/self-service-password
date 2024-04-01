<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Ssp\Lang;

/**
 * Description of Ar
 *
 * @author m_beckschulte
 */
class Ar extends Language {
    public function assign_smarty_messages(&$smarty) {
        $smarty->assign('lang', 'ar');
        parent::assign_smarty_messages($smarty);
    }
}
