<?php

namespace app\core;

use app\core\Application;

class Database{
    private $pdo;
    private $stmt;
        public function __construct(){
        $config = require_once(Application::$ROOT_DIR."/config/database.php");
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";    
        try {
            $this->pdo = new \PDO($dsn, $config['user'], $config['password']);
        } catch (\PDOException $e) {
            if (strpos($e->getMessage() , 'does not exist')!==false) {
                $this->createDatabase($config);
            } else {
                throw $e;
            }
        }
        $this->createTables();
    }
    private function createDatabase($config) {
        $dsn = "pgsql:host={$config['host']};port={$config['port']}";
        $pdo = new \PDO($dsn, $config['user'], $config['password']);
        $pdo->exec("CREATE DATABASE {$config['dbname']}");
        $this->pdo = new \PDO($dsn.";dbname={$config['dbname']}", $config['user'], $config['password']);
    }
    private function createTables() {
        $this->pdo->exec('
            CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
        ');
    
        // Users Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(255) NOT NULL CHECK (role IN ('student', 'teacher', 'admin')) DEFAULT 'student',
                is_active BOOLEAN NOT NULL DEFAULT TRUE
            )
        ");
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS teaching_requests (
                id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
                user_id UUID NOT NULL REFERENCES users(id)
            )
        ");
    
        // Categories Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (
                name VARCHAR(255) PRIMARY KEY
            )
        ");
    
        // Tags Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS tags (
                name VARCHAR(255) PRIMARY KEY
            )
        ");
    
        // Courses Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS courses (
                id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                content TEXT NOT NULL,
                content_type text check(content_type in ('document','video')) NOT NULL DEFAULT 'text',
                thumbnail text NOT NULL DEFAULT 'https://embed-ssl.wistia.com/deliveries/5cd59211cdc35bba92c2560fefd00527.webp?image_crop_resized=960x540',
                teacher_id UUID NOT NULL REFERENCES users(id),
                category_name VARCHAR(255) NOT NULL REFERENCES categories(name) on update cascade,
                vector tsvector generated always as (setweight(to_tsvector('english',coalesce(title)),'A') || setweight(to_tsvector('english',coalesce(description)),'B')) stored
            )
        ");

        $this->pdo->exec("CREATE INDEX IF NOT EXISTS course_vector_index on courses using gin (vector);");
        // Course_Tags Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS course_tags (
                course_id UUID NOT NULL REFERENCES courses(id),
                tag_name VARCHAR(255) NOT NULL REFERENCES tags(name) on update cascade,
                PRIMARY KEY (course_id, tag_name)
            )
        ");
    
        // Enrollments Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS enrollments (
                student_id UUID NOT NULL REFERENCES users(id),
                course_id UUID NOT NULL REFERENCES courses(id),
                PRIMARY KEY (student_id, course_id)
            )
        ");
    
        // Notifications Table
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS notifications (
                id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
                user_id UUID NOT NULL REFERENCES users(id),
                message TEXT NOT NULL,
                is_read BOOLEAN NOT NULL DEFAULT FALSE
            )
        ");
    
        // Insert admin user if none exists
        $count = $this->query("SELECT COUNT(*) FROM users")->getOne()['count'];
        if ($count === 0) {
            $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
            $this->pdo->exec("
                INSERT INTO users (username, email, password, role)
                VALUES ('admin', 'admin@gmail.com', '$hashedPassword', 'admin')
            ");
        }
    }
    public function query($query,$params=[]) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $this->stmt = $stmt;
        return $this;
    }
    public function getOne(){
        return $this->stmt->fetch();
    }
    public function getAll(){
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}