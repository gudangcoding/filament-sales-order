<h1>Langkah Langkah filament panel multi tenant dan shield oke</h1>
<img src='pos1.png'><br>
<ol>
    <li><pre>composer create-project laravel/laravel:^10.0 nama_proyek</pre></li>
    <li><pre>composer require filament/filament:"^3.2" -W</pre></li>
    <li><pre>php artisan filament:install --panels</pre></li>
    <li><pre>php artisan migrate</pre></li>
    <li><pre>php artisan make:filament-user</pre></li>
    <li><pre>composer require spatie/laravel-permission</pre></li>
    <li><pre>php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"</pre>
</li>
    <li>
        <pre>php artisan optimize:clear</pre><br>
        # or<br>
        <pre>php artisan config:clear</pre><br>
    </li>
    <li><pre>php artisan migrate</pre></li>
    <li>
        Tambahkan  pada model User<br>
        <pre>use HasRoles</pre>;
    </li>
    <li>
        Install Shield<br>
        <pre>composer require bezhansalleh/filament-shield</pre>
    </li>
   
    <li>
        <pre>php artisan vendor:publish --tag=filament-shield-config</pre>
    </li>

    <li>
        Tambahkan pada AdminPanelProvider.php<br>
        ->plugins([
            \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
        ]);
    </li>
    <li>
        Jalankan shieldnya agar hak aksenya berjalan<br>
        php artisan shield:install
    </li>
    <li>
        pada model yang berelasi ke team tambahkan belongsto<br>
        contoh : <br>
        <pre>
        public function team(): BelongsTo<br>
        {<br>
            return $this->belongsTo(\App\Models\Team::class);<br>
        }<br>
        </pre>

pada model team tambahkan hasmany atau belongstomany<br>

<pre>
public function members(): BelongsToMany<br>
    {<br>
        return $this->BelongsToMany(User::class);<br>
    }<br>
    public function dataalamat(): HasMany<br>
    {<br>
        return $this->HasMany(DataAlamat::class);<br>
    }<br>
    public function categories(): HasMany<br>
    {<br>
        return $this->HasMany(DataAlamat::class);<br>
    }<br>

    public function role(): HasMany<br>
    {<br>
        return $this->HasMany(Role::class);<br>
    }<br>
    </pre>

    </li>

<li>
    Buat resource baru<br>
    <pre>php artisan make:filament-resource Category --generate --simple</pre><br>
    --simple adalah opsional
</li>
<li>jalanakan ulang php artisan shield:install jika migrasi refresh</li>
<li>
    untuk role atau yang lainnya jika diperlukan tambahkan kode ini<br>
     public static ?string $tenantOwnershipRelationshipName = 'team';<br>
    protected static  ?string $tenantRelationshipName = 'role';<br>
</li>
<li>
tambahkan ini pada Spatie\Permission\Models\Role<br>
    public function team(): BelongsTo<br>
    {<br>
        return $this->belongsTo(\App\Models\Team::class);<br>
    }<br>
</li>
<li>
Tambahkan ini di .env untuk upload file<br>
<pre>FILESYSTEM_DRIVER=local</pre>
</li>
<li>
    Setting faker ke bahasa indonesia<br>
    Setting di env<br>
    <pre>FAKER_LOCALE=id_ID</pre>
    Setting di config/app.php<br>
    <pre>'faker_locale' => env('FAKER_LOCALE', 'en_US'),</pre>
</li>
<li>
    https://www.rosehosting.com/blog/how-to-install-aapanel-on-debian-11/<br>
</li>

<li>
<h1>Install Vps</h1>
<p>Prerequisites
A server with Debian 11 as OS
User privileges: root or non-root user with sudo privileges
Step 1. Update the System
Update the system packages to the latest versions available. Execute the following command:

<pre>sudo apt-get update -y && sudo apt-get upgrade -y</pre>

Step 2. Download aaPanel script
To download and set the aaPanel script executable, use the following commands:

<p>
<pre>wget -O install.sh http://www.aapanel.com/script/install-ubuntu_6.0_en.sh</pre>

<pre>sudo chmod +x install.sh</pre>

