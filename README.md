# Nubix Toast Notification for Laravel Application with Breeze and Vue

### Requirements
* PHP 8.0 and up
* Laravel 8 and up

### Installation
Step 1. 
 
```shell
composer require --dev itsnubix/toast
php artisan nubix-toast:install

```

Step 2.
Add follow lines to `resources/js/app.js` file.

Add follow import to the top of the file
```
import toastPlugin from '@/Plugins/toast'
```


Add `.use(toastPlugin)` after `.use(plugin)`


Finish up installation 
```shell
npm install && npm run dev
```
