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

class TransferCharacteristics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:characteristics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer characteristics';

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
        $characteristics=Characteristic::all();
        foreach($characteristics as $characteristic){
            DB::table('attribute_characteristic')->insert(array('id'=>$characteristic->id,'attribute_id'=>$characteristic->attribute_id,'characteristic_id'=>$characteristic->id));
        }
        $this->info('Successfully transferred');
    }
}
