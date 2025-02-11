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

## 2/x

-   Sentinum の導入、API トークンベース認証追加
-   API 機能追加（株銘柄一覧取得 API）

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
```

## tailwind の色一覧　便利！

https://tailwindcss.com/docs/colors

## prune コマンド実行された時の対象ファイルと対象データ件数を確認できるので便利

```
sail artisan model:prune --pretend
```
