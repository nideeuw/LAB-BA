<?php

class MenuController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $menus = MenuModel::getAllMenus($conn);

        $data = [
            'page_title' => 'Menu Management',
            'active_page' => 'menu',
            'base_url' => getBaseUrl(),
            'menus' => $menus,
            'conn' => $conn
        ];

        // FIX: Path yang benar
        $this->view('cms/views/menu/menu_index', $data);
    }

    public function create($conn)
    {
        checkLogin();

        $parentMenus = MenuModel::getParentMenus($conn);

        $data = [
            'page_title' => 'Create Menu',
            'active_page' => 'menu',
            'base_url' => getBaseUrl(),
            'parent_menus' => $parentMenus,
            'conn' => $conn
        ];

        // FIX: Path yang benar
        $this->view('cms/views/menu/menu_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/menu');
        }

        $errors = [];

        if (empty($_POST['menu_name'])) {
            $errors[] = 'Menu name is required';
        }
        if (empty($_POST['type'])) {
            $errors[] = 'Menu type is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/menu/create');
        }

        $isLabel = isset($_POST['is_label']) ? true : false;
        $slug = $isLabel ? null : (!empty($_POST['slug']) ? $_POST['slug'] : MenuModel::generateSlug($_POST['menu_name'], $conn));

        $menuData = [
            'menu_name' => trim($_POST['menu_name']),
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
            'order_no' => (int)($_POST['order_no'] ?? 1),
            'menu_level' => (int)($_POST['menu_level'] ?? 1),
            'type' => $_POST['type'],
            'menu_icon' => trim($_POST['menu_icon'] ?? ''),
            'slug' => $slug,
            'is_label' => $isLabel,
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = MenuModel::createMenu($menuData, $conn);

        if ($result) {
            setFlash('success', 'Menu created successfully!');
            redirect('/cms/menu');
        } else {
            setFlash('danger', 'Failed to create menu');
            redirect('/cms/menu/create');
        }
    }

    public function edit($conn, $id)
    {
        checkLogin();

        $menu = MenuModel::getMenuById($id, $conn);

        if (!$menu) {
            setFlash('danger', 'Menu not found');
            redirect('/cms/menu');
        }

        $parentMenus = MenuModel::getParentMenus($conn);

        $data = [
            'page_title' => 'Edit Menu',
            'active_page' => 'menu',
            'base_url' => getBaseUrl(),
            'menu' => $menu,
            'parent_menus' => $parentMenus,
            'conn' => $conn
        ];

        // FIX: Path yang benar
        $this->view('cms/views/menu/menu_edit', $data);
    }

    public function update($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/menu');
        }

        $errors = [];

        if (empty($_POST['menu_name'])) {
            $errors[] = 'Menu name is required';
        }
        if (empty($_POST['type'])) {
            $errors[] = 'Menu type is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/menu/edit/' . $id);
        }

        $isLabel = isset($_POST['is_label']) ? true : false;
        $slug = $isLabel ? null : (!empty($_POST['slug']) ? $_POST['slug'] : MenuModel::generateSlug($_POST['menu_name'], $conn, $id));

        $menuData = [
            'menu_name' => trim($_POST['menu_name']),
            'parent_id' => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
            'order_no' => (int)($_POST['order_no'] ?? 1),
            'menu_level' => (int)($_POST['menu_level'] ?? 1),
            'type' => $_POST['type'],
            'menu_icon' => trim($_POST['menu_icon'] ?? ''),
            'slug' => $slug,
            'is_label' => $isLabel,
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = MenuModel::updateMenu($id, $menuData, $conn);

        if ($result) {
            setFlash('success', 'Menu updated successfully!');
            redirect('/cms/menu');
        } else {
            setFlash('danger', 'Failed to update menu');
            redirect('/cms/menu/edit/' . $id);
        }
    }

    public function delete($conn, $id)
    {
        checkLogin();

        $result = MenuModel::deleteMenu($id, $conn);

        if ($result['success']) {
            setFlash('success', $result['message']);
        } else {
            setFlash('danger', $result['message']);
        }

        redirect('/cms/menu');
    }

    public function toggle($conn, $id)
    {
        checkLogin();

        $menu = MenuModel::getMenuById($id, $conn);

        if (!$menu) {
            setFlash('danger', 'Menu not found');
            redirect('/cms/menu');
        }

        $menuData = [
            'menu_name' => $menu['menu_name'],
            'parent_id' => $menu['parent_id'],
            'order_no' => $menu['order_no'],
            'menu_level' => $menu['menu_level'],
            'type' => $menu['type'],
            'menu_icon' => $menu['menu_icon'],
            'slug' => $menu['slug'],
            'is_label' => $menu['is_label'],
            'is_active' => !$menu['is_active']
        ];

        $result = MenuModel::updateMenu($id, $menuData, $conn);

        if ($result) {
            $status = $menuData['is_active'] ? 'activated' : 'deactivated';
            setFlash('success', "Menu {$status} successfully!");
        } else {
            setFlash('danger', 'Failed to toggle menu status');
        }

        redirect('/cms/menu');
    }
}