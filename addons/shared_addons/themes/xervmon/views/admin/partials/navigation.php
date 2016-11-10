<div class="nav-collapse collapse" style="height: 0px;"><ul class="nav">
	
	<li id="dashboard-link" style="padding-top: 5px;"><?php echo anchor('admin', lang('global:dashboard'), 'class="top-link  btn  btn-inverse'.( ! $this->module ? '  ' : '').'"style="padding:5px !important; "') ?></li>

		<?php 

		// Display the menu items.
		// We have already vetted them for permissions
		// in the Admin_Controller, so we can just
		// display them now.
		foreach ($menu_items as $key => $menu_item)
		{
			if (is_array($menu_item))
			{
				echo '<li class="dropdown"> <a href="'.current_url().'#" class="dropdown-toggle" data-toggle="dropdown" href="#">'.lang_label($key).' <b class="caret"></b></a><ul class="dropdown-menu">';

				foreach ($menu_item as $lang_key => $uri)
				{
					echo '<li> <a href="'.site_url($uri).'" class="">'.lang_label($lang_key).'</a></li>';

				}

				echo '</ul></li>';

			}
			elseif (is_array($menu_item) and count($menu_item) == 1)
			{
				foreach ($menu_item as $lang_key => $uri)
				{
					echo '<li>  <a href="'.site_url($menu_item).'" class="top-link no-submenu">'.lang_label($lang_key).'</a></li>';
				}
			}
			elseif (is_string($menu_item))
			{
				echo '<li> <a href="'.site_url($menu_item).'" class="top-link no-submenu">'.lang_label($key).'</a></li>';
			}

		}
	
		?>

</ul>
    </div>