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
        $response = $this->from('/')->post('/', [
            'title' => 'testtitle',
            'content' => 'testcontent',
            'user_id' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

}
