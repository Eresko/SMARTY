<?php
namespace Core;

use Smarty;

class View {
    private static ?Smarty $smarty = null;

    public static function getSmarty(): Smarty {

        if (self::$smarty === null) {
            $smarty = new Smarty();

            $smarty->setTemplateDir(__DIR__ . '/../templates/');
            $smarty->setCompileDir(__DIR__ . '/../templates_c/');

            $smarty->compile_check = true;
            $smarty->force_compile = true;

            self::$smarty = $smarty;
        }
        return self::$smarty;
    }
}

