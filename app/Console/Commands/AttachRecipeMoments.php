<?php

namespace App\Console\Commands;

use App\Models\Recipe;
use Illuminate\Console\Command;

class AttachRecipeMoments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attach-recipe-moments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recipes = Recipe::get();

        foreach ($recipes as $value) {
            $moment = $value->moment_simple;

            $value->moments()->attach($moment);
        }
    }
}
