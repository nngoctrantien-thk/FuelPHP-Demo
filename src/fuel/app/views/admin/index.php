<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('admin/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('admin/create','Create');?></li>
	<li class='<?php echo Arr::get($subnav, "update" ); ?>'><?php echo Html::anchor('admin/update','Update');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('admin/delete','Delete');?></li>
</ul>
<?php $subnav = isset($subnav) ? $subnav : array(); ?>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Title</th>
    </tr>

    <?php if (!empty($lstAdminQuery) || !empty($lstAdmin)): ?>

        <?php 
        $list = !empty($lstAdminQuery) ? $lstAdminQuery : $lstAdmin;
        ?>

        <?php foreach ($list as $item): ?>
        <tr>
            <td>
                <?php 
                echo is_array($item) ? $item['id'] : $item->id; 
                ?>
            </td>
            <td>
                <?php 
                echo is_array($item) ? $item['title'] : $item->title; 
                ?>
            </td>
        </tr>
        <?php endforeach; ?>

    <?php else: ?>
        <tr>
            <td colspan="2">Không có dữ liệu</td>
        </tr>
    <?php endif; ?>
</table>