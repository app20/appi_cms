$(function()
	{
	$(".nc-navbar-mob .nc-navbar-menuopen").bind("click",function ()
		{
		if ($(".nc-navbar-mob .nc-navbar-menu").css("display") == "none") 
			{
			$(".nc-navbar-mob .nc-navbar-menu").show().animate({"left":"0%"},300,false);
			}
		else 
			{
			$(".nc-navbar-mob .nc-navbar-menu").animate({"left":"-80%"},{duration:300,queue:false,complete:function (){$(".nc-navbar-mob .nc-navbar-menu").hide();}});
			}
		})
	});
/*=====================================*/
function showsubmenu(el)
	{
	var ul = $($(el).parent()).children("ul");
	
	if (!$(ul).hasClass('showen'))
		{
		$(".sitemap_left").css({"z-index":"-1"});
		$(".nc-navbar .submenu").removeClass("showen");
		$(ul).addClass('showen');
		
		}
	else 
		{
		$(".sitemap_left").css({"z-index":"2"});
		$(".nc-navbar .submenu").removeClass("showen");
		}
	
	
	
	
	}
/*=====================================*/
function show_flyframe(title,html)
	{
	$("#flyframe .flyframe_title").html(title);
	$("#flyframe .flyframe_content").html(html);
	if ($("#dark").css('display') == 'none')
		{
		$("#dark").fadeIn(400).bind("click",function (){hide_flyframe();});
		}
	$("#flyframe").center2().fadeIn(500);
	}

function hide_flyframe()
	{
	$("#dark").fadeOut(300);
	$("#flyframe").fadeOut(300);
	}
/*=====================================*/
/*=====================================*/
$(function (){$("#dark").bind("click",function (){hide_flyframe();});});
/*=====================================*/
var widgetRecaptcha1;
function onloadCallback()
	{    
	widgetRecaptcha1 = grecaptcha.render('recaptcha', {'sitekey' : recaptcha_key});
    }
$(function (){
	$(".loginform").center();
	})
function login()
	{
	$.ajax({
		type: "POST",
		url: '/'+admindir+"/ajax/login",
		data: "act=dologin&"+$("#loginform").serialize(),
		dataType: 'json',
		cache: false,		
		success: function(res)
			{
			if (res.ok == "yes")
				{
				location.href=location.href+'';
				}
			else
				{
				grecaptcha.reset(widgetRecaptcha1);
				$("#loginform_error_div").html(res.errors).fadeIn(300);
				}
			}
		 }); 
	}
function logout()
	{
	$.ajax({
		type: "POST",
		url: '/'+admindir+"/ajax/login",
		data: {act: "dologout"},
		cache: false,		
		success: function(html)
			{
			location.href=location.href+'';
			}
		 }); 
	}
	
function showusermenu() 
	{
	$(".userinframe").animate({"opacity":"show","height": "show"},{duration: 300, queue: false});
	
	setTimeout(function (){
	$("body").click(function (event) 
		{
		if ($(event.target).closest(".userinframe").length === 0)
			{
			$(".userinframe").animate({"opacity":"hide","height": "hide"},{duration: 300, queue: false});
			$("body").unbind("click");
			}
		});}, 100);

	}