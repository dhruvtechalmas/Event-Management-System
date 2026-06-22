<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecycleBinController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
   $events = Event::where('status', 'Upcoming')->latest()->get();
    return view('welcome', compact('events'));
});

Route::post('/event-register', [ParticipantController::class, 'eventRegister'])->name('participants.eventRegister');


Route::get('/pusher', function () {
    return view('pusher');
});
// Route::get('/event-dashboard', function () {
//     return view('backend.index');
// })->middleware(['auth', 'verified'])->name('backend.index');


Route::get('/settings', function () {
    return view('backend.settings');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    //Events Routes
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    //Participants Routes
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::get('/participants/{participant}', [ParticipantController::class, 'show'])->name('participants.show');
    Route::get('/participants/{participant}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
    Route::put('/participants/{participant}', [ParticipantController::class, 'update'])->name('participants.update');
    Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');


    //Tasks Routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/assigntask/{task}', [TaskController::class, 'assigntask'])->name('tasks.assigntask');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/view-details/{id}', [TaskController::class, 'viewDetails'])->name('tasks.viewDetails');


    //Permissions Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //Roles Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    //Event Calendar routes
    Route::get('/calendar', [EventController::class, 'calendarindex'])->name('calendar.calendarindex');
    Route::get('/api/events', [EventController::class, 'getEvents'])->name('calendar.events');

    //Notification routes
    Route::get('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::get('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/history', [NotificationController::class, 'history'])->name('notifications.history');

    //Pdf routes
    Route::get('/events/pdf/all', [ReportController::class, 'downloadAllEventsSummary'])->name('events.pdf.all');
    Route::get('/events/{id}/pdf', [ReportController::class, 'downloadEventSummary'])->name('events.pdf.single');
    Route::get('/tasks/pdf/all', [ReportController::class, 'downloadAllTasksReport'])->name('tasks.pdf.all');
    Route::get('/tasks/{id}/pdf', [ReportController::class, 'downloadSingleTaskReport'])->name('tasks.pdf.single');

    Route::get('/event-dashboard', [DashboardController::class, 'index'])->name('backend.index');

    //google calendar integration
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


    Route::get('/recycle-bin', [RecycleBinController::class, 'index'])->name('recycle-bin.index');
    Route::patch('/recycle-bin/events/{id}/restore', [RecycleBinController::class, 'restoreEvent'])->name('recycle.events.restore');
    Route::delete('/recycle-bin/events/{id}/force-delete', [RecycleBinController::class, 'forceDeleteEvent'])->name('recycle.events.force-delete');
    Route::patch('/recycle-bin/tasks/{id}/restore', [RecycleBinController::class, 'restoreTask'])->name('recycle.tasks.restore');
    Route::delete('/recycle-bin/tasks/{id}/force-delete', [RecycleBinController::class, 'forceDeleteTask'])->name('recycle.tasks.force-delete');
    Route::patch('/recycle-bin/participants/{id}/restore', [RecycleBinController::class, 'restoreParticipant'])->name('recycle.participants.restore');
    Route::delete('/recycle-bin/participants/{id}/force-delete', [RecycleBinController::class, 'forceDeleteParticipant'])->name('recycle.participants.force-delete');


});

require __DIR__ . '/auth.php';
