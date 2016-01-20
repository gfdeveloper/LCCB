<?php

use App\User;

Route::get('/demo', 'LCCBController@dummy');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('test', function(){
//	return User::with(['organization' => function($query){
//		$query->where('name', 'Tool Install - Layout');
//	}])->select('email')->get();

	return User::toolInstallLayoutEmails()->get();
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', function () {
		//if (Auth::User()->hasRole(['administrator', 'approver'])) {
			return view('dashboard');
//		} else {
//			return redirect()->action('LCCBController@create');
//		}
	});

	Route::post('/lccb/update/{id}', 'LCCBController@update');
	Route::get('/lccb/status/{status_slug}', 'ApprovalController@show');

	Route::post('/lccb/approve/{id}', 'ApprovalController@approve');
	Route::post('/lccb/reject/{id}', 'ApprovalController@reject');
	Route::post('/lccb/revoke/{id}', 'ApprovalController@revoke');
	Route::post('/lccb/attach/{id}', 'LCCBController@attach');
	Route::post('/lccb/status/{id}/{status}', 'ApprovalController@setStatus');

	Route::resource('/lccb', 'LCCBController');
	Route::resource('/comment', 'CommentsController');
	Route::get('/my/requests', 'UserController@myRequests');
	Route::get('/download/{id}', 'DownloadController@download');
	Route::get('/download/{id}/direct', 'DownloadController@save');
	Route::get('/download/{id}/delete', 'DownloadController@delete');

	Route::get('/admin/users', 'AdminController@users');

	Route::get('/api/user-data', 'ApiController@users');
	Route::get('/api/getUploads/{id}', 'ApiController@uploads');
	Route::get('/api/getComments/{id}', 'ApiController@comments');
	Route::put('/api/org/update/{id}', 'ApiController@updateOrganization');
	Route::post('/api/org/save', 'ApiController@saveOrg');
	Route::get('/api/org', 'ApiController@showOrg');
	Route::get('/api/org/{userid}/{orgid}', 'ApiController@updateOrg');
	Route::get('/api/role/{userid}/{roleid}', 'ApiController@updateRole');
	Route::get('/equipment/search/{q}', 'ApiController@equipmentSearch');
	Route::get('/api/locations', 'ApiController@showLocations');
	Route::get('/api/areas', 'ApiController@showAreas');
	Route::get('/api/categories', 'ApiController@showCategories');
	Route::get('/api/get/openActions', 'ApiController@getOpenActions');

	Route::get('/reports/organization/{start}/{end}', 'ReportsController@organization');
	Route::get('/reports/approvals/{start}/{end}', 'ReportsController@approvals');
	Route::get('/reports/average/{start}/{end}', 'ReportsController@averageToApprove');

	Route::get('/reports/minutes', 'Reports\MeetingMinutes@run');
	Route::get('/reports/minutes/get/{start}/{end}', 'Reports\MeetingMinutes@build');
	Route::get('/reports/approvals/get/{start}/{end}', 'Reports\MeetingMinutes@buildApprove');
	Route::get('/reports/actions/get/{start}/{end}', 'Reports\MeetingMinutes@buildActions');

	Route::get('/search', 'SearchController@index');
	Route::post('/search/find', 'SearchController@getRequests');

	Route::post('/action', 'CommentsController@addActionItem');
	Route::get('/action/close/{id}', 'CommentsController@closeActionItem');


	Route::get('/admin/vendors', 'VendorController@index');

	Route::get('/chris123', 'SneakController@updateStatues');
});



Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);