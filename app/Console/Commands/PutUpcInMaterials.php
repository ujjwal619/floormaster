<?php

namespace App\Console\Commands;

use App\Data\Entities\Models\Job\Job;
use App\Data\Entities\Models\Template\Template;
use App\FMS\Job\Manager;
use App\FMS\Product\Manager as ProductManager;
use Illuminate\Console\Command;

class PutUpcInMaterials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'putUpcInMaterials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put Upc In Materials.';

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
        $productManager = app(ProductManager::class);

        $templates = Template::all();
        $templates->map(function (Template $template) use ($productManager) {
            $materials = $template->material_products;
            dd($materials);
            $product = $productManager->findWhere(['id' => array_get($materials, 'product_id')]);
            
            if ($product) {
                $template->fill([
                    'material_products' => $materials
                ])->save();

            }
        });

        dump('Successful');
    }
}
