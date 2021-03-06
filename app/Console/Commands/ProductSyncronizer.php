<?php

namespace App\Console\Commands;

use App\Product;
use App\Variation;
use Exception;
use Illuminate\Console\Command;

class ProductSyncronizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncronize:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize product elements';

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
        // $products=Product::all();
        /*
        foreach($products as $product){
            $this->info($product);
             if($variation=Variation::where('id',$product->variation_id)->first()){
                 $product->element_id=$variation->element_id;
                 $product->save();
                 try{
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
                }catch(Exception $e){
                    // dd($e->getMessage());
                }
             }
        }
        */
        //Slug syncronization
        // foreach($products as $product){
        //     $this->info($product->name);
        //      if($variation=Variation::where('id',$product->variation_id)->first()){
        //          $product->name=$variation->name;
        //          $product->slug=$variation->slug;
        //          $product->save();
        //      }
        // }

        // $this->info('Successfully changed');

        //Clean Products
        $products=Product::where('added_by', 'admin')->withTrashed()->get();
        foreach($products as $product){
            $product->reviews()->delete();
            $product->wishlists()->delete();
            $product->product_translations()->delete();
            $product->forceDelete();
        }

        $this->info('Successfully cleaned');
    }
}
