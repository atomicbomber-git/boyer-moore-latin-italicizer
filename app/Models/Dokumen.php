<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dokumen extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const COLLECTION_WORD = "word";
    const COLLECTION_HTML = "html";

    protected $table = "dokumen";
    protected $guarded = [];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION_WORD)
            ->singleFile();

        $this->addMediaCollection(self::COLLECTION_HTML)
            ->singleFile();
    }
}
