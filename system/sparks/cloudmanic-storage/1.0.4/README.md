# Cloudmanic Storage

A Codeigniter package for interfacing with different cloud storage solutions such as Rackspace CloudFiles and Amazon S3. Easily switch between providers without having to change your code. This package provides- uniform input and response.

## Requirements

1. PHP 5.1+
2. CodeIgniter 2.0.0+
3. CURL

## Cloud Storage Providers

- Rackspace Cloudfiles ::: [http://www.rackspace.com/cloud/cloud_hosting_products/files/](http://www.rackspace.com/cloud/cloud_hosting_products/files/)

- Amazon.com S3 ::: [http://aws.amazon.com/s3/](http://aws.amazon.com/s3/)


## Sparks

This package was built to be used with [http://getsparks.org/](http://getsparks.org/). It should work as a stand alone Codeigniter 3rd party package as well.

## Usage

Best way to get started is to checkout the example controller in controllers/example.php. You can see complete examples from Amazon & Rackspace.

You can always use a symlink from your controller to the package. For example if you are using [http://getsparks.org/](http://getsparks.org/) you could do this to run the test controller.

```
ln -s application/sparks/cloudmanic-storage/1.0.0/controllers/example.php  application/controllers/example.php
```

Don't forget to setup your config/storage.php. You have to enter your different API keys for the different supported providers.

After setting up your keys you need to select a storage driver (or providers)

```
$this->load->spark('cloudmanic-storage/1.x.x');
$this->storage->load_driver('rackspace-cf'); // rackspace-cf or amazon-s3
```

## Functions 

### create_container()

Create a new container with the provider. Second argument is either "private or public". This would trigger if the container can be accessed publicly without authentication or not. Note: Amazon s3 calls containers buckets, just to clear up any confusion.  

```
$this->storage->create_container($container, 'private');
```

### list_containers()

Returns an array of container names from the provider.

```
$this->storage->list_containers();
```

### upload_file()

This function takes 3 arguments the name of the container you are uploading the file to. The full file system path to the file you are uploading, and the name the file will be stored as.  


```
$this->storage->upload_file('container-name', '/tmp/test01.jpg', 'test01.jpg');
```

### get_authenticated_url()

This function is primarily for Amazon s3 because Rackspace does not support this feature. You can pass in a container name, file name, and expiration time in seconds. This function then will return a public URL to the file. The url will no longer be available after the expiration time. 

Since Rackspace does not support this feature, this function will still work but it calls a custom library method you set in the configuration. The idea behind this is you can create your own controller that downloads the file from Rackspace Cloud Files and delivers the file to the user. You more or less build your own custom authentication layer. For an example of this custom wrapper class check out libraries/rackspace_cf_url.php. In this example you would set this config to the following. $config['storage']['cf_auth_url'] = array('library' => 'Rackspace_Cf_Url', 'method' => 'get_url'); It uses the Codeigniter library loader to load this library.

```
$this->storage->get_authenticated_url('container-name', 'test01.jpg', 60);
```

### list_files()

This function returns a list files that live within the container that is passed in. Additional data such as name, url, md5 hash, and more is also included. 

```
$this->storage->list_files('container-name');
```

### delete_file()

Delete a file from the provider. We pass in a container name and a file name. This file will be deleted forever.

```
$this->storage->delete_file('container-name', 'test01.jpg');
```

### delete_container()

Delete a container. The files within that container must be deleted first.


```
$this->storage->delete_container('container-name');
```

## Author(s) 

* Company: Cloudmanic Labs, [http://cloudmanic.com](http://cloudmanic.com)

* By: Spicer Matthews [http://spicermatthews.com](http://spicermatthews.com)
