<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BridgeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return core()->readableDate(\Carbon\Carbon::now());
// });
// 

Route::get('/login',[AuthController::class, 'index'])->name('auth.login');
Route::post('/validate/login',[AuthController::class, 'login'])->name('auth.login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('auth.logout.post');
Route::get('/complete/profile',[AuthController::class, 'verifyAndCompleteRegistration'])->name('auth.profile.complete');
Route::post('/complete/profile',[AuthController::class, 'makeProfileComplete'])->name('auth.make.profile.complete');

Route::get('bridge/{slug}',[BridgeController::class, 'make'])->name('bridge.make');




// SUPER ADMIN ROUTES START HERE //
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth.basic', 'role:super-admin']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\Admin\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\Admin\Role\RoleController::class)->group(function () {
			Route::get('/roles', 'index')->name('roles');
		});
		Route::controller(\App\Http\Controllers\Admin\Website\WebsiteController::class)->group(function () {
			Route::get('/websites', 'index')->name('websites');
			Route::get('/websites/create', 'create')->name('websites.create');
			Route::post('/websites/store', 'store')->name('websites.store');
			Route::get('/websites/edit/{id}', 'edit')->name('websites.edit');
			Route::post('/websites/update/{id}', 'update')->name('websites.update');
			Route::post('/websites/delete/{id}', 'destroy')->name('websites.delete');
			Route::post('/websites/status/update', 'updateStatus')->name('websites.status.update');
			Route::post('/websites/bulk-delete', 'bulkDelete')->name('websites.bulk.delete');
		});
		Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
			Route::get('/users', 'index')->name('users');
			Route::get('/users/create', 'create')->name('users.create');
			Route::post('/users/store', 'store')->name('users.store');
			Route::post('/users/store/client', 'storeClientFromLead')->name('client.store');
			Route::get('/users/edit/{id}', 'edit')->name('users.edit');
			Route::post('/users/update/{id}', 'update')->name('users.update');
			Route::post('/users/delete/{id}', 'destroy')->name('users.delete');
			Route::post('/users/status/update', 'updateStatus')->name('users.status.update');
			Route::post('/users/bulk-delete', 'bulkDelete')->name('users.bulk.delete');
		});
		Route::controller(\App\Http\Controllers\Admin\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\Admin\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\Admin\Lead\LeadController::class)->group(function () {
				Route::get('/leads', 'index')->name('leads');
				Route::get('/leads/create', 'create')->name('leads.create');
				Route::post('/leads/store', 'store')->name('leads.store');
				Route::get('/leads/show/{id}', 'show')->name('leads.show');
				Route::get('/leads/edit/{id}', 'edit')->name('leads.edit');
				Route::post('/leads/update/{id}', 'update')->name('leads.update');
				Route::post('/leads/delete/{id}', 'destroy')->name('leads.delete');
				Route::post('/leads/bulk-delete', 'bulkDelete')->name('leads.bulk.delete');
				Route::post('/leads/update/expected-amount/{id}', 'updateExpectedAmount')->name('leads.update.expected.amount');
				Route::post('/leads/upload/media/{id}', 'uploadMedia')->name('leads.upload.media');

			});

			Route::controller(\App\Http\Controllers\Admin\Lead\PaymentController::class)->group(function () {
				Route::post('/leads/payments/store/', 'store')->name('leads.payments.store');
				Route::post('/leads/payments/update/{id}', 'update')->name('leads.payments.update');
				
			});

			Route::controller(\App\Http\Controllers\Admin\LeadDiscussion\LeadDiscussionController::class)->group(function () {
				Route::get('/discussions', 'index')->name('leads.discussions');
				Route::post('/discussions/store', 'store')->name('leads.discussions.store');
			});

			Route::controller(\App\Http\Controllers\Admin\Team\TeamController::class)->group(function () {
				Route::get('/teams', 'index')->name('teams');
				Route::get('/teams/create', 'create')->name('teams.create');
				Route::post('/teams/store', 'store')->name('teams.store');
				Route::get('/teams/show/{id}', 'show')->name('teams.show');
				Route::get('/teams/edit/{id}', 'edit')->name('teams.edit');
				Route::post('/teams/update/{id}', 'update')->name('teams.update');
				Route::post('/teams/delete/{id}', 'destroy')->name('teams.delete');
				Route::post('/teams/status/update', 'updateStatus')->name('teams.status.update');
				Route::post('/teams/bulk-delete', 'bulkDelete')->name('teams.bulk.delete');
				Route::post('/teams/add-members/{id}', 'addMembers')->name('teams.add.members');
			});

			Route::controller(\App\Http\Controllers\Admin\TaskStage\TaskStageController::class)->group(function () {
				Route::post('/tasks/stages/store', 'store')->name('tasks.stages.store');
			});

			Route::controller(\App\Http\Controllers\Admin\Task\TaskController::class)->group(function () {
				Route::post('/tasks/store', 'store')->name('tasks.store');
				Route::get('/tasks/show/{id}/{team_id}', 'show')->name('tasks.show');
				Route::post('/tasks/update/{id}', 'update')->name('tasks.update');
				Route::post('/tasks/update-status/{id}', 'updateStatus')->name('tasks.update.status');
				Route::post('/tasks/add-members/{id}', 'addMembers')->name('tasks.add.members');
				Route::post('/tasks/upload/media/{id}', 'uploadMedia')->name('tasks.upload.media');
				Route::post('/tasks/update/summary/{id}', 'updateSummary')->name('tasks.update.summary');
				Route::post('/tasks/update/dates/{id}', 'updateDates')->name('tasks.update.dates');
			});

			Route::controller(\App\Http\Controllers\Admin\TaskDiscussion\TaskDiscussionController::class)->group(function () {
				Route::get('/tasks/discussions', 'index')->name('tasks.discussions');
				Route::post('/tasks/discussions/store', 'store')->name('tasks.discussions.store');
			});

		});
	});
});

