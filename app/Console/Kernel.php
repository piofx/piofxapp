<?php

namespace App\Console;
use Request;
use App\Models\Core\Contact;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ContactInfo::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        //flecting the records of all contacts
        $contacts = Contact::all()->groupBy('client_id');
        foreach($contacts as $k=>$v){
            $data = json_decode(Storage::disk('s3')->get('settings/contact/'.$k.'.json' ));
            $data = json_decode($data);
            if ($data->digest == 'daily')
            {   
                $contacts = Contact::whereDate('created_at', Carbon::today())->get()->where('client_id',$k);
                $counter = count($contacts);
                $schedule->command('ContactInfo',[$counter])->daily();
            }
            else if ($data->digest == 'weekly')
            {
                $contacts = Contact::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->where('client_id',$k);
                $counter = count($contacts);
                $schedule->command('ContactInfo',[$counter])->weekly();   
            }
            else
            {
                $contacts = Contact::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->where('client_id',$k);
                $counter = count($contacts);
                $schedule->command('ContactInfo',[$counter])->monthly();   
            }
        }

            
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

 

