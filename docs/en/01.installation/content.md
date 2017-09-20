---
title: Installation
---

## Installation[](#installation)

This section will go over what you need to install PyroCMS and how to do it.

<div class="alert alert-danger">**Heads Up:** Looking for documentation on developing with PyroCMS? Have a look at documentation for Pyro's engine, the [Streams Platform](/documentation/streams-platform).</div>



### Server Requirements[](#installation/server-requirements)

PyroCMS has a few system requirements:

*   PHP >= 7.0 (5.6.4 for v3.3)
*   PDO PHP Extension
*   cURL PHP Extension
*   SQLite PHP Extension
*   OpenSSL PHP Extension
*   Mbstring PHP Extension
*   Fileinfo PHP Extension
*   Tokenizer PHP Extension
*   GD Library (>=2.0) **OR** Imagick PHP extension (>=6.5.7)



### Server Configuration[](#installation/server-configuration)

This section will go over a few basics of setting up your server for a Laravel application like PyroCMS.



#### NGINX Example[](#installation/server-configuration/nginx-example)

Below is an example NGINX configuration:

<div class="alert alert-info">**Notice:** The web root should be set to your installation's **public** directory.</div>

    # --------------------------
    #
    # Redirect non-www > www
    #
    # --------------------------

    server {
        listen      80;
        listen      443 ssl;
        server_name www.example.com;
        return 301 http://example.com$request_uri;
    }

    # --------------------------
    #
    # Redirect to HTTP > HTTPS
    #
    # --------------------------

    #server {
    #    listen      80;
    #    server_name example.com www.example.com;
    #    return      301 https://example.com$request_uri;
    #}

    server {
        listen      80;
        listen      443 ssl;

        server_name example.com;

        access_log /var/log/nginx/example.com_access_log combined;
        error_log /var/log/nginx/example.com_error_log error;

        index  index.php index.html;

        charset utf-8;

        root /var/www/vhosts/example.com/www.example.com/public;

        ssl_certificate      /var/www/vhosts/example.com/ssl/example.com.crt;
        ssl_certificate_key  /var/www/vhosts/example.com/ssl/example.com.key;

        gzip on;
        gzip_static on;
        gzip_http_version 1.0;
        gzip_disable "MSIE [1-6].";
        gzip_vary on;
        gzip_comp_level 9;
        gzip_proxied any;
        gzip_types text/plain text/css application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript image/svg+xml;

        fastcgi_intercept_errors off;
        fastcgi_buffers 8 16k;
        fastcgi_buffer_size 32k;
        fastcgi_read_timeout 180;

        # Remove trailing slashes
        rewrite ^/(.*)/$ /$1 permanent;

        expires $expires;

        location / {
            try_files $uri $uri/ /index.php?$args;
        }

        location ~ \.php$ {

            fastcgi_pass unix:/var/run/php-fpm-default.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;

            include        fastcgi_params;
        }

        location ~ /\.ht {

            access_log off;
            log_not_found off;

            deny all;
        }

        location ~* \.ico$ {

            expires 1w;
            access_log off;
        }

        location ~* \.(?:jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|eot|mp4|ogg|ogv|webm)$ {

            try_files $uri $uri/ /index.php?$query_string;

            access_log off;
            log_not_found off;
        }

        location ~* \.(?:css|js)$ {

            try_files $uri $uri/ /index.php?$query_string;

            access_log off;
            log_not_found off;
        }

        add_header "X-UA-Compatible" "IE=Edge,chrome=1";
    }



### Installing PyroCMS[](#installation/installing-pyrocms)

PyroCMS utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using PyroCMS, make sure you have Composer installed on your machine.

<div class="alert alert-danger">**Heads Up:** Do not create a .env file just yet - Pyro's installer will generate one for you.</div>



#### Via Installer[](#installation/installing-pyrocms/via-installer)

First, download the PyroCMS installer using Composer:

    composer global require "pyrocms/installer"

Make sure to place the `$HOME/.composer/vendor/bin directory` (or the equivalent directory for your OS) in your `$PATH` so the `pyro` executable can be located by your system.

Once installed, the `pyro new` command will create a fresh PyroCMS installation in the directory you specify.

For instance, `pyro new website.dev` will create a directory named `website.dev` containing a fresh Pyro installation with all of Pyro's dependencies already installed:

    pyro new website.dev

You can specify a specific version with the `tag` option and also include VCS sources with the `dev` option.

    pyrocms new website.dev --tag=3.2.0 --dev



#### Via Composer[](#installation/installing-pyrocms/via-composer)

You may install PyroCMS by issuing the Composer `create-project` command in your terminal:

    composer create-project pyrocms/pyrocms

If you are using a Windows environment, you might run into issues with the length of paths when unzipping packages. To avoid this issue, use the `--prefer-source` flag.



#### Host Configuration[](#installation/installing-pyrocms/host-configuration)