// PARTNER ROUTES START HERE //
Route::group(['prefix' => 'partner', 'as' => 'partner.', 'middleware' => ['auth.basic', 'role:partner']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\Partner\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\Partner\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
		Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
			Route::post('/users/store/client', 'storeClientFromLead')->name('client.store');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\Partner\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\Partner\Lead\LeadController::class)->group(function () {
				Route::get('/leads', 'index')->name('leads');
				Route::get('/leads/create', 'create')->name('leads.create');
				Route::post('/leads/store', 'store')->name('leads.store');
				Route::get('/leads/show/{id}', 'show')->name('leads.show');
				Route::get('/leads/edit/{id}', 'edit')->name('leads.edit');
				Route::post('/leads/update/{id}', 'update')->name('leads.update');
				Route::post('/leads/delete/{id}', 'destroy')->name('leads.delete');
				Route::post('/leads/bulk-delete', 'bulkDelete')->name('leads.bulk.delete');
				Route::post('/leads/update/expected-amount/{id}', 'updateExpectedAmount')->name('leads.update.expected.amount');
				Route::post('/leads/upload/media/{id}', 'uploadMedia')->name('leads.upload.media');

			});

			Route::controller(\App\Http\Controllers\Partner\Lead\PaymentController::class)->group(function () {
				Route::post('/leads/payments/store/', 'store')->name('leads.payments.store');
				Route::post('/leads/payments/update/{id}', 'update')->name('leads.payments.update');
			});

			Route::controller(\App\Http\Controllers\Partner\LeadDiscussion\LeadDiscussionController::class)->group(function () {
				Route::get('/discussions', 'index')->name('leads.discussions');
				Route::post('/discussions/store', 'store')->name('leads.discussions.store');
			});

			Route::controller(\App\Http\Controllers\Partner\Team\TeamController::class)->group(function () {
				Route::get('/teams', 'index')->name('teams');
				Route::get('/teams/create', 'create')->name('teams.create');
				Route::post('/teams/store', 'store')->name('teams.store');
				Route::get('/teams/show/{id}', 'show')->name('teams.show');
				Route::get('/teams/edit/{id}', 'edit')->name('teams.edit');
				Route::post('/teams/update/{id}', 'update')->name('teams.update');
				Route::post('/teams/delete/{id}', 'destroy')->name('teams.delete');
				Route::post('/teams/status/update', 'updateStatus')->name('teams.status.update');
				Route::post('/teams/bulk-delete', 'bulkDelete')->name('teams.bulk.delete');
				Route::post('/teams/add-members/{id}', 'addMembers')->name('teams.add.members');
			});

			Route::controller(\App\Http\Controllers\Partner\TaskStage\TaskStageController::class)->group(function () {
				Route::post('/tasks/stages/store', 'store')->name('tasks.stages.store');
			});

			Route::controller(\App\Http\Controllers\Partner\Task\TaskController::class)->group(function () {
				Route::post('/tasks/store', 'store')->name('tasks.store');
				Route::get('/tasks/show/{id}/{team_id}', 'show')->name('tasks.show');
				Route::post('/tasks/update/{id}', 'update')->name('tasks.update');
				Route::post('/tasks/update-status/{id}', 'updateStatus')->name('tasks.update.status');
				Route::post('/tasks/add-members/{id}', 'addMembers')->name('tasks.add.members');
				Route::post('/tasks/upload/media/{id}', 'uploadMedia')->name('tasks.upload.media');
				Route::post('/tasks/update/summary/{id}', 'updateSummary')->name('tasks.update.summary');
				Route::post('/tasks/update/dates/{id}', 'updateDates')->name('tasks.update.dates');
			});

			Route::controller(\App\Http\Controllers\Partner\TaskDiscussion\TaskDiscussionController::class)->group(function () {
				Route::get('/tasks/discussions', 'index')->name('tasks.discussions');
				Route::post('/tasks/discussions/store', 'store')->name('tasks.discussions.store');
			});

		});
	});
});

