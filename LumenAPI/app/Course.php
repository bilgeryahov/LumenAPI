<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model{

	protected $fillable = ['id', 'title', 'description', 'value'];

	protected $hidden = ['created_at', 'updated_at'];
}