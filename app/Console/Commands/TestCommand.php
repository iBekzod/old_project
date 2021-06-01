<?php

namespace App\Console\Commands;

use App\Product;
use App\Variation;
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
    protected $description = 'Run query';

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
        $products=Product::all();
        foreach($products as $product){
            $this->info($product);
             if($variation=Variation::where('id',$product->variation_id)->first()){
                 $product->element_id=$variation->element_id;
                 $product->save();
             }
        }
        $this->info('Successfully run');
    }
}
