<section class="title">
    
    <h4><?php echo lang('nav_group_create_title');?></h4>
    
</section>

<section class="item">

    <?php echo form_open('admin/navigation/groups/create', 'class="crud"'); ?>

	    <fieldset>	
		    <ul>
			    <li class="even">
				    <label for="title"><?php echo lang('nav_title_label');?></label>
				    <?php echo form_input('title', $navigation_group->title, 'class="text"'); ?>
			    </li>
		    
			    <li>
				    <label for="url"><?php echo lang('nav_abbrev_label');?></label>
				    <?php echo form_input('abbrev', $navigation_group->abbrev, 'class="text"'); ?>
			    </li>
		    </ul>
	    </fieldset>
	    
	    <div class="buttons padding-top">       
		    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	    </div>
        
    <?php echo form_close(); ?>
    
</section>
    
