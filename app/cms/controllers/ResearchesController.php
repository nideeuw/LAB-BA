<?php

class ResearchesController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = ResearchesModel::getTotalResearches($conn);
        $researches = ResearchesModel::getResearchesPaginated($conn, $page, $pageSize);
        $dataLength = count($researches);

        foreach ($researches as &$research) {
            $research['member_full_name'] = ResearchesModel::getMemberFullName($research);
        }

        $data = [
            'page_title' => 'Researches Management',
            'active_page' => 'researches',
            'base_url' => getBaseUrl(),
            'researches' => $researches,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/researches/researches_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $members = MembersModel::getActiveMembers($conn);

        $data = [
            'page_title' => 'Add Research',
            'active_page' => 'researches',
            'base_url' => getBaseUrl(),
            'members' => $members,
            'conn' => $conn
        ];

        $this->view('cms/views/researches/researches_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/researches');
        }

        $errors = [];

        if (empty($_POST['id_members'])) {
            $errors[] = 'Member is required';
        }
        if (empty($_POST['title'])) {
            $errors[] = 'Research title is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/researches/add');
        }

        $researchData = [
            'id_members' => $_POST['id_members'],
            'title' => trim($_POST['title']),
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ResearchesModel::createResearch($researchData, $conn);

        if ($result) {
            setFlash('success', 'Research created successfully!');
            redirect('/cms/researches');
        } else {
            setFlash('danger', 'Failed to create research');
            redirect('/cms/researches/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $research = ResearchesModel::getResearchById($id, $conn);

        if (!$research) {
            setFlash('danger', 'Research not found');
            redirect('/cms/researches');
        }

        $members = MembersModel::getActiveMembers($conn);

        $data = [
            'page_title' => 'Edit Research',
            'active_page' => 'researches',
            'base_url' => getBaseUrl(),
            'research' => $research,
            'members' => $members,
            'conn' => $conn
        ];

        $this->view('cms/views/researches/researches_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/researches');
        }

        $errors = [];

        if (empty($_POST['id_members'])) {
            $errors[] = 'Member is required';
        }
        if (empty($_POST['title'])) {
            $errors[] = 'Research title is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/researches/edit/' . $id);
        }

        $researchData = [
            'id_members' => $_POST['id_members'],
            'title' => trim($_POST['title']),
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ResearchesModel::updateResearch($id, $researchData, $conn);

        if ($result) {
            setFlash('success', 'Research updated successfully!');
            redirect('/cms/researches');
        } else {
            setFlash('danger', 'Failed to update research');
            redirect('/cms/researches/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ResearchesModel::deleteResearch($id, $conn);

        if ($result) {
            setFlash('success', 'Research deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete research');
        }

        redirect('/cms/researches');
    }
}