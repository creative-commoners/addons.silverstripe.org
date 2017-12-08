<?php

namespace SilverStripe\Addons\Services\Rating\Check;

use SilverStripe\Addons\Services\Rating\Check;

class ContributingFileCheck extends Check
{
    protected $points = 2;

    public function getKey()
    {
        return 'has_contributing_file';
    }

    public function run()
    {
        $options = [
            'contributing',
            'CONTRIBUTING',
            'contributing.md',
            'CONTRIBUTING.md',
            'contributing.txt',
            'CONTRIBUTING.txt',
        ];
        foreach ($options as $filename) {
            if (file_exists($this->getSuite()->getModuleRoot() . '/' . $filename)) {
                $this->setSuccessful(true);
                break;
            }
        }
    }
}
