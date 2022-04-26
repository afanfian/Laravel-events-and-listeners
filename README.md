# Laravel Events and Listener
## Anggota Kelompok:
1. Fian Awamiry Maulana 5025201035
2. Putu Ravindra Wiguna 5025201237
## Fungsi dari Laravel Events
## Fungsi dari Laravel Listener
## Cara Pemakaian Laravel Events dan Listener
1. Membuat project laravel baru 
```php
    composer create-project laravel/laravel example-app
```  
* Pada pembuatan project baru laravel diberi nama ```Laravel-event-and-listener```  
2. Menambahkan ```Events``` dan ```Listeners``` baru
```php
    LoginHistory::class => [
                StoreUserLoginHistory::class,
            ]
```   
* Menambahkan syntax diatas di dalam ```App\Providers\EventServiceProvider``` dan pada ```class EventServiceProvider```.  
3. Megenerate ```Events``` dan ```Listeners``` dengan menggunakan langkah alternatif
Membuat Events dengan menggunakan syntax:  
```php
    php artisan make:event LoginHistory
```
Membuat Listeners dengan menggunakan syntax: 
```php
    php artisan make:listener StoreUserLoginHistory --event=LoginHistory
```  
Megenerate Events dan Listeners dengan menggunakan syntax:
```php
    php artisan event:generate
```
* Dengan menambahkan syntax tersebut, maka akan membuat sebuah folder baru dan file baru pada ```App```.  
* Yang pertama, yaitu membuat folder ```Events``` yang didalamnya berisi file ```LoginHistory.php```.  
* Yang kedua, yaitu membuat folder ```Listeners``` yang didalamnya berisi file ```StoreUserLoginHistory.php```.  
* Selain membuat folder dan file baru, perintah selanjutnya yaitu megenerate ```Events``` dan ```Listeners```.
4. Meregistrasi ```Events``` dan ```Listener``` secara manual
```php
    use App\Events\LoginHistory;
    use App\Listeners\StoreUserLoginHistory;
    use Illuminate\Support\Facades\Event;

    public function boot()
        {
            Event::listen(
                LoginHistory::class,
                [StoreUserLoginHistory::class, 'handle']
            );

            Event::listen(function (LoginHistory $event) {
                $current_timestamp = Carbon::now()->toDateTimeString();

                $userinfo = $event->user;

                $saveHistory = DB::table('login_history')->insert(
                    [
                        'name' => $userinfo->name,
                        'email' => $userinfo->email,
                        'created_at' => $current_timestamp,
                        'updated_at' => $current_timestamp
                    ]
                );
                return $saveHistory;
            });
        }
```  
* Langkah pertama, masukkan terlebih dahulu inisialisasi dari folder ```Events``` dan ```Listeners``` didalam path ```App\Providers\EventServiceProvider```, yaitu dengan memasukkan:
```php
    use App\Events\LoginHistory;
    use App\Listeners\StoreUserLoginHistory;
```  
* Langkah kedua, yaitu memasukkan class didalam fungsi ```boot``` atau ```public function boot()``` dengan syntax dibawah ini:
```php
    Event::listen(
        LoginHistory::class,
        [StoreUserLoginHistory::class, 'handle']
    );

    Event::listen(function (LoginHistory $event) {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $userinfo = $event->user;

        $saveHistory = DB::table('login_history')->insert(
            [
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp
            ]
        );
        return $saveHistory;
    });
```  
5. Mendefinisikan class event di Events pada path ```App\Events\LoginHistory.php```
```php
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;


    public function __construct($user)
    {
        $this->user = $user;
    }
```  
* Kita perlu memasukkan syntax baru dari file ```LoginHistory.php``` yang awal atau default, yaitu dengan:
    *  Membuat dan menginisialisasikan ```user``` sebagai ```public``` seperti ```public $user;```
    *  Menambahkan syntax ```$user``` pada parameter ```public function __construct()```
    *  Menambahkan syntax ```$this->user = $user;``` didalam fungsi ```public function __construct(){}```
6. Mendefinisikan class listener di Listeners -> StoreUserLoginHistory
7. Menginstall starter kit yaitu Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
7. Dispatching Event di Requests -> Auth -> LoginRequest.php
8. Membuat Queued Listener di Listeners -> StoreUserLoginHistory
9. Menyesuaikan Queue di Listeners -> StoreUserLoginHistory
10. Conditional Queue Listener di Listeners -> StoreUserLoginHistory
11. Mengatasi Job yang Gagal di Listeners -> StoreUserLoginHistory
12. Membuat Event Subscriber dengan syntax  
    php artisan make:listener UserEventSubscriber
13. Register Event Subscriber di Listeners -> EventServiceProvider
