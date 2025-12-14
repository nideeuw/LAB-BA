<?php

class RoadmapController extends Controller
{
    public function index($conn, $params = [])
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = RoadmapModel::getTotalRoadmap($conn);
        $roadmaps = RoadmapModel::getRoadmapPaginated($conn, $page, $pageSize);
        $dataLength = count($roadmaps);

        $data = [
            'page_title' => 'Roadmap Management',
            'active_page' => 'roadmap',
            'base_url' => getBaseUrl(),
            'roadmaps' => $roadmaps,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/roadmap/roadmap_index', $data);
    }

    public function add($conn, $params = [])
    {
        checkLogin();
        $nextOrder = RoadmapModel::getNextSortOrder($conn);

        $data = [
            'page_title' => 'Add Roadmap',
            'active_page' => 'roadmap',
            'base_url' => getBaseUrl(),
            'nextOrder' => $nextOrder,
            'conn' => $conn
        ];

        $this->view('cms/views/roadmap/roadmap_create', $data);
    }

    public function store($conn, $params = [])
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/roadmap');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['content'])) {
            $errors[] = 'Content is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/roadmap/add');
        }

        $roadmapData = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'sort_order' => intval($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = RoadmapModel::createRoadmap($roadmapData, $conn);

        if ($result) {
            setFlash('success', 'Roadmap created successfully!');
            redirect('/cms/roadmap');
        } else {
            setFlash('danger', 'Failed to create Roadmap');
            redirect('/cms/roadmap/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();
        $id = $params['id'] ?? 0;
        $roadmap = RoadmapModel::getRoadmapById($id, $conn);

        if (!$roadmap) {
            setFlash('danger', 'Roadmap not found');
            redirect('/cms/roadmap');
            return;
        }

        $data = [
            'page_title' => 'Edit Roadmap',
            'active_page' => 'roadmap',
            'base_url' => getBaseUrl(),
            'roadmap' => $roadmap,
            'conn' => $conn
        ];

        $this->view('cms/views/roadmap/roadmap_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();
        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/roadmap');
        }

        $errors = [];

        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }

        if (empty($_POST['content'])) {
            $errors[] = 'Content is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/roadmap/edit/' . $id);
        }

        $roadmapData = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'sort_order' => intval($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = RoadmapModel::updateRoadmap($id, $roadmapData, $conn);

        if ($result) {
            setFlash('success', 'Roadmap updated successfully!');
            redirect('/cms/roadmap');
        } else {
            setFlash('danger', 'Failed to update Roadmap');
            redirect('/cms/roadmap/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();
        $id = $params['id'] ?? 0;
        $result = RoadmapModel::deleteRoadmap($id, $conn);

        if ($result) {
            setFlash('success', 'Roadmap deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete Roadmap');
        }

        redirect('/cms/roadmap');
    }
}