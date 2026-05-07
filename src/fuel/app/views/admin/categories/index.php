<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/categories/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "view" ); ?>'><?php echo Html::anchor('admin/categories/view','View');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/categories/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "edit" ); ?>'><?php echo Html::anchor('admin/categories/edit','Edit');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/categories/delete','Delete');?></li>

</ul>
<p>Index</p>