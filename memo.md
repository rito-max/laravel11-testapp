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

## laravel プロジェクトに react,typescript を導入

### 前提

Laravel9 から、デフォルトのビルドツールが、webpack から Vite に変わっているので、
Vite で React を扱えるようにする。

###　 vite の設定

-   必要なモジュール等を導入

```
// viteでreactを扱えるようにするモジュール
sail npm install @vitejs/plugin-react --save-dev

// react, typescript関連のモジュール
sail npm install -D react react-dom @types/react @types/react-dom
sail npm install -D typescript
// typescriptのconfig生成
npx tsc --init --jsx react-jsx
```

-   vite.config.ts の設定変更
    先ほど install した vite の react plugin を使用
    今回は、spa ではなく、いくつかの画面に部分的に導入するのでエントリーポイントを複数設定する

```
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";//追記

export default defineConfig({
    plugins: [
        react(),//追記
        laravel({
            input: [
                //必要に応じてここにエントリポイントを追加する
                "resources/js/pages/stockDetails.tsx",//追記
                "resources/css/app.css",
                "resources/js/app.tsx",
            ],
            refresh: true,
        }),
    ],
});
```

-   ディレクトリ構成を検討（これはより良い構成を常に模索）
    一旦これで。

```
resources/js/
├── components/ # 再利用可能な React コンポーネント
│ ├── ui/ # ボタンや入力フォームなどの UI パーツ
│ │ ├── Button.tsx
│ │ ├── Input.tsx
│ │ └── Modal.tsx
│ ├── layout/ # レイアウト系のコンポーネント
│ │ ├── Header.tsx
│ │ ├── Footer.tsx
│ │ └── Sidebar.tsx
│ └── shared/ # 特定のページに依存しない汎用コンポーネント
│ ├── Loading.tsx
│ └── ErrorBoundary.tsx
│
├── hooks/ # カスタムフック（再利用可能なロジック）
│ ├── useAuth.ts
│ ├── useFetch.ts
│ └── useTheme.ts
│
├── pages/ # 画面ごとのエントリーポイント
│ ├── PageA.tsx
│ ├── PageB.tsx
│ ├── PageC.tsx
│
├── types/ # TypeScript の型定義
│ ├── api.ts # API レスポンスの型
│ ├── auth.ts # 認証関連の型
│ ├── user.ts # ユーザー関連の型
│
├── utils/ # 汎用的なユーティリティ関数
│ ├── date.ts # 日付関連の処理
│ ├── storage.ts # localStorage, sessionStorage 管理
│ ├── fetcher.ts # API 通信系
```

-   react を使いたいページに、エントリポイントのファイルを読み込ませる。

```
@vite('resources/js/pages/stockDetails.tsx')
```

-   あとは、エントリポイントから react 処理を書いていけば、導入できる。
