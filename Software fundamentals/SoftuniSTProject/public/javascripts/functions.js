$(function() {
    $('.sidebar .widget ul li:first-child').addClass('first');
    $('#navigation ul li:first-child').addClass('first');
    $('#navigation ul li:last-child').addClass('last');
    $('.footer-nav ul li:first-child').addClass('first');

		$('a.popup').colorbox({
			onComplete: function(){
				$.colorbox.resize();
			}
		})

    $('option').mousedown(function(e) {
        e.preventDefault();
        $(this).prop('selected', $(this).prop('selected') ? false : true);
        return false;
    });

    <!-- Script to Activate the Carousel -->

    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })

});