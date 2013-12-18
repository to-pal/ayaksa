<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<a id="totop" href="#">Scroll to top</a>
<script type="text/javascript">
	jQuery(function($){
		// back to top
		$("#totop").hide();
		$(function () {
			var wh = $(window).height();
			var whtml =  $(document).height();
			$(window).scroll(function () {
				if ($(this).scrollTop() > whtml/10) {
					$('#totop').fadeIn();
				} else {
					$('#totop').fadeOut();
				}
			});
			$('#totop').click(function () {
				$('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		});
		// end back to top
	});
</script>