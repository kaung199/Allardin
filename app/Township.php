<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Township extends Model  implements Searchable
{
    protected $table = 'townships';
    protected $fillable = ['name', 'deliveryprice', 'deliveryman']; 

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('townships.show', $this->id);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
