(function($) {

	var PyroTreeCookie = {
		config : {
			name : 'page_parent_ids'
		},
		_set : function(name, val, expiredays){
			expiredays = expiredays || 1;
			var exdate=new Date();
			exdate.setDate(exdate.getDate()+expiredays);
			document.cookie = name+"="+escape(val)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
		},
		_get : function(name){
			if (document.cookie.length>0){
				var start = document.cookie.indexOf(name+"=");
				if (start != -1){
					start = start+name.length+1;
					var end = document.cookie.indexOf(";", start);
					if (end == -1){
						end = document.cookie.length;
					}
					return $.trim(unescape(document.cookie.substring(start, end)));
				}
			}
			return '';
		},
		addPage : function(page_id){
			var ids = this._get(this.config.name);
			ids = (ids != '' ? (ids.indexOf(",") != -1 ? ids.split(",") : [ids]) : []);
			// check id doesn't already exist
			for(var i=0; i<ids.length; i++) if (ids[i] == page_id) return; 
			// add parent id to array
			ids.push(page_id);
			// save csv string to cookie
			this._set(this.config.name, ids.join(","));
		},
		removePage : function(page_id){
			var self = this, newids = [], ids = this._get(this.config.name);
			ids = (ids != '' ? (ids.indexOf(",") != -1 ? ids.split(",") : [ids]) : []);
			// remove id from array 
			for(var i=0; i<ids.length; i++) {
				(ids[i] != page_id) && newids.push(ids[i]);
			}
			// save csv string to cookie
			this._set(this.config.name, newids.join(","));
		}
	};
	
	
	$(function(){

		var page_tree = $("div#page-tree > ul");
		page_tree.treeview({
			toggle: function() {
				expandTree(this);
				return false;
			}
		});

	
		function expandTree(item)
		{
			// Define elements
			li = $(item);
			span = li.children('span');
			a = span.children('a');
			other_a = page_tree.find('span > a');
			
			var page_id = a.attr('rel').replace('page-', '');
		
			// Change which link is selected
			other_a.removeClass('selected');
			a.addClass('selected');
		
			// Folder eh? Let's do cool stuff
			if(span.hasClass('folder'))
			{
				child_ul = $('ul', li);
		
				// This is being expanded (and therefore the class has switched to collapseable to show that it is now opened)
				if(li.hasClass('collapsable'))
				{
					// We have already AJAXed in the contents of this folder
					if( child_ul.children().length == 0 )
					{
						$.get(BASE_URI + 'admin/pages/ajax_fetch_children/' + page_id, function(data){
							var branches = $(data).appendTo(child_ul);
							page_tree.treeview({
								add: branches
							});
						});
						
						$('li span', page_tree).unbind('click');
					}
					PyroTreeCookie.addPage(page_id);
				} else {
					PyroTreeCookie.removePage(page_id);
				}
			}
			
		}
		
		$('.filetree li span', page_tree).unbind('click');
		$('.filetree li a', page_tree).live('click', function()
		{
			a = $(this);
			other_a = page_tree.find('span > a');

			// Change which link is selected
			other_a.removeClass('selected');
			a.addClass('selected');
			
			page_id = $(this).attr('rel').replace('page-', '');
			
			// Update the "Details" panel
			$('div#page-details').load(BASE_URI + 'admin/pages/ajax_page_details/' + page_id);
			
			
			return false;
		});

	});
  
})(jQuery);