When you setup your web host be sure to point the web root to Pyro's `public` directory. Just as you would a normal Laravel installation.



#### Directory Permissions[](#installation/installing-pyrocms/directory-permissions)

After installing, you may need to configure some permissions in order to proceed. Directories within the `storage`, `public/app`, and the `bootstrap/cache` directories should be writable by your web server. If you are using the [Homestead](http://laravel.com/docs/5.3/homestead) virtual machine, these permissions should already be set.

**If, when trying to access the installer below, you get a white screen. Your permissions are misconfigured.**



#### Running the Installer[](#installation/installing-pyrocms/running-the-installer)

After downloading and installing PyroCMS and it's dependencies, you will need to install the software in order to get started. By this time you should be able to visit your site's URL which will redirect you to the installer: `http://example.com/installer`



##### Using the CLI Installer[](#installation/installing-pyrocms/running-the-installer/using-the-cli-installer)

Pyro comes with a CLI installer you can use if you like by running the following command:

    php artisan install

You will be prompted for details in order to proceed with the installation process.



##### Automating the CLI Installer[](#installation/installing-pyrocms/running-the-installer/automating-the-cli-installer)

You can automate the installer by creating your own .env file with something like this:

    APP_ENV=local
    APP_DEBUG=true
    APP_KEY=zfesbnTkXvooWVcsKMw2r4SmPVNGbFoS
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_DATABASE=workbench
    DB_USERNAME=root
    DB_PASSWORD=root
    APPLICATION_NAME=Default
    APPLICATION_REFERENCE=default
    APPLICATION_DOMAIN=localhost
    ADMIN_EMAIL=ryan@pyrocms.com
    ADMIN_USERNAME=admin
    ADMIN_PASSWORD=password
    LOCALE=en
    TIMEZONE=UTC

Then run the installer and indicate that the system is ready to install:

    php artisan install --ready

<div class="alert alert-danger">**Heads Up!** The APP_KEY must be exactly 32 characters in length.</div>



##### Using the cURL Installer[](#installation/installing-pyrocms/running-the-installer/using-the-curl-installer)

Pyro also comes with a cURL installer you can use by executing the following CLI command:

    curl -L --max-redirs 100 "http://example.com/installer/process?database_driver=mysql&database_host=localhost&database_name=workbench&database_username=root&database_password=root&admin_username=admin&admin_email=ryan%40pyrocms.com&admin_password=password&application_name=Default&application_reference=default&application_domain=workbench.local%3A8888&application_locale=en&application_timezone=UTC&action=install"

If desired you can make a browser request to the same URL and append `&verbose=true` to load the installer directly without a GUI.



#### Post Installation[](#installation/installing-pyrocms/post-installation)

Upon logging in the first time after installation you will notice the suggestion to delete the Installer module. To do this simply remove the `"anomaly/installer-module"` requirement from your project's `composer.json` file and run `composer update`.

If you are not using composer going forward you can simply delete `/core/anomaly/installer-module` from your Pyro installation.



### Installing Addons[](#installation/installing-addons)

Pyro comes with a few different ways you can include additional addons in your project.



#### Installing Addons Manually[](#installation/installing-addons/installing-addons-manually)

You can manually install addons by copying the addon folder into the appropriate vendor folder in `addons/{APPLICATION_REF}/{VENDOR}` for a specific application or `addons/shared/{VENDOR}` to allow all applications access to the addon.



#### Installing Addons with Composer[](#installation/installing-addons/installing-addons-with-composer)

Addons can be installed with Composer by including the addon in your root `composer.json` file like a normal package.

Addons installed this way will be considered a core component of your core project and as such will be downloaded to the `core` directory.

    {
        "require": {
            ...
            "anomaly/repeater-field_type": "~1.2.0"
        }
    }



#### Installing PRO Addons with Composer[](#installation/installing-addons/installing-pro-addons-with-composer)

You can install PRO and private addons in general with Composer as well. Simply add the repository to your root `composer.json` file as well as the require line:

    "require": {
        ...
        "anomaly/forms-module": "~1.1.0",
        "anomaly/standard_form-extension": "dev-master",
    }

If your installation is older or otherwise does not already have [https://packages.pyrocms.com/](https://packages.pyrocms.com/) included then you can add it now or use the older approach using VCS type repositories:

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/anomalylabs/standard_form-extension"
        },
        {
            "type": "vcs",
            "url": "https://github.com/anomalylabs/forms-module"
        }
    ]



##### GitHub Authentication for Composer[](#installation/installing-addons/installing-pro-addons-with-composer/github-authentication-for-composer)

When deploying PRO addons to servers using composer you will need to authorize Composer to access PRO addons on your behalf. To do this you will need to [create a new personal access token](https://github.com/settings/tokens/new?scopes=repo&description=PyroCMS) and install it on your remote:

    composer config -g github-oauth.github.com <oauthtoken>
