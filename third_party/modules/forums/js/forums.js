jQuery(document).ready(function(){
	jQuery(".delete").click(function (e) {
		e.preventDefault();
		if (confirm('Are you sure you want to delete this?')) {
			window.location = jQuery(this).attr("href");
		}
	});
});

function insert_code(code_open, code_close, is_link)
{
	var input = document.getElementById("forum_input");
	input.focus();

	/* for Internet Explorer )*/
	if(typeof document.selection != 'undefined')
	{
		var range = document.selection.createRange();
		var insText = range.text;
		if(is_link == true)
		{
			url = prompt('What is the URL?');
			display = prompt('What text would you like to display?', insText);
		}

		range.text = code_open + insText + code_close;
		range = document.selection.createRange();
		if (insText.length == 0)
		{
			range.move('character', -code_close.length);
		}
		else
		{
			range.moveStart('character', code_open.length + insText.length + code_close.length);
		}
		range.select();
	}

	/* for newer browsers like Firefox */

	else if(typeof input.selectionStart != 'undefined')
	{
		var start = input.selectionStart;
		var end = input.selectionEnd;
		var insText = input.value.substring(start, end);
		if(is_link == true)
		{
			url = prompt('What is the URL?');
			display = prompt('What text would you like to display?', insText);

			code_open = code_open.replace('%display%', display);
			code_close = code_close.replace('%url%', url);
			insText = '';

		}

		input.value = input.value.substr(0, start) + code_open + insText + code_close + input.value.substr(end);
		var pos;
		if (insText.length == 0)
		{
			pos = start + code_open.length;
		}
		else
		{
			pos = start + code_open.length + insText.length + code_close.length;
		}
		input.selectionStart = pos;
		input.selectionEnd = pos;
	}

	/* for other browsers like Netscape... */
	else
	{
		var pos;
		var re = new RegExp('^[0-9]{0,3}$');
		while(!re.test(pos))
		{
			pos = prompt("insertion (0.." + input.value.length + "):", "0");
		}
		if(pos > input.value.length)
		{
			pos = input.value.length;
		}
		var insText = prompt("Please type your text");
		if(is_link == true)
		{
			url = prompt('What is the URL?');
			display = prompt('What text would you like to display?', insText);
		}

		input.value = input.value.substr(0, pos) + code_open + insText + code_close + input.value.substr(pos);
	}
}
