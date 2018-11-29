
# Laravel Simple Todo API

This is  token based authentication api built with laravel 5.7

## Features
- verifying users email and phone number using nexmo api
- queued notification for email and sms 
- policy for todos and tasks
- filtering tasks and todos
- route throttling
- api resource for each models
- Token based authentication system

## Getting Started



### Installing


 1-  install dependencies using **composer update**
2-   make .env file set NEXMO credentials if you want sms verification
3- **php artisan serve**
4- php artisan migrate
End with an example of getting some data out of the system or using it for a little demo

### API Routes
```
params=
Route::middleware(['auth:api', 'verified'])->get('/user', function (Request $request) {  
  return $request->user();  
});  
  
//register  
Route::post('Auth/register', 'api\Auth\RegisterController@register')->name('register');  
  
  
  
Route::middleware(['auth:api', 'verified'])->group(function () {  
  
  //sms verification  
  Route::get('sms/verify/{code}', 'api\Auth\SMSVerificationController@verify')->middleware('throttle:6,1')->name('sms.verification.verify');  
  Route::get('sms/resend', 'api\Auth\SMSVerificationController@resend')->middleware('throttle:32,1')->name('sms.verification.resend');  
  
  
  //todoes  
  Route::apiResource('todos', 'api\TodoController');  
  
  //task  
  Route::apiResource('tasks', 'api\TaskController')->except(['store']);  
  Route::post('/todos/{todo}/tasks', 'api\TaskController@store')->middleware(['auth:api', 'verified'])->name('tasks.store');  
  
  
});  
  
  
//admin  
Route::get('/users', 'api\AdminController@index')->name('users.index')->middleware(['auth:admin']);  
Route::post('/users/{user}', 'api\AdminController@verify')->name('users.verify')->middleware(['auth:admin']);
```

## Author

* **Erfan Ghoreishi** 



## License

This project is licensed under the MIT License 

