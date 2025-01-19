<?php

namespace app\models;

use app\core\Application;

class Admin extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($id, $email, $password, $username, 'admin', $isactive);
    }
}