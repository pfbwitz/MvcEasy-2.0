<?php
	function Redirect($url)
	{
		echo "<script>window.location = '" . $url . "'</script>";
	}
	
	function loadScript($script)
	{
		echo "<script src='/js/" . $script . ".js'></script>";
	}
?>