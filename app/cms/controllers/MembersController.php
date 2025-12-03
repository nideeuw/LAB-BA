<?php

class MembersController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $members = MembersModel::getAllMembers($conn);

        $data = [
            'page_title' => 'Members Management',
            'active_page' => 'members',
            'base_url' => getBaseUrl(),
            'members' => $members,
            'conn' => $conn
        ];

        $this->view('cms/views/members/members_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Member',
            'active_page' => 'members',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/members/members_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/members');
        }

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors[] = 'Name is required';
        }

        // Validate email if provided
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // Validate image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = MembersModel::uploadImage($_FILES['image']);
            if (!$imagePath) {
                $errors[] = 'Failed to upload image. Please check file type and size (max 2MB)';
            }
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/members/add');
        }

        $memberData = [
            'nama' => trim($_POST['nama']),
            'gelar_depan' => trim($_POST['gelar_depan'] ?? ''),
            'gelar_belakang' => trim($_POST['gelar_belakang'] ?? ''),
            'jabatan' => trim($_POST['jabatan'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'image' => $imagePath,
            'sinta_link' => trim($_POST['sinta_link'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        $result = MembersModel::createMember($memberData, $conn);

        if ($result) {
            setFlash('success', 'Member created successfully!');
            redirect('/cms/members');
        } else {
            setFlash('danger', 'Failed to create member');
            redirect('/cms/members/add');
        }
    }

    public function edit($conn, $id)
    {
        checkLogin();

        $member = MembersModel::getMemberById($id, $conn);

        if (!$member) {
            setFlash('danger', 'Member not found');
            redirect('/cms/members');
        }

        $data = [
            'page_title' => 'Edit Member',
            'active_page' => 'members',
            'base_url' => getBaseUrl(),
            'member' => $member,
            'conn' => $conn
        ];

        $this->view('cms/views/members/members_edit', $data);
    }

    public function update($conn, $id)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/members');
        }

        $errors = [];

        if (empty($_POST['nama'])) {
            $errors[] = 'Name is required';
        }

        // Validate email if provided
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/members/edit/' . $id);
        }

        $memberData = [
            'nama' => trim($_POST['nama']),
            'gelar_depan' => trim($_POST['gelar_depan'] ?? ''),
            'gelar_belakang' => trim($_POST['gelar_belakang'] ?? ''),
            'jabatan' => trim($_POST['jabatan'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'sinta_link' => trim($_POST['sinta_link'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? true : false
        ];

        // Handle image upload if new image provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = MembersModel::uploadImage($_FILES['image']);
            if ($imagePath) {
                // Delete old image
                $oldMember = MembersModel::getMemberById($id, $conn);
                if (!empty($oldMember['image'])) {
                    $oldImagePath = ROOT_PATH . 'public/' . $oldMember['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $memberData['image'] = $imagePath;
            }
        }

        $result = MembersModel::updateMember($id, $memberData, $conn);

        if ($result) {
            setFlash('success', 'Member updated successfully!');
            redirect('/cms/members');
        } else {
            setFlash('danger', 'Failed to update member');
            redirect('/cms/members/edit/' . $id);
        }
    }

    public function delete($conn, $id)
    {
        checkLogin();

        $result = MembersModel::deleteMember($id, $conn);

        if ($result) {
            setFlash('success', 'Member deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete member');
        }

        redirect('/cms/members');
    }
}