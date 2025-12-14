<?php

class RoleController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = RoleModel::getTotalRoles($conn);
        $roles = RoleModel::getRolesPaginated($conn, $page, $pageSize);
        $dataLength = count($roles);

        $data = [
            'page_title' => 'Role Management',
            'active_page' => 'role',
            'base_url' => getBaseUrl(),
            'roles' => $roles,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/role/role_index', $data);
    }

    public function create($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Role',
            'active_page' => 'role',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/role/role_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/role');
        }

        $errors = [];

        if (empty($_POST['role_code'])) {
            $errors[] = 'Role code is required';
        }
        if (empty($_POST['role_name'])) {
            $errors[] = 'Role name is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/role/create');
        }

        $roleData = [
            'role_code' => strtoupper(trim($_POST['role_code'])),
            'role_name' => trim($_POST['role_name']),
            'is_active' => isset($_POST['is_active']) ? true : false,
            'created_by' => $_SESSION['username'] ?? 'system'
        ];

        $result = RoleModel::createRole($roleData, $conn);

        if ($result) {
            setFlash('success', 'Role created successfully!');
            redirect('/cms/role');
        } else {
            setFlash('danger', 'Failed to create role. Role code might already exist.');
            redirect('/cms/role/create');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid role ID');
            redirect('/cms/role');
        }

        $role = RoleModel::getRoleById($id, $conn);

        if (!$role) {
            setFlash('danger', 'Role not found');
            redirect('/cms/role');
        }

        $data = [
            'page_title' => 'Edit Role',
            'active_page' => 'role',
            'base_url' => getBaseUrl(),
            'role' => $role,
            'conn' => $conn
        ];

        $this->view('cms/views/role/role_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/role');
        }

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid role ID');
            redirect('/cms/role');
        }

        $errors = [];

        if (empty($_POST['role_code'])) {
            $errors[] = 'Role code is required';
        }
        if (empty($_POST['role_name'])) {
            $errors[] = 'Role name is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/role/edit/' . $id);
        }

        $roleData = [
            'role_code' => strtoupper(trim($_POST['role_code'])),
            'role_name' => trim($_POST['role_name']),
            'is_active' => isset($_POST['is_active']) ? true : false,
            'modified_by' => $_SESSION['username'] ?? 'system'
        ];

        $result = RoleModel::updateRole($id, $roleData, $conn);

        if ($result) {
            setFlash('success', 'Role updated successfully!');
            redirect('/cms/role');
        } else {
            setFlash('danger', 'Failed to update role');
            redirect('/cms/role/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid role ID');
            redirect('/cms/role');
        }

        $isUsed = RoleModel::isRoleUsed($id, $conn);

        if ($isUsed) {
            setFlash('danger', 'Cannot delete role that is being used by users!');
            redirect('/cms/role');
        }

        $result = RoleModel::deleteRole($id, $conn);

        if ($result) {
            setFlash('success', 'Role deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete role');
        }

        redirect('/cms/role');
    }

    public function toggle($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid role ID');
            redirect('/cms/role');
        }

        $result = RoleModel::toggleStatus($id, $conn);

        if ($result) {
            setFlash('success', 'Role status updated successfully!');
        } else {
            setFlash('danger', 'Failed to update role status');
        }

        redirect('/cms/role');
    }
}
