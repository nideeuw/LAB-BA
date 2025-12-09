<?php

class ResearchesController extends Controller
{
    /**
     * Display researches list (CMS)
     */
    public function index($conn)
    {
        checkLogin();

        $researches = ResearchesModel::getAllResearches($conn);

        $data = [
            'page_title' => 'Researches Management',
            'active_page' => 'researches',
            'base_url' => getBaseUrl(),
            'researches' => $researches,
            'conn' => $conn
        ];

        $this->view('cms/views/researches/researches_index', $data);
    }

    /**
     * Show add research form
     */
    public function add($conn)
    {
        checkLogin();

        // Get active members for dropdown
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

    /**
     * Store new research
     */
    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/researches');
        }

        $errors = [];

        // Validation
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
            'year' => !empty($_POST['year']) ? $_POST['year'] : null,
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

    /**
     * Show edit research form
     */
    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $research = ResearchesModel::getResearchById($id, $conn);

        if (!$research) {
            setFlash('danger', 'Research not found');
            redirect('/cms/researches');
        }

        // Get active members for dropdown
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

    /**
     * Update research
     */
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
            'year' => !empty($_POST['year']) ? $_POST['year'] : null,
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

    /**
     * Delete research
     */
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
