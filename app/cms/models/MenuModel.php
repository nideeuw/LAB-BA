<?php

class MenuModel
{
    public static function getAllMenusHierarchical($conn)
    {
        try {
            // FIX: HAPUS filter type = 'admin'
            $query = 'SELECT * FROM menu WHERE is_active = TRUE ORDER BY order_no ASC, menu_level ASC';
            $stmt = $conn->prepare($query);
            $stmt->execute(); // FIX: Hapus parameter ['type' => 'admin']
            $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return self::buildMenuTree($menus);
        } catch (PDOException $e) {
            error_log("Get menus error: " . $e->getMessage());
            return [];
        }
    }

    private static function buildMenuTree($menus, $parent_id = null)
    {
        $tree = [];

        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parent_id) {
                $menu['children'] = self::buildMenuTree($menus, $menu['id']);
                $tree[] = $menu;
            }
        }

        return $tree;
    }

    public static function getAllMenus($conn)
    {
        try {
            $query = 'SELECT m.*, 
                      p.menu_name as parent_name
                      FROM menu m
                      LEFT JOIN menu p ON m.parent_id = p.id
                      ORDER BY m.order_no ASC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get all menus error: " . $e->getMessage());
            return [];
        }
    }

    public static function getMenuById($id, $conn)
    {
        try {
            $query = 'SELECT * FROM menu WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get menu by ID error: " . $e->getMessage());
            return false;
        }
    }

    public static function getParentMenus($conn)
    {
        try {
            $query = 'SELECT id, menu_name, menu_level, type
                      FROM menu 
                      WHERE is_active = TRUE
                      ORDER BY order_no ASC';
            $stmt = $conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get parent menus error: " . $e->getMessage());
            return [];
        }
    }

    public static function createMenu($data, $conn)
    {
        try {
            $query = 'INSERT INTO menu (
                        menu_name, parent_id, order_no, menu_level, 
                        type, menu_icon, slug, is_label, is_active,
                        created_by, created_on
                      ) VALUES (
                        :menu_name, :parent_id, :order_no, :menu_level,
                        :type, :menu_icon, :slug, :is_label, :is_active,
                        :created_by, NOW()
                      )';

            $stmt = $conn->prepare($query);
            $stmt->execute([
                'menu_name' => $data['menu_name'],
                'parent_id' => $data['parent_id'] ?: null,
                'order_no' => $data['order_no'],
                'menu_level' => $data['menu_level'],
                'type' => $data['type'],
                'menu_icon' => $data['menu_icon'],
                'slug' => $data['slug'],
                'is_label' => $data['is_label'] ?? false,
                'is_active' => $data['is_active'] ?? true,
                'created_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            return $conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Create menu error: " . $e->getMessage());
            return false;
        }
    }

    public static function updateMenu($id, $data, $conn)
    {
        try {
            $query = 'UPDATE menu SET 
                        menu_name = :menu_name,
                        parent_id = :parent_id,
                        order_no = :order_no,
                        menu_level = :menu_level,
                        type = :type,
                        menu_icon = :menu_icon,
                        slug = :slug,
                        is_label = :is_label,
                        is_active = :is_active,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id';

            $stmt = $conn->prepare($query);
            $stmt->execute([
                'id' => $id,
                'menu_name' => $data['menu_name'],
                'parent_id' => $data['parent_id'] ?: null,
                'order_no' => $data['order_no'],
                'menu_level' => $data['menu_level'],
                'type' => $data['type'],
                'menu_icon' => $data['menu_icon'],
                'slug' => $data['slug'],
                'is_label' => $data['is_label'] ?? false,
                'is_active' => $data['is_active'] ?? true,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Update menu error: " . $e->getMessage());
            return false;
        }
    }

    public static function deleteMenu($id, $conn)
    {
        try {
            $query = 'SELECT COUNT(*) as count FROM menu WHERE parent_id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                return ['success' => false, 'message' => 'Cannot delete menu with sub-menus'];
            }

            $query = 'UPDATE menu SET 
                        is_active = FALSE,
                        modified_by = :modified_by,
                        modified_on = NOW()
                      WHERE id = :id';
            $stmt = $conn->prepare($query);
            $stmt->execute([
                'id' => $id,
                'modified_by' => $_SESSION['user_name'] ?? 'system'
            ]);

            return ['success' => true, 'message' => 'Menu deleted successfully'];
        } catch (PDOException $e) {
            error_log("Delete menu error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error deleting menu'];
        }
    }

    public static function generateSlug($menuName, $conn, $excludeId = null)
    {
        $slug = strtolower(trim($menuName));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        $originalSlug = $slug;
        $counter = 1;

        while (self::slugExists($slug, $conn, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private static function slugExists($slug, $conn, $excludeId = null)
    {
        try {
            $query = 'SELECT COUNT(*) as count FROM menu WHERE slug = :slug';
            if ($excludeId) {
                $query .= ' AND id != :id';
            }

            $stmt = $conn->prepare($query);
            $params = ['slug' => $slug];
            if ($excludeId) {
                $params['id'] = $excludeId;
            }

            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
