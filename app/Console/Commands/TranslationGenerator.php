<?php

namespace App\Console\Commands;

use App\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TranslationGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translation:generate {--table=} {--translation_table=} {--relation_id=} {--column=name}';

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
        $error = false;

        if(!$this->option('table')) {
            $error = true;
            $this->error('table option required');
        }

        if(!$this->option('translation_table')) {
            $error = true;
            $this->error('translation_table option required');
        }
        if(!$this->option('relation_id')) {
            $error = true;
            $this->error('relation_id option required');
        }

        if($error)
            return;
        $table=$this->option('table');
        $relation_id=$this->option('relation_id');
        $translation_table=$this->option('translation_table');
        $column=$this->option('column');
        $items=DB::table($table)->select(['id', $column])->get();

        foreach($items as $item){
            print_r($item->name);
            foreach (Language::all() as $language){
                DB::table($translation_table)
                ->updateOrInsert(
                    ['lang' => $language->code, $relation_id => $item->id],
                    [$column => $item->$column, 'lang' => $language->code, $relation_id => $item->id]
                );
            }
        }

        $this->info('Successfully generated translations');
    }
}
