<?php namespace ResourceManager;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ResourceManagerServiceProvider extends ServiceProvider {
    public function register() {}

    public function boot()
    {

        if( ! Schema::hasTable('resources') )
        {
            $this->createTable();
        }

        $this->publishConfig();

        $this->loadViewsFrom(__DIR__.'/views', 'resourceManager');

        include __DIR__.'/ResourceRoutes.php';

    }

    private function publishConfig(){

        $this->mergeConfigFrom(
            __DIR__.'/config/resourceManager.php', 'resourceManager'
        );

        $this->publishes([
            __DIR__.'/config/resourceManager.php' => config_path('resourceManager.php'),
        ]);

    }

    private function createTable(){

        Schema::create('resources', function($table)
        {

            $table->increments('id');
            $table->string('columns');
            $table->string('name');
            $table->string('model');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        while(count(Resource::all()) < 1){

            $r = new Resource([
                'columns' => 'columns,name,model',
                'name' => 'Resource',
                'model' => 'ResourceManager\Resource'
            ]);
            $r->save();

        }

    }

}