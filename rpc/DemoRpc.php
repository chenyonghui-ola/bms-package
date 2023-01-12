<?php

namespace Imee\Models\Rpc;

use GuzzleHttp\Psr7\Response;
use Imee\Libs\Rpc\BaseRpc;

/**
 * 使用说明：
 * 统一放置在model下面
 * $obj = new DemoRpc();
 * 1.url传参
 * $obj->call(
 * DemoRpc::API_PRICE_LEVEL, ['query' => []]
 * );
 * 2.json传参
 * $obj->call(
 * DemoRpc::API_PRICE_LEVEL, ['json' => []]
 * );
 * 3.post x-www-form-urlencoded
 * $obj->call(
 * DemoRpc::API_PRETTY_LIST, ['form_params' => []]
 * );
 * 4.post form-data
 * $obj->call(
 * DemoRpc::API_PRETTY_LIST, ['multipart' => [
 * [
 * 'name'     => 'file',
 * 'contents' => $fileContent,
 * 'filename' => 'file_name.txt'
 * ],
 * [
 * 'name'     => 'test_name',
 * 'contents' => 'test_value'
 * ],
 * ]
 * );
 */

/**
 * 接口调用配置
 */
class DemoRpc extends BaseRpc
{
    const API_PRICE_LEVEL = 'price_level';
    const API_UPDATE_PRICE_LEVEL = 'price_level_update';

    protected $apiConfig = [
        'domain' => 'http://ip',
        'host' => 'www'
    ];

    public $apiList = [
        self::API_UPDATE_PRICE_LEVEL => [
            'path' => '/go/internal/cms/updateUserExp?format=json',
            'method' => 'post',
        ],
        self::API_PRICE_LEVEL => [
            'path' => '/go/internal/cms/listUserExp?format=json',
            'method' => 'post',
        ],
    ];

    protected function serviceConfig(): array
    {
        $config = $this->apiConfig;
        $config['options'] = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'connect_timeout' => 5,
            'timeout' => 10,
        ];

        $config['retry'] = [
            'max' => 1,
            'delay' => 100,
        ];

        return $config;
    }

    protected function decode(Response $response = null, $code = 200): array
    {
        if ($response) {
            return [json_decode($response->getBody(), true), $response->getStatusCode()];
        }

        return [null, 500];
    }
}