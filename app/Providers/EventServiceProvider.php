<?php

namespace App\Providers;

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
	    'App\Events\ApprovalWasSubmitted' => [
		    'App\Listeners\ChangeRequestStatus',
	    ],
	    'App\Events\UserWasCreated' => [
		    'App\Listeners\SetDefaultUserGroup',
	    ],
	    'App\Events\RequestWasSubmitted' => [
		    'App\Listeners\SendThankYouEmail',
	    ],
        'App\Events\CommentWasSubmitted' => [
            'App\Listeners\SendUpdateEmail',
        ],
        'App\Events\FinalStatusSubmitted' => [
            'App\Listeners\SendFinalEmail',
        ],
        'App\Events\ActionItemSubmitted' => [
            'App\Listeners\SendNewActionItemEmail',
        ],
        'App\Events\ActionItemClosed' => [
            'App\Listeners\SendClosedActionItemEmail',
        ],
	    'App\Events\ActionItemApproved' => [
		    'App\Listeners\SendEmailToToolInstallLayoutOrg',
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

        //
    }
}
