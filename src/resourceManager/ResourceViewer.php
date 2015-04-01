<?php


namespace ResourceManager;

use Illuminate\Database\Eloquent\Model;

class ResourceViewer extends Model {

    protected $resourceToLookUp;

    function __construct($resourceToLookUp = null)
    {
        $this->resourceToLookUp = $resourceToLookUp;
    }

    public function getResources(){

        return Resource::all();
    }

    public function getResourceColumns(){

        return explode(',',Resource::where('name','=',$this->resourceToLookUp)->first()->columns);
    }

    public function getRowFor(){
        return $this->getModel($this->resourceToLookUp)->limit(10)->get();
    }

    public function getModel(){
        $modelName = (Resource::where('name','=',$this->resourceToLookUp)->first()->model);
        return new $modelName;
    }

    public function getModelName(){
        return Resource::where('name','=',$this->resourceToLookUp)->first()->model;
    }

    public function getName(){
        return Resource::where('name','=',$this->resourceToLookUp)->first()->name;
    }


} 