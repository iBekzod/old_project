<?php

namespace App\Console\Commands;

use App\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Statickidz\GoogleTranslate;

class Translater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate {--lang=} {--to_lang=} {--key=} {--save_to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate the table keys';

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

        if(!$this->option('lang')) {
            $error = true;
            $this->error('lang option required');
        }

        if(!$this->option('to_lang')) {
            $error = true;
            $this->error('to_lang option required');
        }

        if(!$this->option('key')) {
            $error = true;
            $this->error('key option required');
        }

        if(!$this->option('save_to')) {
            $error = true;
            $this->error('save_to option required');
        }

        if($error)
            return;

        $data = Translation::where('lang', $this->option('lang'))
            ->latest()
            ->get();

        $trans = new GoogleTranslate();

        foreach ($data as $item)
        {
            $item->{$this->option('save_to')} = $trans->translate(
                'en',
                $this->option('to_lang'),
                $item->{$this->option('key')}
            );
            $item->save();
            sleep(rand(1,2));
        }

        $this->info('Successfully translated');
    }
}
