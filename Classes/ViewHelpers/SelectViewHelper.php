<?php

namespace Heiner\heiner\ViewHelpers;


class SelectViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    public function initializeArguments(){
        $this->registerArgument('uid', $type, $description)
    }
    /**
     * Render View Helper
     * @return string
     */
    public function render(){

    }
}