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
            $client_id = $v[0]['client_id'];
            $agency_id = $v[0]['agency_id'];
            $data = json_decode(Storage::disk('s3')->get('settings/contact/'.$k.'.json' ));
            if($data->primary_email && $data->secondary_email)
            {
                $email1 = $data->primary_email;
                $email2 = $data->secondary_email;
            }
            elseif($data->primary_email)
            {
                $email1 = $data->primary_email;
                $email2 = '';
            }
            elseif($data->secondary_email)
            {
                $email = $data->secondary_email;
                $email = '';
            }
            
            if($email1)
            {   
                if ($data->digest == 'daily')
                {   
                    $contacts = Contact::whereDate('created_at', Carbon::today())->get()->where('client_id',$k);
                    $counter = count($contacts);  
                    $schedule->command('ContactInfo',[$counter,$email1,$email2,$client_id,$agency_id])->everyMinute();
                }
                else if ($data->digest == 'weekly')
                {
                    $contacts = Contact::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->where('client_id',$k);
                    $counter = count($contacts);
                    $schedule->command('ContactInfo',[$counter,$email1,$email2,$client_id,$agency_id])->weekly();   
                }
                else
                {
                    $contacts = Contact::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get()->where('client_id',$k);
                    $counter = count($contacts);
                    $schedule->command('ContactInfo',[$counter,$email1,$email2,$client_id,$agency_id])->monthly();   
                }

                
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

 

