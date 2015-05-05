# PyroCMS

PyroCMS is an easy to use, abstracted, and modular CMS built using Laravel. If you are looking for the original CodeIgniter version of PyroCMS please see the [2.2/develop branch].

[2.2/develop branch]: https://github.com/pyrocms/pyrocms/tree/2.2/develop

### Install istructions

````bash
cd /path/to/some/folder

git clone -b 3.0/develop https://github.com/pyrocms/pyrocms.git .

// for now install the develop dependencies too, otherwise it
// won't work (Notice: it can take some time to install)
composer install

// after composer installing has finished
// goto pyrocms installation vhost (in my case http://pyro.app)
// or you can run built in web-server, like:
php artisan serve

// and now navigate to http://localhost:8000
// and follow the installer

```
