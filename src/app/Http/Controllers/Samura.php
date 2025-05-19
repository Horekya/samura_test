<?php

namespace App\Http\Controllers;

use App\Repository\OzonApiRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Samura extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function index(OzonApiRepository $api)
    {
        $data = $api->get_items();
        return view('index', compact('data'));
    }

    /**
     * @throws ConnectionException
     */
    public function show(OzonApiRepository $api, $id)
    {
        return redirect('');
    }

    /**
     * @throws ConnectionException
     */
    public function table(OzonApiRepository $api)
    {
        $data = $api->get_table();
        return view('table', compact('data'));
    }

}
