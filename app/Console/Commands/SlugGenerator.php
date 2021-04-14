<?php

namespace App\Console\Commands;

use App\Brand;
use App\Category;
use App\CustomerProduct;
use App\FlashDeal;
use App\Page;
use App\Product;
use App\Shop;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SlugGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:slug';

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
        $items = FlashDeal::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(FlashDeal::class, 'slug', $item->title));
            $item->save();
        }
        $items = Product::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(Product::class, 'slug', $item->name));
            $item->save();
        }
        $items = Page::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(Page::class, 'slug', $item->title));
            $item->save();
        }
        $items = Shop::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(Shop::class, 'slug', $item->name));
            $item->save();
        }
        $items = Category::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(Category::class, 'slug', $item->name));
            $item->save();
        }
        $items = CustomerProduct::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(CustomerProduct::class, 'slug', $item->name));
            $item->save();
        }
        $items = Brand::all();//
        foreach ($items as $item) {
            $item->slug = slugify(SlugService::createSlug(Brand::class, 'slug', $item->name));
            $item->save();
        }
        $this->info('Successfully generated successfully');
    }
}
