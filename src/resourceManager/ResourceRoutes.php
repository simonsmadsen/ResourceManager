<?php

Route::get('/res/{resource?}', function($resource = null){

    $viewBag = config('resourceManager.viewbag');
    $viewBag['r'] = new ResourceViewer($resource);


    return view('resourceManager::welcome',$viewBag);

});

Route::post('/res/update',function(){

    $modelName = Input::get('resource_model');
    $model = new $modelName;
    $model = $model->find(Input::get('id'));
    $model->fill(Input::all());
    $model->update();
    return Redirect::back();
});

Route::post('/res/create',function(){


    $modelName = Input::get('resource_model');
    $model = new $modelName(Input::all());
    $model->save();

    return Redirect::back();
});

Route::get('/res/delete/{id}/{model}',function($id,$model){
    $model = str_replace('_','\\',$model);
    $model = new $model;
    $model->destroy($id);
    return Redirect::back();
});