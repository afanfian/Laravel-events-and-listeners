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
2. Memasukkan login history kedalam App\Providers\EventServiceProvider
3. Megenerate event dan listener dengan menggunakan langkah alternatif
Membuat Event dengan menggunakan syntax: php artisan make:event LoginHistory
Membuat Listener dengan menggunakan syntax: php artisan make:listener StoreUserLoginHistory --event=LoginHistory
4. Mendefinisikan class event di Events -> LoginHistory.php
5. Mendefinisikan class listener di Listeners -> StoreUserLoginHistory
6. Menginstall starter kit yaitu Laravel Breeze
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
