$(document).ready(function(){
	var selectedTopic = null;
	var maxTopics = 1;
	$('body').on('click', '.js-SubmitTopic', function(e){
		e.preventDefault();
		if(selectedTopic.length === 0 || selectedTopic == null){
			alert("Morate odabrati temu.");
			return;
		}

		else if(selectedTopic != null){
			var data = { topicid: selectedTopic };
			$.post("saveTopic.php", data).done(function(result){
				if(result === "OK"){
					window.location.href="end.php"; //UKOLIKO NEMA GREŠAKA - PREUSMJERI NA ZAVRŠNU STRANICU
				}else{
					alert(result)
				}
			});
		}
	})
	$('body').on('click', '.js-Checkbox', function(e){
		var id = $(this).attr("id");			
		if($(this).is(':checked')){
			if(selectedTopic < maxTopics){
				selectedTopic = id;
			} else {
				e.preventDefault();
				alert('Moguće je odabrati samo ' + maxTopics );		
			}
		} else {
			selectedTopic = null; 
		}	
	})
})