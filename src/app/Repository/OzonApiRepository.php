<?php

namespace App\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OzonApiRepository{

    private function get_part($limit = '1000', $offset = '')
    {
        $response = Http::withHeaders([
            'Client-Id' => env('CLIENT_ID'),
            'Api-Key' => env('API_KEY'),
        ])->post('https://api-seller.ozon.ru/v3/product/list', [
            'filter' => ['visibility' => 'ALL'],
            'last_id' => $offset,
            'limit' => $limit
        ]);
        $data = $response->json();
        return $data;
    }
    private function get_goods()
    {
        $data = [];
        $ids = [];
        $part_data = $this->get_part();
        foreach ($part_data['result']['items'] as $item) {
            $data []= $item;
        }
        if(!Cache::has('samura_keys')){
            Cache::put('samura_keys', $this->form_keys($data),120);
        }
        if(!Cache::has('samura_ids')){
            Cache::put('samura_ids', $this->form_ids($data),120);
        }
        return $data;
    }
    public function all()
    {
        return Cache::flexible('samura_goods', [60,120], function () {
            return $this->get_goods();
        });
    }
    private function form_keys($data)
    {
        $keys = [];
        foreach ($data[0] as $key => $value) {
            $keys[] = $key;
        }
        return $keys;
    }
    private function form_ids($data): array
    {
        $ids = [];
        foreach ($data as $value) {
            $ids[] = $value['product_id'];
        }
        return $ids;
    }
    private function get_ids()
    {
        return Cache::flexible('samura_ids', [60,120], function () {
            return $this->form_ids($this->all());
        });
    }
    public function get_keys()
    {
        return Cache::flexible('samura_keys', [60,120], function () {
            return $this->form_keys($this->all());
        });
    }
    public function get_table()
    {
        $result = [];
        $result['goods'] = $this->all();
        $result['keys'] = $this->get_keys();
        return $result;
    }
    private function get_items_info($ids)
    {
        $response = Http::withHeaders([
            'Client-Id' => env('CLIENT_ID'),
            'Api-Key' => env('API_KEY'),
        ])->post('https://api-seller.ozon.ru/v3/product/info/list', [
            'product_id' => $ids
        ]);
        $data = $response->json();
        return array_key_exists('items',$data) ? $data['items'] : $data;
    }
    public function get_items()
    {
        return Cache::flexible('samura_items', [60,120], function() {
            return $this->get_items_info($this->get_ids());
        });
    }
}
