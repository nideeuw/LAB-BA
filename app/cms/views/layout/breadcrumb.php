<?php
/**
 * Dynamic Breadcrumb Component
 * Auto generate dari URL
 * 
 * Usage di view:
 * $page_title = 'Dashboard';
 * include __DIR__ . '/../components/breadcrumb.php';
 */

// Validasi: $page_title HARUS diset
if (!isset($page_title)) {
    die('Error: $page_title harus diset sebelum include breadcrumb!');
}

// Ambil current URL path
$current_url = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', trim(parse_url($current_url, PHP_URL_PATH), '/'));

// Filter base path & empty
$url_parts = array_filter($url_parts, function($part) {
    return !empty($part) && strtolower($part) !== 'lab-ba';
});
$url_parts = array_values($url_parts);

// Generate breadcrumb items
$breadcrumb_items = [];
$accumulated_path = '';

// 1. Home (always first)
$breadcrumb_items[] = [
    'label' => 'Home',
    'url' => '/'
];

// 2. Auto generate dari URL (kecuali item terakhir)
$count = count($url_parts);
foreach($url_parts as $index => $part) {
    $accumulated_path .= '/' . $part;
    $is_last = ($index === $count - 1);
    
    if (strtolower($part) === 'cms') {
        continue;
    }
    
    // Jangan tambahkan item terakhir (sudah ada di $page_title)
    if (!$is_last) {
        // Auto format: cms -> CMS, users-management -> Users Management
        $label = ucwords(str_replace(['-', '_'], ' ', $part));
        
        $breadcrumb_items[] = [
            'label' => $label,
            'url' => $accumulated_path
        ];
    }
}
?>

<!-- [ Dynamic Breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <?php foreach($breadcrumb_items as $item): ?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $item['url']; ?>"><?php echo $item['label']; ?></a>
                        </li>
                    <?php endforeach; ?>
                    <!-- Current page (dari $page_title) -->
                    <li class="breadcrumb-item" aria-current="page">
                        <?php echo $page_title; ?>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0"><?php echo $page_title; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Dynamic Breadcrumb ] end -->