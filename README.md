# Laravel Events and Listener
## Anggota Kelompok:
| No    | Nama          | NRP  |
| ------------- |:-------------:| -----:|
| 1      | Fian Awamiry Maulana | 5025201035 |
| 2      | Putu Ravindra Wiguna      |   5025201237 |
## Fungsi dari Laravel Events<br>

Event Laravel merupakan suatu cara yang bagus untuk memisahkan berbagai aspek dalam applikasi kita. Dimana event dalam laravel ini memberikan implementasi _Oberserver Pattern_ sederhana yang memungkinkan kita untuk mensubscribe ke berbagai event yang terjadi dalam aplikasi kita.<br>

Suatu event dapat memiliki banyak listener yang tidak bergantung satu sama lainnya. Misalnya dalam suatu aplikasi, kita ingin mengirimkan notifikasi Slack kepada user tiap kali sebuah pemesanan telah dikirim. Daripada menyatukan kode untuk mengirim notifikasi dan memproses pemesanan, kita dapat memunculkan event ```App\Events\OrderShipped``` yang mana akan diterima listener dan digunakan untuk memunculkan notifikasi Slack.<br>

Kelas dari event ini biasanya disimpan dalam directory ```app/Events```. Secara default biasanya directory ini belum ada, tetapi jangan khawatir karena kita dapat membuatnya secara otomatis saat kita menggunakan command console Artisan seperti ```php artisan make:event {NamaEvent}``` untuk membuat event.<br>

Setelah membuat event pada laravel, kita perlu mendaftarkannya pada ```App\Providers\EventServiceProvider```. Terdapat beberapa cara untuk mendaftarkan event, salah satu cara tersebut adalah dengan menambahkannya ke array ```$listen``` pada ```EventsServiceProvider```. Properti ```listen``` ini berisikan array yang menyimpan semua event (key) dan listener (value) dalam aplikasi kita. Kita tinggal menambahkan event dan listener yang kita buat pada array tersebut.<br>
Berikut adalah contoh menambahkan ```OrderShipped``` event pada ```App\Providers\EventServiceProvider```:<br>
```php
use App\Events\OrderShipped;
use App\Listeners\SendShipmentNotification;
 
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    OrderShipped::class => [
        SendShipmentNotification::class,
    ],
];
```

## Fungsi dari Laravel Listener
Sama seperti event, listener dalam laravel ini merupakan bagian dari _Observer Pattern_ yang dapat mensubscribe suatu event dan melakukan sesuatu berdasarkan event tersebut. Biasanya kelas listener disimpan dalam directory ```app/Listeners```. Untuk membuat listener pada laravel kita dapat menggunakan command console Artisan seperti ```php artisan make:listener {NamaListener} --event={NamaEvent}```. Sama seperti event, kita perlu mendaftarkannya ke ```App\Providers\EventServiceProvider```<br>

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
* Menambahkan syntax diatas di dalam ```app\Providers\EventServiceProvider``` dan pada ```class EventServiceProvider```.
* Properti ```$listen``` merupakan array yang berisi bergbagai event (sebagai key) dan ```$listen``` yang dimilikinya (sebagai value).  
3. Megenerate ```Events``` dan ```Listeners``` dengan menggunakan langkah alternatif
Membuat Events dengan menggunakan syntax:  
```php
php artisan make:event LoginHistory
```
Hasil:<br>
<img src="https://user-images.githubusercontent.com/77233945/166098629-ac8c4d0c-dc0b-4c61-8183-b8853e6961cc.png" alt="Hasil Make Event" width="1080">
Terdapat directory baru yakni ```app/Events``` dan file ```LoginHistory.php```<br><hr>
Membuat Listeners dengan menggunakan syntax: 
```php
php artisan make:listener StoreUserLoginHistory --event=LoginHistory
```
Hasil:<br>
<img alt="HasilMakeListener" src="https://user-images.githubusercontent.com/77233945/166098844-e66ce40c-a8f4-45ce-80dc-897ffbf30c00.png" width="1080">
Terdapat directory baru yakni ```app/Listeners``` dan file ```StoreUserLoginHistory.php```<br><hr>
Megenerate Events dengan menggunakan syntax:
```php
php artisan event:generate
```
* Dengan menambahkan syntax tersebut, maka akan membuat sebuah folder baru dan file baru pada ```App```.  
* Yang pertama, yaitu membuat folder ```Events``` yang didalamnya berisi file ```LoginHistory.php```.  
* Yang kedua, yaitu membuat folder ```Listeners``` yang didalamnya berisi file ```StoreUserLoginHistory.php```.  
* Selain membuat folder dan file baru, perintah selanjutnya yaitu megenerate ```Events```.
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
* Langkah pertama, masukkan terlebih dahulu inisialisasi dari folder ```Events``` dan ```Listeners``` didalam path ```app\Providers\EventServiceProvider```, yaitu dengan memasukkan:
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
5. Mendefinisikan ```class event``` pada path ```app\Events\LoginHistory.php```
```php
use Dispatchable, InteractsWithSockets, SerializesModels;

public $user;


public function __construct($user)
{
    $this->user = $user;
}
```  
* Kita perlu memasukkan syntax baru dari file ```LoginHistory.php``` yang awal atau default, yaitu dengan:
    *  Membuat dan menginisialisasikan ```user``` sebagai ```public``` seperti ```public $user;```.
    *  Menambahkan syntax ```$user``` pada parameter ```public function __construct()```.
    *  Menambahkan syntax ```$this->user = $user;``` didalam fungsi ```public function __construct(){}```.
