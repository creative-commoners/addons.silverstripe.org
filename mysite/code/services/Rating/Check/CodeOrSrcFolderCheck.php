<?php

namespace SilverStripe\Addons\Services\Rating\Check;

use SilverStripe\Addons\Services\Rating\Check;

class CodeOrSrcFolderCheck extends Check
{
    protected $points = 5;

    public function getKey()
    {
        return 'has_code_or_src_folder';
    }

    public function run()
    {
        $options = ['code', 'src'];
        foreach ($options as $folder) {
            if (file_exists($this->getSuite()->getModuleRoot() . '/' . $folder)) {
                $this->setSuccessful(true);
            }
        }
    }
}
