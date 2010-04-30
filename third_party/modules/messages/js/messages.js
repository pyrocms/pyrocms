jQuery(document).ready(function()
{
	jQuery("#check_all_action").click(function()
	{
		var checked_status = this.checked;
		jQuery("input[name=action]").each(function()
		{
			this.checked = checked_status;
		});
	});
});