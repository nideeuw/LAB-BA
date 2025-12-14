<?php

class ContactController extends Controller
{
    public function index($conn)
    {
        checkLogin();

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $total = ContactModel::getTotalContacts($conn);
        $contacts = ContactModel::getContactsPaginated($conn, $page, $pageSize);
        $dataLength = count($contacts);

        $data = [
            'page_title' => 'Contact Management',
            'active_page' => 'contact',
            'base_url' => getBaseUrl(),
            'contacts' => $contacts,
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $total,
            'dataLength' => $dataLength,
            'conn' => $conn
        ];

        $this->view('cms/views/contact/contact_index', $data);
    }

    public function add($conn)
    {
        checkLogin();

        $data = [
            'page_title' => 'Add Contact',
            'active_page' => 'contact',
            'base_url' => getBaseUrl(),
            'conn' => $conn
        ];

        $this->view('cms/views/contact/contact_create', $data);
    }

    public function store($conn)
    {
        checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/contact');
        }

        $errors = [];

        if (empty($_POST['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (empty($_POST['alamat'])) {
            $errors[] = 'Address is required';
        }

        if (empty($_POST['no_telp'])) {
            $errors[] = 'Phone number is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/contact/add');
        }

        $contactData = [
            'email' => trim($_POST['email']),
            'alamat' => trim($_POST['alamat']),
            'no_telp' => trim($_POST['no_telp']),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ContactModel::createContact($contactData, $conn);

        if ($result) {
            setFlash('success', 'Contact created successfully!');
            redirect('/cms/contact');
        } else {
            setFlash('danger', 'Failed to create contact');
            redirect('/cms/contact/add');
        }
    }

    public function edit($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $contact = ContactModel::getContactById($id, $conn);

        if (!$contact) {
            setFlash('danger', 'Contact not found');
            redirect('/cms/contact');
        }

        $data = [
            'page_title' => 'Edit Contact',
            'active_page' => 'contact',
            'base_url' => getBaseUrl(),
            'contact' => $contact,
            'conn' => $conn
        ];

        $this->view('cms/views/contact/contact_edit', $data);
    }

    public function update($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/contact');
        }

        $errors = [];

        if (empty($_POST['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (empty($_POST['alamat'])) {
            $errors[] = 'Address is required';
        }

        if (empty($_POST['no_telp'])) {
            $errors[] = 'Phone number is required';
        }

        if (!empty($errors)) {
            setFlash('danger', implode('<br>', $errors));
            redirect('/cms/contact/edit/' . $id);
        }

        $contactData = [
            'email' => trim($_POST['email']),
            'alamat' => trim($_POST['alamat']),
            'no_telp' => trim($_POST['no_telp']),
            'is_active' => isset($_POST['is_active']) && $_POST['is_active'] == '1'
        ];

        $result = ContactModel::updateContact($id, $contactData, $conn);

        if ($result) {
            setFlash('success', 'Contact updated successfully!');
            redirect('/cms/contact');
        } else {
            setFlash('danger', 'Failed to update contact');
            redirect('/cms/contact/edit/' . $id);
        }
    }

    public function delete($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ContactModel::deleteContact($id, $conn);

        if ($result) {
            setFlash('success', 'Contact deleted successfully!');
        } else {
            setFlash('danger', 'Failed to delete contact');
        }

        redirect('/cms/contact');
    }

    public function setActive($conn, $params = [])
    {
        checkLogin();

        $id = $params['id'] ?? 0;

        $result = ContactModel::setActiveContact($id, $conn);

        if ($result) {
            setFlash('success', 'Contact set as active successfully!');
        } else {
            setFlash('danger', 'Failed to set contact as active');
        }

        redirect('/cms/contact');
    }
}