Step 3. Install aaPanel<br>
To install the aaPanel execute the following command:<br>

<pre>sudo bash install.sh</pre>

You will be asked if you want to install the aaPanel into the /www directory on your server:<br>

+----------------------------------------------------------------------<br>
| aaPanel 6.x FOR CentOS/Ubuntu/Debian<br>
+----------------------------------------------------------------------<br>
| Copyright © 2015-2099 BT-SOFT(http://www.aapanel.com) All rights reserved.<br>
+----------------------------------------------------------------------<br>
| The WebPanel URL will be http://SERVER_IP:7800 when installed.<br>
+----------------------------------------------------------------------<br>

<p>Do you want to install aaPanel to the /www directory now?(y/n): Y
Once you confirm, the installation will start and it will take up to 3 minutes. You will see the following output after successful installation:</p>

# Congratulations! Installed successfully!<br>

aaPanel Internet Address: https://YourServerIP:7800/64b21d3e<br>
aaPanel Internal Address: https://YourServerIP:7800/64b21d3e<br>
username: zjs6ojyz<br>
password: 7cf519ed<br>
Warning:<br>
If you cannot access the panel,<br>
release the following port (7800|888|80|443|20|21) in the security group<br>
==================================================================<br>
Time consumed: 2 Minute!<br>

</li>
<li>
htacess untuk vps agar tidak perlu mengakses folder public http://ip-vps/public menjadi http://ip-vps<br>
Buat File htacess di root proyek dan tuliskan kode di bawah ini<br>
<pre>
<IfModule mod_rewrite.c><br>
RewriteEngine On<br>
RewriteRule ^(.*)$ public/$1 [L]<br>
 </IfModule> <br>
 </pre>
</li>  
<li>
<h1>Install Composer di VPS</h1>

<pre>sudo -u www composer install</pre>

</li>
<li>
<h1>Install Ekstensi PHP</h1>
<p>
    ke menu App Store-> PHP yang terinstall -> Install Extensions
</p>
</li>
<li>
<h1>Terminal </h1>
<p>
    ke menu File -> terminal
</p>
</li>
<li>
<h1>Ekstensi Vs Code ? Cursor Untuk Remote Server</h1>
<p>SFTP/FTP sync</p>
</li>
<li>
<h2>Remote File dari cursor/vscode dengan ekstensi SFTP dari Natizyskunk dan sftp FS dari Kelvin</h2>
<p>Buat masing Masing config di volder .vscode/sftp.json dan ssh.json</p>
<pre>
 "name": "Nama Proyek",
    "host": "ip/192.168.1.123",
    "protocol": "ssh", //jika ftp ganti jadi ftp jika vps ganti jadi sftp
    "port": 22,
    "secure": true,
    "username": "usernamevps",
    "password": "Password vps",
    "remotePath": "folder yang diremote",
    "uploadOnSave": true
</pre>
<p>Aktifkan pengaturan write pada folder target di vps dengan atau sudo chmod 777
</li>
<li>
<h2>Konek Database</h2>
<p>Install Ekstensi "Database Client" dari cweijan lalu aktifkan icon database pada sidebar dan buat koneksi baru</p>
</li>
<li>
<h3>Link pgsql</h3>
https://www.enterprisedb.com/download-postgresql-binaries
</li>
<li>
<h3>Jika bukan super_admin hide role menu</h3>
<p>
lokasi file di vendor/bezhansalleh/filament-shield/src/Resources/RoleResource.php Baris 161
</p>
<pre>
public static function shouldRegisterNavigation(): bool
    {
        // return Utils::isResourceNavigationRegistered();
        //hide menu jika bukan super admin
        return auth()->user()->hasAnyRole(['admin', 'super_admin']);
    }
    </pre>
    <p>Hide Tenant Menu, Lokasi File di app/Providers/Filament/AdminPanelProvider.php</p>
<pre>
->tenantMenu(function () {
                return auth()->user()->hasRole('super_admin'); // Check for super_admin role
            })
    </pre>
</li>
<li>
buat faktur pakai escpos-php
</li>
</ol>
