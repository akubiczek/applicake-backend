<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    const SOURCE_KEY_MAXLENGTH = 8;

    protected $fillable = [
        'name',
        'recruitment_id',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'key';
    }

    public function recruitment()
    {
        return $this->belongsTo(Recruitment::class);
    }

    protected function generateUniqueKey()
    {
        $this->key = $this->getUniqueKey();
    }

    protected static function getUniqueKey()
    {
        do {
            $key = strtoupper(substr(md5(uniqid()), 0, self::SOURCE_KEY_MAXLENGTH));
            $sources = Source::where('key', $key)->count();
        } while($sources > 0);

        return $key;
    }

    public function save(array $options = [])
    {
        if(empty($this->key)){
            $this->key = $this->getUniqueKey();
        }
        parent::save();
    }
}
