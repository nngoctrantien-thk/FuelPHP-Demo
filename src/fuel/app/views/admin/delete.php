<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "update" ); ?>'><?php echo Html::anchor('admin/update','Update');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/delete','Delete');?></li>

</ul>
<p>Delete</p>