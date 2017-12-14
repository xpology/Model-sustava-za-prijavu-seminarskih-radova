$(document).ready(function(){
	var selectedDate = null;
	var maxDates = 1;
	$('body').on('click', '.js-SubmitDate', function(e){
		e.preventDefault();
		if(selectedDate.length === 0 || selectedDate == null){
			alert("Morate odabrati datum.");
			return;
		}

		else if(selectedDate != null){
			var data = { dateid: selectedDate };
			$.post("saveDate.php", data).done(function(result){
				if(result === "OK"){
					window.location.href="home.php"; //UKOLIKO NEMA GREŠAKA - PREUSMJERI NA POČETNU STRANICU
				}else{
					alert(result)
				}
			});
		}
	})
	$('body').on('click', '.js-Checkbox', function(e){
		var id = $(this).attr("id");			
		if($(this).is(':checked')){
			if(selectedDate < maxDates){
				selectedDate = id;
			} else {
				e.preventDefault();
				alert('Moguće je odabrati samo ' + maxDates );		
			}
		} else {
			selectedDate = null; 
		}	
	})
})