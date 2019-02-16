$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});

$("#contactform").submit(function(e){
	e.preventDefault();    
	submitContactForm();
    return false;
});

function submitContactForm(){
	$.ajax({
		type:"POST", 
		url:"mail.php", 
		data:$('#contactform').serialize(),
		success:function(data){
			if(data === "success"){
				$("#contactform").trigger("reset");
				swal("Message Sent!", "Our sales team will be in contact with you as soon as possible", "success");
			}
			else
				swal(data,"Please correct this error and resubmit the form.", "error");
		}
	});
}


$(window).scroll(function() {
    var portScroll = 1029;
    var aboutusScroll = 1329;
    var contactScroll = 1729;
    var features1 = 332;
    var features2 = 532;
    console.log($(document).scrollTop());

    if($(document).scrollTop() > portScroll){
        $('#port').removeClass('invisible').addClass('fadeIn')

    }
    if($(document).scrollTop() > aboutusScroll){
        $('#aboutus').removeClass('invisible').addClass('bounceInLeft')

    }
    if($(document).scrollTop() > contactScroll){
        $('#contact').removeClass('invisible').addClass('lightSpeedIn')

    }
    if($(document).scrollTop() > features1){
        $('.features1').removeClass('invisible').addClass('bounceIn')

    }
    if($(document).scrollTop() > features2){
        $('.features2').removeClass('invisible').addClass('bounceIn')

    }
});
