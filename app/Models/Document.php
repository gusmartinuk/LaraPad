<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'filename',
        'file_path',
        'file_type',
        'extracted_text',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
