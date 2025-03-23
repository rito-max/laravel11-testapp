<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use App\Enums\User\Role;

class TransactionControllerTest extends TestCase
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

    public function test_create_post() {
        $stock = Stock::create(['name' => 'dummy']);

        //データは元々存在しない
        $this->assertCount(0, Transaction::all());
        $response = $this->actingAs($this->editUser)->post(route('stock.transaction.store', $stock), [
            'date' => '2022-10-10',
            'price' => 1000,
            'quantity' => 10,
            'type' => 1,
        ]);

        //データが作成されていることをテスト
        $this->assertCount(1, Transaction::all());

        //リダイレクト先をtest
        $response->assertRedirect(route('stock.show', $stock));

        $response = $this->actingAs($this->readUser)->post(route('stock.transaction.store', $stock), [
            'date' => '2022-10-10',
            'price' => 1000,
            'quantity' => 10,
            'type' => 1,
        ]);
        //権限がないので、403！
        $this->assertEquals(403, $response->getStatusCode());
    }
}
