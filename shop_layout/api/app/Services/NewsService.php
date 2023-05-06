<?php

namespace App\Services;

use App\Models\News;

class NewsService implements NewsServiceInterface
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function create($params)
    {
        $this->news->create($params);
    }

    public function get()
    {
        $data = $this->news->get();
        return $data->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'image' => $item->image,
                'status' => $item->status == 1 ? true : false,
            ];
        });
    }

    public function update($id, $params)
    {
        $this->news->findOrFail($id)->update($params);
    }

    public function detail($id)
    {
        return $this->news->findOrFail($id);
    }

    public function getNewList() {
        return $this->news->where('status', 1)->limit(3)->get();
    }

    public function detailBySlug($slug)
    {
        return $this->news->where('slug', $slug)->first();
    }

    public function getAll()
    {
        return $this->news->where('status', 1)->paginate();
    }
}
