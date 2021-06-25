<?php

namespace App\Console\Commands;

use App\Color;
use App\Product;
use App\Variation;
use App\Attribute;
use App\Characteristic;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
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
        //Set variation lowest price id and synchronize all variations
        /*
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
        */

        //Change variation name by element and characteristics
        /*
        $variations=Variation::withTrashed()->get();
        foreach($variations as $variation){
            try{
                $color=Color::where('id', $variation->color_id)->first();
                $attributes=Characteristic::whereIn('id', explode(",", $variation->characteristics))->pluck('name');
                $variation_name=$variation->element->name;
                // dd( $attributes);
                foreach($attributes as $attribute){
                    $variation_name=$variation_name.', '.$attribute;
                }
                if($color->name){
                    $variation_name=$variation_name.', '.$color->name;
                }
                var_dump($variation_name);
                $variation->name=$variation_name;
                $variation->slug = SlugService::createSlug(Variation::class, 'slug', ($variation_name));
                $variation->save();
            }catch(Exception $e){
                $this->info($e->getMessage());
            }
        }
        */

        //Remove variation duplicates
        $unique_data=Variation::groupBy(['color_id', 'element_id', 'characteristics'])->pluck('id');
        $variations=Variation::whereNotIn('id',$unique_data)->withTrashed()->get();
        foreach($variations as $variation){
            try{
                $products=Product::where('variation_id', $variation->id)->get();
                foreach($products as $product){
                    $product->forceDelete();
                }
                $variation->forceDelete();
            }catch(Exception $e){
                $this->info($e->getMessage());
            }
        }
        $this->info('Successfully generated translations');
    }
}
