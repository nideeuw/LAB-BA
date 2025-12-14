<?php

class VisiMisiController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = VisiMisiModel::getTotalVisiMisi($conn);
        $visiMisiList = VisiMisiModel::getVisiMisiPaginated($conn, $page, $pageSize);
        $dataLength = count($visiMisiList);

        $data = [
            'page_title' => 'Visi Misi Management',
            'active_page' => 'visi_misi',
            'base_url' => getBaseUrl(),
            'visiMisiList' => $visiMisiList,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/visi_misi/visi_misi_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Visi Misi',
            'active_page' => 'visi_misi',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/visi_misi/visi_misi_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/visi_misi');
        }

        $errors = [];

        if (empty($_POST['visi'])) {
            $errors[] = 'Visi is required';
        }

        if (empty($_POST['misi'])) {
            $errors[] = 'Misi is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/visi_misi/add');
        }

        $createData = [
            'visi' => trim($_POST['visi']),
            'misi' => trim($_POST['misi']),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = VisiMisiModel::createVisiMisi($createData, $conn);

        if ($result) {
            setFlash('success', 'Visi Misi created successfully!');
        } else {
            setFlash('danger', 'Failed to create Visi Misi');
        }

        redirect('/cms/visi_misi');
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/visi_misi');
            return;
        }

        $visiMisi = VisiMisiModel::getVisiMisiById($id, $conn);

        if (!$visiMisi) {
            setFlash('danger', 'Visi Misi not found');
            redirect('/cms/visi_misi');
            return;
        }

        $data = [
            'page_title' => 'Edit Visi Misi',
            'active_page' => 'visi_misi',
            'base_url' => getBaseUrl(),
            'visiMisi' => $visiMisi,
            'conn' => $conn
        ];

        $this->view('cms/views/visi_misi/visi_misi_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/visi_misi');
        }

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/visi_misi');
        }

        $visiMisi = VisiMisiModel::getVisiMisiById($id, $conn);

        if (!$visiMisi) {
            setFlash('danger', 'Visi Misi not found');
            redirect('/cms/visi_misi');
        }

        $errors = [];

        if (empty($_POST['visi'])) {
            $errors[] = 'Visi is required';
        }

        if (empty($_POST['misi'])) {
            $errors[] = 'Misi is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/visi_misi/edit/' . $id);
        }

        $updateData = [
            'visi' => trim($_POST['visi']),
            'misi' => trim($_POST['misi']),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = VisiMisiModel::updateVisiMisi($id, $updateData, $conn);

        if ($result) {
            setFlash('success', 'Visi Misi updated successfully!');
        } else {
            setFlash('danger', 'Failed to update Visi Misi');
        }

        redirect('/cms/visi_misi');
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/visi_misi');
        }

        $visiMisi = VisiMisiModel::getVisiMisiById($id, $conn);

        if (!$visiMisi) {
            setFlash('danger', 'Visi Misi not found');
            redirect('/cms/visi_misi');
        }

        $result = VisiMisiModel::deleteVisiMisi($id, $conn);

        if ($result) {
            setFlash('success', 'Visi Misi deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete Visi Misi');
        }

        redirect('/cms/visi_misi');
    }
}