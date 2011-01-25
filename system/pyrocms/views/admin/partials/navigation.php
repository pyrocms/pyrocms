<nav id="main-nav">

	<ul>
		<li><?php echo anchor('admin', lang('cp_admin_home_title'), 'class="top-link no-submenu' . (!$this->module > '' ? ' current' : '').'"');?></li>
		
        
        <?php
		
		foreach($menu_items as $menu_item){
			
			$display = '';
			
			foreach($modules[$menu_item] as $module){
				
				if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'){
					
					$display = 1;
				
				}
				
			}
				
			if($display === 1){
				
				?>
				
				<li><a href="#" class="top-link <?php echo ($this->module_details AND $this->module_details['menu'] == $menu_item) ? 'current' : ''; ?>">
				<?php
				
					if(lang('cp_nav_'.$menu_item)!=''&&lang('cp_nav_'.$menu_item)!=NULL){
						echo lang('cp_nav_'.$menu_item);	
					}
					else{
						echo $menu_item;
					}				
				?>
                </a>
                    <ul>
                    <?php
                    
                    ksort($modules[$menu_item]);
                    foreach ($modules[$menu_item] as $module){
                        
                        if(in_array($module['slug'], $this->permissions) OR $this->user->group == 'admin'){
                        
                            if(lang('cp_nav_'.$module['name'])!=''&&lang('cp_nav_'.$module['name'])!=NULL){
                                $module['name'] = lang('cp_manage_'.$module['slug']);	
                            }
                            ?>
                            <li><?php echo anchor('admin/'.$module['slug'], $module['name'], ($this->module == $module['slug']) ? 'class="current"' : '');?></li>                                         
                        <?php
                        
                        }					
                    }
                    
                    ?>
                    </ul>
                </li>
                <?php
			}
		}
		
		if(in_array('settings', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/settings', lang('cp_nav_settings'), 'class="top-link no-submenu' . (($this->module == 'settings') ? ' current"' : '"'));?></li>
		<?php endif; ?>
		
		<?php if(in_array('modules', $this->permissions) OR $this->user->group == 'admin'): ?>
		<li><?php echo anchor('admin/modules', lang('cp_nav_addons'), 'class="last top-link no-submenu' . (($this->module == 'modules') ? ' current"' : '"'));?></li>
		<?php endif; ?>        
        
	</ul>
</nav>