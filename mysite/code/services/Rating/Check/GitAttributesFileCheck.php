<?php

namespace SilverStripe\Addons\Services\Rating\Check;

use SilverStripe\Addons\Services\Rating\Check;

class GitAttributesFileCheck extends Check
{
    protected $points = 2;

    public function getKey()
    {
        return 'has_gitattributes_file';
    }

    public function run()
    {
        if (file_exists($this->getSuite()->getModuleRoot() . '/.gitattributes')) {
            $this->setSuccessful(true);
        }
    }
}
