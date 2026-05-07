<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/books/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "view" ); ?>'><?php echo Html::anchor('admin/books/view','View');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/books/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "edit" ); ?>'><?php echo Html::anchor('admin/books/edit','Edit');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/books/delete','Delete');?></li>

</ul>
<p>View</p>