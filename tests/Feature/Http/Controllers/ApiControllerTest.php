<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // DatabaseSeederを実行
        $this->seed();
    }

    public function test_APIトークン発行(): void
    {
        //パラーメータが不正パターン
        //存在しない
        $response = $this->post('/api/tokens/create', [
            'email' => 'noexist@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(401);

        //emailがない
        $response = $this->post('/api/tokens/create', [
            'password' => 'password',
        ]);
        $response->assertStatus(401);

         //emailがnull
         $response = $this->post('/api/tokens/create', [
            'email' => null,
            'password' => 'password',
        ]);
        $response->assertStatus(401);

        //正常認証
        $response = $this->post('/api/tokens/create', [
            'email' => 'reader@example.com',
            'password' => 'password',
        ]);
        $response->assertOk();

        $response = $this->post('/api/tokens/create', [
            'email' => 'editor@example.com',
            'password' => 'password',
        ]);
        $response->assertOk();

        $this->assertEquals($response['token_type'] , 'Bearer');
        $this->assertNotNull($response['token']);
    }

    public function test_APIトークン_権限制御CHECK(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['edit']
        );
     
        $response = $this->get('/api/stocks');
        $response->assertOk();
        //正常にデータ作成可能
        $response = $this->post('/api/stock/create', ['name' => 'test']);
        $response->assertStatus(201);
     
        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );

        //readは可能
        $response = $this->get('/api/stocks');
        $response->assertOk();
        //token ability 権限エラー
        $response = $this->post('/api/stock/create', ['name' => 'test']);
        $response->assertStatus(403);
    }
}
