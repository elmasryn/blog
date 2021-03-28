<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '/', 'middleware' => 'Maintenance'], function () {

    Auth::routes();

    Route::get('', 'HomeController@index')->name('home');

    //ContactUs
    Route::get('contactUs', 'contactUsController@create')->name('contactUs.create');
    Route::post('contactUs/store', 'contactUsController@store')->name('contactUs.store');

    //Profile
    Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');
    Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('profile/{id}', 'ProfileController@update')->name('profile.update');
    Route::put('profile/password/{id}', 'ProfileController@password')->name('profile.password');

    //Get Category
    Route::get('categories', 'GetCategoryController@index')->name('category.index');

    //Get Post & Comment
    Route::post('posts/publishPost', 'GetPostController@publishPost')->name('publishPost');
    Route::resource('posts', 'GetPostController');
    Route::post('posts/{post_id}/storeComment', 'GetPostController@storeComment')->name('storeComment');
    Route::post('posts/publishComment', 'GetPostController@publishComment')->name('publishComment');
    Route::put('posts/editComment/{id}', 'GetPostController@editComment')->name('editComment');
    Route::delete('posts/destroyComment/{id}', 'GetPostController@destroyComment')->name('destroyComment');

    //Get Page
    Route::get('page/{page}', 'GetPageController@show')->name('page.show');
    Route::post('page/upload', 'GetPageController@upload')->name('page.upload');
});





/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => adminview(), 'as' => adminview()], function () {
    // login
    Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'AdminAuth\LoginController@login');

    Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

    Route::group(['middleware' => 'role:Admin,User'], function () {

        Route::post('/', 'AdminAuth\LoginController@logout')->name('logout');
        Route::get('/', 'AdminController@index')->name('admin');

        //Reset password
        Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.update');

        //confirm Password
        Route::get('password/confirm', 'AdminAuth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'AdminAuth\ConfirmPasswordController@confirm');

        //Settings
        Route::get('settings', 'SettingsController@show')->name('settings');
        Route::post('settings', 'SettingsController@update')->name('settings.update');

        //Message Titles
        Route::resource('message_titles', 'Message_titleController')->except(['create', 'edit']);

        //Messages
        Route::get('messages/unread', 'MessageController@unreadMessages')->name('messages.unread');
        Route::get('messages/read', 'MessageController@readMessages')->name('messages.read');
        Route::get('messages/trash', 'MessageController@trashMessages')->name('messages.trash');
        Route::put('messages/multirestore', 'MessageController@multiRestore')->name('messages.multirestore');
        Route::put('messages/restore/{id}', 'MessageController@restore')->name('messages.restore');
        Route::put('messages/mark/{id}', 'MessageController@mark')->name('messages.mark');
        Route::put('messages/title/{id}', 'MessageController@title')->name('messages.title');
        Route::put('messages/multiMark', 'MessageController@multiMark')->name('messages.multiMark');
        Route::delete('messages/multidestroy', 'MessageController@multidestroy')->name('messages.multidestroy');
        Route::delete('messages/forcedestroy', 'MessageController@multiForcedestroy')->name('messages.forcedestroy');
        Route::put('messages/pagination/{id}', 'MessageController@pagination')->name('messages.pagination');
        Route::resource('messages', 'MessageController')->only(['index', 'show', 'destroy']);

        //Category
        Route::delete('categories/multidestroy', 'CategoryController@multidestroy')->name('categories.multidestroy');
        Route::resource('categories', 'CategoryController')->except('show');

        //Page
        Route::delete('pages/multidestroy', 'PageController@multidestroy')->name('pages.multidestroy');
        Route::resource('pages', 'PageController')->except('show');

        //User
        Route::delete('users/multidestroy', 'UserController@multidestroy')->name('users.multidestroy');
        Route::resource('users', 'UserController')->except('show');

        //Post
        Route::delete('posts/multidestroy', 'PostController@multidestroy')->name('posts.multidestroy');
        Route::get('posts', 'PostController@index')->name('posts.index');
        Route::delete('posts/{post}', 'PostController@destroy')->name('posts.destroy');

        //Tag
        Route::delete('tags/multidestroy', 'TagController@multidestroy')->name('tags.multidestroy');
        Route::resource('tags', 'TagController')->except('show');

        //Comment
        Route::delete('comments/multidestroy', 'CommentController@multidestroy')->name('comments.multidestroy');
        Route::get('comments', 'CommentController@index')->name('comments.index');
        Route::delete('comments/{comment}', 'CommentController@destroy')->name('comments.destroy');

        //Website_content
        Route::delete('website_contents/multidestroy', 'Website_contentController@multidestroy')->name('website_contents.multidestroy');
        Route::resource('website_contents', 'Website_contentController')->except('show');
    });
});




/*
|--------------------------------------------------------------------------
| general
|--------------------------------------------------------------------------
*/

//Maintenance for front end
Route::get('maintenance', function () {
    if (setting()->website_status == '1') {
        return redirect('');
    }
    return view('maintenance');
});

//Locale
Route::get('/{locale}', 'Locale@locale')->name('locale');
