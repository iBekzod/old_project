<?php

namespace App\Console\Commands;

use App\Product;
use App\Variation;
use Exception;
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
        // $products=Product::where('variation_id', '<>', null);
        // $products=$this->filterPublishedProduct($products)->get();
        // $products=$products->groupBy('variation_id');
        // $products_arr=[];
        // $products=$products->each(function($variation, $variation_key) {
        //     $random_product_id=$variation->random()->id;
        //     return $variation->filter(function($product) use ($random_product_id) {
        //         return $product->id==$random_product_id;

        //     })->values();
        // });
        // dd($products);
        // return response()->json([
        //     'products' => $products
        // ]);
        // print_r($products);
        $this->info('Successfully run');
    }

    // public function filterPublishedProduct($products){
    //     return $products->where('qty', '>', 0)->where('is_accepted', 1)->where('published', 1);
    // }
}
