
	 //Hidden All  Alert Message Before
	  function alertHide(){
				 $('#alertMessage').each(function(index) {	 
						$(this).attr("id","alertMessage"+index).animate({ opacity: 0,right: '30'}, 500,function(){ $(this).remove(); });	
				});	
	  }
	  // Create Alert Message Box
	  function alertMessage(type,str){
				//Hidden All  Alert Message Before
				alertHide();
				// type is a success ,info, warning ,error
				$('body').append('<div id="alertMessage" class="alertMessage '+type+'">');
				$.alertbox=$('#alertMessage').html(str);
				$.alertbox.show().animate({ opacity: 1,right: '10' },500);
	  }	  
	  function onfocus(){
			if($(window).width()>480) {					  
					$('.tip input').tipsy({ trigger: 'focus', gravity: 'w' ,live: true});
			}else{
				  $('.tip input').tipsy("hide");
			}
	  }
	  // Loading 
	  function loading(name,overlay) { 
			$('body').append('<div id="overlay"></div><div id="preloader">'+name+'..</div>');
					if(overlay==1){
					  		$('#overlay').css('opacity',0.4).fadeIn(400,function(){  $('#preloader').fadeIn(400);	});
					  return  false;
			  		 }
			$('#preloader').fadeIn();	  
	   }
	   // Unloading 
	  function unloading() { 
			$('#preloader').fadeOut(400,function(){ $('#overlay').fadeOut();}).remove();
	   }