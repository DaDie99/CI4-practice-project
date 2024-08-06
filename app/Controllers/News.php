<?php
namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data['news_list'] = $model->getNews();

        echo view('templates/header', $data);
        echo view('news/index', $data);
        echo view('templates/footer', $data);
    }

    public function show(?string $slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        echo view('templates/header', $data);
        echo view('news/show', $data);
        echo view('templates/footer', $data);
    }
}
