# Installation

- [Installation](#installation)
    - [Installing PyroCMS](#installing-pyrocms)
    - [Directory Permissions](#directory-permissions)
    - [Running The Installer](#installer)
    - [Post Installation](#post-installation)

<a name="installation"></a>
## Installation

### Server Requirements

PyroCMS has a few system requirements:

- PHP >= 5.5.9
- PDO PHP Extension
- cURL PHP Extension
- OpenSSL PHP Extension
- Mbstring PHP Extension
- Fileinfo PHP Extension
- Tokenizer PHP Extension
- GD Library (>=2.0) **OR** Imagick PHP extension (>=6.5.7)


<a name="installing-pyrocms"></a>
### Installing PyroCMS

PyroCMS utilizes [Composer](http://getcomposer.org) to manage its dependencies. So, before using PyroCMS, make sure you have Composer installed on your machine.

<div class="alert alert-danger">
<strong>Heads Up:</strong> Do not create a .env file just yet - Pyro's installer will generate one for you.
</div>

#### Via Composer Create-Project

You may install PyroCMS by issuing the Composer `create-project` command in your terminal:

    composer create-project pyrocms/pyrocms

If you are using a Windows environment, you might run into issues with the length of paths when unzipping packages. To avoid this issue, use the `--prefer-source` flag instead.

<a name="directory-permissions"></a>
### Directory Permissions

After installing, you may need to configure some permissions in order to proceed. Directories within the `storage`, `public/app`, and the `bootstrap/cache` directories should be writable by your web server. If you are using the [Homestead](http://laravel.com/docs/5.1/homestead) virtual machine, these permissions should already be set.

**If, when trying to access the installer below, you get a white screen. Your permissions are misconfigured.**

<a name="installer"></a>
### Running The Installer

After downloading and installing PyroCMS and it's dependencies, you still need to install the software in order to get started. By this time you should be able to visit your site's URL which will cause you to be redirected to the installer.

<a name="post-installation"></a>
### Post Installation

Upon logging in the first time after installation you will notice the suggestion to delete the Installer module. To do this simply remove the `"anomaly/installer-module"` requirement from your project's `composer.json` file and run `composer update`.

If you are not using composer going forward you can simply delete `/core/anomaly/installer-module` from your Pyro installation.