// SALES HEAD ROUTES START HERE //
Route::group(['prefix' => 'saleshead', 'as' => 'saleshead.', 'middleware' => ['auth.basic', 'role:sales-head']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\SaleHead\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\SaleHead\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
		Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
			Route::post('/users/store/client', 'storeClientFromLead')->name('client.store');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\SaleHead\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\SaleHead\Lead\LeadController::class)->group(function () {
				Route::get('/leads', 'index')->name('leads');
				Route::get('/leads/create', 'create')->name('leads.create');
				Route::post('/leads/store', 'store')->name('leads.store');
				Route::get('/leads/show/{id}', 'show')->name('leads.show');
				Route::get('/leads/edit/{id}', 'edit')->name('leads.edit');
				Route::post('/leads/update/{id}', 'update')->name('leads.update');
				Route::post('/leads/delete/{id}', 'destroy')->name('leads.delete');
				Route::post('/leads/bulk-delete', 'bulkDelete')->name('leads.bulk.delete');
				Route::post('/leads/update/expected-amount/{id}', 'updateExpectedAmount')->name('leads.update.expected.amount');
				Route::post('/leads/upload/media/{id}', 'uploadMedia')->name('leads.upload.media');
				Route::post('/leads/convert/task/{id}', 'convertLeadToTask')->name('leads.convert.task');

			});

			Route::controller(\App\Http\Controllers\SaleHead\Lead\PaymentController::class)->group(function () {
				Route::post('/leads/payments/store/', 'store')->name('leads.payments.store');
				Route::post('/leads/payments/update/{id}', 'update')->name('leads.payments.update');
				Route::post('/leads/payments/refund/partial', 'refundPartialPayment')->name('leads.payments.refund.partial');
			});

			Route::controller(\App\Http\Controllers\SaleHead\LeadDiscussion\LeadDiscussionController::class)->group(function () {
				Route::get('/discussions', 'index')->name('leads.discussions');
				Route::post('/discussions/store', 'store')->name('leads.discussions.store');
			});
		});
	});
});

