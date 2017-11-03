## **Licensee - Roles and Permissions**
Licensee allows you to manage user permissions and roles in a database without specificing or maintaining roles staticaly.
licensee is an package made for Laravel 5.5
 - It will detech role and permissions slug from routes
 - Developer can also add custom permission in config

**Installation:**
 - Just fire below command to root of your Laravel app with composer.
````php
composer require rakshitbharat/licensee
````
- Alias to config/app.php
````php
'aliases' => [
'PermissionFunction' => Modules\PermissionBuilder\ViewPermission\PermissionFunction::class,
],
````
 - Below parameters to your routes
```` php
Route::get('home', [
       'as' => 'home',
       'uses' => 'HomeController@index',
       'permission_area_name_prefix_inroute' => 'adminHome_',
       'permission_area_name_inroute' => 'create|read|update|delete',    ]);
````
- Set to add middle-ware check code
````php
PermissionFunction::checkDeclaredPermissionURL();
````
- Check permission in view
````php
if (PermissionFunction::checkDeclaredPermissionView
('userView_update')) {
Echo 'access granted';
}else{
Echo 'access denied';
}
````
