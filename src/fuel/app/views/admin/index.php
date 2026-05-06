<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 100px;">ID</th>
                    <th>Tiêu đề (Title)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lstAdminQuery) || !empty($lstAdmin)): ?>
                    <?php $list = !empty($lstAdminQuery) ? $lstAdminQuery : $lstAdmin; ?>
                    <?php foreach ($list as $item): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">
                                    <?php echo is_array($item) ? $item['id'] : $item->id; ?>
                                </span>
                            </td>
                            <td>
                                <?php echo is_array($item) ? $item['title'] : $item->title; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted py-4">
                            <p class="mb-0">Chưa có dữ liệu admin nào được tìm thấy.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>