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
        foreach($elements as $element){
            $this->info($element->name);
            $element->slug=SlugService::createSlug(Element::class, 'slug', ($element->name));
            $element->save();
        }

        $this->info('Successfully changed');
    }
}
