core = {
	isOpera:(navigator.userAgent.toLowerCase().indexOf('opera') != -1),

	isIE:(!this.isOpera && (navigator.userAgent.toLowerCase().indexOf('msie') != -1)),

	isFF:(navigator.userAgent.toLowerCase().indexOf('firefox') != -1),

	isSafari: /webkit|safari|khtml/i.test(navigator.userAgent),

	findX:function(obj){
		var left = 0;
		var top = 0;
    if (obj.offsetParent) {
      do {
        left += obj.offsetLeft;
        top += obj.offsetTop;
      } while (obj = obj.offsetParent);
    }
    return left;
	},

	findY:function(obj){
		var left = 0;
		var top = 0;
    if (obj.offsetParent) {
      do {
        left += obj.offsetLeft;
        top += obj.offsetTop;
      } while (obj = obj.offsetParent);
    }
    return top;
	},

    getMousePos:function(e, c, side){
		var pos = 0;
		if (!e) var e = window.event;
		var bodyScrl = document.body["scroll"+side] || 0;
		var docScrl = document.documentElement["scroll"+side] || 0;
		pos = e["page"+c] || (e["client"+c] + (bodyScrl || docScrl)) || 0;
		return pos;
	},

	getMouseX:function(e){
		return this.getMousePos(e, "X", "Left");
	},

	getMouseY:function(e){
		return this.getMousePos(e, "Y", "Top");
	}
		};




function explode( delimiter, string ) {

	var emptyArray = { 0: '' };

	if ( arguments.length != 2
		|| typeof arguments[0] == 'undefined'
		|| typeof arguments[1] == 'undefined' )
	{
		return null;
	}

	if ( delimiter === ''
		|| delimiter === false
		|| delimiter === null )
	{
		return false;
	}

	if ( typeof delimiter == 'function'
		|| typeof delimiter == 'object'
		|| typeof string == 'function'
		|| typeof string == 'object' )
	{
		return emptyArray;
	}

	if ( delimiter === true ) {
		delimiter = '1';
	}

	return string.toString().split ( delimiter.toString() );
}



function pathajax(path)
	{ //write like pathajax('/ajax/main.php'),
	var temp = explode('/',location.pathname);
	var res="";
	if (temp.length <= 2)
		{
		res += '.'
		}
	else
		{
		for (var i=0; i<(temp.length-2); i++)
			{
			res += "/..";
			}
		}
	res += (path)
	return res;
	}

jQuery.fn.center = function()
	{
	var w = $(window);
	this.css("position","absolute");
	this.css("top",(w.height()-this.height())/2+w.scrollTop() + "px");
	this.css("left",(w.width()-this.width())/2+w.scrollLeft() + "px");
	return this;
	}
	
jQuery.fn.center2 = function()
	{	
	var w_x = window.innerWidth;
	var w_y =  window.innerHeight;
	
	this.css("position","fixed");
	this.css("top",(w_y-this.height())/2 + "px");
	this.css("left",(w_x-this.width())/2 + "px");
	return this;
	}