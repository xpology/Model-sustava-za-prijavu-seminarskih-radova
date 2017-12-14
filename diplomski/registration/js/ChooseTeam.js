$(document).ready(function(){
	var selectedUsers = [];
	
	$('body').on('click', '.js-CreateTeam', function(e){
		e.preventDefault();
		var teamName = $.trim($('.js-TeamName').val());
		
		if(teamName === ""){ //IME TIMA NE SMIJE BITI PRAZNO
			alert("Odaberite ime tima");
			return;
		}		
		else if(selectedUsers.length === 0){ //BROJ ODABRANIH ČLANOVA JE 0
			var data = { teamName: teamName };
			$.post("registerSoloTeam.php", data).done(function(result){
				if(result === "OK"){
					window.location.href="topics.php"; //UKOLIKO NEMA GREŠAKA - PREUSMJERI NA ODABIR TEME
				}else{
					alert(result)
				}
			});
		}
		else if(selectedUsers.length > 0 && selectedUsers.length <= maxTeamMembers){
			var data = { teamName: teamName, members: selectedUsers };
			$.post("registerTeam.php", data).done(function(result){
				if(result === "OK"){
					window.location.href="topics.php"; //UKOLIKO NEMA GREŠAKA - PREUSMJERI NA ODABIR TEME
				}else{
					alert(result)
				}
			});
		}
	})

	$('body').on('click', '.js-Checkbox', function(e){
		var id = $(this).attr("id");
			
			if($(this).is(':checked')){
				if(selectedUsers.length < maxTeamMembers){
					selectedUsers.push(id);
				} else {
					e.preventDefault();
					alert('Moguće je dodati samo ' + maxTeamMembers + ' dodatna člana u tim'); //ISPIŠI MAKSIMALNI BROJ DODATNIH ČLANOVA KOJI SE MOGU ODABRATI		
				}
			} else {
				selectedUsers.splice( $.inArray(id, selectedUsers), 1 );
			}	
	})
})