 <nav class="sidebar-nav">
	<ul class="nav">
		<li class="nav-title"><?php echo $this->resources->LblMenu; ?></li>
		<?php Loaders_MenuLoader::loadMenu(); ?>
	</ul>
</nav>