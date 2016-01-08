<?php

namespace App\Providers;

use App\Model\Course;
use App\Model\Department;
use App\Model\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Pivot::saving(function ($pivot) {
            if ($pivot->getTable() == 'course_user') {
                $course = Course::findOrFail($pivot->course_id);
                $user = User::findOrFail($pivot->user_id);
                $department = Department::findOrFail($course->department_id);
                if (!$user->departments->contains($department->id)) {
                    $user->departments()->attach($department);
                }
            }
        });
    }
}
