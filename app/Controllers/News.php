<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

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
        helper('form');
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        echo view('templates/header', $data);
        echo view('news/show', $data);
        echo view('templates/footer', $data);
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body']);

        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            return view('templates/header', ['title' => 'Create a news item'])
                . view('news/create')
                . view('templates/footer');
        }

        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }

    public function update($id = null)
    {
        helper('form');
        $model = model(NewsModel::class);

        $data = $model->find($id);

        if (empty($data)) {
            throw new PageNotFoundException('Cannot find the news item: ' . $id);
        }

        if ($this->request->getMethod() === 'post') {
            $postData = $this->request->getPost(['title', 'body']);

            if (! $this->validateData($postData, [
                'title' => 'required|max_length[255]|min_length[3]',
                'body'  => 'required|max_length[5000]|min_length[10]',
            ])) {
                return view('templates/header', ['title' => 'Edit news item'])
                    . view('news/edit', ['news' => $data])
                    . view('templates/footer');
            }

            $validatedData = $this->validator->getValidated();

            $model->update($id, [
                'title' => $validatedData['title'],
                'slug'  => url_title($validatedData['title'], '-', true),
                'body'  => $validatedData['body'],
            ]);

            return view('templates/header', ['title' => 'Edit news item'])
                . view('news/success')
                . view('templates/footer');
        }

        return view('templates/header', ['title' => 'Edit news item'])
            . view('news/edit', ['news' => $data])
            . view('templates/footer');
    }
    public function new()
{
    helper('form');

    return view('templates/header', ['title' => 'Create a news item'])
        . view('news/create')
        . view('templates/footer');
}

}
