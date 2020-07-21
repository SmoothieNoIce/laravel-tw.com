# 發行說明

- [版本計劃](#versioning-scheme)
- [支援政策](#support-policy)
- [Laravel 7](#laravel-7)

<a name="versioning-scheme"></a>
## 版本計劃

Laravel 及其他第一方擴充包遵循 [Semantic Versioning](https://semver.org)，主要版本每六個月（~二月、~八月）發行一次，次要版本和補丁版本可能每週發佈一次，次要和補修版本**不會**包含非兼容性更改。

引入 Laravel 框架或其組件時，應該保持使用版本約束，像是 `^7.0`，因為 Laravel 的主要版本確實包含非兼容性更改，我們會努力確保您可以在一天或更短的時間內更新到最新的版本。

<a name="support-policy"></a>
## 支援政策

對於 LTS 版本，例如 Laravel 6，提供了 2 年的錯誤修復和 3 年的安全更新，這些版本提供了最長的支援和維護，對於一般的發佈版本，只提供了 6 個月的錯誤修復和 1 年的安全更新，對於包括 Lumen 在內的所有其他版本，只有最新版本才會修復錯誤。此外，請查看 Laravel [支援的](/docs/{{version}}/database#introduction) 資料庫版本。

| 版本 | 發佈日期 | 錯誤修復支援到 | 安全更新支援到 |
| --- | --- | --- | --- |
| 5.5 (LTS) | 2017 年 8 月 30 日 | 2019 年 8 月 30 日 | 2020 年 8 月 30 日 |
| 5.6 | 2018 年 2 月 7 日 | 2018 年 8 月 7 日 | 2019 年 2 月 7 日 |
| 5.7 | 2018 年 9 月 4 日 | 2019 年 3 月 4 日 | 2019 年 9 月 4 日 |
| 5.8 | 2019 年 2 月 26 日 | 2019年 8 月 26 日 | 2020 年 2 月 26 日 |
| 6 (LTS) | 2019 年 9 月 3 日 | 2021 年 9 月 3 日 | 2022 年 9 月 3 日 |
| 7 | 2020 年 3 月 3 日 | 2020 年 9 月 3 日 | 2021 年 3 月 3 日 |

<a name="laravel-7"></a>
## Laravel 7

Laravel 7 透過引用 Laravel Sanctum、提高路由速度、自訂 Eloquent 強制轉換(casts)、Blade 元件標籤、流暢的字元操作、開發人員專用的 HTTP Client 端、第一方 CORS 支援、改善路由模組綁定作用域、存跟自訂、改善資料庫列隊、多信箱驅動、查詢時間強制轉換(casts)、新的 `artisan test` 指令，以及各種其他錯誤修復和使用性改善，並對 Laravel 6.x 持續繼續進行優化。

### Laravel Sanctum

_Laravel Sanctum 由 [Taylor Otwell](https://github.com/taylorotwell) 所創造。_

Laravel Sanctum 為單頁應用(Single-page application)，行動裝置應用程式和基於 Token 的簡單 API 提供了輕巧的身份驗證系統，Sanctum 允許應用程式的每個使用者產生多個 API Token，這些 Token 可以被授與權限或作用域，用於指定允許 Token 執行哪些動作。

有關 Laravel Sanctum 的更多訊息，請翻閱 [Sanctum 文件](/docs/{{version}}/sanctum)。

### 自訂 Eloquent 強制轉換(casts)

_自訂 Eloquent 強制轉換(casts) 由 [Taylor Otwell](https://github.com/taylorotwell) 所開發貢獻。_

Laravel 內建了多種常用的型態轉換，但是，使用者偶爾會需要將資料轉換成自訂義類型。現在，該需求可以透過定義一個實作 `CastsAttributes` 端口的類型來完成。

實作了該端口的類型必須事先定義一個 `get` 和 `set` 的方法。`get` 方法負責將資料庫中獲得的原始資料轉換成對應的類型，而 `set` 方法則是將資料轉換成對應的資料庫類型，以便存入資料庫當中，舉例來說，下面我們將內置的 `json` 類型轉換以自訂義類型形式重新實現一次：

    <?php

    namespace App\Casts;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Json implements CastsAttributes
    {
        /**
         * Cast the given value.
         *
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  mixed  $value
         * @param  array  $attributes
         * @return array
         */
        public function get($model, $key, $value, $attributes)
        {
            return json_decode($value, true);
        }

        /**
         * Prepare the given value for storage.
         *
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  array  $value
         * @param  array  $attributes
         * @return string
         */
        public function set($model, $key, $value, $attributes)
        {
            return json_encode($value);
        }
    }

定義好自訂義類型轉換後，可以省用其類別名稱將其附加到 Model 的 casts 屬性當中：

    <?php

    namespace App;

    use App\Casts\Json;
    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'options' => Json::class,
        ];
    }

要學習如何實現自訂義 Eloquent 類型轉換，包括轉換成特定值對象的類型轉換，請參考 [Eloquent 文件](/docs/{{version}}/eloquent-mutators#custom-casts)。

### Blade 元件標籤 & 改進措施

_Blade 元件標籤貢獻人員有 [Spatie](https://spatie.be/), [Marcel Pociot](https://twitter.com/marcelpociot), [Caleb Porzio](https://twitter.com/calebporzio), [Dries Vints](https://twitter.com/driesvints) 和 [Taylor Otwell](https://github.com/taylorotwell)。_

> {tip} Blade 元件經過修正後，以允許基於標籤的渲染、屬性管理、元件類別、內關聯視圖元件 ... 等等，由於 Blade 元件的檢修非常廣泛，因此請查看[完整的 Blade 文件](/docs/{{version}}/blade#components)以了解此功能。

總而言之，現在的一個元件能從指定的類別取得資料，所有的公開屬性和方法都能清楚的定義在元件類別裡，會自動組裝成元件試圖，任何附加的 HTML 屬性都指定於一個可以自動管理的 `$attribute` 變數，它是一個屬性實作。

下面舉個例子，我們會假設一個 `App\View\Components\Alert` 元件，其內容是這樣：

    <?php

    namespace App\View\Components;

    use Illuminate\View\Component;

    class Alert extends Component
    {
        /**
         * alert 提示類型
         *
         * @var string
         */
        public $type;

        /**
         * 建立元件實作
         *
         * @param  string  $type
         * @return void
         */
        public function __construct($type)
        {
            $this->type = $type;
        }

        /**
         * 獲得 alert 的提示類型
         *
         * @return string
         */
        public function classForType()
        {
            return $this->type == 'danger' ? 'alert-danger' : 'alert-warning';
        }

        /**
         * 渲染該元件的視圖或內容。
         *
         * @return \Illuminate\View\View|string
         */
        public function render()
        {
            return view('components.alert');
        }
    }

並且假設 Blade 元件模板定義是這樣：

    <!-- /resources/views/components/alert.blade.php -->

    <div class="alert {{ $classForType }}" {{ $attributes }}>
        {{ $heading }}

        {{ $slot }}
    </div>

元件可以被渲染在另一個使用元件標籤的 Blade 視圖當中：

    <x-alert type="error" class="mb-4">
        <x-slot name="heading">
            Alert 元件內容...
        </x-slot>

        預設內容 ...
    </x-alert>

如前面所說，在大改之後的 Laravel 7 當中，這是一個非常小又普通的一個功能，而且還沒有實現匿名元件、內關聯視圖組建和各式各樣的其他特性，請從[所有 Blade 文件](/docs/{{version}}/blade#components)當中來了解這些新功能。

> {note} 以前的 Blade 元件 `@component` 語法並沒有被移除。

### HTTP 使用者端

_HTTP 使用者端是 Guzzle 的一個封裝，由 [Adam Wathan](https://twitter.com/adamwathan), [Jason McCreary](https://twitter.com/gonedark) 和 [Taylor Otwell](https://github.com/taylorotwell) 所提供。_

Laravel 現在提供一套圍繞 [Guzzle HTTP 使用者端](http://docs.guzzlephp.org/en/stable/) 所建立的精簡且高效能的 API 呼叫工具，你可以快速的向其他 Web 應用程式發起 HTTP 請求。Laravel 基於 Guzzle 的封裝專注於最常見的使用範例，以及良好的開發人員體驗。例如，使用者端發起帶 JSON 資料的 `POST` 請求可以變得非常簡單：

    use Illuminate\Support\Facades\Http;

    $response = Http::withHeaders([
        'X-First' => 'foo',
        'X-Second' => 'bar'
    ])->post('http://test.com/users', [
        'name' => 'Taylor',
    ]);

    return $response['id'];

另外，HTTP 使用者端還提供了容易使用的測試功能：

    Http::fake([
        // Stub a JSON response for GitHub endpoints...
        'github.com/*' => Http::response(['foo' => 'bar'], 200, ['Headers']),

        // Stub a string response for Google endpoints...
        'google.com/*' => Http::response('Hello World', 200, ['Headers']),

        // Stub a series of responses for Facebook endpoints...
        'facebook.com/*' => Http::sequence()
                                ->push('Hello World', 200)
                                ->push(['foo' => 'bar'], 200)
                                ->pushStatus(404),
    ]);

要了解有關 HTTP 使用者端的所有功能，請瀏覽 [HTTP 使用者端文件](/docs/{{version}}/http-client)。

### 流暢的字元操作

_流暢的字元操作由 [Taylor Otwell](https://twitter.com/taylorotwell) 所開發貢獻。_

您可能對 Laravel 本身已經擁有的 `Illuminate\Support\Str` 這個類別比較熟悉，它提供了各種有關於字串操作的函式，基於這些函式，Laravel 7 現在提供了一個更加面向物件的、更加流暢的字串操作，您可以使用 `Str::of` 方法來建立一個 `Illuminate\Support\Stringable` 物件，然後可以使用該物件的各種方法去運算字串。

    return (string) Str::of('  Laravel Framework 6.x ')
                        ->trim()
                        ->replace('6.x', '7.x')
                        ->slug();

有關流暢的字元操作的更多訊息，可以查看[所有文件](/docs/{{version}}/helpers#fluent-strings)。

### 路由模型綁定以及優化

_路由模型綁定以及優化由 [Taylor Otwell](https://twitter.com/taylorotwell) 所開發貢獻。_

#### 路由自訂欄位關鍵字

有時候，您可能希望使用 `id` 以外的欄位來獲得 Eloquent 模型，因此 Laravel 7 允許您在 route 參數中定義指定的欄位：

    Route::get('api/posts/{post:slug}', function (App\Post $post) {
        return $post;
    });

#### 自動綁定約束
隐式绑定约束

有時候，當你在路由中綁定多個 Eloquent 模型時，可能會希望對第二個 Eloquent 模型進行約束，使其必須是第一個 Eloquent 模型的子類別，例如，透過 Slug 欄位為特定使用者尋找部落格文章：

    use App\Post;
    use App\User;

    Route::get('api/users/{user}/posts/{post:slug}', function (User $user, Post $post) {
        return $post;
    });

當你使用自訂義自動綁定約束作為路由參數時，Laravel 7 將自動綁定查詢範圍，以使用綁定其父類別上的關聯命名，以其父類別關聯模型，在這種情況之下，將 User 模型關聯了名為 posts(路由參數名稱的複數) 的關係，該關聯可用於搜尋 Post 模型。

有關路由模型綁定的更多資訊，請瀏覽[路由文件](/docs/{{version}}/routing#route-model-binding)。

### 多個信箱驅動程式

_多個信箱驅動程式由 [Taylor Otwell](https://twitter.com/taylorotwell) 所開發貢獻。_

Laravel 7 允許為單個應用程式配置多個信箱驅動，在 mail 設定文件中的每個信箱驅動都擁有它們自己的以及自己獨特的「transport」，這允許您的應用程式使用不同的信箱服務來發送電子信件，例如，你的應用程式可以使用 `Postmark` 來發送大量電子信件，並且使用 `Amzon SES` 來發送公事電子信件。

預設情況之下，Laravel 將使用 mail 設定文件中的 `default` 作為信箱驅動，然而你可以透過 `mailer` 方法來使用特定的信箱驅動來發送電子信件。

    Mail::mailer('postmark')
            ->to($request->user())
            ->send(new OrderShipped($order));

### 路由快取速度改善

_路由快取速度改善由 [Symfony](https://symfony.com) 的貢獻者以及 [Dries Vints](https://twitter.com/driesvints) 所開發貢獻。_

Laravel 7 提供了一種新的方式，用於使用 Artisan 指令 `route:cache` 快取以編譯的暫存路由，在大型應用程式(例如具有 800 條或更多路由的應用程式)上，這些改善可以使簡單的「Hello World」基準測試每秒的請求速度**提高 2 倍**，而無需更改應用程式。

### CORS 支援

_CORS 支援由 [Barry vd. Heuvel](https://twitter.com/barryvdh) 所開發貢獻。_

Laravel 7 內建由 Barry vd. Heuvel 所開發的 Laravel CORS，為設定跨域資源共享(CORS) `OPTIONS` 呼叫提供了官方支援，[預設的 Laravel 應用程式框架](https://github.com/laravel/laravel/blob/develop/config/cors.php)中包含一個新的 cors 設定。

有關於 Laravel 7.x 中的 CORS 支援的更多訊息，請翻閱 [CORS 文件](/docs/{{version}}/routing#cors)。

### 查詢時間轉換

_查詢時間轉換由 [Matt Barlow](https://github.com/mpbarlow) 所開發貢獻。_

有些時候，您可能需要在執行查詢指令時，針對特定欄位的資料進行時間轉換，例如需要從資料庫當中獲得資料的時候，舉個例子，請參考以下的查詢：

    use App\Post;
    use App\User;

    $users = User::select([
        'users.*',
        'last_posted_at' => Post::selectRaw('MAX(created_at)')
                ->whereColumn('user_id', 'users.id')
    ])->get();

在該查詢獲得到的結果當中，`last_posted_at` 欄位將會是一個字串，假如我們在執行查詢時進行 `date` 類型的轉換，您將可以透過使用 `withCasts` 方法來完成上述的操作：

    $users = User::select([
        'users.*',
        'last_posted_at' => Post::selectRaw('MAX(created_at)')
                ->whereColumn('user_id', 'users.id')
    ])->withCasts([
        'last_posted_at' => 'date'
    ])->get();

### MySQL 8+ 資料庫列隊改善

_MySQL 資料庫列隊改善由 [Mohamed Said](https://github.com/themsaid) 所開發貢獻。_

在先前版本的 Laravel 中， database 队列的健壮性被认为无法满足生产环境的需求。但是，Laravel 7 针对使用基于 MySQL 8+ 数据库队列的应用进行了改进。通过使用 FOR UPDATE SKIP LOCKED 语句进行 SQL 的优化，database 队列驱动可以安全地用于生产环境。

在以往版本的 Laravel 當中，`資料庫` 列隊被認為不足以用於正式環境的需求。但是 Laravel 7 針對使用基於 MySQL 8+ 資料庫列隊的應用進行了改善，透過使用 `FOR UPDATE SKIP LOCKED` 語法進行 SQL 的優化，`database` 列隊驅動可以安全地使用於正式環境當中。

### Artisan `test` 指令

_`test` 指令由 [Nuno Maduro](https://twitter.com/enunomaduro) 所開發貢獻。_

除了 phpunit 命令之外，现在可以使用 test Artisan 命令来运行测试。 Artisan 测试运行器提供了漂亮的控制台，以及有关当前正在运行的测试的更多信息。 此外，运行器将在第一次测试失败时自动停止：

除了 `phpunit` 指令以外，現在可以使用 Artisan 的 `test` 指令來進行測試，Artisan 測試提供了漂亮的控制台，以及有關當前正在執行的測試訊息。另外執行將在第一次測試失敗時自動停止：

    php artisan test

<p align="center">
<img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1582142435/Screen_Shot_2020-02-19_at_2.00.01_PM.png">
</p>

可以傳送給 `phpunit` 指令的任何參數，也可以傳送給 Artisan 的 `test` 指令：

    php artisan test --group=feature

### Markdown 電子信件模板改善

_Markdown 電子信件模板改善由 [Taylor Otwell](https://twitter.com/taylorotwell) 所開發貢獻。_

預設的 Markdown 電子信件模板已經基於 Tailwind CSS 重新改寫，更具現代化的設計。當然，可以根據您的應用程式的需要來發佈或客製化此模板：

<p align="center">
<img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1582142674/Screen_Shot_2020-02-19_at_2.04.11_PM.png">
</p>


有關於 Markdown 電子信件的更多訊息，請查閱[電子信件發送文件](/docs/{{version}}/mail#markdown-mailables)。

### 自訂義 Stub

_自訂義 Stub 由 [Taylor Otwell](https://twitter.com/taylorotwell) 所開發貢獻。_

Artisan 控制台的 make 指令用於建立各種類別，例如控制器(Controllers)、任務(Jobs)、資料庫遷移(Migrations)和測試(Tests)，這些類別是根據輸入的參數來生成文件的。但是有時可能希望對 Artisan 生成的文件進行局部修改，因此 Laravel 7 提供了 `stub:publish` 指令來生成最常見的自訂義指令：

    php artisan stub:publish

發佈的指令碼將位於應用程式根目錄當中的 `stubs` 目錄當中，使用 Artisan 的 make 指令產生它們相對應的類別時，對這些 Stub 所做的任何變更都會直接反應在生成文件上。

### 列隊 `maxExceptions` 設定

_列隊 `maxExceptions` 設定由 [Mohamed Said](https://twitter.com/themsaid) 所開發貢獻。_

有時候執行列隊任務時，希望可以碰到失敗時，再繼續重新嘗試，達到某個錯誤數次後，則列隊任務才認定該次失敗。在 Laravel 7 當中，可以在任務類別上定義 `maxExceptions` 屬性：

    <?php

    namespace App\Jobs;

    class ProcessPodcast implements ShouldQueue
    {
        /**
         * 該任務可以被重新執行的次數。
         *
         * @var int
         */
        public $tries = 25;

        /**
         * 任務失敗前，所允許拋出例外錯誤的最大次數。
         *
         * @var int
         */
        public $maxExceptions = 3;

        /**
         * 執行任務。
         *
         * @return void
         */
        public function handle()
        {
            Redis::throttle('key')->allow(10)->every(60)->then(function () {
                // Lock obtained, process the podcast...
            }, function () {
                // Unable to obtain lock...
                return $this->release(10);
            });
        }
    }

在此次範例當中，如果應用程式無法獲得 Redis lock，則該任務將等待 10 秒鐘，並且將重新嘗試 25 次。但是如果任務拋出 3 個未處理的異常錯誤，則該次任務將失敗。
