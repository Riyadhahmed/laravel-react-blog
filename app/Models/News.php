<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
   protected $fillable = ['title', 'category'];

   public function author()
   {
      return $this->belongsTo(User::class, 'uploaded_by');
   }
}
