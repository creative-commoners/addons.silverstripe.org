<?php

namespace SilverStripe\Addons\Services\Rating\Check;

use SilverStripe\Addons\Services\Rating\Check;

class EditorConfigFileCheck extends Check
{
    protected $points = 5;

    public function getKey()
    {
        return 'has_editorconfig_file';
    }

    public function run()
    {
        if (file_exists($this->getSuite()->getModuleRoot() . '/.editorconfig')) {
            $this->setSuccessful(true);
        }
    }
}
