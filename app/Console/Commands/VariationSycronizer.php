<?php

namespace App\Console\Commands;

use App\Product;
use App\Variation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VariationSycronizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncronize:variation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translations';

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

        $items=Product::where('variation_id', '<>', null)->get();
        foreach($items as $product){
            if ($variation = Variation::findOrFail($product->variation_id)) {
                $products = Product::where('variation_id', $variation->id);
                if(count($products->get())>0){
                    $min_price=$products->min("price");
                    $lowest_price_list=$products->where('price', $min_price)->pluck('id');
                    $lowest_price_id=$lowest_price_list[rand(0, count($lowest_price_list)-1)];
                    $variation->lowest_price_id=$lowest_price_id;
                    $variation->qty=$products->sum('qty');
                    $variation->num_of_sale=$products->sum('num_of_sale');
                    $variation->prices=$products->pluck('price');
                    $variation->rating=(double)$products->sum('rating')/$products->count();
                    $variation->save();
                }
            }
        }

        // foreach($items as $variation_id=>$products){
        //     print_r($variation_id);
        //     // break;
        //     if($variation=Variation::findOrFail($variation_id)){
        //         // print_r($variation);
        //         $min_price=$products->min("price");
        //         $variation->lowest_price_id=json_encode($products->where('price', $min_price)->pluck('id'));
        //         $variation->qty=$products->sum('qty');
        //         $variation->num_of_sale=$products->sum('num_of_sale');
        //         $variation->prices=$products->pluck('price');
        //         $variation->rating=(double)$products->sum('rating')/$products->count();
        //         $variation->save();
        //         // print_r($variation);
        //     }
        // }

        // $items=Product::where('variation_id', '<>', null)->get()->groupBy('variation_id');


        // foreach($items as $variation_id=>$products){
        //     print_r($variation_id);
        //     // break;
        //     if($variation=Variation::findOrFail($variation_id)){
        //         // print_r($variation);
        //         $min_price=$products->min("price");
        //         $variation->lowest_price_id=json_encode($products->where('price', $min_price)->pluck('id'));
        //         $variation->qty=$products->sum('qty');
        //         $variation->num_of_sale=$products->sum('num_of_sale');
        //         $variation->prices=$products->pluck('price');
        //         $variation->rating=(double)$products->sum('rating')/$products->count();
        //         $variation->save();
        //         // print_r($variation);
        //     }
        // }

        $this->info('Successfully generated translations');
    }
}