// SALES INDIVIDUAL ROUTES START HERE //
Route::group(['prefix' => 'sales', 'as' => 'sales.', 'middleware' => ['auth.basic', 'role:sales']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\Sale\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\Sale\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
		Route::controller(\App\Http\Controllers\Admin\User\UserController::class)->group(function () {
			Route::post('/users/store/client', 'storeClientFromLead')->name('client.store');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\Sale\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\Sale\Lead\LeadController::class)->group(function () {
				Route::get('/leads', 'index')->name('leads');
				Route::get('/leads/create', 'create')->name('leads.create');
				Route::post('/leads/store', 'store')->name('leads.store');
				Route::get('/leads/show/{id}', 'show')->name('leads.show');
				Route::get('/leads/edit/{id}', 'edit')->name('leads.edit');
				Route::post('/leads/update/{id}', 'update')->name('leads.update');
				Route::post('/leads/delete/{id}', 'destroy')->name('leads.delete');
				Route::post('/leads/bulk-delete', 'bulkDelete')->name('leads.bulk.delete');
				Route::post('/leads/update/expected-amount/{id}', 'updateExpectedAmount')->name('leads.update.expected.amount');
				Route::post('/leads/upload/media/{id}', 'uploadMedia')->name('leads.upload.media');
				Route::post('/leads/convert/task/{id}', 'convertLeadToTask')->name('leads.convert.task');
			});

			Route::controller(\App\Http\Controllers\Sale\Lead\PaymentController::class)->group(function () {
				Route::post('/leads/payments/store/', 'store')->name('leads.payments.store');
				Route::post('/leads/payments/update/{id}', 'update')->name('leads.payments.update');
				Route::post('/leads/payments/refund/partial', 'refundPartialPayment')->name('leads.payments.refund.partial');
			});

			Route::controller(\App\Http\Controllers\Sale\LeadDiscussion\LeadDiscussionController::class)->group(function () {
				Route::get('/discussions', 'index')->name('leads.discussions');
				Route::post('/discussions/store', 'store')->name('leads.discussions.store');
			});
		});
	});
});

// PRODUCTION HEAD ROUTES START HERE //
Route::group(['prefix' => 'prodhead', 'as' => 'prodhead.', 'middleware' => ['auth.basic', 'role:production-head']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\ProdHead\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\ProdHead\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\ProdHead\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\ProdHead\Team\TeamController::class)->group(function () {
				Route::get('/teams', 'index')->name('teams');
				Route::get('/teams/create', 'create')->name('teams.create');
				Route::post('/teams/store', 'store')->name('teams.store');
				Route::get('/teams/show/{id}', 'show')->name('teams.show');
				Route::get('/teams/edit/{id}', 'edit')->name('teams.edit');
				Route::post('/teams/update/{id}', 'update')->name('teams.update');
				Route::post('/teams/delete/{id}', 'destroy')->name('teams.delete');
				Route::post('/teams/status/update', 'updateStatus')->name('teams.status.update');
				Route::post('/teams/bulk-delete', 'bulkDelete')->name('teams.bulk.delete');
				Route::post('/teams/add-members/{id}', 'addMembers')->name('teams.add.members');
			});

			Route::controller(\App\Http\Controllers\ProdHead\TaskStage\TaskStageController::class)->group(function () {
				Route::post('/tasks/stages/store', 'store')->name('tasks.stages.store');
			});

			Route::controller(\App\Http\Controllers\ProdHead\Task\TaskController::class)->group(function () {
				Route::post('/tasks/store', 'store')->name('tasks.store');
				Route::get('/tasks/show/{id}/{team_id}', 'show')->name('tasks.show');
				Route::post('/tasks/update/{id}', 'update')->name('tasks.update');
				Route::post('/tasks/update-status/{id}', 'updateStatus')->name('tasks.update.status');
				Route::post('/tasks/add-members/{id}', 'addMembers')->name('tasks.add.members');
				Route::get('/tasks/remove-member/{task_id}/{id}', 'removeMember')->name('tasks.remove.member');
				Route::post('/tasks/upload/media/{id}', 'uploadMedia')->name('tasks.upload.media');
				Route::post('/tasks/update/summary/{id}', 'updateSummary')->name('tasks.update.summary');
				Route::post('/tasks/update/dates/{id}', 'updateDates')->name('tasks.update.dates');
				Route::post('/subtasks/store', 'storeSubtask')->name('subtasks.store');
				Route::post('/subtasks/update/{id}', 'updateSubtask')->name('subtasks.update');
				Route::post('/subtasks/update/status/{id}', 'updateSubtaskStatus')->name('subtasks.status.update');
			});

			Route::controller(\App\Http\Controllers\ProdHead\TaskDiscussion\TaskDiscussionController::class)->group(function () {
				Route::get('/tasks/discussions', 'index')->name('tasks.discussions');
				Route::post('/tasks/discussions/store', 'store')->name('tasks.discussions.store');
			});

		});
	});
});


