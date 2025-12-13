<?php

/**
 * Search Model
 * File: app/cms/models/SearchModel.php
 * Purpose: Unified search across all content types
 */

class SearchModel
{
    /**
     * Search across all content
     * Returns array of results with type, title, preview, url, icon
     * $context: 'landing' or 'cms' - determines URLs
     */
    public static function searchAll($query, $conn, $context = 'landing', $limit = 20)
    {
        $results = [];
        $query = trim($query);

        if (strlen($query) < 2) {
            return $results;
        }

        // Escape for LIKE query
        $searchTerm = '%' . $query . '%';

        try {
            // 1. Search Members
            $members = self::searchMembers($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $members);

            // 2. Search Gallery
            $gallery = self::searchGallery($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $gallery);

            // 3. Search Publications
            $publications = self::searchPublications($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $publications);

            // 4. Search Researches
            $researches = self::searchResearches($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $researches);

            // 5. Search Profile Lab
            $profileLab = self::searchProfileLab($searchTerm, $conn, $context);
            $results = array_merge($results, $profileLab);

            // 6. Search Visi Misi
            $visiMisi = self::searchVisiMisi($searchTerm, $conn, $context);
            $results = array_merge($results, $visiMisi);

            // 7. Search Research Focus
            $researchFocus = self::searchResearchFocus($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $researchFocus);

            // 8. Search Research Scope
            $researchScope = self::searchResearchScope($searchTerm, $conn, $context);
            $results = array_merge($results, $researchScope);

            // 9. Search Roadmap
            $roadmap = self::searchRoadmap($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $roadmap);

            // 10. Search Banner
            $banner = self::searchBanner($searchTerm, $conn, $context, $limit);
            $results = array_merge($results, $banner);

            // 11. Search Contact
            $contact = self::searchContact($searchTerm, $conn, $context);
            $results = array_merge($results, $contact);

            // 12. Search Lab Bookings (CMS only)
            if ($context === 'cms') {
                $bookings = self::searchLabBookings($searchTerm, $conn, $limit);
                $results = array_merge($results, $bookings);

                $userBookings = self::searchUserBookings($searchTerm, $conn, $limit);
                $results = array_merge($results, $userBookings);
            }

            // 13. Search Menus (CMS only)
            if ($context === 'cms') {
                $menus = self::searchMenus($searchTerm, $conn, $limit);
                $results = array_merge($results, $menus);
            }

            // 14. Search Users (CMS only)
            if ($context === 'cms') {
                $users = self::searchUsers($searchTerm, $conn, $limit);
                $results = array_merge($results, $users);
            }

            // 15. Search Roles (CMS only)
            if ($context === 'cms') {
                $roles = self::searchRoles($searchTerm, $conn, $limit);
                $results = array_merge($results, $roles);
            }

            // Limit total results
            if (count($results) > $limit) {
                $results = array_slice($results, 0, $limit);
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search all error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Members
     */
    private static function searchMembers($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT 
                        id, nama, gelar_depan, gelar_belakang, jabatan, email
                      FROM members 
                      WHERE is_active = TRUE 
                      AND (
                          nama ILIKE :search 
                          OR gelar_depan ILIKE :search 
                          OR gelar_belakang ILIKE :search
                          OR jabatan ILIKE :search
                          OR email ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $fullName = self::buildFullName($row);
                $preview = $row['jabatan'] ?? '';
                if ($row['email']) {
                    $preview .= ($preview ? ' • ' : '') . $row['email'];
                }

                $url = $context === 'cms'
                    ? '/cms/members/edit/' . $row['id']
                    : '/members/detail/' . $row['id'];

                $results[] = [
                    'type' => 'Member',
                    'title' => $fullName,
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-user'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search members error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Gallery
     */
    private static function searchGallery($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT id, title, description, date
                      FROM gallery 
                      WHERE is_active = TRUE 
                      AND (title ILIKE :search OR description ILIKE :search)
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = $row['description'] ? self::truncate($row['description'], 100) : '';
                if ($row['date']) {
                    $preview = date('d M Y', strtotime($row['date'])) . ($preview ? ' • ' . $preview : '');
                }

                $url = $context === 'cms'
                    ? '/cms/gallery/edit/' . $row['id']
                    : '/gallery#item-' . $row['id'];

                $results[] = [
                    'type' => 'Gallery',
                    'title' => $row['title'],
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-images'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search gallery error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Publications
     */
    private static function searchPublications($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT 
                        p.id, p.title, p.journal_name, p.year, p.id_members,
                        m.nama, m.gelar_depan, m.gelar_belakang
                      FROM publications p
                      LEFT JOIN members m ON p.id_members = m.id
                      WHERE p.is_active = TRUE 
                      AND (
                          p.title ILIKE :search 
                          OR p.journal_name ILIKE :search
                          OR m.nama ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $author = $row['nama'] ? self::buildFullName($row) : 'Unknown Author';
                $preview = $author . ' • ' . ($row['year'] ?? 'N/A');
                if ($row['journal_name']) {
                    $preview .= ' • ' . $row['journal_name'];
                }

                $url = $context === 'cms'
                    ? '/cms/publications/edit/' . $row['id']
                    : '/members/detail/' . $row['id_members'] . '#publications';

                $results[] = [
                    'type' => 'Publication',
                    'title' => $row['title'],
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-book'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search publications error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Researches
     */
    private static function searchResearches($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT 
                        r.id, r.title, r.deskripsi,
                        m.nama, m.gelar_depan, m.gelar_belakang
                      FROM researches r
                      LEFT JOIN members m ON r.id_members = m.id
                      WHERE r.is_active = TRUE 
                      AND (
                          r.title ILIKE :search 
                          OR r.deskripsi ILIKE :search
                          OR m.nama ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = '';
                if ($row['nama']) {
                    $preview = self::buildFullName($row);
                }
                if ($row['deskripsi']) {
                    $preview .= ($preview ? ' • ' : '') . self::truncate($row['deskripsi'], 80);
                }

                $url = $context === 'cms'
                    ? '/cms/researches/edit/' . $row['id']
                    : '/members?research=' . urlencode($row['title']);

                $results[] = [
                    'type' => 'Research',
                    'title' => $row['title'],
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-flask'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search researches error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Profile Lab
     */
    private static function searchProfileLab($searchTerm, $conn, $context)
    {
        try {
            $query = "SELECT id, title, description
                      FROM profile_lab 
                      WHERE is_active = TRUE 
                      AND (title ILIKE :search OR description ILIKE :search)
                      LIMIT 1";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            $results = [];
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $url = $context === 'cms'
                    ? '/cms/profile_lab/edit/' . $row['id']
                    : '/#about-lab';

                $results[] = [
                    'type' => 'About Lab',
                    'title' => $row['title'],
                    'preview' => self::truncate($row['description'], 120),
                    'url' => $url,
                    'icon' => 'fas fa-info-circle'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search profile lab error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Visi Misi
     */
    private static function searchVisiMisi($searchTerm, $conn, $context)
    {
        try {
            $query = "SELECT id, visi, misi
                      FROM visi_misi 
                      WHERE is_active = TRUE 
                      AND (visi ILIKE :search OR misi ILIKE :search)
                      LIMIT 1";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            $results = [];
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = '';
                if (stripos($row['visi'], str_replace('%', '', $searchTerm)) !== false) {
                    $preview = 'Visi: ' . self::truncate($row['visi'], 100);
                } else {
                    $preview = 'Misi: ' . self::truncate($row['misi'], 100);
                }

                $url = $context === 'cms'
                    ? '/cms/visi_misi/edit/' . $row['id']
                    : '/#visi-misi';

                $results[] = [
                    'type' => 'Visi & Misi',
                    'title' => 'Visi & Misi Lab BA',
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-bullseye'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search visi misi error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Research Focus
     */
    private static function searchResearchFocus($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT id, title, focus_description, examples
                      FROM research_focus 
                      WHERE is_active = TRUE 
                      AND (
                          title ILIKE :search 
                          OR focus_description ILIKE :search 
                          OR examples ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = self::truncate($row['focus_description'], 100);

                $url = $context === 'cms'
                    ? '/cms/research_focus/edit/' . $row['id']
                    : '/#research-focus';

                $results[] = [
                    'type' => 'Research Focus',
                    'title' => $row['title'],
                    'preview' => $preview,
                    'url' => $url,
                    'icon' => 'fas fa-microscope'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search research focus error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Research Scope
     */
    private static function searchResearchScope($searchTerm, $conn, $context)
    {
        try {
            $query = "SELECT id, title, description
                      FROM research_scope 
                      WHERE is_active = TRUE 
                      AND (title ILIKE :search OR description ILIKE :search)
                      LIMIT 1";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            $results = [];
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $url = $context === 'cms'
                    ? '/cms/research_scope/edit/' . $row['id']
                    : '/#research-scope';

                $results[] = [
                    'type' => 'Research Scope',
                    'title' => $row['title'],
                    'preview' => self::truncate($row['description'], 120),
                    'url' => $url,
                    'icon' => 'fas fa-globe'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search research scope error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Roadmap
     */
    private static function searchRoadmap($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT id, title, content
                      FROM roadmap 
                      WHERE is_active = TRUE 
                      AND (title ILIKE :search OR content ILIKE :search)
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $url = $context === 'cms'
                    ? '/cms/roadmap/edit/' . $row['id']
                    : '/#roadmap';

                $results[] = [
                    'type' => 'Roadmap',
                    'title' => $row['title'],
                    'preview' => self::truncate($row['content'], 120),
                    'url' => $url,
                    'icon' => 'fas fa-road'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search roadmap error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Banner
     */
    private static function searchBanner($searchTerm, $conn, $context, $limit)
    {
        try {
            $query = "SELECT id, image, created_on
                      FROM banner 
                      WHERE is_active = TRUE 
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($context === 'cms') {
                    $results[] = [
                        'type' => 'Banner',
                        'title' => 'Banner #' . $row['id'],
                        'preview' => 'Created: ' . date('d M Y', strtotime($row['created_on'])),
                        'url' => '/cms/banner/edit/' . $row['id'],
                        'icon' => 'fas fa-image'
                    ];
                }
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search banner error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Contact
     */
    private static function searchContact($searchTerm, $conn, $context)
    {
        try {
            $query = "SELECT id, email, alamat, no_telp
                      FROM contact 
                      WHERE is_active = TRUE 
                      AND (email ILIKE :search OR alamat ILIKE :search OR no_telp ILIKE :search)
                      LIMIT 1";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            $results = [];
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $url = $context === 'cms'
                    ? '/cms/contact/edit/' . $row['id']
                    : '/#contact';

                $results[] = [
                    'type' => 'Contact',
                    'title' => 'Contact Information',
                    'preview' => $row['email'] . ' • ' . $row['no_telp'],
                    'url' => $url,
                    'icon' => 'fas fa-phone'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search contact error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Lab Bookings (CMS only)
     */
    private static function searchLabBookings($searchTerm, $conn, $limit)
    {
        try {
            $query = "SELECT 
                        lb.id, lb.tanggal_mulai, lb.jam_mulai, lb.deskripsi, lb.status,
                        ub.nama as peminjam_name
                      FROM lab_bookings lb
                      LEFT JOIN user_bookings ub ON lb.id_peminjam = ub.id
                      WHERE (
                          ub.nama ILIKE :search 
                          OR lb.deskripsi ILIKE :search
                          OR lb.status ILIKE :search
                      )
                      ORDER BY lb.tanggal_mulai DESC
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = $row['peminjam_name'] . ' • ' .
                    date('d M Y', strtotime($row['tanggal_mulai'])) . ' ' .
                    substr($row['jam_mulai'], 0, 5) . ' • ' .
                    ucfirst($row['status']);

                $results[] = [
                    'type' => 'Lab Booking',
                    'title' => $row['deskripsi'] ?: 'Booking #' . $row['id'],
                    'preview' => $preview,
                    'url' => '/cms/lab_bookings/edit/' . $row['id'],
                    'icon' => 'fas fa-calendar-check'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search lab bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search User Bookings (CMS only)
     */
    private static function searchUserBookings($searchTerm, $conn, $limit)
    {
        try {
            $query = "SELECT id, nama, nip, email, no_telp, category
                      FROM user_bookings 
                      WHERE (
                          nama ILIKE :search 
                          OR nip ILIKE :search 
                          OR email ILIKE :search
                          OR no_telp ILIKE :search
                          OR category ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = $row['nip'] . ' • ' . ucfirst($row['category']) . ' • ' . $row['email'];

                $results[] = [
                    'type' => 'User Booking',
                    'title' => $row['nama'],
                    'preview' => $preview,
                    'url' => '/cms/user_bookings/edit/' . $row['id'],
                    'icon' => 'fas fa-user-tag'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search user bookings error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Menus (CMS only)
     */
    private static function searchMenus($searchTerm, $conn, $limit)
    {
        try {
            $query = "SELECT id, menu_name, slug, type, menu_level
                      FROM menu 
                      WHERE is_active = TRUE 
                      AND (
                          menu_name ILIKE :search 
                          OR slug ILIKE :search
                      )
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $preview = 'Level ' . $row['menu_level'] . ' • ' . ucfirst($row['type']) . ' • ' . $row['slug'];

                $results[] = [
                    'type' => 'Menu',
                    'title' => $row['menu_name'],
                    'preview' => $preview,
                    'url' => '/cms/menu/edit/' . $row['id'],
                    'icon' => 'fas fa-bars'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search menus error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Users (CMS only)
     */
    private static function searchUsers($searchTerm, $conn, $limit)
    {
        try {
            $query = "SELECT id, username, created_on
                      FROM users 
                      WHERE is_active = TRUE 
                      AND username ILIKE :search
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = [
                    'type' => 'User',
                    'title' => $row['username'],
                    'preview' => 'Created: ' . date('d M Y', strtotime($row['created_on'])),
                    'url' => '/cms/users/edit/' . $row['id'],
                    'icon' => 'fas fa-user-shield'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search users error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search Roles (CMS only)
     */
    private static function searchRoles($searchTerm, $conn, $limit)
    {
        try {
            $query = "SELECT id, role_name, role_code
                      FROM role 
                      WHERE is_active = TRUE 
                      AND (role_name ILIKE :search OR role_code ILIKE :search)
                      LIMIT :limit";

            $stmt = $conn->prepare($query);
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = [
                    'type' => 'Role',
                    'title' => $row['role_name'],
                    'preview' => 'Code: ' . $row['role_code'],
                    'url' => '/cms/roles/edit/' . $row['id'],
                    'icon' => 'fas fa-user-cog'
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Search roles error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper: Build full name with titles
     */
    private static function buildFullName($person)
    {
        $name = '';

        if (!empty($person['gelar_depan'])) {
            $name .= $person['gelar_depan'] . ' ';
        }

        $name .= $person['nama'];

        if (!empty($person['gelar_belakang'])) {
            $name .= ', ' . $person['gelar_belakang'];
        }

        return $name;
    }

    /**
     * Helper: Truncate text
     */
    private static function truncate($text, $length = 100)
    {
        $text = strip_tags($text);
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }

    /**
     * Get search statistics
     */
    public static function getSearchStats($query, $conn)
    {
        $results = self::searchAll($query, $conn, 100);

        $stats = [
            'total' => count($results),
            'by_type' => []
        ];

        foreach ($results as $result) {
            $type = $result['type'];
            if (!isset($stats['by_type'][$type])) {
                $stats['by_type'][$type] = 0;
            }
            $stats['by_type'][$type]++;
        }

        return $stats;
    }
}
