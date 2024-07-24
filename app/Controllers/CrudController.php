<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class CrudController extends Controller
{
    private $jsonPlaceholderUrl = "https://jsonplaceholder.typicode.com/posts";

    public function index()
    {
        return view('crud_view');
    }

    public function fetchAll()
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get($this->jsonPlaceholderUrl);
        return $this->response->setJSON($response->getBody());
    }

    public function fetchSingle($id)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get("$this->jsonPlaceholderUrl/$id");
        return $this->response->setJSON($response->getBody());
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $client = \Config\Services::curlrequest();
        $response = $client->post($this->jsonPlaceholderUrl, [
            'json' => $data
        ]);
        return $this->response->setJSON($response->getBody());
    }

    public function update($id)
    {
        $data = $this->request->getJSON();
        $client = \Config\Services::curlrequest();
        $response = $client->put("$this->jsonPlaceholderUrl/$id", [
            'json' => $data
        ]);
        return $this->response->setJSON($response->getBody());
    }

    public function delete($id)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->delete("$this->jsonPlaceholderUrl/$id");
        return $this->response->setJSON($response->getBody());
    }
}
