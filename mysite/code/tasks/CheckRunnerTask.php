<?php

class CheckRunnerTask extends BuildTask
{
    public function run($request)
    {
        $runner = new \SilverStripe\Addons\Services\Rating\CheckSuite();

        $runner->setModuleRoot('/var/folders/56/sc0m6m9d7z55w_h22ztly_1m0000gn/T/silverstripe-cache-php7.0.22-Users-robbieaverill-dev-addons.silverstripe.org/robbieaverill/add-ons/silverstripe/iframe');
        $runner->setRepositorySlug('silverstripe/silverstripe-iframe');
        $runner->run();
        var_dump($runner->getScore()  . ' out of 100');
        print_r($runner->getCheckDetails());
    }
}
