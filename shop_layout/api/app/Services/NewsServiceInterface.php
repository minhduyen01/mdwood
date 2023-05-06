<?php

namespace App\Services;

interface NewsServiceInterface
{
    public function create($params);

    public function get();

    public function update($id, $params);

    public function detail($id);

    public function getNewList();

    public function detailBySlug($slug);

    public function getAll();
}
