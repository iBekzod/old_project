<?php

namespace App\Console\Commands;

use App\Element;
use App\Product;
use App\Variation;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Console\Command;

class ElementSyncronizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncronize:element';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize elements';

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
        $elements=Element::withTrashed()->get();
        //syncronize slugs
        // foreach($elements as $element){
        //     $this->info($element->name);
        //     $element->slug=SlugService::createSlug(Element::class, 'slug', ($element->name));
        //     $element->save();
        // }

        //syncronize parent child
        foreach($elements as $element){
            if($element->parent_id != null){
                $products=Product::where('element_id', $element->id)->get();
                foreach($products as $product){
                    $product->forceDelete();
                }
                $variations=Variation::where('element_id', $element->id)->get();
                foreach($variations as $variation){
                    $variation->forceDelete();
                }
                $element->forceDelete();
            }

        }

        $this->info('Successfully changed');
    }
}
