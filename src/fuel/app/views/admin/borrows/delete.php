<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/borrows/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "view" ); ?>'><?php echo Html::anchor('admin/borrows/view','View');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/borrows/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "edit" ); ?>'><?php echo Html::anchor('admin/borrows/edit','Edit');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/borrows/delete','Delete');?></li>

</ul>
<p>Delete</p>