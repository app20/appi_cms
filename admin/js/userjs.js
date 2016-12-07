function addnewuser()
	{
	$.ajax({
		type: "POST",
		url: '/'+admindir+"/ajax/users",
		dataType: 'json',
		data: "act=addnewuser&"+$("#addnewadminuser_form").serialize(),
		cache: false,
		success: function(res)
			{
			if (res.ok == 'yes')
				{
				//добавили
				$("#adduser_error_div").hide();
				alert('Пользователь добавлен');
				location.href=location.href+'';
				}
			else
				{				
				$("#adduser_error_div").html(res.errors).fadeIn(300);
				}
			}
		 }); 
	}