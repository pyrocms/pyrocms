<!--
/**
 * Information
 */
-->	
<nav class="navbar-right" id="information">

    <div class="pull-left">

        <span>
            <?php echo $this->current_user->contact->first_name; ?>&nbsp;
            <?php echo $this->current_user->contact->last_name; ?> |
            <?php echo $this->current_user->email; ?><br>
        </span>

        <?php

        $my_groups = array();

        foreach($this->current_user->groups as $group)
            {
                $groups[] = $group->description;
            }

        ?>

        <?php echo '<span class="c-gray italic  ">'.implode(', ',$groups).'</span>'; ?>

    </div>


	<ul class="nav navbar-nav">

		<li>
			<a href="#" class="fa fa-search" data-hotkey="s" data-toggle="global-search"></a>
			<a href="#" class="hidden" data-hotkey="/" data-toggle="module-search"></a>
		</li>
	
		<?php if (! empty(ci()->module_details['help'])): ?>
		<li>
			<a href="<?php echo ci()->module_details['help']; ?>" target="_blank" class="fa fa-info-circle"></a>
		</li>
		<?php endif; ?>


		<li class="dropdown-submenu">
			<a href="#" class="dropdown-submenu user" data-toggle="dropdown">
                <img src="https://gravatar.com/avatar/<?php echo md5($this->current_user->email); ?>" class="avatar-sm"/>
			</a>

			<ul class="dropdown-menu animated fadeInTop">
				<li><a href="<?php echo site_url('edit-profile'); ?>"><?php echo lang('cp:edit_profile_label'); ?></a></li>
				<li><a href="<?php echo site_url('admin/logout'); ?>"><?php echo lang('cp:logout_label'); ?></a></li>
			</ul>
		</li>

	</ul>

</nav>