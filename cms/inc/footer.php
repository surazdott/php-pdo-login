<?php
	// Avoid unneccessary script if not needed
	if(getCurrentPage() != 'index') {

?>

    <!-- Bootstrap -->
    <script src="<?php echo CMS_JS; ?>bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo CMS_JS; ?>fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo CMS_JS; ?>nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo CMS_JS; ?>custom.min.js"></script>

 <?php } ?>

  </body>
</html>