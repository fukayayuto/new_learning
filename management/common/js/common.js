$('#navTrigger').on('click',function(){
  if($(this).hasClass('active')){
    $(this).removeClass('active');
    $('nav').fadeOut();
	$('body').removeClass('fixed');
  } else {
    $(this).addClass('active');
    $('nav').fadeIn();
	$('body').addClass('fixed');
  }
});