* Class ```Events``` merupakan sebuah container data yang menyimpan informasi yang berhubungan dengan event tersebut. Bisa dicontohkan dalam file ```LoginHistory.php```.
6. Mendefinisikan ```class listener``` pada path ```app\Listeners\StoreUserLoginHistory```
```php
public function handle(LoginHistory $event)
{
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
}
```  
* Di dalam method ```handle``` ini kita melakukan aksi yang dibutuhkan ketika ```events``` terjadi Contohnya kita akan mendefinisikan aksi apa yang akan dilakukan ketika ```events``` ```LoginHistory```.
* Pertama, disini kita perlu menambahkan, syntax ```LoginHistory $event``` didalam parameter fungsi ```public function handle()```.
* Selanjutnya, kita menambahkan syntax berikut pada fungsi ```public function handle(){}```:  
```php
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
```
7. Menginstall starter kit yaitu Laravel Breeze
```php 
composer require laravel/breeze --dev
```
```php 
php artisan breeze:install
```
```php 
npm install && npm run dev
```
* Sebelum melakukan ```Dispatching Event``` kita harus menginstall ```Laravel Breeze``` seperti pada materi sebelumnya yaitu: materi ```Authentication```, terlebih dahulu untuk mendapatkan ```Authentication``` pada file ```LoginRequest.php``` pada ```app\Http\Requests\Auth```.
8. Melakukan dispatching Event pada path ```app\Http\Requests\Auth\LoginRequests.php```
```php
public function authenticate()
{
    $user = Auth::user();
    LoginHistory::dispatch($user);

    $this->ensureIsNotRateLimited();

    if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}
```
* Selanjutnya kita menambahkan syntax berikut ini pada fungsi ```public function authenticate(){}```, sehingga menjadi code seperti diatas:
```php
$user = Auth::user();
LoginHistory::dispatch($user);
```
*  Pada contoh diatas kita ingin memanggil ```events``` ketika ada seorang user yang melakukan login. 
*  Maka dari itu kita akan memanggil event pada ```app/Http/Requests/Auth/LoginRequest.php``` di dalam method ```authenticate()```. 
9. Membuat Queued Listener pada path ```App\Listeners\StoreUserLoginHistory.php```
```php
class StoreUserLoginHistory implements ShouldQueue
{
    //
}
```
* Memanggil ```ShouldQueue``` yaitu dengan ```use Illuminate\Contracts\Queue\ShouldQueue;```
* Menambahkan ```implements ShouldQueue``` pada class ```StoreUserLoginHistory``` yang sebelumnya default kosong atau belum di implements.
10. Menyesuaikan Queue pada path ```App\Listeners\StoreUserLoginHistory```
```php 
class StoreUserLoginHistory implements ShouldQueue
{
    public $connection = 'sqs';
    public $queue = 'listeners';
    public $delay = 10;
}
```
```php
public function viaQueue()
{
    return 'listeners';
}
```
* Dengan begitu maka ketika ```events``` yang dihandle oleh ``listeners``` ini terpanggil maka listener akan secara otomatis di queue menggunakan Laravel's queue system.
* Menambahkan syntax berikut ini pada class ```StoreUserLoginHistory```:
```php
public $connection = 'sqs';
public $queue = 'listeners';
public $delay = 10;

