# Application Structure

- [Introduction](#introduction)
- [The Root Directory](#the-root-directory)

<hr>

<a name="introduction"></a>
## Introduction

The structure for PyroCMS is nearly identical to [Laravel's application structure](https://laravel.com/docs/5.1/structure).

<a name="the-root-directory"></a>
## The Root Directory

For simplicity, we will only review additional root level directories.

    - addons
        - shared
        - {app_reference}
    - core
    - docs
    - resources
    - storage
        - streams

#### Addons

Any addons that are not included in the `composer.json` file can be added to the `addons` directory.

Shared addons can be accessed by any application in the PyroCMS installation while addons for a specific application are kept within their own directory.

    addons/shared   // Accessible by all applications
    addons/default  // Only accessible by the default application

Typically, project specific or non-reusable addons would live in either of these directories and be committed to your project's VCS.

#### Core Addons

All addons included in your projects `composer.json` file are loaded into the `core` directory.

#### Docs

All documentation for PyroCMS addons and packages lives within the `docs` directory in the root. This is where the getting started docs live for PyroCMS.

#### Resources

All system override files go in the `resources` folder. You can override config files as well as translation files currently.

#### Storage

Streams adds it's own storage directory. All volatile storage like compiled entry models and field type file dumps belong here. This directory should **not** be committed to your VCS.
