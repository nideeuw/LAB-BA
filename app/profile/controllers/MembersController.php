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
     * Display member detail
     */
    public function detail($conn, $params = [])
    {
        // Get ID from params
        $id = $params['id'] ?? 0;

        if ($id === 0) {
            redirect('/members');
            return;
        }

        // Get member detail from model
        $memberDetail = MembersModel::getMemberDetailForProfile($id, $conn);

        if (!$memberDetail) {
            redirect('/members');
            return;
        }

        $publikasi_list = [];
        if (!empty($memberDetail['publikasi_list'])) {
            foreach ($memberDetail['publikasi_list'] as $pub) {
                $publikasi_list[] = [
                    'id' => $pub['id'] ?? null,
                    'judul' => $pub['title'] ?? $pub['judul'] ?? '',
                    'tahun' => $pub['year'] ?? $pub['tahun'] ?? '',
                    'kategori' => $pub['kategori_publikasi'] ?? $pub['kategori'] ?? '-',
                    'journal_name' => $pub['journal_name'] ?? '',
                    'journal_link' => $pub['journal_link'] ?? ''
                ];
            }
        }

        // Pass data to view
        $data = [
            'page_title' => $memberDetail['nama_lengkap'] . ' - Profile',
            'base_url' => getBaseUrl(),
            'member' => $memberDetail,
            'bidang_riset' => $memberDetail['bidang_riset'],
            'publikasi_list' => $publikasi_list,  // Use transformed data
            'total_publikasi' => count($publikasi_list),
            'conn' => $conn
        ];

        $this->view('profile/views/members_detail', $data);
    }
}
