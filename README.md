# coachtech フリマ  
## 作成した目的  
以前より使いやすいアプリにするため
## アプリケーションURL  
開発環境:http://localhost/  
phpMyAdmin:http://localhost:8080/  
## 他のリポジトリ  
## 機能一覧  
・会員登録機能  
・ログイン機能  
・ログアウト機能  
・プロフィール変更機能  
・ユーザー商品お気に入り追加・削除機能  
・商品評価機能(コメント追加・削除機能)  
・出品  
・購入  
・ユーザーの削除機能(管理者のみ)  
・ショップとユーザーのやり取り確認(管理者のみ)  
・配送先変更機能  
## 使用技術(実行環境)
## ER図  
## 環境構築  
1.リポジトリをクローンします。  
`git clone https://github.com/katsukishiori/free-market`  
2.環境変数用のファイルを用意します。  

Dockerビルド  
1.ディレクトリの作成  
2.docker-compose.ymlの作成  
3.Nginxの設定  
4.PHPの設定  
5.MySQLの設定  
6.phpMyAdminの設定  
7.docker-compose up -d --build  
  
※MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集してください  
  
Laravel環境構築
1.docker-compose exec php bash  
2.composer -vでcomposerがインストールできているか確認  
3.composer create-project "laravel/laravel=8.*" . --prefer-dist  
4.php artisan migrate  
5.php artisan db:seed  
## その他

<<<<<<< HEAD
=======
# free-market
=======
# フリーマーケットアプリ  

>>>>>>> 1fa0c6c (Update README.md)
# free-market
# free-market
# 20240427_free-market
# 20240427_free-market
# free-market
>>>>>>> c2de332 (first commit)
# free-market
# free-market
# free-market
