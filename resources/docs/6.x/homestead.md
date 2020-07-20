# Laravel Homestead

- [簡介](#introduction)
- [安裝與設定](#installation-and-setup)
    - [前置動作](#first-steps)
    - [設定 Homestead](#configuring-homestead)
    - [啟動 Vagrant Box](#launching-the-vagrant-box)
    - [根據專案各別安裝](#per-project-installation)
    - [安裝可選功能](#installing-optional-features)
    - [別名](#aliases)
- [常見用法](#daily-usage)
    - [全域存取 Homestead](#accessing-homestead-globally)
    - [透過 SSH 連接](#connecting-via-ssh)
    - [連接資料庫](#connecting-to-databases)
    - [備份資料庫](#database-backups)
    - [快照資料庫](#database-snapshots)
    - [新增更多網站](#adding-additional-sites)
    - [環境變數](#environment-variables)
    - [設定 Cron 排程器](#configuring-cron-schedules)
    - [設定電子信箱](#configuring-mailhog)
    - [設定 Minio](#configuring-minio)
    - [連接埠](#ports)
    - [分享你的環境](#sharing-your-environment)
    - [多個 PHP 版本](#multiple-php-versions)
    - [網頁伺服器](#web-servers)
    - [電子信箱](#mail)
- [測試與分析](#debugging-and-profiling)
    - [使用 Xdebug 發送 Web 測試請求](#debugging-web-requests)
    - [測試 CLI 應用程式](#debugging-cli-applications)
    - [使用 Blackfire 對應用程式進行效能分析](#profiling-applications-with-blackfire)
- [網路介面卡](#network-interfaces)
- [擴展 Homestead](#extending-homestead)
- [升級 Homestead](#updating-homestead)
- [特定虛擬機設定](#provider-specific-settings)
    - [VirtualBox](#provider-specific-virtualbox)

<a name="introduction"></a>
## 簡介

Laravel 致力於讓 PHP 開發體驗更愉快，也包含本地的開發環境。[Vagrant](https://www.vagrantup.com) 提供了一個簡單、優雅的方式來管理與供應虛擬機器。

Laravel Homestead 是一個官方預載的 Vagrant box，提供一個美好的開發環境，不需要在本機電腦安裝 PHP、HHVM、網頁伺服器或任何伺服器軟體。不用擔心搞亂你的系統！Vagrant box 可以搞定一切。如果有什麼地方搞爛掉了，還可以在幾分鐘內快速地砍掉並重建虛擬機器！

Homestead 可以在任何 Windows、Mac 或 Linux 系統上面執行，裡面包含了 Nginx 網頁伺服器、PHP、MySQL、Postgres、Redis、Memcached、Node，以及所有在使用 Laravel 開發各種精彩的應用程式時所需要的軟體。

> {note} 如果是 Windows 的使用者，您可能需要啟用硬體虛擬化(VT-x)。這通常需要透過 BIOS 來啟用它。假如您使用的 Hyper-V 是在 UEFI 系統上，為了使用 VT-x 您可能需同時地禁用 Hyper-V。 

<a name="included-software"></a>
### 內建軟體

<style>
    #software-list > ul {
        column-count: 3; -moz-column-count: 3; -webkit-column-count: 3;
        column-gap: 5em; -moz-column-gap: 5em; -webkit-column-gap: 5em;
        line-height: 1.9;
    }
</style>

<div id="software-list" markdown="1">
- Ubuntu 18.04
- Git
- PHP 7.3
- PHP 7.2
- PHP 7.1
- PHP 7.0
- PHP 5.6
- Nginx
- MySQL
- lmm for MySQL or MariaDB database snapshots
- Sqlite3
- PostgreSQL
- Composer
- Node (With Yarn, Bower, Grunt, and Gulp)
- Redis
- Memcached
- Beanstalkd
- Mailhog
- avahi
- ngrok
- Xdebug
- XHProf / Tideways / XHGui
- wp-cli
</div>

<a name="optional-software"></a>
### 可選軟體

<style>
    #software-list > ul {
        column-count: 3; -moz-column-count: 3; -webkit-column-count: 3;
        column-gap: 5em; -moz-column-gap: 5em; -webkit-column-gap: 5em;
        line-height: 1.9;
    }
</style>

<div id="software-list" markdown="1">
- Apache
- Blackfire
- Cassandra
- Chronograf
- CouchDB
- Crystal & Lucky Framework
- Docker
- Elasticsearch
- Gearman
- Go
- Grafana
- InfluxDB
- MariaDB
- MinIO
- MongoDB
- MySQL 8
- Neo4j
- Oh My Zsh
- Open Resty
- PM2
- Python
- RabbitMQ
- Solr
- Webdriver & Laravel Dusk Utilities
</div>

<a name="installation-and-setup"></a>
## 安裝與設定

<a name="first-steps"></a>
### 前置動作

在啟動 Homestead 環境之前，必需先安裝 [VirtualBox 6.x](https://www.virtualbox.org/wiki/Downloads)、[VMWare](https://www.vmware.com)、[Parallels](https://www.parallels.com/products/desktop/) 或 [Hyper-V](https://docs.microsoft.com/zh-tw/virtualization/hyper-v-on-windows/quick-start/enable-hyper-v) 以及搭配 [Vagrant](https://www.vagrantup.com/downloads.html)。這些軟體在各個常用的平台都有提供易用的視覺化安裝程式。

若要使用 VMware provider，你需要同時購買 VMware Fusion / Workstation 及 [VMware Vagrant plug-in](https://www.vagrantup.com/vmware)。雖然他不是免費的，但 VMware 可以在共享資料夾上獲得較快的性能。

若要使用 Parallels provider，則必需安裝 [Parallels Vagrant plug-in](https://github.com/Parallels/vagrant-parallels)，它是免費的。

由於 [Vagrant 的限制](https://www.vagrantup.com/docs/hyperv/limitations.html)，Hyper-V 將會忽略所有的網路設定。

#### 安裝 Homestead Vagrant Box

當 VirtualBox / VMware 以及 Vagrant 安裝完成後，可以在終端機執行下列指令將 `laravel/homestead` 這個 box 安裝進你的 Vagrant 程式中。下載 box 會花一點時間，時間長短將依據你的網路速度決定：

    vagrant box add laravel/homestead

如果此指令執行失敗了，請確保安裝的 Vargrant 是最新版。

> {note} Homestead 會定期發出 `alpha`、`beta` boxes 用於測試，這可能會影響到 `vagrant box add` 指令，如果你在運行 `vagrant box add` 時遇到問題，你可以運行 `vagrant up` 指令，當 Vagrant 嘗試啟動虛擬機時，將會下載正確的 Box。

#### 安裝 Homestead

你可以通过克隆代码来安装 Homestead。建议将代码克隆到你的「home」目录下的 Homestead 文件夹中，这样 Homestead box 就可以作为你的所有 Laravel 项目的主机：

您可以通過將儲存庫 clone 到主機上來安裝 Homestead，建議將程式碼 clone 到你的「home」目錄下的 `Homestead` 資料夾當中，這樣 Homestead box 就可以作為你的所有 Laravel 項目的主機：

    git clone https://github.com/laravel/homestead.git ~/Homestead

您應該使用具有穩定版本標籤的 Homestead，因為 `master` 分支可能不是那麼的穩定。不過你可以在 [GitHub 發布頁面](https://github.com/laravel/homestead/releases)上找到最新的穩定版本，或者，你可以查看包含最新穩定版本的 `release` 分支：

    cd ~/Homestead

    git checkout release

當 Homestead 儲存庫 clone 完成以後，在 Homestead 目錄當中使用 `bash init.sh` 指令來建立 `Homestead.yaml` 設定文件。`Homestead.yaml` 文件將會被存放在 Homestead 目錄中：

    // Mac / Linux...
    bash init.sh

    // Windows...
    init.bat

<a name="configuring-homestead"></a>
### 設定 Homestead

#### 設定提供者

The `provider` key in your `Homestead.yaml` file indicates which Vagrant provider should be used: `virtualbox`, `vmware_fusion`, `vmware_workstation`, `parallels` or `hyperv`. You may set this to the provider you prefer:

在 `Homestead.yaml` 檔案中的 `provider` 是用來設定想要使用哪一個 Vagrant 提供者，像是：`virtualbox`, `vmware_fusion`, `vmware_workstation`, `parallels` 以及 `hyperv`，你可以根據你的喜好來設定它們：

    provider: virtualbox

#### 設定共享目錄

可以在 `Homestead.yaml` 檔案的 `folders` 屬性裡列出所有想與 Homestead 環境共享的目錄。這些目錄中的檔案若有更動，它們將會同步更動在你的本機電腦與 Homestead 環境。可以將多個共享目錄都設定於此：

    folders:
        - map: ~/code/project1
          to: /home/vagrant/project1

> {note} Windows 使用者不應該使用 `~/` 相對路徑語法，而應該使用其項目的絕對路徑，例如：`C:\Users\user\Code\project1`。

你需要將每個項目對應到自己的目錄當中，而不是直接對應整個 `~/code` 目錄，當你對應目錄時，虛擬機會監聽該目錄下每個文件的所有硬碟讀寫，隨著站點數量的增加，可能會遇到效能上的問題，尤其是在包含大量文件的低端硬體或項目中，效能問題可能會越發明顯，正是因為這個原因，所以不推薦對應整個 `~/code` 目錄。

    folders:
        - map: ~/code/project1
          to: /home/vagrant/project1

        - map: ~/code/project2
          to: /home/vagrant/project2

> {note} 當你在使用 Homestead 的時候，永遠不要掛載當前目錄 `.`，這會導致 Vagrant 不對應當前目錄到 `/vagrant` 並且在設置過程時中斷可選功能，造成異常結果。

若要啟用 [NFS](https://www.vagrantup.com/docs/synced-folders/nfs.html)，只需要在共享目錄的設定值中加入一個簡單的參數：

    folders:
        - map: ~/code/project1
          to: /home/vagrant/project1
          type: "nfs"

> {note} 在 `Windows` 上使用 NFS 時，應該考慮安裝 [vagrant-winnfsd](https://github.com/winnfsd/vagrant-winnfsd) 套件，該套件可用於在 Homestead 中為文件和目錄維持正確的使用者、群組權限。

你也可以透過 Vagrant 的 [Synced Folders](https://www.vagrantup.com/docs/synced-folders/basic_usage.html)，將想帶入的任何選項列在 options 關鍵字下方：

    folders:
        - map: ~/code/project1
          to: /home/vagrant/project1
          type: "rsync"
          options:
              rsync__args: ["--verbose", "--archive", "--delete", "-zz"]
              rsync__exclude: ["node_modules"]

#### 設定 Nginx 網站

對 Nginx 不熟悉嗎？沒關係。`sites` 屬性幫助你可以輕易的指定「網域」對應至 homestead 環境中的目錄。在 `Homestead.yaml` 檔案中已包含一個網站設定範例。同樣的，你可以增加數個網站到 Homestead 環境中。Homestead 可以為每個你正在開發中的 Laravel 專案提供方便的虛擬化環境：

    sites:
        - map: homestead.test
          to: /home/vagrant/project1/public

在設定 Homestead box 之後，若有更改 `sites` 屬性，你應該重新執行設定指令 `vagrant reload --provision` 來更新虛擬機裡的 Nginx 設定。

> {note} Homestead 腳本被建制為可能保證操作順利，但是，如果在設置的過程還是遇到問題，則需要透過 `vagrant destroy && vagrant up` 指令來銷毀並重啟虛擬機。

<a name="hostname-resolution"></a>
#### 主機名稱對應

Homestead 通過 `mDNS` 發布主機名來自動解析主機，如果你在 `Homestead.yaml` 中設置了 `hostname: homestead`，則該主機會以 `homestead.local` 的形式生效（可以通過 `homestead.local` 這個主機名來訪問對應的虛擬機）。macOS、iOS 和 Linux 桌面系統預設提供了對於 `mDNS` 的支持，Windows 則需要額外安裝 [Bonjour Print Services for Windows](https://support.apple.com/kb/DL999?viewlocale=zh_TW&locale=zh_TW) 才能實現。

自動主機名稱在每個項目獨立安裝的 Homestead 中工作最好，如果你在一個 Homestead 服務上部署了多個站點，可以在伺服器主機上將站點「域名」添加到 `hosts` 設定檔中做域名對應，`hosts` 設定檔將會針對 Homestead 站點的請求重新定向到 Homestead 虛擬機，在 Mac 和 Linux 系統中，該設定檔位於 `/etc/hosts`，而在 Windows 系统中，設定檔位於 `C:\Windows\System32\drivers\etc\hosts`，我們以 `homestead.test` 域名對應為例，添加到 `hosts` 設定檔的內容如下所示：

    192.168.10.10  homestead.test

確保 IP 位址和你的 `Homestead.yaml` 設定文件中的 IP 設定是一致的，當你將域名添加到 `hosts` 設定文件，就可以在瀏覽器中透過該域名來訪問站點了。

    http://homestead.test

<a name="launching-the-vagrant-box"></a>
### 啟動 Vagrant Box

當你編輯完 `Homestead.yaml` 後，開啟終端機，進入 Homestead 目錄，並執行 `vagrant up` 指令。Vagrant 就會自將虛擬主機啟動並自動設定共享目錄和 Nginx 網站。

如果要移除虛擬機器，可以使用 `vagrant destroy --force` 指令。

<a name="per-project-installation"></a>
### 根據專案各別安裝

有別於將 Homestead 安裝成全域環境且讓所有的專案共用同一個 Homestead box，你可以各別為每一個專案獨立設定一個 Homstead。如果你希望直接在專案裡傳遞 `Vagrantfile`，那麼替每個專案安裝 Homestead 即是你可以考慮的方式，這將會允許其他人可以簡單地執行 `vagrant up` 即能開始工作於此專案。

使用 Composer 將 Homestead 直接安裝至你的專案中：

    composer require laravel/homestead --dev

一旦 Homestead 安裝完畢，你可以使用 `make` 指令產生 `Vagrantfile` 與 `Homestead.yaml` 存放於專案的根目錄。這個 make 指令將會自動設定 `sites` 及 `folders` 於 `Homestead.yaml`。

Mac / Linux:

    php vendor/bin/homestead make

Windows:

    vendor\\bin\\homestead make

接著，在終端機中執行 `vagrant up` 指令，並透過網頁瀏覽器造訪 `http://homestead.test`。再次提醒，如果您未使用自動[主機名稱對應](#hostname-resolution)，你仍然需要在 `/etc/hosts` 裡設定 `homestead.test` 或其他想要使用的網域。

<a name="installing-optional-features"></a>
### 安裝可選功能

使用 Homestead 設定檔中的 `features` 可以設定安裝的功能選項，你可以使用 true/false 來啟用或禁用大多數的功能，而某些功能則允許多種設定選項：

    features:
        - blackfire:
            server_id: "server_id"
            server_token: "server_value"
            client_id: "client_id"
            client_token: "client_value"
        - cassandra: true
        - chronograf: true
        - couchdb: true
        - crystal: true
        - docker: true
        - elasticsearch:
            version: 7
        - gearman: true
        - golang: true
        - grafana: true
        - influxdb: true
        - mariadb: true
        - minio: true
        - mongodb: true
        - mysql8: true
        - neo4j: true
        - ohmyzsh: true
        - openresty: true
        - pm2: true
        - python: true
        - rabbitmq: true
        - solr: true
        - webdriver: true

#### MariaDB

啟用 MariaDB 將會刪除 MySQL 並且安裝 MariaDB，MariaDB 可以替代 MySQL，因此您仍然應該在應用程式的資料庫設定中使用 MySQL 資料庫連接方式。

#### MongoDB

預設的 MongoDB 安裝會將資料庫使用者設定為 `homestead`，並且將其的密碼設定為 `secret`。

#### Elasticsearch

你可以指定安裝特定的 Elasticsearch 版本，可以是主要版本或次要的版本號(major.minor.patch)，預設安裝將建立一個名為「homestead」的集合，切記，您永遠不要給 Elasticsearch 佔用超過一半的作業系統內存，因此請確保您的 Homestead 機器至少有兩倍的空間足夠分配給 Elasticsearch。

> {tip} 查看 [Elasticsearch 文件](https://www.elastic.co/guide/en/elasticsearch/reference/current) 了解如何設定您的設定。

#### Neo4j

預設 Neo4j 安裝會將資料庫使用者設定為 `homestead`，並將其密碼設置為 `secret`，通過瀏覽器打開 `http://homestead.test:7474`，當通訊埠 `7687`(Bolt)、`7474`(HTTP)、`7473`(HTTPS) 準備就緒，就會可以開始處理來自 Neo4j 使用者端的請求。

<a name="aliases"></a>
### 別名

透過修改 Homestead 目錄中的 `aliases` 檔案可以把 Bash 別名新增到你的 Homestead 機器中：

    alias c='clear'
    alias ..='cd ..'

更新 `aliases` 檔案內容之後，你應該使用 `vagrant reload --provision` 指令來重新設定 Homestead 機器。這會確保你的新別名可以在機器上使用。

<a name="daily-usage"></a>
## 常見用法

<a name="accessing-homestead-globally"></a>
### 全域存取 Homestead

有時你可能想從任何地方 `vagrant up` 你的 Homestead 機器。你可以在 Mac / Linux 上增加簡單的 Bash 函式至你的 Bash 設定檔來做到。 在 Windows 上，你可以添加一個「batch」檔案到你的 `PATH`。此函式會自動指到你的 Homestead 安裝位置，能讓你在系統的任何位置執行任意的 Vagrant 指令：

#### Mac / Linux

    function homestead() {
        ( cd ~/Homestead && vagrant $* )
    }

確保函式中 `~/Homestead` 路徑為你實際 Homestead 的安裝位置。一旦函式被設定後，你可以在系統的任何位置執行像是 `homestead up` 或 `homestead ssh` 的指令。

#### Windows

在你的機器上的任何地方建立一個 `homestead.bat` batch 檔案，並包含以下內容：

    @echo off

    set cwd=%cd%
    set homesteadVagrant=C:\Homestead

    cd /d %homesteadVagrant% && vagrant %*
    cd /d %cwd%

    set cwd=
    set homesteadVagrant=

確認你有將腳本中的路徑 `C:\Homestead` 調整成你 Homesteam 的安裝位置。建立完檔案之後，把此檔案位置加入你的 `PATH`。你就可以從系統上的任何地方執行像是 `homestead up` 或 `homestead ssh` 的指令。

<a name="connecting-via-ssh"></a>
### 透過 SSH 連接

你可以在終端機裡進入你的 Homestead 目錄，並執行 `vagrant ssh` 指令藉此以 SSH 連上你的虛擬主機。

但是，你可能會經常需要透過 SSH 連上你的 Homestead 主機，因此你可以考慮在你的本機電腦上創建一個上述的「Bash 函式」來快速 SSH 至 Homestead box。

<a name="connecting-to-databases"></a>
### 連接資料庫

`homestead` 的資料庫已經設定了 MySQL 與 Postgres 兩種資料庫。為了方便使用，Laravel 的 .env 檔案預設會設定框架會使用此資料庫。

如果要從本機資料庫的客戶端連接到 MySQL 或 PostgreSQL 資料庫，你應該連接到 `127.0.0.1` 和 port `33060`（MySQL）或 `54320`（PostgreSQL）。資料庫的帳號及密碼為 `homestead` / `secret`。

> {note} 在本機電腦你應該只使用這些非標準的連接埠來連接資料庫。因為當 Laravel 執行於虛擬主機中時，你會在 Laravel 的資料庫設定檔使用預設的 3306 及 5432 連接埠。

<a name="database-backups"></a>
### 備份資料庫

當您的“無家可歸”盒子被破壞時，Homestead可以自動備份數據庫。 要使用此功能，您必須使用Vagrant 2.1.0或更高版本。 或者，如果您使用的是舊版的Vagrant，則必須安裝`vagrant-triggers`插件。 要啟用自動數據庫備份，請將以下行添加到“ Homestead.yaml”文件中：

Homestead 可以自動備份資料庫，當您的 Vagrant box 被破壞時，資料不會跟著一去不復返，如果要使用這項功能，你必須使用 Vagrant 2.1.0 或更高版本。或者，如果你使用的是舊版的 Vagrant，則必須安裝 `vagrant-triggers` 套件，要啟用自動備份資料庫，請將以下指令添加到 `Homestead.yaml` 文件當中。

    backup: true

設定完成後，執行 `vagrant destroy` 命令，Homestead 會將資料庫導出到 `mysql_backup` 和 `postgres_backup` 目錄。如果使用[根據專案各別安裝](#per-project-installation)，則可以在 Homestead 的目錄中找到這些備份目錄，也可以在項目的根目錄中找到這些備份目錄。

<a name="database-snapshots"></a>
### 快照資料庫

Homestead 支援暫停 MySQL 和 MariaDB 資料庫的狀態，並使用 [Logical MySQL Manager](https://github.com/Lullabot/lmm) 在它們之間進行分支，例如，假設在一個具有數 GB 的資料庫站點上工作，您可以導入資料庫快照，在完成一些工作並在本地建立一些測試內容之後，您可以快速恢復到原始狀態。

在底層運行中，LMM 使用了 LVM 支援即時分支的快照功能，這代表當修改資料表中的某項資料列時，只會將你所做的更新寫入硬碟，從而在恢復時節省大量時間和硬碟空間。

由於 `lmm` 會與 LVM 進行交互，所以必須以 `root` 身份運行，要了解 LMM 支援的所有指令，可以在 Homestead 虛擬機中透過 `sudo lmm` 查看，lmm 常見的工作流程會像是這樣：

1. 導入資料庫到 `lmm` 預設的 `master` 分支。
1. 運行 `sudo lmm branch prod-YYYY-MM-DD` 儲存所有尚未做任何修改的資料庫快照。
1. 修改資料庫的紀錄。
1. 運行 `sudo lmm merge prod-YYYY-MM-DD` 回滾所有的修改。
1. 運行 `sudo lmm delete <branch>` 刪除不需要的分支。

<a name="adding-additional-sites"></a>
### 新增更多網站

一旦完成了 Homestead 環境設定並成功執行，你可能會想要為你的 Laravel 應用程式新增更多的 Nginx 網站。你可以在單一個 Homestead 環境中執行許多的 Laravel 安裝。若要新增其他網站，只要新增該網站到你的 `Homestead.yaml` 檔案中：

    sites:
        - map: homestead.test
          to: /home/vagrant/project1/public
        - map: another.test
          to: /home/vagrant/project2/public

如果 Vagrant 不再自動管理你的「hosts」檔案，你可能需要將新的網站新增到這個檔案中：

    192.168.10.10  homestead.test
    192.168.10.10  another.test

一旦新增好網站，請從 Homestead 目錄中執行 `vagrant reload --provision` 指令。

<a name="site-types"></a>
#### 網站類型

Homestead 支援幾種類型的網站來讓你輕易的執行非 Laravel 的專案。例如，我們可以使用 `symfony2` 網站類型來輕易的將 Symfony 應用程式新增到 Homestead：

    sites:
        - map: symfony2.test
          to: /home/vagrant/my-symfony-project/web
          type: "symfony2"

目前可用的網站類型有：`apache`、`apigility`、`expressive`、`laravel`（預設）、`proxy`、`silverstripe`、`statamic`、`symfony2`、`symfony4` 和 `zf`。

<a name="site-parameters"></a>
#### 網站參數

你可以透過 `params` 網站指令來新增額外的 Nginx 的 `fastcgi_param` 值到你的網站。例如，我們將要新增一個 `BAR` 值到 `FOO` 參數：

    sites:
        - map: homestead.test
          to: /home/vagrant/project1/public
          params:
              - key: FOO
                value: BAR

<a name="environment-variables"></a>
### 環境變數

你能新增它們到你的 `Homestead.yaml` 檔案來設定全域的環境變數：

    variables:
        - key: APP_ENV
          value: local
        - key: FOO
          value: bar

在更新 `Homestead.yaml` 之前，請務必執行過 `vagrant reload --provision` 指令來重新設定機器。這會更新所有安裝的 PHP 版本的 PHP-FPM 設定，且還會更新 `vagrant` 使用者的環境。

<a name="configuring-cron-schedules"></a>
### 設定 Cron 排程器

Laravel 提供了便利的方式來[排程 Cron 任務](/docs/{{version}}/scheduling)，透過 Artisan 的 `schedule:run` 指令，排程便會在每分鐘被執行。`schedule:run` 指令會檢查你定義在 `App\Console\Kernel` 類別中排程的任務，判斷哪個任務該被執行。

如果你想為 Homestead 網站使用 `schedule:run` 指令，你可以在定義網站時設置 `schedule` 選項為 `true：`

    sites:
        - map: homestead.test
          to: /home/vagrant/project1/public
          schedule: true

該網站的 Cron 任務會被定義於虛擬機器的 `/etc/cron.d` 資料夾中。

<a name="configuring-mailhog"></a>
### 設定 Mailhog

Mailhog 可以讓你輕易的擷取你送出的 Email 並檢查它，而不用真的將電子郵件發送給其他人。請使用以下電子郵件設定來更新 `.env` 檔案：

    MAIL_DRIVER=smtp
    MAIL_HOST=localhost
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null

一旦設定了 Mailhog，您可以在以下位址瀏覽 Mailhog 儀表板 `http://localhost:8025`。

<a name="configuring-minio"></a>
### 設定 Minio

Minio 是一項開源的物件儲存伺服器，並且提供了與 Amazon S3 兼容的 API，要安裝 Minio 需要更新 `Homestead.yaml`，在 [features](#installing-optional-features) 設定項目中啟用它：

    minio: true

在預設情況下，Minio 可以透過 9600 通訊埠來瀏覽，在瀏覽器中打開 `http://localhost:9600/` 即可查看 Monio 儀表板，預設的 `access key`、`secret key` 分別是 `homestead`、`secretkey`，使用 Minio 時需要使用 `us-east-1` 區域。

為了使用 Minio，你需要在設定文件 `config/filesystems.php` 當中修改 Amazon S3 的硬碟設定，添加 `use_path_style_endpoint` 設定項目到 `s3` 項目，並且將 `url` 的值修改為 `endpoint`：

    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'endpoint' => env('AWS_URL'),
        'use_path_style_endpoint' => true
    ]

最後，確保在 `.env` 設定文件中存在以下設定：

    AWS_ACCESS_KEY_ID=homestead
    AWS_SECRET_ACCESS_KEY=secretkey
    AWS_DEFAULT_REGION=us-east-1
    AWS_URL=http://localhost:9600

要設定 buckets 則可以添加 `buckets` 指令到 Homestead 設定文件：

    buckets:
        - name: your-bucket
          policy: public
        - name: your-private-bucket
          policy: none

目前支援的 `policy` 值包括：`none`、`download`、`upload` 和 `public`。

<a name="ports"></a>
### 連接埠

以下的連接埠預設將會被轉發至 Homestead 環境：

<div class="content-list" markdown="1">
- **SSH:** 2222 &rarr; 轉發到 22
- **ngrok UI:** 4040 &rarr; 轉發到 4040
- **HTTP:** 8000 &rarr; 轉發到 80
- **HTTPS:** 44300 &rarr; 轉發到 443
- **MySQL:** 33060 &rarr; 轉發到 3306
- **PostgreSQL:** 54320 &rarr; 轉發到 5432
- **MongoDB:** 27017 &rarr; 轉發到 27017
- **Mailhog:** 8025 &rarr; 轉發到 8025
- **Minio:** 9600 &rarr; 轉發到 9600
</div>

#### 轉發到其他連接埠

你可以轉發更多額外的連接埠給 Vagrant box，同時也可指定連接埠的通訊協定：

    ports:
        - send: 50000
          to: 5000
        - send: 7777
          to: 777
          protocol: udp

<a name="sharing-your-environment"></a>
### 共享環境變數

有時候你可能會希望和合作夥伴分享你現在的工作環境或者分享到一個client上。Vagrant有一個內建的方法，透過 `vagrant share` 支援這個功能;然而，如果你有多個網站同時使用你的 `Homestead.yaml` 檔案，這功能將無法使用。

要解決這個問題，Homestead 加入了自己的 `share` 指令。開始前，透過 `vagrant ssh` 連線到你的 Homestead 機器然後執行 `share homestead.test。這會從你的` `Homestead.yaml` 分享 `homestead.test` 網站。當然，你可以將 `homestead.test` 替換成任何其他網站。

    share homestead.test

執行這個指令之後，你將會看到一個 Ngrok 視窗，其中包含著活動記錄和共享網站的公開存取網址。如果你想指定一個自定的區域、子網域或者其他 Ngrok runtime 選項，你可以加入到 `share` 下：

    share homestead.test -region=eu -subdomain=laravel

> {note} 請記住，Vagrant 本質上還是不安全的，當你執行 `share` 指令，你會暴露你的虛擬機器位置到網路上。

<a name="multiple-php-versions"></a>
### 多個 PHP 版本

Homestead 6 在同一個虛擬機上支援了多個 PHP 版本的切換。你可以在 `Homestead.yaml` 檔案中指定給定網站要使用的 PHP 版本。目前可用的 PHP 版本有：`5.6`、`7.0`、`7.1`、`7.2`、`7.3` 和 `7.４`（預設）：

    sites:
        - map: homestead.test
          to: /home/vagrant/project1/public
          php: "7.1"

另外，你可以透過 CLI 來使用任何有支援的 PHP 版本：

    php5.6 artisan list
    php7.0 artisan list
    php7.1 artisan list
    php7.2 artisan list
    php7.3 artisan list
    php7.4 artisan list

你還可以通過在 Homestead 虛擬機中送出以下指令來更新預設的 CLI 版本：

    php56
    php70
    php71
    php72
    php73
    php74

<a name="web-servers"></a>
### 網頁伺服器

Homestead 預設採用 Nginx 作為網頁伺服器。然而，如果指定 `apache` 作為網站類型，就會改安裝 Apache。雖然兩個網站伺服器都能安裝，但無法同時運行。`flip` 是簡易切換網頁伺服器的指令。`flip` 指令會自行確定運行中的伺服器已關閉，才會接著啟動另一台機器。你可以透過 SSH 進到 Homestead 機器上執行該指令：

    flip

<a name="mail"></a>
### 電子信箱

Homestead 內建了 Postfix 電子郵件轉發代理，預設會監聽 `1025` 通訊埠，所以，你可以指定應用程式使用 `smtp` 伺服器為 `localhost`，這樣所有本機應用程式所發送的電子郵件都會經由 Postfix 處理，然後被 Mialhog 擷取，如果要查看所有發送出去的電子郵件，可以在瀏覽器打開 [http://localhost:8025](http://localhost:8025)。

<a name="debugging-and-profiling"></a>
## 測試與分析

<a name="debugging-web-requests"></a>
### 使用 Xdebug 發送 Web 測試請求

Homestead 內建了 [Xdebug](https://xdebug.org) 提供逐步測試的功能。例如，你可以從瀏覽器載入某個頁面，此時 PHP 會連接到你的 IDE 以便允許對於應用程式所運行的程式碼進行檢查和修改。

預設情況下，Xdebug 已經運行並且準備好接收請求，如果你需要在 CLI 中啟用 Xdebug，那麼可以在 Homestead 虛擬機中執行 `sudo phpenmod xdebug` 指令即可，接下來，按照 IDE 的步驟只是來啟用測試功能，最後，透過瀏覽器新增 [bookmarklet](https://www.jetbrains.com/phpstorm/marklets/) 外掛元件來觸發 Xdebug。

> {note} Xdebug 會導致 PHP 運行速度變慢，如果要禁用 Xdebug，可以在虛擬機中執行 `sudo phpdismod xdebug` 並且重新執行 PHP-FPM 服務。

<a name="debugging-cli-applications"></a>
### 測試 CLI 應用程式

要測試 PHP CLI 應用程式，請在 Vagrant box 內使用 `xphp` 指令：

    xphp path/to/script

#### 自動啟動 Xdebug


当发送请求到 Web 服务器调试功能测试时，自动启动调试比修改测试通过自定义请求头或者 Cookie 来触发调试要轻松许多。要设置 Xdebug 自动启动，可以在虚拟机中编辑 /etc/php/7.#/fpm/conf.d/20-xdebug.ini 添加如下配置来完成：

When debugging functional tests that make requests to the web server, it is easier to autostart debugging rather than modifying tests to pass through a custom header or cookie to trigger debugging. To force Xdebug to start automatically, modify `/etc/php/7.x/fpm/conf.d/20-xdebug.ini` inside your Vagrant box and add the following configuration:

    ; If Homestead.yml contains a different subnet for the IP address, this address may be different...
    xdebug.remote_host = 192.168.10.1
    xdebug.remote_autostart = 1

<a name="profiling-applications-with-blackfire"></a>
### 使用 Blackfire 對應用程式進行效能分析

[Blackfire](https://blackfire.io/docs/introduction) is a SaaS service for profiling web requests and CLI applications and writing performance assertions. It offers an interactive user interface which displays profile data in call-graphs and timelines. It is built for use in development, staging, and production, with no overhead for end users. It provides performance, quality, and security checks on code and `php.ini` configuration settings.

The [Blackfire Player](https://blackfire.io/docs/player/index) is an open-source Web Crawling, Web Testing and Web Scraping application which can work jointly with Blackfire in order to script profiling scenarios.

To enable Blackfire, use the "features" setting in your Homestead configuration file:

    features:
        - blackfire:
            server_id: "server_id"
            server_token: "server_value"
            client_id: "client_id"
            client_token: "client_value"

Blackfire server credentials and client credentials [require a user account](https://blackfire.io/signup). Blackfire offers various options to profile an application, including a CLI tool and browser extension. Please [review the Blackfire documentation for more details](https://blackfire.io/docs/cookbooks/index).

### Profiling PHP Performance Using XHGui

[XHGui](https://www.github.com/perftools/xhgui) is a user interface for exploring the performance of your PHP applications. To enable XHGui, add `xhgui: 'true'` to your site configuration:

    sites:
        -
            map: your-site.test
            to: /home/vagrant/your-site/public
            type: "apache"
            xhgui: 'true'

If the site already exists, make sure to run `vagrant provision` after updating your configuration.

To profile a web request, add `xhgui=on` as a query parameter to a request. XHGui will automatically attach a cookie to the response so that subsequent requests do not need the query string value. You may view your application profile results by browsing to `http://your-site.test/xhgui`.

To profile a CLI request using XHGui, prefix the command with `XHGUI=on`:

    XHGUI=on path/to/script

CLI profile results may be viewed in the same way as web profile results.

Note that the act of profiling slows down script execution, and absolute times may be as much as twice as real-world requests. Therefore, always compare percentage improvements and not absolute numbers. Also, be aware the execution time includes any time spent paused in a debugger.

Since performance profiles take up significant disk space, they are deleted automatically after a few days.

<a name="network-interfaces"></a>
## Network Interfaces

The `networks` property of the `Homestead.yaml` configures network interfaces for your Homestead environment. You may configure as many interfaces as necessary:

    networks:
        - type: "private_network"
          ip: "192.168.10.20"

To enable a [bridged](https://www.vagrantup.com/docs/networking/public_network.html) interface, configure a `bridge` setting and change the network type to `public_network`:

    networks:
        - type: "public_network"
          ip: "192.168.10.20"
          bridge: "en1: Wi-Fi (AirPort)"

To enable [DHCP](https://www.vagrantup.com/docs/networking/public_network.html), just remove the `ip` option from your configuration:

    networks:
        - type: "public_network"
          bridge: "en1: Wi-Fi (AirPort)"

<a name="extending-homestead"></a>
## Extending Homestead

You may extend Homestead using the `after.sh` script in the root of your Homestead directory. Within this file, you may add any shell commands that are necessary to properly configure and customize your virtual machine.

When customizing Homestead, Ubuntu may ask you if you would like to keep a package's original configuration or overwrite it with a new configuration file. To avoid this, you should use the following command when installing packages to avoid overwriting any configuration previously written by Homestead:

    sudo apt-get -y \
        -o Dpkg::Options::="--force-confdef" \
        -o Dpkg::Options::="--force-confold" \
        install your-package

### User Customizations

When using Homestead in a team setting, you may want to tweak Homestead to better fit your personal development style. You may create a `user-customizations.sh` file in the root of your Homestead directory (The same directory containing your `Homestead.yaml`). Within this file, you may make any customization you would like; however, the `user-customizations.sh` should not be version controlled.

<a name="updating-homestead"></a>
## 更新 Homestead

Before you begin updating Homestead ensure you have removed your current virtual machine by running the following command in your Homestead directory:

    vagrant destroy

Next, you need to update the Homestead source code. If you cloned the repository you can run the following commands at the location you originally cloned the repository:

    git fetch

    git pull origin release

These commands pull the latest Homestead code from the GitHub repository, fetches the latest tags, and then checks out the latest tagged release. You can find the latest stable release version on the [GitHub releases page](https://github.com/laravel/homestead/releases).

如果你是透過 `composer.json` 文件來安裝 Homestead，那麼你應該確保你的 `composer.json` 文件中包含 `"laravel/homestead": "^9"` 並更新你的依賴套件：

    composer update

然後，你應該先使用 `vagrant box update` 更新你的 Vagrant box:

    vagrant box update

最後，你需要重新建立 Homestead box，以利安裝最新的 Vagrant：

    vagrant up

<a name="provider-specific-settings"></a>
## 特定虛擬機設定

<a name="provider-specific-virtualbox"></a>
### VirtualBox

#### `natdnshostresolver`

預設的 Homestead 會將 `natdnshostresolver` 設定為 `on`。這可以讓 Homestead 去使用本機作業系統的 DNS 設定。如果你想要覆寫這個行為，請新增下面幾行到你的 `Homestead.yaml` 檔案：

    provider: virtualbox
    natdnshostresolver: 'off'

#### Windows 的捷徑

如果無法再 Windows 機器上運作該捷徑，你可能需要新增以下內容到 `Vagrantfile` 檔案中：

    config.vm.provider "virtualbox" do |v|
        v.customize ["setextradata", :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"]
    end
