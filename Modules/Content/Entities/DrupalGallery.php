<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client as GuzzleClient;

use Modules\Content\Entities\DrupalAuthor;
use Modules\Content\Entities\DrupalGalleryImage;
use Modules\Tags\Entities\Tag;
use App\Traits\HasUuid;

class DrupalGallery extends Model
{
    use HasUuid;

    /**
     *
     * Convert these columns to Carbon instances when retrieved
     *
     */
    protected $dates = ['drupal_published_at','drupal_changed_at'];

    /**
     *
     * RELATIONS
     *
     */
    public function drupalAuthor()
    {
        return $this->belongsTo(DrupalAuthor::class);
    }
    public function drupalGalleryImages()
    {
        return $this->belongsToMany(DrupalGalleryImage::class)->withTimestamps();
    }
    public function tags()
    {
        if(array_key_exists('Tags',\Module::allEnabled())){
            return $this->morphToMany(Tag::class,'taggable');
        }
        return collect([]);
    }

    /**
     *
     * METHODS
     *
     */
    public function drupalPublished()
    {
        $client = new GuzzleClient();
        $url = 'https://api.nba.net/2/celtics/gallery/'.$this->drupal_uuid;
        $result = $client->get($url, [
            'headers' => [
                'accessToken' => config('nba.capi_token')
            ]
        ]);
        if($result->getStatusCode() === 200){
            $api_data = @json_decode($result->getBody()->getContents());
            if(!empty($api_data) && property_exists($api_data,'response') && !empty($api_data->response) && property_exists($api_data->response,'count')){
                if($api_data->response->count > 0){
                    $this->drupal_published = true;
                }
                else {
                    $this->drupal_published = false;
                }
                $this->save();
            }
        }
        return $this->drupal_published;
    }
}
