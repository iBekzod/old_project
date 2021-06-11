<?php

namespace App\Console\Commands;

use App\Services\NormalDependency;
use App\Services\SingleTonDependency;
use App\Services\ViaInterfaceDependency;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run test command';


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
        $this->app->bind(NormalDependency::class,function($app){
            return new NormalDependency();
        });
        $this->info('Normal binding');
        $this->app->singleton(SingleTonDependency::class,function($app){
           return new SingleTonDependency();
        });
        $this->info('Singleton');
        $this->app->bind(ExampleContract::class,function($app){
           return new ViaInterfaceDependency();
        });
        $this->info('Binding through interface');
        $this->info('Successfully run');
    }

    // public function filterPublishedProduct($products){
    //     return $products->where('qty', '>', 0)->where('is_accepted', 1)->where('published', 1);
    // }
}
