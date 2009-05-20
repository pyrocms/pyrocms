/*
 * Ajaxify - jQuery Plugin
 * version: 2.00 (11/12/2008)
 * Created by: MaX
 * Examples and documentation at: http://max.jsrhost.com/ajaxify/
 * licensed under and GPL licenses:
 * http://www.gnu.org/licenses/gpl.html
 */

(function($){


jQuery.AjaxifyDefaults = {  
		event:'click', /*specify the event*/
		link:false, /* specify the link, priority is for the href attr.*/
		target:'#container', /*the data loaded via ajax will be placed here*/
		animateOut:false,
		animateIn:false,
		animateOutSpeed:'normal',
		animateInSpeed:'normal',
		method: 'GET', /* the request method GET or POST*/
		tagToload:false, /* inserts just the tag from the data loaded, it can be specified as t a second argument in the 'target' attr(#box,#result)*/
		loading_txt:'',
		loading_img:"images/loading.gif",
		loading_target: false,
		loading_fn:function(options){
			jQuery.ajaxifyLoading(options);
		},
		loadHash:false,	/* for use this to resolve bookmarking issues, see example for more details*/
		title:false, /* change page title along with the request. */
		forms:false, /* send form data along with th request (forms, input , radio ... etc jquery selector) */
		params:'ajax=true',/*extend parameters for the webpage. it can be set to function since v2*/
		timeout:false, /*in ms.  there is a problem in this option on linux servers*/
		contentType:"application/x-www-form-urlencoded",
		dataType:'html',
		cache:false, /* force the browser not to cache*/
		username:false, /*username HTTP access authentication*/
		password:false, /*password HTTP access authentication*/
		onStart:function(op){}, /* a callback function before start requesting.*/
		onError:function(op){
			jQuery.ajaxifyManip(op,"<font style='color: #CC0000'>Error: </font> Couldn't open the page.");		
		}, /* a callback function if error happened while requesting*/
		onSuccess:function(op){},/* a callback function if the request finished successfuly*/
		onComplete:function(op){}//*a callback function when the request finished weather it was a successful one or not.*/
	};
jQuery.AjaxifyFirstLoad = true;
jQuery.AjaxifyhistorySet = new Object();
jQuery.AjaxifyPageTitle = document.title;
jQuery.AjaxifyDebug = false;



jQuery.fn.ajaxify = function(options) {  
	if(!jQuery(this).size()){
		jQuery.ajaxifylog('Error: No matched element/s for your ajaxify selector " '+jQuery(this).selector+' ".');
		return false;
	}
	/*var ver = jQuery.fn.jquery.split('.');
	if(ver[0] < 1 || ver[1] < 2 || ver[2] < 6){
		jQuery.ajaxifylog('Error: Your jQuery version is old. Version 1.2.6 or newer is required.');
		return false;
	}*/
	return this.each(function() {
	var current = jQuery.extend({},jQuery.AjaxifyDefaults, options);
	if(jQuery.metadata){
	current = jQuery.extend(current,jQuery(this).metadata());
	}
	
	
	if(current.event){
		jQuery(this).bind(current.event,function(){		
			jQuery(this).ajaxifyAnalyse(current);
			if(!current.hash)
				jQuery.ajaxifyLoad(current);
			else{
				jQuery.ajaxifyHash(current);
			}
			 //stop browser
			if(jQuery(this).is('a') || jQuery(this).is('form')) return false;
		});
	}else{
		jQuery(this).ajaxifyAnalyse(current);
		jQuery.ajaxifyLoad(current);		
	}	
		//for bookmarking	
		if(current.loadHash  && jQuery.AjaxifyFirstLoad){
			jQuery(this).ajaxifyAnalyse(current);
			if(document.location.hash.replace(/^#/, '') == current.hash	&& current.hash){
				jQuery.ajaxifyHash(current);
				jQuery.AjaxifyFirstLoad = false;
			}
		}
		
  }); // end each fn 
}; // end ajaxify fn


 

 
jQuery.fn.ajaxifyAnalyse = function(current){
	current.object = this;
	if(jQuery(this).is('a')){
		if(jQuery(this).attr('href')){
			//if(jQuery.browser.msie)
				//var link = jQuery(this).attr('href').replace(/^#/, "");
			//else
				var link = jQuery(this).attr('href').replace(/^#/, "");
				//alert(link);
			current.link = link || current.link;
		}else 
			current.link;
			
		if(typeof current.tagToload != 'object')
			if(jQuery(this).attr('target'))
				current.target = jQuery(this).attr('target');
			else
				current.target;
		else
			current.target = current.loading_target || '#AjaxifyTemp';
	}
	   
	if(!current.loading_target)
	   current.loading_target = current.target;
	   

	if(current.forms){
		var text = jQuery(current.forms).serialize();
		current.paramres = text;
	}
	
	if(typeof current.params == 'function')
		var params = current.params(current);
	else
		var params = current.params;

	if(typeof params == 'string'){
		if(text)
		current.paramres +='&'+params;
		else
		current.paramres = params;
	}
	
	var len = current.target.length-1;
	if(typeof current.tagToload !='object')
		if(current.target.charAt(len) == '+' || current.target.charAt(len)=='-'){
			current.manip = current.target.charAt(len);
			current.target = current.target.substr(0,len);
		}

   	if(current.loadHash){
		if(!jQuery.historyInit){
			jQuery.ajaxifylog('Error: loadHash is enabled but history plugin couldn\'t be found.');
		return false;
		}
		
		if(current.loadHash === true){
			jQuery.ajaxifylog('Info: It seemes you are upgrading from v1.0. Please see the new documentation about loadHash. "attr:href" will be used instead of "true".');
			current.loadHash = "attr:href";
		}
		if(current.loadHash.toLowerCase() == 'attr:href' || 
			current.loadHash.toLowerCase() == 'attr:rel' ||
			current.loadHash.toLowerCase() == 'attr:title'){
			
			current.loadHash = current.loadHash.toLowerCase();
			current.hash = jQuery(this).attr(current.loadHash.replace('attr:',''));
			if(jQuery.browser.opera){
				current.hash = current.hash.replace('?','%3F');
				current.hash = current.hash.replace('&','%26');
				current.hash = current.hash.replace('=','%3D');
			}
		}else
			current.hash = current.loadHash;
		
		if(!current.hash)
			jQuery.ajaxifylog('Warning: You have specified loadHash, but its empty or attribute couldn\'t be found.');
	}
	
	if(!jQuery(current.target).size() && typeof current.tagToload !='object')
		jQuery.ajaxifylog('Warning: Target " '+current.target+' " couldn\'t be found.');
 	

};

 


jQuery.ajaxifyLoading = function(options){
	var html = "<div id='AjaxifyLoading'><img src='"+options.loading_img+"' alt='Loading...' title='Loading...' >"+options.loading_txt+"</div>";
	if(options.loading_target)
		jQuery.ajaxifyManip(options.loading_target,html);
	else
		jQuery.ajaxifyManip(options,html);
}





jQuery.ajaxifyHash = function(current){
	var ob = new Object();
	jQuery.each(current, function(key, value) {
		ob[key] = value;
	});
	jQuery.AjaxifyhistorySet[ob.hash] = ob;
	location.hash = ob.hash;
	//if(jQuery.AjaxifyFirstLoad.history){
	//alert(ob.hash);
		jQuery.historyInit(jQuery.ajaxifyHistory);
		jQuery.AjaxifyFirstLoad.history = false;
	//}
};





jQuery.ajaxifyLoad = function(current) {
	// turn off globals 
	//alert('ajaxifyLoad'+print_r(current,true));
	jQuery.ajaxSetup({global:false});	
	//start calling  jQuery.ajax function. thank you jquery for making this easy
	jQuery.ajax({
		type: current.method,
		url: current.link,
		dataType: current.dataType,
		data: current.paramres,
		contentType:current.contentType,
		processData:true,
		timeout:current.timeout,
		cache:current.cache,
		username:current.username,
		password:current.password,
		complete: function(){
			current.onComplete(current)
		},
		beforeSend: function(){
			current.onStart(current);
			
			if(current.animateOut){
				if(current.loading_target != current.target);//diff target? fire before start anim
					current.loading_fn(current);
				jQuery(current.target).animate(current.animateOut,current.animateOutSpeed,function(){
					//alert('hr');
					if(!current.loading_target)//already fired
					current.loading_fn(current);		
				});
			}else
				current.loading_fn(current);
			},
		success: function(data){
		jQuery(current.target).stop();
		jQuery('#AjaxifyLoading').remove();
		
		if(current.title)
			document.title = current.title;
		else if(document.title != jQuery.AjaxifyPageTitle)
			document.title = jQuery.AjaxifyPageTitle;
		
		if(current.tagToload){
		data = '<div>'+data+'</div>'; //wrap data so we can find tags within it.
			if(typeof current.tagToload == 'string'){
					jQuery.ajaxifyManip(current,jQuery(data).find(current.tagToload)); 					
			}else if(typeof current.tagToload == 'object') {
					jQuery.each(current.tagToload, function(tag, target) {
						if(jQuery(data).find(tag).size())
							jQuery.ajaxifyManip(target,jQuery(data).find(tag)); 
						else
							jQuery.ajaxifylog('Warning: Tag "'+tag+'" couldn\'t be found.');
						
					});
			}
		
		}else{
		 // 
		 jQuery.ajaxifyManip(current,data);
		  }
		current.onSuccess(current,data);
		if(current.animateIn)
			jQuery(current.target).animate(current.animateIn,current.animateInSpeed);
		  
		  },
		  error:function(msg){
			  jQuery(current.target).stop();
			  current.onError(current,msg);
			  if(current.animateIn)
		  jQuery(current.target).animate(current.animateIn,current.animateInSpeed);
		  }
		});
};





jQuery.ajaxifylog = function(message) {
	if(jQuery.AjaxifyDebug)
		if(window.console) {
			 console.debug(message);
		} else {
			 alert(message);
		}
};





jQuery.ajaxifyHistory = function(hash){
	if(hash){
		if(jQuery.browser.safari){
			var options = jQuery.AjaxifyhistorySet[location.hash.replace(/^#/,'')]; //fix bug in history.js
		}else
			var options = jQuery.AjaxifyhistorySet[hash];
		
		if(options)
			jQuery.ajaxifyLoad(options);
		else
			jQuery.ajaxifylog('History Fired. But I couldn\'t find hash. Most propabley, the hash is empty. If so, its normal.');
	}
};





jQuery.ajaxifyManip = function(current,data){

if(typeof current != 'object'){
	var target = current;
	var current = new Object;
	var len = target.length-1;
	if(target.charAt(len) == '+' || target.charAt(len)=='-'){
		current.manip = target.charAt(len);
		current.target = target.substr(0,len);
	}
	else{
		current.manip = '';
		current.target = target;
	}
	if(!jQuery(current.target).size())
		jQuery.ajaxifylog('Warning: Target "'+current.target+'" couldn\'t be found.');
}
	
		
	if(current.manip == '+')
		jQuery(current.target).append(data);
	else if(current.manip == '-')
		jQuery(current.target).prepend(data);
	else
		jQuery(current.target).html(data);
};


})(jQuery);