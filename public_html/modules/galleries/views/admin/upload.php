<h2>Photos in this Gallery</h2>

<div id="photos">

 <?
if ($photos) {
    echo form_open('admin/galleries/deletephoto');
    foreach($photos as $photo){
    	// echo '<a href="/assets/img/galleries/' . $this->uri->segment(4) . '/' . $photo->filename . '" title="' . $photo->description . '">' . image('galleries/' . $this->uri->segment(4) . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), $photo->description) . '</a><br />' . $photo->description . '<p></p>';
    	echo "<div style=\"float:left;margin:5px;text-align:center;";
    	echo "\"><input type=\"checkbox\" name=\"delete[".$photo->id."]\" /><br>".image('galleries/' . $this->uri->segment(4) . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description))."<br>";

    	echo "</div>";
 	
     }
		echo "<div class='clear'></div><p>&nbsp;</p>";
		echo "<input type='submit' name='btnDelete' value='Delete Selected' />";
		echo "</form>";
        } else {
            echo 'There are no photos in this gallery.';
        }?>

        </div>

<div class="clear-both"></div>
<p>&nbsp;</p>
<h2>Add a Photo</h2>

<? $attributes = array('id' => 'gallery-upload-form'); ?>
    <?= form_open_multipart('admin/galleries/upload/' . $this->uri->segment(4), $attributes); ?>

<div class="field">
	<label>Photo</label>
	<input type="file" class="text" name="userfile" id="userfile" />
</div>

<div class="field">
	<label>Description</label>
	<input type="text" class="text" name="description" id="description" maxlength="100" />
</div>

<p>
	<input type="image" src="/assets/img/admin/fcc/btn-save.jpg" value="Save" name="btnSave" class="fcc-submit-btn" />
	 or 
	<?= anchor('admin/galleries/index', 'Cancel'); ?>
</p>

<?= form_close(); ?>