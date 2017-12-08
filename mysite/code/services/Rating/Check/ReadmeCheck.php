<?php

namespace SilverStripe\Addons\Services\Rating\Check;

use SilverStripe\Addons\Services\Rating\Check;

class ReadmeCheck extends Check
{
    protected $points = 5;

    public function getKey()
    {
        return 'has_readme';
    }

    public function run()
    {
        $options = ['readme', 'README', 'readme.md', 'README.md', 'readme.txt', 'README.txt'];
        foreach ($options as $filename) {
            if (file_exists($this->getSuite()->getModuleRoot() . '/' . $filename)) {
                $this->setSuccessful(true);
                break;
            }
        }
    }
}
