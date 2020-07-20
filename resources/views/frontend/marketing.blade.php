@extends('frontend.partials.layout')

@section('content')
    @include('frontend.partials.header')

    <div class="home standard_layout">
        <div class="remodal-bg">
            <div class="content_contain" style="padding-bottom: 4.5em;">
                <div class="page_contain">
                    <div class="banner">
                        <a href="https://vapor.laravel.com/">
                            <div class="banner_icon icon_nova">
                                <img src="/img/ecosystem/vapor.min.svg" alt="Nova">
                            </div>
                            <div class="banner_content">
                                <p class="small">Laravel Vapor 現在已經上市！立即註冊！
                                    <span class="arrow">→</span></p>
                            </div>
                        </a>
                    </div>
                    <div class="contain">
                        <section class="hero">
                            <div class="hero_bg">
                                <video poster="/img/hero/hero_poster.jpg" playsinline autoplay muted loop>
                                    <source src="/img/hero/hero.mp4" type="video/mp4">
                                </video>
                            </div>
                            <div class="hero_content">
                                <h1>為網頁藝術家所創造的 PHP 框架</h1>
                                <p>Laravel 是一個語意直觀且優雅的網頁應用程式框架，我們已經奠定了一系列的基礎，使您可以自由自在的開發，而不會在芝麻小事上費盡心思。</p>
                                <div class="hero_actions">
                                    <a href="/docs" class="btn"><span>文件</span></a>
                                    <a href="https://laracasts.com" data-remodal-target="video_modal" class="btn secondary"><span><img src="/img/icons/play.min.svg" alt="Play Video"><span>看看 Laracasts</span></span></a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="contain">
                        <div class="content_block img_left">
                            <div class="bg">
                                <video poster="/img/blocks/blocks_3.jpg" playsinline autoplay muted loop>
                                    <source src="/img/blocks/blocks_3.mp4" type="video/mp4">
                                </video>
                            </div>
                            @if (SHOW_VAPOR)
                                <div class="image">
                                    <img src="/img/homepage/vapor.jpg" alt="Vapor">
                                </div>
                                <div class="content">
                                    <h1>Laravel Vapor</h1>
                                    <p>Laravel Vapor 是由 AWS 支持的 Laravel 無伺服器部署平台，在 Vapor 上部署您的 Laravel 應用程式，並愛上無伺服器輕鬆且具有可擴展性的優勢。</p>
                                    <a href="https://vapor.laravel.com" class="btn"><span>查看更多</span></a>
                                </div>
                            @else
                                <div class="image">
                                    <img src="/img/homepage/forge.jpg" alt="Forge">
                                </div>
                                <div class="content">
                                    <h1>Laravel Forge</h1>
                                    <p>能夠依照需求將您的應用程式部署到 DigitalOcean、Linode ... 等等的雲端服務平台，並整合 Redis、隊列以及啟動 Laravel 應用程式所需的所有其他功能。</p>
                                    <a href="https://forge.laravel.com" class="btn"><span>查看更多</span></a>
                                </div>
                            @endif
                        </div>

                        <div class="ecosystem_block">
                            <div class="heading">
                                <h6>徹底改變您開發網頁應用程式的方式</h6>
                                <h1>Laravel 生態系統</h1>
                            </div>
                            <ul class="ecosystem">
                                <li class="sys_vapor">
                                    <a href="https://vapor.laravel.com">
                                        <div class="system_icon"><img src="/img/ecosystem/vapor.min.svg" alt="Icon"></div>
                                        <div class="system_info">Vapor <span>無伺服器平台</span></div>
                                    </a>
                                </li>
                                <li class="sys_forge">
                                    <a href="https://forge.laravel.com">
                                        <div class="system_icon"><img src="/img/ecosystem/forge.min.svg" alt="Icon"></div>
                                        <div class="system_info">Forge <span>伺服器管理</span></div>
                                    </a>
                                </li>
                                <li class="sys_envoyer">
                                    <a href="https://envoyer.io">
                                        <div class="system_icon"><img src="/img/ecosystem/envoyer.min.svg" alt="Icon"></div>
                                        <div class="system_info">Envoyer <span>Zero Downtime Deployment</span></div>
                                    </a>
                                </li>
                                <li class="sys_horizon">
                                    <a href="/docs/{{DEFAULT_VERSION}}/horizon">
                                        <div class="system_icon"><img src="/img/ecosystem/horizon.min.svg" alt="Icon"></div>
                                        <div class="system_info">Horizon <span>隊列監控</span></div>
                                    </a>
                                </li>
                                <li class="sys_nova">
                                    <a href="https://nova.laravel.com">
                                        <div class="system_icon"><img src="/img/ecosystem/nova.min.svg" alt="Icon"></div>
                                        <div class="system_info">Nova <span>後台管理</span></div>
                                    </a>
                                </li>
                                <li class="sys_echo">
                                    <a href="/docs/{{DEFAULT_VERSION}}/broadcasting">
                                        <div class="system_icon"><img src="/img/ecosystem/echo.min.svg" alt="Icon"></div>
                                        <div class="system_info">Echo <span>即時事件</span></div>
                                    </a>
                                </li>
                                <li class="sys_lumen">
                                    <a href="https://lumen.laravel.com">
                                        <div class="system_icon"><img src="/img/ecosystem/lumen.min.svg" alt="Icon"></div>
                                        <div class="system_info">Lumen <span>微框架</span></div>
                                    </a>
                                </li>
                                <li class="sys_homestead">
                                    <a href="/docs/{{DEFAULT_VERSION}}/homestead">
                                        <div class="system_icon"><img src="/img/ecosystem/homestead.min.svg" alt="Icon"></div>
                                        <div class="system_info">Homestead <span>Pre-Packaged Vagrant Box</span></div>
                                    </a>
                                </li>
                                <li class="sys_spark">
                                    <a href="https://spark.laravel.com">
                                        <div class="system_icon"><img src="/img/ecosystem/spark.min.svg" alt="Icon"></div>
                                        <div class="system_info">Spark <span>SaaS App Scaffolding</span></div>
                                    </a>
                                </li>
                                <li class="sys_valet">
                                    <a href="/docs/{{DEFAULT_VERSION}}/valet">
                                        <div class="system_icon"><img src="/img/ecosystem/valet.min.svg" alt="Icon"></div>
                                        <div class="system_info">Valet <span>Mac 的開發環境</span></div>
                                    </a>
                                </li>
                                <li class="sys_mix">
                                    <a href="/docs/{{DEFAULT_VERSION}}/mix">
                                        <div class="system_icon"><img src="/img/ecosystem/mix.min.svg" alt="Icon"></div>
                                        <div class="system_info">Mix <span>Webpack 檔案編譯</span></div>
                                    </a>
                                </li>
                                <li class="sys_cashier">
                                    <a href="/docs/{{DEFAULT_VERSION}}/billing">
                                        <div class="system_icon"><img src="/img/ecosystem/cashier.min.svg" alt="Icon"></div>
                                        <div class="system_info">Cashier <span>訂閱計費整合</span></div>
                                    </a>
                                </li>
                                <li class="sys_dusk">
                                    <a href="/docs/{{DEFAULT_VERSION}}/dusk">
                                        <div class="system_icon"><img src="/img/ecosystem/dusk.min.svg" alt="Icon"></div>
                                        <div class="system_info">Dusk <span>瀏覽器測試和自動化測試</span></div>
                                    </a>
                                </li>
                                <li class="sys_passport">
                                    <a href="/docs/{{DEFAULT_VERSION}}/passport">
                                        <div class="system_icon"><img src="/img/ecosystem/passport.min.svg" alt="Icon"></div>
                                        <div class="system_info">Passport <span>簡單實踐 OAuth2</span></div>
                                    </a>
                                </li>
                                <li class="sys_scout">
                                    <a href="/docs/{{DEFAULT_VERSION}}/scout">
                                        <div class="system_icon"><img src="/img/ecosystem/scout.min.svg" alt="Icon"></div>
                                        <div class="system_info">Scout <span>全文搜索</span></div>
                                    </a>
                                </li>
                                <li class="sys_socialite">
                                    <a href="/docs/{{DEFAULT_VERSION}}/socialite">
                                        <div class="system_icon"><img src="/img/ecosystem/socialite.min.svg" alt="Icon"></div>
                                        <div class="system_info">Socialite <span>OAuth 驗證</span></div>
                                    </a>
                                </li>
                                <li class="sys_telescope">
                                    <a href="/docs/{{DEFAULT_VERSION}}/telescope">
                                        <div class="system_icon"><img src="/img/ecosystem/telescope.min.svg" alt="Icon"></div>
                                        <div class="system_info">Telescope <span>Debug 助手</span></div>
                                    </a>
                                </li>
                                <li class="sys_tinker">
                                    <a href="https://github.com/laravel/tinker">
                                        <div class="system_icon"><img src="/img/ecosystem/tinker.min.svg" alt="Icon"></div>
                                        <div class="system_info">Tinker <span>互動式 REPL</span></div>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="content_block bg_right resources">
                            <div class="content">
                                <h6>相關資源</h6>
                                <h1>為您所建立的社群</h1>
                                <p>無論您是開發人員還是 20 人的團隊，都要感謝我們的社群，使得它很容易上手。</p>
                                <ul class="resource_list">
                                    <li><a href="https://blog.laravel.com">部落格</a></li>
                                    <li><a href="https://laracasts.com">Laracasts</a></li>
                                    <li><a href="https://laravel-news.com">Laravel 最新消息</a></li>
                                    <li><a href="https://laracon.us/">Laracon</a></li>
                                    <li><a href="https://larajobs.com/">工作機會</a></li>
                                    <li><a href="https://laracon.eu/">Laracon 歐盟</a></li>
                                    <li><a href="https://laracasts.com/discuss">論壇</a></li>
                                    <li><a href="https://laracon.com.au/">Laracon 澳洲</a></li>
                                    <li><a href="https://certification.laravel.com/">相關認證</a></li>
                                </ul>
                            </div>

                            <div class="featured_resource">
                                <div class="resource_icon">
                                    <img src="/img/icons/laracasts.min.svg" alt="Laracasts">
                                </div>
                                <h6>特色資源</h6>
                                <h3>Laracasts</h3>
                                <p class="small">10 位專家當中，就有 9 位推薦 Laracasts 而不是其他競爭品牌，不信你自己去玩玩看，然後順便提升你的開發技能。</p>
                                <a href="https://laracasts.com" class="btn secondary"><span>立即加入 →</span></a>
                            </div>
                            <div class="bg">
                                <video poster="/img/blocks/blocks_4.jpg" playsinline autoplay muted loop>
                                    <source src="/img/blocks/blocks_4.mp4" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
