# 安裝

- [安裝](#installation)
    - [伺服器需求](#server-requirements)
    - [安裝 Laravel](#installing-laravel)
    - [設定](#configuration)
- [網站伺服器設定](#web-server-configuration)
    - [目錄配置](#directory-configuration)
    - [優雅的 URLs](#pretty-urls)

<a name="installation"></a>
## 安裝

<a name="server-requirements"></a>
### 伺服器要求

Laravel 框架有一些系統上的需求。當然，[Laravel Homestead](/docs/{{version}}/homestead) 虛擬機器都能滿足這些需求，所以強烈的建議你使用 [Laravel Homestead](/docs/{{version}}/homestead) 作為本機 Laravel 開發環境。

然而如果您不使用 [Laravel Homestead](/docs/{{version}}/homestead)，則需要確保您的伺服器符合下列要求：

<div class="content-list" markdown="1">
- PHP >= 7.2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
</div>

<a name="installing-laravel"></a>
### 安裝 Laravel

Laravel 使用 [Composer](https://getcomposer.org) 來管理相依套件，所以在使用 Laravel 之前，您必須確認電腦上是否安裝了 Composer。

#### 透過 Laravel 安裝

首先，使用 [Composer](https://getcomposer.org) 來安裝 Laravel：

    composer global require laravel/installer

請確定把 `$HOME/.composer/vendor/bin` 路徑放置於環境變數 `$PATH` 裡，這樣您的系統才能找到 Laravel 執行檔，這個路徑會根據您的作業系統而有不同的位址，然而，一些常見的位址包括：

<div class="content-list" markdown="1">
- macOS 以及 GNU / Linux 發行版: `$HOME/.composer/vendor/bin`
- Windows: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`
</div>

一旦安裝完成後，就可以使用 `laravel new` 指令在指定的目錄建立一份全新安裝的 Laravel。例如：`laravel new blog` 將會建立一個名稱為 `blog` 的目錄，裡面存放著全新安裝的 Laravel 和相依程式碼：

    laravel new blog

#### 透過 Composer Create-Project

您也可以透過 Composer 在命令列執行 `create-project` 指令來安裝 Laravel：

    composer create-project --prefer-dist laravel/laravel blog

#### 本地開發伺服器

如果您在本地安裝了 PHP，並且想使用 PHP 的內置開發伺服器來啟動您的應用程式，則可以使用 Artisan 的 `serve` 指令，該指定將會在 `http://localhost:8000` 上啟動開發伺服器：

    php artisan serve

或者您也可以選擇 [Homestead](/docs/{{version}}/homestead) 和 [Valet](/docs/{{version}}/valet) 來當作您的開發選項。

<a name="configuration"></a>
### 設定

#### Public 目錄

安裝完 Laravel 之後，需要將您的網站伺服器根目錄指向 `public` 目錄。該目錄下的 `index.php` 將作為前端控制器，所有的 HTTP 請求將會透過它進入您的應用程式。

#### 設定檔

所有 Laravel 框架的設定檔都放置在 `config` 目錄下。每個選項都有說明，因此您可以輕鬆地瀏覽這些文件，並且熟悉這些選項配置。

#### 目錄權限

安裝 Laravel 之後，你必須設定一些權限。`storage` 和 `bootstrap/cache` 目錄中的目錄必須讓你的伺服器有寫入權限，否則 Laravel 就無法執行。如果你使用 [Laravel Homestead](/docs/{{version}}/homestead) 虛擬機器，那麼這些權限應該已經被設定完成。

#### 應用程式金鑰

在你安裝完 Laravel 後，首先需要做的事情是設定一個隨機字串到應用程式金鑰。假設你是透過 Composer 或是 Laravel 安裝工具安裝 Laravel，那麼這個金鑰已經透過 `php artisan key:generate` 指令幫你設定完成。

通常這個金鑰應該有 32 字元長。這個金鑰可以被設定在 `.env` 環境檔案中。如果你還沒將 `.env.example` 檔案重新命名為 `.env`，那麼你應該現在開始。如果應用程式金鑰沒有被設定的話，**您的使用者 Sessions 和其他的加密資料都是不安全的！**

#### 其他設定

Laravel 幾乎不需設定就可以馬上使用，您可以自由的開始開發！當然，您可以瀏覽 `config/app.php` 檔案和對應的文件。它包含數個選項，如 `timezone(時區)` 和 `locale(語言環境)`，您不仿根據您的應用程式來做修改。

您也可以設定 Laravel 的幾個附加元件，像是：

<div class="content-list" markdown="1">
- [快取](/docs/{{version}}/cache#configuration)
- [資料庫](/docs/{{version}}/database#configuration)
- [Session](/docs/{{version}}/session#configuration)
</div>

<a name="web-server-configuration"></a>
## 網站伺服器設定

<a name="directory-configuration"></a>
### 目錄配置

Laravel 應該始終在您 Web 伺服器配置的 `Web 目錄` 的跟目錄之外運行，您不應該嘗試從 `Web 目錄` 的子目錄當中提供 Laravel 應用程式，這樣做可能會暴露應用程式內的一些敏感文件。

<a name="pretty-urls"></a>
### 優雅的 URLs

#### Apache

Laravel 包含 `public/.htaccess` 檔案，提供無需顯示 `index.php` 前端控制器的優雅 URL。當 Laravel 架設於 Apache 時，確認您的伺服器已啟用 `mod_rewrite` 模組，則 `.htaccess` 檔案會被啟用。

若在您的 Apache 環境中 `.htaccess` 檔案沒有效的話，嘗試以下的替代內容：

    Options +FollowSymLinks -Indexes
    RewriteEngine On

    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

#### Nginx

若你使用的是 Nginx，在網站設定檔中使用以下的指令，會重導所有的請求給 `index.php` 前端控制器：

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

理所當然的是，當使用 [Homestead](/docs/{{version}}/homestead) 或 Valet，優雅的 URL 已自動設定完畢。
