<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Product extends Model  implements Searchable
{
    protected $table = 'products';
    protected $fillable = ['name', 'quantity', 'price', 'count_method', 'photo', 'images', 'description'];


    public function photos()
    {
        return $this->hasMany('App\ProductsPhoto');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('products.show', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            $url
         );
    }
}
