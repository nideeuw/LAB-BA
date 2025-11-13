<?php

class UserModel
{
    public static function register($username, $password, $conn) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = 'INSERT INTO "user" ("username", "password") VALUES ($1, $2)';
        $result = pg_query_params($conn, $query, array($username, $hashedPassword));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function login($username, $password, $conn)
    {
        $query = 'SELECT * FROM "user" WHERE "username" = $1 AND "is_active" = TRUE';
        $result = pg_query_params($conn, $query, array($username));

        if ($row = pg_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}