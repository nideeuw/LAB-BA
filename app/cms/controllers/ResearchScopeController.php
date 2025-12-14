<?php

class ResearchScopeController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = ResearchScopeModel::getTotalResearchScopes($conn);
        $researchScopes = ResearchScopeModel::getResearchScopesPaginated($conn, $page, $pageSize);
        $dataLength = count($researchScopes);

        $data = [
            'page_title' => 'Research Scope Management',
            'active_page' => 'research_scope',
            'base_url' => getBaseUrl(),
            'researchScopes' => $researchScopes,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/research_scope/research_scope_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Research Scope',
            'active_page' => 'research_scope',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/research_scope/research_scope_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/research_scope');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/research_scope/add');
        }

        $imagePath = ResearchScopeModel::uploadImage($_FILES['image']);
        if (!$imagePath) {
            setFlash('danger', 'Failed to upload image. Check file type and size (max 5MB)');
            redirect('/cms/research_scope/add');
        }

        $createData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'image' => $imagePath,
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = ResearchScopeModel::createResearchScope($createData, $conn);

        if ($result) {
            setFlash('success', 'Research Scope created successfully!');
        } else {
            setFlash('danger', 'Failed to create Research Scope');
        }

        redirect('/cms/research_scope');
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/research_scope');
            return;
        }

        $researchScope = ResearchScopeModel::getResearchScopeById($id, $conn);

        if (!$researchScope) {
            setFlash('danger', 'Research Scope not found');
            redirect('/cms/research_scope');
            return;
        }

        $data = [
            'page_title' => 'Edit Research Scope',
            'active_page' => 'research_scope',
            'base_url' => getBaseUrl(),
            'researchScope' => $researchScope,
            'conn' => $conn
        ];

        $this->view('cms/views/research_scope/research_scope_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/research_scope');
        }

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/research_scope');
        }

        $researchScope = ResearchScopeModel::getResearchScopeById($id, $conn);

        if (!$researchScope) {
            setFlash('danger', 'Research Scope not found');
            redirect('/cms/research_scope');
        }

        $updateData = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = ResearchScopeModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                if (!empty($researchScope['image'])) {
                    $oldImagePath = ROOT_PATH . 'assets/' . $researchScope['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $updateData['image'] = $imagePath;
            } else {
                setFlash('danger', 'Failed to upload image');
                redirect('/cms/research_scope/edit/' . $id);
            }
        }

        $result = ResearchScopeModel::updateResearchScope($id, $updateData, $conn);

        if ($result) {
            setFlash('success', 'Research Scope updated successfully!');
        } else {
            setFlash('danger', 'Failed to update Research Scope');
        }

        redirect('/cms/research_scope');
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? null;

        if (!$id) {
            setFlash('danger', 'Invalid ID');
            redirect('/cms/research_scope');
        }

        $researchScope = ResearchScopeModel::getResearchScopeById($id, $conn);

        if (!$researchScope) {
            setFlash('danger', 'Research Scope not found');
            redirect('/cms/research_scope');
        }

        if (!empty($researchScope['image'])) {
            $imagePath = ROOT_PATH . 'assets/' . $researchScope['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $result = ResearchScopeModel::deleteResearchScope($id, $conn);

        if ($result) {
            setFlash('success', 'Research Scope deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete Research Scope');
        }

        redirect('/cms/research_scope');
    }
}