# to do & 作業内容メモ

## 2/7

-   model、migration 作成
-   seeder、factory 　作成
-   enum transaction_type 　を作成、置き換え

## 2/8-9

-   routing 設定
-   top, stock の CRUD 作成(Transaction の一覧は、stock の詳細に表示すること)、stock の詳細画面に、取引の追加、削除リンク、機能を追加。
-   github の公開リポジトリを作成して PUSH
-   画面を簡単に tailwind で装飾

## 2/10

-   株銘柄の pegination
-   各モデルの、event クラスと observer クラスの作成（機能の動作確認のために実装してみる。event 発火したことをログに出力させる）
-   feature test を一部作成
-   セッションベースのログイン機能追加

## 2/11

-   ログイン通知メール、ファイル添付
-   Prunable で、論理削除された取引データを定期的に完全に削除する処理を追加。（機能の動作確認のために実装してみる）

## 2/12

-   Gate でモデル操作以外の権限管理
    https://laravel.com/docs/11.x/authorization#gates
-   Policy でモデル操作以外の権限管理
    https://laravel.com/docs/11.x/authorization#creating-policies
    stock モデル:user モデル経由、transaction モデル:Gate ファサード経由、それぞれで 2 パターン方法を試す
    https://laravel.com/docs/11.x/authorization#via-the-user-model
    https://laravel.com/docs/11.x/authorization#via-the-gate-facade

## 2/13

-   ログイン通知メール処理をキューで処理するようにする
    https://laravel.com/docs/11.x/queues

## 2/17

-   Sentinum の導入、API トークンベース認証追加
-   API 機能追加（株銘柄一覧取得、株銘柄新規作成）
-   Token ability の導入（API トークン毎にできる処理: 権限付与を行える）
    https://laravel.com/docs/11.x/sanctum#token-abilities
    株銘柄一覧取得: 認証済みなら実行可能
    株銘柄新規作成: 実行に編集権編が必要
-   API 機能のテスト作成（トークン発行処理、トークンの ability 毎の権限制御テスト）

## 3/22-23

-   laravel プロジェクトに react,typescript を部分的に使えるようにする（SPA ではない）
-   取引履歴部分を react に置き換え

# 各種 便利コマンド　メモ

## DB 作り直し＆seed 実行

```
sail artisan migrate:fresh --seed
```

## DB 接続

```
sail exec mysql mysql -u sail -p
```

## npm バックグランド実行

```
sail npm run dev &
```

## log を tailing

リアルタイムでログ追えるので便利！

```
sail artisan pail
```

https://laravel.com/docs/11.x/logging#tailing-log-messages-using-pail

## ファイル作成コマンドなど、メモ

```
sail artisan make:seeder StockSeeder
sail artisan make:factory StockFactory
sail artisan make:factory TransactionFactory
sail artisan make:controller TransactionController --resource
sail artisan make:controller StockController --resource
sail artisan make:request StockRequest
sail artisan make:request TransactionRequest
sail artisan make:event StockSaved
sail artisan make:listener SendSlackNotification --event=StockSaved
sail artisan make:listener LoginMail
sail artisan make:controller LoginController --test
sail artisan make:test StockControllerTest
sail artisan make:mail LoginMail
sail artisan make:policy StockPolicy --model=Stock
sail artisan make:policy TransactionPolicy --model=Transaction
sail artisan make:job SendLoginMail
sail artisan install:api
```

## キュー worker

job を処理し続けさせるためには、下記コマンドでキューワーカーを動かし続ける必要がある。
本番環境では、supervisor を使って監視するなど、キューワーカーを止めない仕組みが必要。

```
sail artisan queue:work
```

運用目線で、ソースコードの変更を反映させるには、restart が必要。
https://laravel.com/docs/11.x/queues#queue-workers-and-deployment

失敗した job の再試行

```
sail artisan queue:retry all
```

https://laravel.com/docs/11.x/queues#retrying-failed-jobs

## tailwind の色一覧　便利！

https://tailwindcss.com/docs/colors

## prune コマンド実行された時の対象ファイルと対象データ件数を確認できるので便利

```
sail artisan model:prune --pretend
```
