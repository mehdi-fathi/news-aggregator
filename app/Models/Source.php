<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'data_source_id'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function DataSource()
    {
        return $this->belongsTo(DataSource::class);
    }


}
