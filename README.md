# SilverStripe Addons

[![Build Status](https://travis-ci.org/silverstripe/addons.silverstripe.org.svg?branch=master)](https://travis-ci.org/silverstripe/addons.silverstripe.org)

This is the [SilverStripe](http://silverstripe.org) add-ons listing site project. It aggregates SilverStripe packages 
from [Packagist](http://packagist.org).

* [SilverStripe Add-ons](http://addons.silverstripe.org)
* [GitHub Project](https://github.com/silverstripe/addons.silverstripe.org)
* [Issue Tracker](https://github.com/silverstripe/addons.silverstripe.org/issues)

## Getting started

1. `git clone https://github.com/silverstripe/addons.silverstripe.org.git`
2. `cd` into the directory
3. `composer install`
4. Install elasticsearch `brew install elasticsearch` and configure if required
5. Start `elasticsearch`
6. Run all tasks to populate database (see below, first run may take some time to populate)

## Dependencies

### Environment variables

 * `SS_ADDONS_DOWNLOAD_PATH`: Set this to the full path of the folder to download into. Otherwise, a subfolder of the
   SilverStripe temp path will be used.

### ElasticSearch

[ElasticSearch](http://www.elasticsearch.org) is used to provide add-on package indexing and searching.

The configuration is already set up in `mysite/_config/injector.yml` and will use a different index depending on 
whether the site is on the production server (live) or on UAT or local development environment (test or dev).

 - Install with `brew install elasticsearch`
 - Start the server with `elasticsearch` in your terminal

You should run the elastic search reindex task to create the mappings after installation.

Once running you can run the `UpdateAddonsTask` to pull all SilverStripe modules from Packagist into the addons site.

### Queued Jobs

For extended add-on information such as parsed Readme content, a Queued Job is created during the `UpdateAddonsTask`.
Queued Jobs requires a cronjob to run - for more information [visit the module's wiki](https://github.com/symbiote/silverstripe-queuedjobs/wiki/Installing-and-configuring).

## Tasks

Run each of the following tasks in order the first time you set up the site to ensure you have a full database 
of modules to work with.

1. `framework/sake dev/tasks/UpdateSilverStripeVersionsTask`: Updates the available SilverStripe versions.
2. `framework/sake dev/tasks/UpdateAddonsTask`: Runs the add-on updater, and queues extended add-on builds.
3. `framework/sake dev/tasks/DeleteRedundantAddonsTask`: Deletes addons which haven't been updated
   from packagist in a specified amount of time, which implies they're no longer available there.
4. `framework/sake dev/tasks/BuildAddonsTask`: Manually build addons, downloading screenshots
   and a README for display through the website and run module ratings. There's no need to set up a cron job
   for this task if you're using the resque queue.
5. `framework/sake dev/tasks/SilverStripe-Elastica-ReindexTask`: Defines and refreshes the elastic search index.

## Front-end build tooling

The site uses [LESS](http://lesscss.org) for compiling CSS.

One way to compile it is through [Grunt](http://gruntjs.org), which requires you to install 
[NodeJS](http://nodejs.org) first.

```
npm install -g grunt grunt-cli
npm install --save-dev
```

To compile, run:

```
grunt less
```

To watch for file changes, run:

```
grunt watch
```

## API Endpoints

Addons has 3 endpoints that can be used to gather statistics about SilverStripe addons.

### Single Addon Ratings Endpoint

If required, you can access the JSON ratings data for a module:

```
$ curl http://addons.localhost/api/rating/yourvendor/yourmodule
{
    "success": true,
    "rating": 79
}
```

Add `?detailed` to return the details of the metric results:

```
$ curl http://addons.localhost/api/rating/yourvendor/yourmodule?detailed
{
    "success": true,
    "rating": 79,
    "metrics": {
        "good_code_coverage": 0,
        "great_code_coverage": 0,
        "has_code_of_conduct_file": 0,
        "has_code_or_src_folder": 5,
        "coding_standards": 10,
        "has_contributing_file": 2,
        "has_editorconfig_file": 5,
        "has_gitattributes_file": 2,
        "has_license": 5,
        "has_readme": 5,
        "travis_passing": 10
    }
}
```

### Multiple Addon Ratings Endpoint

If fetching ratings for multiple addons is required, it is recommended that you use fetch them in a single request:

```
$ curl http://addons.localhost/api/ratings?addons=vendorA/moduleA,vendorB/moduleB
{
    "success": true,
    "ratings": {
        "vendorA/moduleA": 79,
        "vendorB/moduleB": 77
    }
}
```

Note that the order of returned modules is not related to the order in the request.

### Supported Addons Endpoint

For a list of addons that are marked as supported you can use this endpoint:

```
$ curl http://addons.localhost/api/supported-addons
{
    "success": true,
    "addons": [
        "vendorA/moduleA",
        "vendorB/moduleB"
    ]
}
```

Whether an addon is supported or not is controlled by a boolean field on the `Addon` DataObject.
