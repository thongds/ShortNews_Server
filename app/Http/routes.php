<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('users/user',['user'=>'Thong is the boss']);
});
//Route::get('/user/{id}','UserController@showProfile');
//Route::get('/insert/{email}','UserController@insertUser');




/* auth controller group */

Route::group(['namespace' => 'Auth'],function (){
    Route::get('auth/login','AuthController@login')->name('login');
    Route::post('auth/login','AuthController@login')->name('login');
    Route::get('auth/register','AuthController@register')->name('register');
    Route::post('auth/register','AuthController@register')->name('register');
    Route::post('auth/validate','AuthController@validateRegister')->name('validate');
    Route::get('auth/logout','AuthController@logout')->name('logout');
});
/* create data group */
Route::group(['namespace' => 'Admin\CreateData'],function (){
    Route::get('admin/song-index','SongDetailController@index')->name('get_song');
    Route::post('admin/song-index','SongDetailController@index')->name('post_song');
});
/* api router*/
Route::group(['namespace' => 'Api\v1'],function (){
    Route::get('api/v1/home-page-host-song','HomePageController@hostSong')->name('get_api_home_page');
    Route::get('api/v1/home-page-new-song','HomePageController@mainPageByCategory')->name('get_api_home_page_new_song');
    Route::get('api/v1/home-page-menu','HomePageController@menuSong')->name('get_api_home_page_menu');
    Route::get('api/v1/home-page-event','HomePageController@getEvent')->name('get_api_home_page_event');
    //for testing
    Route::get('api/v1/timeout','HomePageController@timeOut')->name('get_api_time_out');
    Route::get('api/v1/response-not-json','HomePageController@ResponseNotJson')->name('get_api_response_not_json');

});
/* Setting controller group */
Route::group(['namespace' => 'Admin\Setting'],function (){
    //setting SubtitleType
    Route::get('admin/subtitletype','SubtitleTypeController@index')->name('get_subtitle_type');
    Route::post('admin/subtitletype','SubtitleTypeController@index')->name('post_subtitle_type');
    //setting language
    Route::get('admin/language','LanguageController@index')->name('get_language');
    Route::post('admin/language','LanguageController@index')->name('post_language');
    //setting category
    Route::get('admin/category','CategoryController@index')->name('get_category');
    Route::post('admin/category','CategoryController@index')->name('post_category');
    //setting ProviderPayment
    Route::get('admin/provider-payment','ProviderPaymentController@index')->name('get_provider_payment');
    Route::post('admin/provider-payment','ProviderPaymentController@index')->name('post_provider_payment');
    //setting role
    Route::get('admin/role','RoleController@index')->name('get_role');
    Route::post('admin/role','RoleController@index')->name('post_role');
    //setting song type
    Route::get('admin/song-type','SongTypeController@index')->name('get_song_type');
    Route::post('admin/song-type','SongTypeController@index')->name('post_song_type');
    //setting subscribe type
    Route::get('admin/subscribe-type','SubscribeTypeController@index')->name('get_subscribe_type');
    Route::post('admin/subscribe-type','SubscribeTypeController@index')->name('post_subscribe_type');
    //setting singer
    Route::get('admin/singer','SingerController@index')->name('get_singer');
    Route::post('admin/singer','SingerController@index')->name('post_singer');
    //setting default image
    Route::get('admin/default-image','DefaultImageController@index')->name('get_default_image');
    Route::post('admin/default-image','DefaultImageController@index')->name('post_default_image');
    //setting default image
    Route::get('admin/event','EventController@index')->name('get_event');
    Route::post('admin/event','EventController@index')->name('post_event');
    //setting newspaper
    Route::get('admin/newspaper','NewspaperController@index')->name('get_newspaper');
    Route::post('admin/newspaper','NewspaperController@index')->name('post_newspaper');
    //setting session day
    Route::get('admin/session_day','SessionDayController@index')->name('get_session_day');
    Route::post('admin/session_day','SessionDayController@index')->name('post_session_day');
    //setting news
    Route::get('admin/news','NewsController@index')->name('get_news');
    Route::post('admin/news','NewsController@index')->name('post_news');
    //setting social info
    Route::get('admin/social-info','SocialInfoController@index')->name('get_social_info');
    Route::post('admin/social-info','SocialInfoController@index')->name('post_social_info');
    //setting fanpage info
    Route::get('admin/fanpage','FanPageController@index')->name('get_fanpage');
    Route::post('admin/fanpage','FanPageController@index')->name('post_fanpage');
    //setting social content type
    Route::get('admin/social-content-type','SocialContentTypeController@index')->name('get_social_content_type');
    Route::post('admin/social-content-type','SocialContentTypeController@index')->name('post_social_content_type');
    //setting social media
    Route::get('admin/social-media','SocialMediaController@index')->name('get_social_media');
    Route::post('admin/social-media','SocialMediaController@index')->name('post_social_media');


});

Route::get('api/news/getnews','Api\v1\NewsController@getNews');

Route::get('api/getsocial/{page}','Api\v1\SocialController@getSocial')->where('page','[0-9]+');









Route::auth();

Route::get('/home', 'HomeController@index');
