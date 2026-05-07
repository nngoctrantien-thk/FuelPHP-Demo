<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/authors/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "view" ); ?>'><?php echo Html::anchor('admin/authors/view','View');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/authors/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "edit" ); ?>'><?php echo Html::anchor('admin/authors/edit','Edit');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/authors/delete','Delete');?></li>

</ul>
<p>Index</p>