<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;

class StockControllerTest extends TestCase
{
    // transaction内でテストすることによってレコードが作成されない。
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_トップにアクセスすると銘柄一覧にリダイレクトされることを確認(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * A basic feature test example.
     */
    public function test_銘柄一覧の正常形_データあり(): void
    {
        Stock::factory()->count(10)->create();
        $expected = 10;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);

        $response = $this->get('/stock');

        $response->assertSee('銘柄一覧');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_銘柄一覧の正常形_データなし(): void
    {
        $expected = 0;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);
        
        $response = $this->get('/stock');

        $response->assertOk();
    }

    /**
     * A basic feature test example.
     */
    public function test_データ新規作成_バリデーションエラー確認(): void
    {
        $response = $this->post('/stock');
        $response->assertSessionHasErrors([
            'name' => '銘柄名を入力してください。'
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_データ新規作成_バリデーションデータ作成処理確認(): void
    {
        //post前はデータが存在しないことを確認
        $expected = 0;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);
        $response = $this->post('/stock', ['name' => 'トヨタ']);

        //バリデーションエラーなし、正常ステータス
        $response->assertSessionHasNoErrors();

        //postによってデータが作成されることを確認
        $expected = 1;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);

        $stock = Stock::first();
        $this->assertEquals('トヨタ' , $stock->name);
    }
}
