<?php


namespace ResourceManager;


use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

    protected $table = 'resources';

    protected $fillable = ['columns','name','model'];

} 