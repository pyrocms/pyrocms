    function insert_bbcode(bbopen, bbclose)
    {
        var input = document.getElementById("reply_content");
        input.focus();

        /* for Internet Explorer )*/
        if(typeof document.selection != 'undefined')
        {
            var range = document.selection.createRange();
            var insText = range.text;
            range.text = bbopen + insText + bbclose;
            range = document.selection.createRange();
            if (insText.length == 0)
            {
                range.move('character', -bbclose.length);
            }
            else
            {
                range.moveStart('character', bbopen.length + insText.length + bbclose.length);
            }
            range.select();
        }

        /* for newer browsers like Firefox */

        else if(typeof input.selectionStart != 'undefined')
        {
            var start = input.selectionStart;
            var end = input.selectionEnd;
            var insText = input.value.substring(start, end);
            input.value = input.value.substr(0, start) + bbopen + insText + bbclose + input.value.substr(end);
            var pos;
            if (insText.length == 0)
            {
                pos = start + bbopen.length;
            }
            else
            {
                pos = start + bbopen.length + insText.length + bbclose.length;
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
            var insText = prompt("Please tape your text");
            input.value = input.value.substr(0, pos) + bbopen + insText + bbclose + input.value.substr(pos);
        }
    }
