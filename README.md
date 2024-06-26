# coachtech フリマアプリ   
<img width="1126" alt="スクリーンショット 2024-06-25 17 25 30" src="https://github.com/katsukishiori/free-market/assets/145991391/af6fd6d5-4aa7-4050-9ccf-bb239ad80b88">  
 
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
・配送先変更機能  
・ユーザーの削除機能(管理者)  
・ショップとユーザーのやり取り確認(管理者)  
・ショップスタッフ招待.削除機能(店舗代表者)  
  
## 使用技術(実行環境)  
・PHP: 7.4.9  
・MySQL: 10.3.39-MariaDB  
・Laravel: 8.75  
  
## 環境構築  
### 1.リポジトリをクローンします。    
     git clone https://github.com/katsukishiori/free-market.git        
  
### 2.Dockerコンテナを起動します。  
     docker-compose up -d --build      
  
### 3.PHP コンテナへログインし、Laravel アプリケーションの準備をします。  
  #### ◇PHPコンテナへのログイン
    docker-compose exec php bash    
  
  #### ◇Laravelアプリケーションの依存関係をインストール  
     composer update    

  #### ◇環境変数の設定
  env.exampleファイルをコピーして.envファイルを作成し、必要な環境変数を設定します。  
    cp .env.example .env       
    
  DB_CONNECTION=mysql  
  DB_HOST=mysql  
  DB_PORT=3306  
  DB_DATABASE=laravel_db  
  DB_USERNAME=laravel_user  
  DB_PASSWORD=laravel_pass  
    
  #### ◇アプリケーションキーの生成  
     php artisan key:generate        

  #### ◇データベーステーブルの作成   
     php artisan migrate      

  #### ◇初期データの投入  
     php artisan db:seed     

### 4.以下の URL にアクセスし、トップページを表示します。  
http://localhost/  
  
  ⚫︎管理者  
    Email: admin@example.com  
    Password: admin123  
    
  ⚫︎店舗代表者    
    Email: manager@example.com  
    Password: manager123  
      
  ⚫︎一般ユーザーA  
    Email: usera@example.com  
    Password: usera123  
      
  ⚫︎一般ユーザーB    
    Email: userb@example.com    
    Password: userb123 
    
## その他 
メール送信はGmailを使用しています。
`your_email@gmail.com`と`your_pass`の所は自分のメールアドレスやパスワードに書き換えてください。  
    MAIL_MAILER=smtp  
    MAIL_HOST=smtp.gmail.com    
    MAIL_PORT=587  
    MAIL_USERNAME=your_email@gmail.com  
    MAIL_PASSWORD=your_pass  
    MAIL_ENCRYPTION=tls  
    MAIL_FROM_ADDRESS=your_email@gmail.com  
    MAIL_FROM_NAME="${APP_NAME}"  

 


