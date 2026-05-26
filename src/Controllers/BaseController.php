<?php
namespace App\Controllers;

use Smarty;

abstract class BaseController {
    protected Smarty $smarty;

    public function __construct(Smarty $smarty) {
        $this->smarty = $smarty;
    }
}
