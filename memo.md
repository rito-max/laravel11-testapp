# セッションにアクセスする方法

-   Request Instance

```
   //こんな感じで、セッションデータにアクセスできます。
   $value = $request->session()->get('key');
   //保存
   $request->session()->put('key', 'value');
   //削除＆取得
   $value = $request->session()->pull('key', 'default');
　　//削除 特定のkey、配列にすることで複数同時も可能
   $request->session()->forget('name');
   //削除 all
   $request->session()->flush();

　　// フラッシュメッセージ
   $request->session()->flash('status', 'Task was successful!');
```

-   session helper

```
   // sessionデータ取得
   $value = session('key');

   //sessionデータ保存
   session(['key' => 'value']);
```

## prone で定期的にデータの削除をスケジュールできる。

-   Prunable トレイトを use し、prunable で条件を指定する。

```
use Illuminate\Database\Eloquent\Prunable;

class Flight extends Model
{
    use Prunable;

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth());
    }
}
```

pruning メソッドで、定期的に削除される瞬間に実行する処理を記述できる。（例えば、関連する画像データなど）

```
protected function pruning(): void
{
    // ...
}
```

routes/console.php でスケジューリング

```
use Illuminate\Support\Facades\Schedule;

Schedule::command('model:prune')->daily();
```

## scope

-   global
    毎回自動で、クエリを付与できる。（これが存在することを知らないと、なんでこうなるのってなるから注意
-   local
    これはめちゃ有用！
    クエリの使い回し！
    https://laravel.com/docs/11.x/eloquent#local-scopes

# 株の売買データ記録アプリ

## DB 構造

-   株銘柄（こっちは物理削除）
-   銘柄名
-   取引データ
-   取引日(date)
-   金額(unsinged integer)
-   数量(integer)
-   type（購入、売却: enum）
-   deleted_at（試しに soft_deleted にする:論理削除）

# sail docker のカスタマイズ

sail で作った DB は、日本語文字化けする。
sail artisan sail:publish で、docker をカスタマイズできる！

## observer でイベントをまとめて監視

sail artisan make:observer TransactionObserver --model=Transaction
https://laravel.com/docs/11.x/eloquent#observers
