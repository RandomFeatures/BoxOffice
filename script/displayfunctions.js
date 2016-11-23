var spinner = '<div style="padding:50px; position:absolute; z-index: 2; width:1048px;"><div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div></div>';

function loadWeek(slotWeek)
{
	
	//if(slotWeek == 1)
	//	$("#week1").html(spinner);
	//else
	setTimeout(function () {
		$.ajax({
				url: 'loadweek.php',
				type: 'POST',
				data: {
				  week: slotWeek
				},
				dataType : 'html',
				success: function(response) {
					if(slotWeek == 1)
						$("#week1").html(response);
					else
						$("#week2").html(response);
				}
			});
	});

}

function loadShowNight()
{
	//$("#shownight").html(spinner);
	setTimeout(function () {
    $.ajax({
			url: 'loadshow.php',
			type: 'POST',
			dataType : 'html',
			success: function(response) {
					$("#shownight").html(response);
			}
		});
	});
}

function reminder_OnClick()
{
	var checked = 0;

	if($('#remindercheck').is(':checked'))
		checked = 1;
	
	$.ajax({
		url: 'UserEmailOpt.php',
		type: 'POST',
		data: {
		  reminder: checked
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{
				alert("I am sorry! There was an error. Please email Allen.");					
				
			}
		}
	});
	
}

function signup_onClick(slotDay, slotWeek, slotTime) {

	$.ajax({
		url: 'claimslot.php',
		type: 'POST',
		data: {
		  day: slotDay,
		  week: slotWeek,
		  time:slotTime
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{
				alert("I am sorry. That time slot is already taken.");					
			}
			
			loadWeek(slotWeek);
		}
	});
}

function shownight_onClick(slotDay, leaveearly) {

	$.ajax({
		url: 'claimshow.php',
		type: 'POST',
		data: {
		  day: slotDay,
		  early: leaveearly
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{
				alert("I am sorry. That time slot is already taken.");					
			}
			
			loadShowNight();
		}
	});
}



function cancel_OnClick(slotID,slotWeek) {
	$.ajax({
		url: 'cancel.php',
		type: 'POST',
		data: {
		  slot: slotID
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{
				alert("I am sorry! There was an error. Please email Allen.");					
				
			}
			
			loadWeek(slotWeek);
		}
	});
}

function cancelshow_OnClick(slotID) {
	$.ajax({
		url: 'cancelshow.php',
		type: 'POST',
		data: {
		  slot: slotID
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{
				alert("I am sorry! There was an error. Please email Allen.");					
				
			}
			
			loadShowNight();
		}
	});
}

function login_OnClick()
{
	var username = $('#email').val();
	var password = $('#pass').val();
	
	$.ajax({
		url: 'login.php',
		type: 'POST',
		data: {
		  user: username,
		  pass: password
		},
		dataType : 'json',
		success: function(response) {
			if(response.error)
			{	
				alert('This email and password combination does not match our records.');
				$('#pass').val("");
				$('#pass').focus();
			}
			else
			{
				UserName = response.UserName;
				UserID = response.UserID;
				if(response.Reminder == 1)
					$('#remindercheck').prop('checked', true);
				else
					$('#remindercheck').prop('checked', false);
				$('#closelogin').click();
				ShowingLogin = false;
				loadWeek(1);
				loadWeek(2);
				loadShowNight();
			}		
		}
	});
	
}


function close_OnClick(id)
{
	$('#'+id).click();
}
