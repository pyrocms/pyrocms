<?php

	if($this->uri->segment(2))
	{
		echo lang('cp_admin_title');
		if(lang($this->uri->segment(2)))
		{
			echo ' | '.lang($this->uri->segment(2));
		}
		else
		{
			echo ' | '.ucwords($this->uri->segment(2));
		}
	}
	else
	{
		echo $this->settings->site_name.' | '.lang('cp_admin_title');
	}

	if($this->uri->segment(3))
	{
		if(lang($this->uri->segment(3)))
		{
			echo ' | '.lang($this->uri->segment(3));
		}
		else
		{
			if(!is_numeric($this->uri->segment(3)))
			{
				echo ' | '.ucwords($this->uri->segment(3));
			}
		}
	}

	if($this->uri->segment(4))
	{
		if(lang($this->uri->segment(4)))
		{
			echo ' | '.lang($this->uri->segment(4));
		}
		else
		{
			if(!is_numeric($this->uri->segment(4)))
			{
				echo ' | '.ucwords($this->uri->segment(4));
			}
		}
	}
