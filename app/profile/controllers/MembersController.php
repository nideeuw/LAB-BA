<?php

class MembersController extends Controller
{
    /**
     * Display members list (landing page)
     */
    public function index($conn)
    {
        // Get filter from query string
        $filter_riset = $_GET['riset'] ?? 'all';

        // Get research fields for filter dropdown
        $riset_list = MembersModel::getResearchFields($conn);

        // Get active members with research fields
        $members = MembersModel::getActiveMembersWithResearch($conn, $filter_riset);

        // Separate kepala lab and anggota
        $kepala_lab = null;
        $anggota = [];

        if ($members) {
            foreach ($members as $m) {
                if ($m['is_kepala_lab'] === true || $m['is_kepala_lab'] === 't' || $m['is_kepala_lab'] == 1) {
                    $kepala_lab = $m;
                } else {
                    $anggota[] = $m;
                }
            }
        }

        // Pass data to view
        $data = [
            'page_title' => 'Our Team',
            'base_url' => getBaseUrl(),
            'riset_list' => $riset_list,
            'filter_riset' => $filter_riset,
            'kepala_lab' => $kepala_lab,
            'anggota' => $anggota,
            'conn' => $conn
        ];

        $this->view('profile/views/members', $data);
    }

    /**
     * Display member detail with pagination for publications
     */
    public function detail($conn, $params = [])
    {
        // Get ID from params
        $id = $params['id'] ?? 0;

        if ($id === 0) {
            redirect('/members');
            return;
        }

        // Get pagination parameters
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = 10; // Publications per page

        // Get member detail from model
        $memberDetail = MembersModel::getMemberDetailForProfile($id, $conn);

        if (!$memberDetail) {
            redirect('/members');
            return;
        }

        // Get all publications for this member
        $allPublikasi = $memberDetail['publikasi_list'] ?? [];
        $totalPublikasi = count($allPublikasi);

        // Calculate pagination
        $totalPages = ceil($totalPublikasi / $pageSize);
        $offset = ($page - 1) * $pageSize;

        // Slice publications for current page
        $publikasi_list = array_slice($allPublikasi, $offset, $pageSize);

        // Transform publikasi data
        $transformedPublikasi = [];
        foreach ($publikasi_list as $pub) {
            $transformedPublikasi[] = [
                'id' => $pub['id'] ?? null,
                'judul' => $pub['title'] ?? $pub['judul'] ?? '',
                'tahun' => $pub['year'] ?? $pub['tahun'] ?? '',
                'kategori' => $pub['kategori_publikasi'] ?? $pub['kategori'] ?? '-',
                'journal_name' => $pub['journal_name'] ?? '',
                'journal_link' => $pub['journal_link'] ?? ''
            ];
        }

        // Pass data to view
        $data = [
            'page_title' => $memberDetail['nama_lengkap'] . ' - Profile',
            'base_url' => getBaseUrl(),
            'member' => $memberDetail,
            'bidang_riset' => $memberDetail['bidang_riset'],
            'publikasi_list' => $transformedPublikasi,
            'total_publikasi' => $totalPublikasi,
            'page' => $page,
            'pageSize' => $pageSize,
            'totalPages' => $totalPages,
            'conn' => $conn
        ];

        $this->view('profile/views/members_detail', $data);
    }
}
