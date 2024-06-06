<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testIndexViewAccessIsShow(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('index');
    }

    public function testPostArticleIsSuccessfully(): void
    {
        $response = $this->post('/', [
            'title' => 'testtitle',
            'body' => 'testbody',
            'thumbnail' => [
                'name' => 'testicon.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'testicon.jpg',
                'error' => 0,
                'size' => 1024
            ],
            'postImage' => [
                'name' => 'testicon.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'testicon.jpg',
                'error' => 0,
                'size' => 1024
            ],
            'tags' => ['tag1', 'tag2']
        ]);

        $response->assertStatus(200);
    }
}
