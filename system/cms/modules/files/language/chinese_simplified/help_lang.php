<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Chinese Simpplified translation.
 *
 * @author		Kefeng DENG
 * @package		PyroCMS
 * @subpackage 	File Module
 * @category	Modules
 * @link		http://pyrocms.com
 * @date		2012-06-22
 * @version		1.0
 */
// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>概观</h6><hr>
<p>文件模块是一个很好的方式，为网站管理员在网站上使用的文件管理。
页，画廊，博客文章中插入图像或文件都存储在这里。
对于页面内容的图像，你可以上传他们的所见即所得的编辑器直接从他们在这里你可以上传，只需插入他们通过所见即所得.</p>
<p>文件的界面很像一个本地文件系统，它使用右键显示上下文菜单。在中间窗格中的一切都是可点击的。</p>

<h6>管理文件夹</h6>
<p>在创建顶级文件夹或文件夹，你可以创建多个子文件夹，你需要，如博客/图片/截图/或网页/音频/。
您使用的文件夹名称，名称不显示在前端的下载链接。
管理文件夹右击它并选择从菜单或文件夹，双击打开它的行动。
你也可以点击左栏中的文件夹，打开它们。</p>
<p>如果启用了云提供商，您将可以设置文件夹的位置，右击文件夹，然后选择详情。
然后，您可以选择一个位置（例如\“亚马逊S3\”）把远程桶或容器的名字。如果桶或容器
不存在将创建当您单击保存。请注意，你只能改变一个空文件夹的位置。</p>

<h6>管理文件</h6>
<p>管理文件，浏览到的文件夹，在左侧立柱上的文件夹在中间窗格中点击文件夹树。
一旦您正在查看的文件，通过右键点击它们，你可以编辑他们。你还可以订购他们拖入他们的位置。注意
这如果你有相同的父文件夹的文件夹和文件夹将总是首先显示文件。</p>

<h6>上传文件</h6>
<p>上传窗口，右键单击所需的文件夹后会出现。
您可以通过拖放上传文件框，或在框中单击并选择您的标准文件对话框的文件添加文件。
由持有控制/命令或Shift键的同时点击，您可以选择多个文件。选定的文件将显示在屏幕底部的列表。
然后，您可以删除不必要的文件从列表或如果满意单击Upload开始上传过程。
</p>
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