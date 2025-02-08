# to do & 作業内容メモ

## 2/7

-   model、migration 作成
-   seeder、factory 　作成
-   enum transaction_type 　を作成、置き換え

## 2/8-9

-   routing 設定
-   top, stock の CRUD 作成(Transaction の一覧は、stock の詳細に表示すること)、stock の詳細画面に、取引の追加、削除リンク、機能を追加。
-   画面を簡単に tailwind で装飾
-   docker の公開リポジトリを作成して PUSH

## 2/x

-   株銘柄の pegination
-   各モデルの、event クラスと observer クラスの作成（機能の動作確認のために実装してみる。event 発火したことをログに出力させる）
-   feature test 作成
-   Prunable で、論理削除された取引データを定期的に完全に削除する処理を追加。（機能の動作確認のために実装してみる）

## 便利コマンド　メモ

DB 作り直し＆seed 実行

```
sail artisan migrate:fresh --seed
```

DB 接続

```
sail exec mysql mysql -u sail -p
```

その他、ファイル作成コマンドなど、メモ

```
sail artisan make:seeder StockSeeder
sail artisan make:factory StockFactory
sail artisan make:factory TransactionFactory
sail artisan make:controller TransactionController --resource
sail artisan make:controller StockController --resource
```
