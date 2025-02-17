<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\User;
use App\Enums\User\Role;

class StockControllerTest extends TestCase
{
    // transaction内でテストすることによってレコードが作成されない。
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->editUser = User::factory()->create(['role_id' => Role::Editor->value]);
        $this->readUser = User::factory()->create(['role_id' => Role::Reader->value]);
    }

    public function test_トップにアクセスすると銘柄一覧にリダイレクトされることを確認(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_銘柄一覧の正常形_データあり(): void
    {
        Stock::factory()->count(10)->create();
        $expected = 10;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);

        $response = $this->actingAs($this->editUser)->get('/stock');

        $response->assertSee('銘柄一覧');

        $response->assertOk();
    }

    public function test_銘柄一覧の正常形_データなし(): void
    {
        $expected = 0;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);
        
        $response = $this->actingAs($this->editUser)->get('/stock');

        $response->assertOk();
    }

    public function test_データ新規作成_バリデーションエラー確認(): void
    {
        $response = $this->actingAs($this->editUser)->post('/stock');
        $response->assertSessionHasErrors([
            'name' => '銘柄名を入力してください。'
        ]);
    }

    public function test_編集権限がないとデータを新規作成できないことを確認(): void
    {
        $response = $this->actingAs($this->readUser)->post('/stock', ['name' => 'トヨタ']);
        //権限エラー
        $response->assertStatus(403);
    }

    public function test_データ新規作成_バリデーションデータ作成処理確認(): void
    {
        //post前はデータが存在しないことを確認
        $expected = 0;
        $actual = Stock::count();
        $this->assertEquals($expected , $actual);
        $response = $this->actingAs($this->editUser)->post('/stock', ['name' => 'トヨタ']);
        //バリデーションエラーなし、正常ステータス
        $response->assertSessionHasNoErrors();

        //サクセスメッセージ確認
        $this->assertEquals(session('success') , '株銘柄を登録しました。');

        //postによって意図したデータが作成されることを確認
        $stock = Stock::first();
        $this->assertEquals($stock->name, 'トヨタ');
    }
}