public function viaQueue()
{
    return 'listeners';
}
```
* Fungsi ```viaQueue``` yaitu berfungsi jika ingin mendifinisikan nama queue listener saat runtime.
* Apabila ingin mengubah koneksi queue, nama queue, atau waktu delay queue dari sebuah listener, kita dapat melakukannya dengan mendefinisikan properti ```$connection```, ```$queue```, atau ```$delay``` pada ```class listener```.
11. Conditional Queue Listener pada path ```App\Listeners\StoreUserLoginHistory```:
```php
public function shouldQueue(LoginHistory $event)
{
    return true;
}  
```
* Fungsi ```shouldQueue``` yang berisi parameter ```LoginHistory $event``` berfungsi untuk me-  ueue listener berdasarkan suatu kondisi/data, selain itu dapat menentukan apakah listener akan di queue atau tidak didalamnya. Jika mereturn false maka listener tidak akan dieksekusi. 
12. Mengatasi Job yang Gagal pada path ```App\Listeners\StoreUserLoginHistory```
```php
class StoreUserLoginHistory implements ShouldQueue
{
    public $tries = 2;

    public function failed(OrderShipped $event, $exception)
    {
        // logic yang ingin dijalankan ketika gagal
    }
}

public function retryUntil()
{
    return now()->addSeconds(5);
}
```
* Dengan menginisialisasikan ```public $tries = 2;``` pada ```class StoreUserLoginHistory```.
* Batas maksimum percobaan dapat diatur dengan mendefinisikan properti ```$tries```.
* Selain itu, menambahkan fungsi ```failed``` yang berisikan parameter ```OrderShipped $event, $exception```
* Fungsi ```retryUntil``` berfungsi, untuk mendefinisikan batas percobaan, dengan menggunakan waktu sebagai batasannya. Batas waktu ini akan bekerja dengan mengizinkan listener melakukan percobaan berulang-kali hingga batas waktu tertentu.
* Seperti contoh, pada fungsi ```retryUntil()``` diberi batas waktu sebesar ```5 detik```.
13. Membuat ```Event Subscriber``` pada ```App\Listeners``` dengan syntax: 
```php
php artisan make:listener UserEventSubscriber
```
* Setelah membuat ```Event Subscriber```, kita mendefinisikan method ```subscribe``` yang akan di pass ke dalam event dispatcher instance. Seperti Syntax berikut ini pada class ```UserEventSubscriber```:
```php
class UserEventSubscriber
{
    
    public function storeUserLogin($event) {
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
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            LoginHistory::class,
            [UserEventSubscriber::class, 'storeUserLogin']
        );
    }
}
```
* Dari contoh dapat terlihat kita membuat method ```storeUserLogin```. Method ini merupakan ```handle``` yang akan dijalankan ketika event ```LoginHistory``` terpanggil. Di bagian ```subscribe``` kita menghubungkan event LoginHistory dengan method ```storeUserLogin``` tadi.
14. Register Event Subscriber pada path ```App\Listeners\EventServiceProvider```
```php 
use App\Listeners\UserEventSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        UserEventSubscriber::class,
    ];
}
```
* Pada class ```EventServiceProvider``` kita melakukan register subsciber, dengan mendefinisikan properti ```$subscribe```.
## Referensi 
1. Materi Laravel Events dan Listeners
* https://github.com/dptsi/laravel-tutorial/blob/master/Laravel-authentication-and-authorization/authentication.md
2. Materi Laravel Authentication
* https://github.com/dptsi/laravel-tutorial/blob/master/Laravel-event-and-listener/event.md 
3. Dokumentasi Official Laravel
* https://laravel.com/docs/9.x/events
