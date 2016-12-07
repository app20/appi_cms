$(function()
	{
	$(".mmenu_div").bind("click",function ()
		{
		if ($("#mob_sidebar_menu").css("left") != "0px") 
			{
			$("#mob_sidebar_overlay").animate({"opacity":'show'},{duration:200,queue:false,complete:function (){}});
			$("#mob_sidebar_menu").animate({"left":'0px'},{duration:200,queue:false,complete:function (){}});
			}
		else
			{
			$("#mob_sidebar_menu").animate({"left":'-200px'},{duration:200,queue:false,complete:function (){$("#mob_sidebar_menu");}});
			$("#mob_sidebar_overlay").animate({"opacity":'hide'},{duration:200,queue:false,complete:function (){}});
			}
		});
		
	$(".login_div").bind("click",function ()
		{
		if ($("#mob_sidebar_login").css("right") != "0px") 
			{
			$("#mob_sidebar_overlay").animate({"opacity":'show'},{duration:200,queue:false,complete:function (){}});
			$("#mob_sidebar_login").animate({"right":'0px'},{duration:200,queue:false,complete:function (){}});
			}
		else
			{
			$("#mob_sidebar_login").animate({"right":'-200px'},{duration:200,queue:false,complete:function (){$("#mob_sidebar_menu");}});
			$("#mob_sidebar_overlay").animate({"opacity":'hide'},{duration:200,queue:false,complete:function (){}});
			}
		});
		
	$("#mob_sidebar_overlay").bind("click",function ()
		{
		if ($("#mob_sidebar_menu").css("left") != "-200px") 
			{	
			$("#mob_sidebar_menu").animate({"left":'-200px'},{duration:200,queue:false,complete:function (){$("#mob_sidebar_menu");}});
			$("#mob_sidebar_overlay").animate({"opacity":'hide'},{duration:200,queue:false,complete:function (){}});
			}
		else if ($("#mob_sidebar_login").css("right") != "-200px") 
			{
			$("#mob_sidebar_login").animate({"right":'-200px'},{duration:200,queue:false,complete:function (){$("#mob_sidebar_menu");}});
			$("#mob_sidebar_overlay").animate({"opacity":'hide'},{duration:200,queue:false,complete:function (){}});
			}
		});
	
	
	});


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
var widgetRecaptcha1,widgetRecaptcha2,widgetRecaptcha3;
/*function onloadCallback()
	{    
	widgetRecaptcha1 = grecaptcha.render('recaptcha', {'sitekey' : '6LfgmgwUAAAAAA2eVjMpvW214Z5fIQdBlIMe-PTw'});
    }*/
var widgetRecaptcha1,widgetRecaptcha2;
function loginform()
	{
	$.ajax({
		type: "POST",
		url: "/ajax/login",
		data: {act: "getloginform"},
		dataType: 'json',
		cache: false,		
		success: function(res)
			{
			if (res.ok == 'yes')
				{
				show_flyframe(res.title,res.html);				
				}
			}
		 }); 
	}
function registerform()
	{
	$.ajax({
		type: "POST",
		url: "/ajax/login",
		data: {act: "getform"},
		cache: false,		
		success: function(html)
			{
			show_flyframe("Login on TopBoost",html);
			}
		 }); 
	}
function forgotpassform()
	{
	$.ajax({
		type: "POST",
		url: "/ajax/login",
		data: {act: "getforgotform"},
		cache: false,		
		success: function(html)
			{
			show_flyframe("Password reset",html);
			widgetRecaptcha2 = grecaptcha.render('recaptcha', {'sitekey' : '6LfgmgwUAAAAAA2eVjMpvW214Z5fIQdBlIMe-PTw'});
			}
		 }); 
	}

function logout()
	{
	$.ajax({
		type: "POST",
		url: "/ajax/login",
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