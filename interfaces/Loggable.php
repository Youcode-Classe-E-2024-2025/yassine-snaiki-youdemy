<?php

namespace app\interfaces;

interface Loggable {
    public static function getAll();
    public static function getPaginated($limit,$offset);
    public static function count();
    public function getCourses();
}