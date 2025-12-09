<?php

class PublicationsController extends Controller
{
    /**
     * Display publications list (CMS)
     */
    public function index($conn)
    {
        checkLogin();

        $publications = PublicationsModel::getAllPublications($conn);

        $data = [
            'page_title' => 'Publications Management',
            'active_page' => 'publications',
            'base_url' => getBaseUrl(),
            'publications' => $publications,
            'conn' => $conn
        ];

        $this->view('cms/views/publications/publications_index', $data);
    }

    /**
     * Show add publication form
     */
    public function add($conn)
    {
        checkLogin();

        // Get active members for dropdown
        $members = MembersModel::getActiveMembers($conn);

        $data = [
            'page_title' => 'Add Publication',
            'active_page' => 'publications',
            'base_url' => getBaseUrl(),
            'members' => $members,
            'conn' => $conn
        ];

        $this->view('cms/views/publications/publications_create', $data);
    }

    /**
     * Store new publication
     */
    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/publications');
        }

        $errors = [];

        // Validation
        if (empty($_POST['id_members'])) {
            $errors[] = 'Member is required';
        }
        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }
        if (empty($_POST['year'])) {
            $errors[] = 'Year is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/publications/add');
        }

        $publicationData = [
            'id_members' => $_POST['id_members'],
            'title' => trim($_POST['title']),
            'journal_name' => trim($_POST['journal_name'] ?? ''),
            'year' => $_POST['year'],
            'journal_link' => trim($_POST['journal_link'] ?? ''),
            'kategori_publikasi' => trim($_POST['kategori_publikasi'] ?? ''),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = PublicationsModel::createPublication($publicationData, $conn);

        if ($result) {
            setFlash('success', 'Publication created successfully!');
            redirect('/cms/publications');
        } else {
            setFlash('danger', 'Failed to create publication');
            redirect('/cms/publications/add');
        }
    }

    /**
     * Show edit publication form
     */
    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $publication = PublicationsModel::getPublicationById($id, $conn);

        if (!$publication) {
            setFlash('danger', 'Publication not found');
            redirect('/cms/publications');
        }

        // Get active members for dropdown
        $members = MembersModel::getActiveMembers($conn);

        $data = [
            'page_title' => 'Edit Publication',
            'active_page' => 'publications',
            'base_url' => getBaseUrl(),
            'publication' => $publication,
            'members' => $members,
            'conn' => $conn
        ];

        $this->view('cms/views/publications/publications_edit', $data);
    }

    /**
     * Update publication
     */
    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/publications');
        }

        $errors = [];

        if (empty($_POST['id_members'])) {
            $errors[] = 'Member is required';
        }
        if (empty($_POST['title'])) {
            $errors[] = 'Title is required';
        }
        if (empty($_POST['year'])) {
            $errors[] = 'Year is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/publications/edit/' . $id);
        }

        $publicationData = [
            'id_members' => $_POST['id_members'],
            'title' => trim($_POST['title']),
            'journal_name' => trim($_POST['journal_name'] ?? ''),
            'year' => $_POST['year'],
            'journal_link' => trim($_POST['journal_link'] ?? ''),
            'kategori_publikasi' => trim($_POST['kategori_publikasi'] ?? ''),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = PublicationsModel::updatePublication($id, $publicationData, $conn);

        if ($result) {
            setFlash('success', 'Publication updated successfully!');
            redirect('/cms/publications');
        } else {
            setFlash('danger', 'Failed to update publication');
            redirect('/cms/publications/edit/' . $id);
        }
    }

    /**
     * Delete publication
     */
    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = PublicationsModel::deletePublication($id, $conn);

        if ($result) {
            setFlash('success', 'Publication deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete publication');
        }

        redirect('/cms/publications');
    }
}
