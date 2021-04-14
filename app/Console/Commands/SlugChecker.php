<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SlugChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:slug {--table=} {--column=slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize duplicates and make it unique';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $error = false;

        if(!$this->option('table')) {
            $error = true;
            $this->error('table option required');
        }

        if(!$this->option('column')) {
            $error = true;
            $this->error('column option required');
        }

        if($error)
            return;
        $table=$this->option('table');
        $column=$this->option('column');
        $rows=DB::table($table)
            ->select('id','slug',DB::raw('COUNT('.$column.') as count'))
            ->get();
            print_r($rows);

            foreach ($rows as $row) {
                 print_r("Before: ".$row->$column);
               if($row->count>1){
                 print_r("Before: ".$row->$column);
                   DB::update('update '.$table.' set '.$column.' = '.slugify($column).' where '.$column.' = ?', [$row->$column]);
                    print_r("After: ".$row->$column);
               }
            }


        $this->info('Successfully syncronized and changed to unique');
    }
}