// PRODUCTION INDIVIDUAL ROUTES START HERE //
Route::group(['prefix' => 'prod', 'as' => 'prod.', 'middleware' => ['auth.basic', 'role:production']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\Prod\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		Route::controller(\App\Http\Controllers\Prod\Profile\ProfileController::class)->group(function () {
			Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
			Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
			Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		});
	});

	//Single Website Routes
	Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
		Route::group(['prefix' => '{slug}'], function() {
			Route::controller(\App\Http\Controllers\Prod\Dashboard\DashboardController::class)->group(function () {
				Route::get('/', 'singleDashboard')->name('single.dashboard');
			});

			Route::controller(\App\Http\Controllers\Prod\Team\TeamController::class)->group(function () {
				Route::get('/teams', 'index')->name('teams');
				// Route::get('/teams/create', 'create')->name('teams.create');
				// Route::post('/teams/store', 'store')->name('teams.store');
				Route::get('/teams/show/{id}', 'show')->name('teams.show');
				// Route::get('/teams/edit/{id}', 'edit')->name('teams.edit');
				// Route::post('/teams/update/{id}', 'update')->name('teams.update');
				// Route::post('/teams/delete/{id}', 'destroy')->name('teams.delete');
				// Route::post('/teams/status/update', 'updateStatus')->name('teams.status.update');
				// Route::post('/teams/bulk-delete', 'bulkDelete')->name('teams.bulk.delete');
				// Route::post('/teams/add-members/{id}', 'addMembers')->name('teams.add.members');
			});

			// Route::controller(\App\Http\Controllers\Prod\TaskStage\TaskStageController::class)->group(function () {
			// 	Route::post('/tasks/stages/store', 'store')->name('tasks.stages.store');
			// });

			Route::controller(\App\Http\Controllers\Prod\Task\TaskController::class)->group(function () {
				// Route::post('/tasks/store', 'store')->name('tasks.store');
				Route::get('/tasks/', 'index')->name('tasks');
				Route::get('/tasks/show/{id}/{team_id}', 'show')->name('tasks.show');
				// Route::post('/tasks/update/{id}', 'update')->name('tasks.update');
				Route::post('/tasks/update-status/{id}', 'updateStatus')->name('tasks.update.status');
				// Route::post('/tasks/add-members/{id}', 'addMembers')->name('tasks.add.members');
				Route::post('/tasks/upload/media/{id}', 'uploadMedia')->name('tasks.upload.media');
				Route::post('/tasks/update/summary/{id}', 'updateSummary')->name('tasks.update.summary');
				Route::post('/subtasks/store', 'storeSubtask')->name('subtasks.store');
				Route::post('/subtasks/update/{id}', 'updateSubtask')->name('subtasks.update');
				Route::post('/subtasks/update/status/{id}', 'updateSubtaskStatus')->name('subtasks.status.update');
				// Route::post('/tasks/update/dates/{id}', 'updateDates')->name('tasks.update.dates');
			});

			// Route::controller(\App\Http\Controllers\Prod\TaskDiscussion\TaskDiscussionController::class)->group(function () {
			// 	Route::get('/tasks/discussions', 'index')->name('tasks.discussions');
			// 	Route::post('/tasks/discussions/store', 'store')->name('tasks.discussions.store');
			// });

		});
	});
});

