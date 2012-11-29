<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Overview</h6><hr>
<p>The files module is an excellent way for the site admin to manage the files in use on the site.
All images or files that are inserted into pages, galleries, or blog posts are stored here.
For page content images you may upload them directly from the WYSIWYG editor or you can upload them here and just insert them via WYSIWYG.</p>
<p>The files interface works much like a local file system: it uses the right click to show a context menu. Everything in the middle pane is clickable.</p>

<h6>Managing Folders</h6>
<p>After you create the top level folder or folders you may create as many subfolders as you need such as blog/images/screenshots/ or pages/audio/.
The folder names are for your use only, the name is not displayed in the download link on the front end.
To manage a folder either right click on it and select an action from the resulting menu or double click on the folder to open it.
You can also click on folders in the left column to open them.</p>
<p>If cloud providers are enabled you will be able to set the location of the folder by right clicking on the folder and then selecting Details.
You can then select a location (for example \"Amazon S3\") and put in the name of your remote bucket or container. If the bucket or container does
not exist it will be created when you click Save. Note that you can only change the location of an empty folder.</p>

<h6>Managing Files</h6>
<p>To manage files navigate to the folder using the folder tree in the left column or by clicking on the folder in the center pane.
Once you are viewing the files you may edit them by right clicking on them. You can also order them by dragging them into position. Note
that if you have folders and files in the same parent folder the folders will always be displayed first followed by the files.</p>

<h6>Uploading Files</h6>
<p>After right clicking the desired folder an upload window will appear.
You may add files by either dropping them in the Upload Files box or by clicking in the box and choosing the files from your standard file dialog.
You can select multiple files by holding your Control/Command or Shift key while clicking them. The selected files will display in a list at the bottom of the screen.
You may then either delete unnecessary files from the list or if satisfied click Upload to start the upload process.</p>
<p>If you get a warning about the files size being too large be advised that many hosts do not allow file uploads over 2MB.
Many modern cameras produce images in exess of 5MB so it is very common to run into this issue.
To remedy this limitation you may either ask your host to change the upload limit or you may wish to resize your images before uploading.
Resizing has the added advantage of faster upload times. You may change the upload limit in
CP > Files > Settings also but it is secondary to the host's limitation. For example if the host allows a 50MB upload you can still limit the size
of the upload by setting a maximum of \"20\" (for example) in CP > Files > Settings.</p>

<h6>Synchronizing Files</h6>
<p>If you are storing files with a cloud provider you may want to use the Synchronize function. This allows you to \"refresh\"
your database of files to keep it up to date with the remote storage location. For example if you have another service
that dumps files into a folder on Amazon that you want to display in your weekly blog post you can simply go to your folder
that is linked to that bucket and click Synchronize. This will pull down all the available information from Amazon and
store it in the database as if the file was uploaded via the Files interface. The files are now available to be inserted into page content,
your blog post, or etc. If files have been deleted from the remote bucket since your last Synchronize they will now be removed from
the database also.</p>

<h6>Search</h6>
<p>You may search all of your files and folders by typing a search term in the right column and then hitting Enter. The first
5 folder matches and the first 5 file matches will be returned. When you click on an item its containing folder will be displayed
and the items that match your search will be highlighted. Items are searched using the folder name, file name, extension,
location, and remote container name.</p>";