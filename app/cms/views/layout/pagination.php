<?php
$page = $page ?? 1;
$pageSize = $pageSize ?? 10;
$total = $total ?? 0;
$dataLength = $dataLength ?? 0;

$totalPages = max(1, ceil($total / $pageSize));

function generatePageNumbers($page, $totalPages) {
    $pages = [];
    
    if ($totalPages <= 6) {
        for ($i = 1; $i <= $totalPages; $i++) {
            $pages[] = $i;
        }
    } else {
        if ($page <= 4) {
            for ($i = 1; $i <= 5; $i++) {
                $pages[] = $i;
            }
            $pages[] = '...';
            $pages[] = $totalPages;
        } else if ($page >= $totalPages - 3) {
            $pages[] = 1;
            $pages[] = '...';
            for ($i = $totalPages - 4; $i <= $totalPages; $i++) {
                $pages[] = $i;
            }
        } else {
            $pages[] = 1;
            $pages[] = '...';
            for ($i = $page - 1; $i <= $page + 1; $i++) {
                $pages[] = $i;
            }
            $pages[] = '...';
            $pages[] = $totalPages;
        }
    }
    
    return $pages;
}

$pageNumbers = generatePageNumbers($page, $totalPages);
$pageSizeOptions = $pageSizeOptions ?? [10, 25, 50, 100];
?>

<div class="pagination-wrapper">
    <div class="pagination-controls">
        <div class="pagination-buttons">
            <button type="button" 
                    <?php echo ($page <= 1 || $dataLength === 0) ? 'disabled' : ''; ?>
                    onclick="changePage(<?php echo max(1, $page - 1); ?>)">
                Previous
            </button>

            <?php if ($dataLength > 0): ?>
                <?php foreach ($pageNumbers as $idx => $p): ?>
                    <?php if ($p === '...'): ?>
                        <button type="button" disabled>...</button>
                    <?php else: ?>
                        <button type="button" 
                                class="<?php echo ($page === $p) ? 'active' : ''; ?>"
                                onclick="changePage(<?php echo $p; ?>)">
                            <?php echo number_format($p); ?>
                        </button>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <button type="button" 
                    <?php echo ($page >= $totalPages || $dataLength === 0) ? 'disabled' : ''; ?>
                    onclick="changePage(<?php echo min($totalPages, $page + 1); ?>)">
                Next
            </button>
        </div>

        <div class="pagination-page-size">
            <span>Show</span>
            <select onchange="changePageSize(this.value)">
                <?php foreach ($pageSizeOptions as $size): ?>
                    <option value="<?php echo $size; ?>" <?php echo ($pageSize === $size) ? 'selected' : ''; ?>>
                        <?php echo number_format($size); ?>
                    </option>
                <?php endforeach; ?>
                <option value="<?php echo $total; ?>" <?php echo ($pageSize >= $total) ? 'selected' : ''; ?>>All</option>
            </select>
            <span>entries</span>
        </div>
    </div>

    <div class="pagination-info">
        <?php if ($dataLength > 0): ?>
            Showing <?php echo number_format(($page - 1) * $pageSize + 1); ?> 
            to <?php echo number_format(min($page * $pageSize, $total)); ?> 
            of <?php echo number_format($total); ?> entries
        <?php else: ?>
            Showing 0 to 0 of 0 entries
        <?php endif; ?>
    </div>
</div>

<script>
function changePage(newPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('page', newPage);
    window.location.href = url.toString();
}

function changePageSize(newSize) {
    const url = new URL(window.location.href);
    url.searchParams.set('page', 1);
    url.searchParams.set('pageSize', newSize);
    window.location.href = url.toString();
}
</script>