// CLIENT ROUTES START HERE //
Route::group(['prefix' => 'client', 'as' => 'client.', 'middleware' => ['auth.basic', 'role:client']],function(){
	Route::group(['prefix' => 'main'], function () {
		Route::controller(\App\Http\Controllers\Client\Dashboard\DashboardController::class)->group(function () {
			Route::get('/', 'index')->name('dashboard');
			// Route::get('/analytics/', 'singleWebAnalytics')->name('dashboard.analytics');
			
		});
		// Route::controller(\App\Http\Controllers\Prod\Profile\ProfileController::class)->group(function () {
		// 	Route::get('/profile/edit/{id}', 'edit')->name('profile.edit');
		// 	Route::post('/profile/update/image/{id}', 'updateProfileImage')->name('profile.update.image');
		// 	Route::post('/profile/update/password/{id}', 'updatePassword')->name('profile.update.password');
		// });
	});

	//Single Website Routes
	// Route::group(['prefix' => 'single', 'middleware' => ['auth.basic', 'handle.currentweb']], function () {
	// 	Route::group(['prefix' => '{slug}'], function() {
	// 		Route::controller(\App\Http\Controllers\Prod\Dashboard\DashboardController::class)->group(function () {
	// 			Route::get('/', 'singleDashboard')->name('single.dashboard');
	// 		});

	// 		Route::controller(\App\Http\Controllers\Prod\Team\TeamController::class)->group(function () {
	// 			Route::get('/teams', 'index')->name('teams');
	// 			// Route::get('/teams/create', 'create')->name('teams.create');
	// 			// Route::post('/teams/store', 'store')->name('teams.store');
	// 			Route::get('/teams/show/{id}', 'show')->name('teams.show');
	// 			// Route::get('/teams/edit/{id}', 'edit')->name('teams.edit');
	// 			// Route::post('/teams/update/{id}', 'update')->name('teams.update');
	// 			// Route::post('/teams/delete/{id}', 'destroy')->name('teams.delete');
	// 			// Route::post('/teams/status/update', 'updateStatus')->name('teams.status.update');
	// 			// Route::post('/teams/bulk-delete', 'bulkDelete')->name('teams.bulk.delete');
	// 			// Route::post('/teams/add-members/{id}', 'addMembers')->name('teams.add.members');
	// 		});

	// 		// Route::controller(\App\Http\Controllers\Prod\TaskStage\TaskStageController::class)->group(function () {
	// 		// 	Route::post('/tasks/stages/store', 'store')->name('tasks.stages.store');
	// 		// });

	// 		Route::controller(\App\Http\Controllers\Prod\Task\TaskController::class)->group(function () {
	// 			// Route::post('/tasks/store', 'store')->name('tasks.store');
	// 			Route::get('/tasks/', 'index')->name('tasks');
	// 			Route::get('/tasks/show/{id}/{team_id}', 'show')->name('tasks.show');
	// 			// Route::post('/tasks/update/{id}', 'update')->name('tasks.update');
	// 			Route::post('/tasks/update-status/{id}', 'updateStatus')->name('tasks.update.status');
	// 			// Route::post('/tasks/add-members/{id}', 'addMembers')->name('tasks.add.members');
	// 			Route::post('/tasks/upload/media/{id}', 'uploadMedia')->name('tasks.upload.media');
	// 			Route::post('/tasks/update/summary/{id}', 'updateSummary')->name('tasks.update.summary');
	// 			Route::post('/subtasks/store', 'storeSubtask')->name('subtasks.store');
	// 			Route::post('/subtasks/update/{id}', 'updateSubtask')->name('subtasks.update');
	// 			Route::post('/subtasks/update/status/{id}', 'updateSubtaskStatus')->name('subtasks.status.update');
	// 			// Route::post('/tasks/update/dates/{id}', 'updateDates')->name('tasks.update.dates');
	// 		});

	// 		// Route::controller(\App\Http\Controllers\Prod\TaskDiscussion\TaskDiscussionController::class)->group(function () {
	// 		// 	Route::get('/tasks/discussions', 'index')->name('tasks.discussions');
	// 		// 	Route::post('/tasks/discussions/store', 'store')->name('tasks.discussions.store');
	// 		// });

	// 	});
	// });
});


