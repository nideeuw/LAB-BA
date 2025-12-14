<?php

class ResearchFocusController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = ResearchFocusModel::getTotalResearchFocus($conn);
        $focusItems = ResearchFocusModel::getResearchFocusPaginated($conn, $page, $pageSize);
        $dataLength = count($focusItems);

        $data = [
            'page_title' => 'Research Focus Management',
            'active_page' => 'research_focus',
            'base_url' => getBaseUrl(),
            'focusItems' => $focusItems,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/research_focus/research_focus_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();

        $nextOrder = ResearchFocusModel::getNextSortOrder($conn);

        $data = [
            'page_title' => 'Add Research Focus',
            'active_page' => 'research_focus',
            'base_url' => getBaseUrl(),
            'nextOrder' => $nextOrder,
            'conn' => $conn
        ];

        $this->view('cms/views/research_focus/research_focus_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/research_focus');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['focus_description'])) {
            $errors[] = 'Focus Description is required';
        }

        if (empty($_POST['examples'])) {
            $errors[] = 'Examples are required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/research_focus/add');
        }

        $focusData = [
            'title' => trim($_POST['title']),
            'focus_description' => trim($_POST['focus_description']),
            'examples' => trim($_POST['examples']),
            'sort_order' => intval($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ResearchFocusModel::createResearchFocus($focusData, $conn);

        if ($result) {
            setFlash('success', 'Research Focus created successfully!');
            redirect('/cms/research_focus');
        } else {
            setFlash('danger', 'Failed to create Research Focus');
            redirect('/cms/research_focus/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $focus = ResearchFocusModel::getResearchFocusById($id, $conn);

        if (!$focus) {
            setFlash('danger', 'Research Focus not found');
            redirect('/cms/research_focus');
            return;
        }

        $data = [
            'page_title' => 'Edit Research Focus',
            'active_page' => 'research_focus',
            'base_url' => getBaseUrl(),
            'focus' => $focus,
            'conn' => $conn
        ];

        $this->view('cms/views/research_focus/research_focus_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/research_focus');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['focus_description'])) {
            $errors[] = 'Focus Description is required';
        }

        if (empty($_POST['examples'])) {
            $errors[] = 'Examples are required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/research_focus/edit/' . $id);
        }

        $focusData = [
            'title' => trim($_POST['title']),
            'focus_description' => trim($_POST['focus_description']),
            'examples' => trim($_POST['examples']),
            'sort_order' => intval($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ResearchFocusModel::updateResearchFocus($id, $focusData, $conn);

        if ($result) {
            setFlash('success', 'Research Focus updated successfully!');
            redirect('/cms/research_focus');
        } else {
            setFlash('danger', 'Failed to update Research Focus');
            redirect('/cms/research_focus/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ResearchFocusModel::deleteResearchFocus($id, $conn);

        if ($result) {
            setFlash('success', 'Research Focus deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete Research Focus');
        }

        redirect('/cms/research_focus');
    }
}