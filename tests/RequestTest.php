<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 13/04/2020
 * Time: 12:47 PM
 */

namespace Dlabs\PaginateApi;


use Dlabs\PaginateApi\Test\TestCase;

class RequestTest extends TestCase
{

    public function test_that_response_is_successful_when_paginate_api_method_is_used()
    {
        $response = $this->json('GET', '/');
        $response->assertStatus(200);
    }


    public function test_that_offset_in_request_can_be_used()
    {
        $this->mockTestModel(5);
        $response = $this->json('GET', '/?offset=2');
        $response->assertJsonFragment([
            'offset' => 2
        ]);
    }
}