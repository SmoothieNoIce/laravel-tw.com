# 設定

- [介紹](#introduction)
- [環境配置](#environment-configuration)
    - [環境變數類型](#environment-variable-types)
    - [搜尋環境配置](#retrieving-environment-configuration)
    - [判斷當前環境](#determining-the-current-environment)
    - [從頁面隱藏環境變數](#hiding-environment-variables-from-debug)
- [存取設定值](#accessing-configuration-values)
- [設定快取](#configuration-caching)
- [維護模式](#maintenance-mode)

<a name="introduction"></a>
## 介紹

Laravel 框架的所有設定都存放於 `config` 目錄中。每個選項都有文件，您可以隨意瀏覽這些檔案，並熟悉這些可用的選項。

<a name="environment-configuration"></a>
## 環境配置

基於應用程式的執行環境，採用不同的設定值，通常是很有幫助的。例如您可能會希望在本地開發環境上使用與正式環境不同的快取驅動。

為了做到這件事，Laravel 透過 Vance Lucas 的 [DotEnv](https://github.com/vlucas/phpdotenv) PHP 函式庫來達到這項需求。在全新安裝好的 Laravel 裡，應用程式的根目錄下會包含 `.env.example` 檔案。若透過 Composer 安裝 Laravel，則這個檔案將自動被更名為 `.env`，否則應該手動更改它的檔名為 `.env`。

您應用程式的 `.env` 設定檔不應該提交到版本控制服務當中，因為使用該應用程式的每個開發人員、伺服器都可能需要不同的環境配置，此外，如果入侵者獲得對您的原始碼儲存庫的訪問權限，這將帶來資訊安全上的隱憂，因為任何敏感的資料都將不再安全。

如果與團隊一起開發，則可能希望繼續在應用程式中包含 `.env.example` 文件，通過將佔位符值放在示例配置文件中，團隊中的其他開發人員可以清楚地看到運行應用程式所需的環境變數，您也可以建立一個設定檔 .env.testing。當執行 PHPUnit 測試，或當執行 Artisan 指令的時候加上參數 `--env=testing`，這個檔案就會被用來取代 `.env` 設定檔。

> {tip} 您的 `.env` 文件中的任何變數都可以被外部環境變數（例如伺服器級或系統級環境變數）覆蓋。

<a name="environment-variable-types"></a>
### 環境變數類型

`.env` 設定檔中的所有變數都將會被解析為字符串，因此已建立了一些預設值，使您可以透過 `env()` 方法來獲得其他的類型：

`.env` Value  | `env()` Value
------------- | -------------
true | (bool) true
(true) | (bool) true
false | (bool) false
(false) | (bool) false
empty | (string) ''
(empty) | (string) ''
null | (null) null
(null) | (null) null

如果您需要使用包含空格的值來定義環境變數，可以透過將值包含在雙引號中來實現。

    APP_NAME="My Application"

<a name="retrieving-environment-configuration"></a>
### 搜尋環境配置

當應用程式收到請求時，這個程式中所有的變數都會被載入到 PHP 超級全域變數 `$_ENV` 裡。然而，可以使用 `env` 輔助方法來從設定檔中取得這些變數的值。事實上，如果檢閱過 Laravel 的設定檔案，您會注意到有幾個選項已經在使用這個輔助方法：

    'debug' => env('APP_DEBUG', false),

傳遞至 `env` 函式的第二個參數為「預設值」。當給定的鍵沒有環境變數存在時就會使用該值。

<a name="determining-the-current-environment"></a>
### 判斷當前環境

應用程式的當前環境是由 `.env` 檔案中的 `APP_ENV` 變數所決定，您可以透過 `App` [facade](/docs/{{version}}/facades) 的 `environment` 方法取得該值：

    $environment = App::environment();

您也可以傳遞參數至 `environment` 方法中，來確認目前的環境是否與給定參數相符合，如果環境符合任何一個給定的值，該方法就會回傳 `true`：

    if (App::environment('local')) {
        // 應用程式的當前環境為 local
    }

    if (App::environment(['local', 'staging'])) {
        // 應用程式的當前環境為 local 或 staging...
    }

> {tip} 伺服器級別的 `APP_ENV` 環境變數可以覆蓋當前的應用程式環境檢測，當您需要為不同的環境運行同一應用程式時，這招很有用，因此您可以設置一個給特定主機以匹配伺服器配置中所給定的環境。

<a name="hiding-environment-variables-from-debug"></a>
### 從頁面隱藏環境變數

當應用程式是正常運行且 `APP_DEBUG` 環境變數為 `true` 時，頁面將顯示所有環境變量及其內容，在某些情況下，您可能希望不要顯示這些變數，您可以通過更新 `config/app.php` 設定文件當中的 `debug_blacklist` 選項來實現。

在環境變數和伺服器、請求資料中都可以使用某些變數，因此，您可能需要將它們同時添加到 `$_ENV` 和 `$_SERVER` 當中：

    return [

        // ...

        'debug_blacklist' => [
            '_ENV' => [
                'APP_KEY',
                'DB_PASSWORD',
            ],

            '_SERVER' => [
                'APP_KEY',
                'DB_PASSWORD',
            ],

            '_POST' => [
                'password',
            ],
        ],
    ];

<a name="accessing-configuration-values"></a>
## 存取設定值

您可以在應用程式的任何位置輕鬆的使用全域的 `config` 輔助函式來存取您的設定值，設定值可以透過「點」語法來取得，其中包含了您想存取的檔案與選項的名稱，也可以指定預設值，當該設定選項不存在時就會回傳預設值：

    $value = config('app.timezone');

若要在執行期間修改設定值，請傳遞一個陣列至 `config` 輔助方法：

    config(['app.timezone' => 'Asia/Taipei']);

<a name="configuration-caching"></a>
## 設定快取

為了讓應用程式提升一些速度，你可以使用 `config:cache` Artisan 指令將所有的設定檔存到單一檔案，它會將所有的設定選項合併成一個檔案，讓框架能夠快速載入。

你通常應該將執行 `php artisan config:cache` 指令作為上線部署的例行公事。在你開發應用程式時，此指令則不應該執行，因為設定選項會因開發需要而經常地變動。

> {note} 如果在部署過程中執行 `config:cache` 命令，則應確保只從設定檔中調用 `env` 函數。一旦配置被暫存當中，`.env` 文件將不會被加載，對 `env` 函數的所有呼叫都將回傳 `null`。

<a name="maintenance-mode"></a>
## 維護模式

當你的應用程式處於維護模式時，所有傳遞至應用程式的請求都會變成顯示自定視圖。在你要更新或進行維護作業時，這麼做可以很輕鬆的「關閉」整個應用程式。應用程式的預設中介層堆疊會核對是否處於維護模式。如果應用程式處於維護模式，會拋出 `MaintenanceModeException` 並附帶 503 的狀態碼。

若要啟用維護模式，只需要執行 `down` Artisan 指令：

    php artisan down

可以提供 `message` 和 `retry` 選項給 `down` 指令。`message` 選項的值用來顯示或紀錄客製化訊息，`retry` 選項的值用來當作 HTTP 標頭 `Retry-After` 的值：

    php artisan down --message="Upgrading Database" --retry=60

即使在維護模式下，也可以使用命令的 `allow` 選項允許特定的 IP 位址或網絡來使用應用程式：

    php artisan down --allow=127.0.0.1 --allow=192.168.0.0/16

若要關閉維護模式，請使用 `up` 指令：

    php artisan up

> {tip} 您可以透過 `resources/views/errors/503.blade.php` 這份模板來自定義預設維護模式的樣式。

#### 維護模式與隊列

當應用程式處於維護模式中，將不會處理任何 [隊列任務](/docs/{{version}}/queues)，所有的任務將會在應用程式離開維護模式後繼續被進行。

#### 維護模式以外的選擇

因為維護模式需要讓你的應用程式有幾秒鐘的停機時間，你可以考慮像是 [Envoyer](https://envoyer.io) 的替代方案，以做到 Laravel 的零停機時間部署。
