<?php
$page_title = 'Visi Misi Management';
include __DIR__ . '/../layout/header.php';
include __DIR__ . '/../layout/sidebar.php';
?>

<div class="pc-container">
    <div class="pc-content">
        <?php include __DIR__ . '/../layout/breadcrumb.php'; ?>

        <?php
        $flash = getFlash();
        if ($flash):
        ?>
            <div class="alert alert-<?php echo $flash['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $flash['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Visi Misi List</h5>
                        <a href="<?php echo $base_url; ?>/cms/visi_misi/add" class="btn btn-primary">
                            <i class="ti ti-plus"></i> Add New Visi Misi
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="30%">Visi</th>
                                        <th width="35%">Misi</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Created</th>
                                        <th width="10%" class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($visiMisiList)): ?>
                                        <?php foreach ($visiMisiList as $item): ?>
                                            <tr>
                                                <td><?php echo $item['id']; ?></td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($item['visi']); ?>">
                                                        <?php echo htmlspecialchars(substr($item['visi'], 0, 100)) . (strlen($item['visi']) > 100 ? '...' : ''); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 350px;" title="<?php echo htmlspecialchars($item['misi']); ?>">
                                                        <?php echo htmlspecialchars(substr($item['misi'], 0, 120)) . (strlen($item['misi']) > 120 ? '...' : ''); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($item['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <small>
                                                        <?php echo htmlspecialchars($item['created_by'] ?? '-'); ?><br>
                                                        <span class="text-muted">
                                                            <?php echo !empty($item['created_on']) ? date('d M Y', strtotime($item['created_on'])) : '-'; ?>
                                                        </span>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-info"
                                                            onclick="viewDetail(<?php echo htmlspecialchars(json_encode($item)); ?>)"
                                                            title="View Detail">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <a href="<?php echo $base_url; ?>/cms/visi_misi/edit/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="ti ti-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo $base_url; ?>/cms/visi_misi/delete/<?php echo $item['id']; ?>"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Delete this visi misi?')" title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="ti ti-file-text f-40 text-muted"></i>
                                                <p class="mt-2">No visi misi found</p>
                                                <a href="<?php echo $base_url; ?>/cms/visi_misi/add" class="btn btn-primary mt-2">
                                                    <i class="ti ti-plus"></i> Add First Visi Misi
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php include __DIR__ . '/../layout/pagination.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visi Misi Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6 class="text-primary mb-2">VISI</h6>
                    <p id="modalVisi" class="mb-0" style="text-align: justify; line-height: 1.8;"></p>
                </div>
                <div>
                    <h6 class="text-primary mb-2">MISI</h6>
                    <div id="modalMisi" style="text-align: justify; line-height: 1.8;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <span id="modalStatus" class="badge me-auto"></span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
$page_scripts = '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function viewDetail(item) {
    $("#modalVisi").text(item.visi);
    
    let misiText = item.misi;
    let misiArray = misiText.split(/\n|(?<=\.)\s+/).filter(m => m.trim());
    
    let misiHtml = "<ol class=\"mb-0\">";
    misiArray.forEach(function(misi) {
        if (misi.trim()) {
            misiHtml += "<li>" + misi.trim().replace(/^\d+\.\s*/, "") + "</li>";
        }
    });
    misiHtml += "</ol>";
    
    $("#modalMisi").html(misiHtml);
    
    if (item.is_active) {
        $("#modalStatus").removeClass("bg-secondary").addClass("bg-success").text("Active");
    } else {
        $("#modalStatus").removeClass("bg-success").addClass("bg-secondary").text("Inactive");
    }
    
    $("#detailModal").modal("show");
}
</script>
';
include __DIR__ . '/../layout/footer.php';
?>