# Nubix Toast Notification for Laravel Application with Breeze and Vue

### Requirements

- PHP 8.0 and up
- Laravel 8 and up

### Installation

Step 1. Install dev package with Composer

```shell
composer require --dev itsnubix/toast
php artisan nubix-toast:install

```

Step 2. Add follow lines to `resources/js/app.js` file.

- Add follow import to the top of the file

```js
import toastPlugin from '@/Plugins/toast'
```

- Add following line after `.use(plugin)`

```js
.use(toastPlugin)
```

Step 3. Add follow to `HandleInertiaRequests.php`

```php
'toast' => fn () => $request->session()->get(config('toast.session_id')) ?? []
```

Final `share` function should look like this.

````php
/**
 * Define the props that are shared by default.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return array
 */
public function share(Request $request)
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => $request->user(),
        ],
        'toast' => fn () => $request->session()->get(config('toast.session_id')) ?? []
    ]);
}

```

Step 4. Finish up installation

```shell
npm install && npm run dev
````
