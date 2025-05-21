<?php

namespace App\Models\Territory;

use App\Enums\Cache\Tags\CommonCacheTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Declination;
use App\Models\Region;
use App\Models\Territory\District;
use App\Models\Territory\SettlementDivision;
use App\Models\Territory\SettlementSector;
use App\Models\Territory\SettlementType;
use App\Services\Traits\Getters\HasSlug;
use App\Traits\HasFAQ;
use App\Traits\HasMetatags;
use App\Traits\HasViews;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Settlement extends Model implements HasMedia
{
    use HasFAQ;
    use HasMetatags;
    use HasSlug;
    use HasViews;
    use InteractsWithMedia;
    use SoftDeletes;

    protected const CACHE_KEY = 'settlements';

    protected $fillable = [
        'district_id',
        'settlement_type_id',
        'price_category',
        'declination_id',
        'ohrana_slug',
        'name',
        'population',
        'latitude',
        'longitude',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class);
    }

    public function declination()
    {
        return $this->belongsTo(Declination::class);
    }

    public function priceCategory()
    {
        return $this->belongsTo(Region::class, 'price_category');
    }

    public function divisions()
    {
        return $this->hasMany(SettlementDivision::class);
    }

    public function sectors()
    {
        return $this->hasMany(SettlementSector::class);
    }

    public static function getByOhranaSlug(string $slug): ?self
    {
        if (! $slug) {
            return null;
        }

        return cache()
            ->tags([CommonCacheTags::PAGES])
            ->rememberForever(self::CACHE_KEY . '_item_' . $slug, function () use ($slug) {
                return self::where('ohrana_slug', $slug)->with('media')->first();
            });
    }
}
