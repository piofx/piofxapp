<?php

namespace App\Console;
use Illuminate\Http\Request;
use App\Models\Core\Contact;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ContactUpdate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        //$client_id = Request::get('client.id');
        //if(Storage::disk('s3')->exists('settings/contact/1/json' ))
        //{   
            //ddd('here');
           // $data = json_decode(Storage::disk('s3')->get('settings/contact/1/json' ));
            //$columns = [];
            //$columns = array_unique(array_merge($columns, array_values(json_decode($data, true))));
            //if (in_array("rightaway", $columns))
            //{   
                //$contacts = Contact::all();
                //$schedule->command('ContactUpdate')->everyMinute();
            //}
        //}
       // $contacts = array(Contact::all());
       // $schedule->command('ContactUpdate',$contacts)->everyMinute();
        //$schedule->command('ContactUpdate')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
