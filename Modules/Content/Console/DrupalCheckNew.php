<?php

namespace Modules\Content\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;

use Modules\Content\Entities\DrupalArticle;
use Modules\Content\Entities\DrupalAuthor;
use Modules\Content\Entities\DrupalGallery;
use Modules\Content\Entities\DrupalGalleryImage;
use Modules\Content\Entities\DrupalVideo;
use Modules\Content\Entities\DrupalVideoCaption;
use Modules\Tags\Entities\Tag;

class DrupalCheckNew extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'content:drupal_check_new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the Content API (2.0) for recently created Drupal Items (Articles, Galleries, Videos) - ordered by publish date.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Check if Tags module is enabled
        $tags_enabled = array_key_exists('Tags',\Module::allEnabled());

        $count = 50;
        $this->info('Grabbing items '.$count.' most recent items from the Content API...');
        $client = new GuzzleClient();
        $url = 'https://api.nba.net/2/celtics/video,article,gallery/?count='.$count.'&verbose=true';
        $result = $client->get($url, [
            'headers' => [
                'accessToken' => config('nba.capi_token')
            ],
            'http_errors' => false
        ]);
        if($result->getStatusCode() === 200){
            $api_data = @json_decode($result->getBody()->getContents());
            if(!empty($api_data) && property_exists($api_data,'response') && property_exists($api_data->response,'result') && !empty($api_data->response->result)){
                foreach($api_data->response->result as $item){
                    if($item->type === 'video'){
                        if(property_exists($item,'uuid') && !empty($item->uuid)){
                            $drupal_item = DrupalVideo::where('drupal_uuid','=',$item->uuid)->first();
                        }
                        elseif(property_exists($item,'nid') && !empty($item->nid)){
                            $drupal_item = DrupalVideo::where('nid','=',$item->nid)->first();
                        }
                        if(empty($drupal_item)){
                            $this->info('Found new Video. Creating...');
                            $drupal_item = new DrupalVideo();
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->short_headline = property_exists($item,'shortHeadline') && !empty($item->shortHeadline) ? $item->shortHeadline : null;
                            $drupal_item->description = property_exists($item,'description') && !empty($item->description) ? $item->description : null;
                        }
                        elseif(!$drupal_item->is_locally_edited){
                            // Only update the following if it hasn't been changed locally (reserved for things like title, description, etc.)
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->short_headline = property_exists($item,'shortHeadline') && !empty($item->shortHeadline) ? $item->shortHeadline : null;
                            $drupal_item->description = property_exists($item,'description') && !empty($item->description) ? $item->description : null;
                        }
                        $drupal_item->drupal_uuid = property_exists($item,'uuid') && !empty($item->uuid) ? $item->uuid : null;
                        $drupal_item->nid = property_exists($item,'nid') && !empty($item->nid) ? $item->nid : null;
                        $drupal_item->api_uri = property_exists($item,'apiUri') && !empty($item->apiUri) ? $item->apiUri : null;
                        $drupal_item->content_xml = property_exists($item,'contentXml') && !empty($item->contentXml) ? $item->contentXml : null;
                        $drupal_item->video_id = property_exists($item,'videoId') && !empty($item->videoId) ? $item->videoId : null;
                        $drupal_item->video_source = property_exists($item,'videoSource') && !empty($item->videoSource) ? $item->videoSource : null;
                        $drupal_item->brand = property_exists($item,'brand') && !empty($item->brand) ? $item->brand : null;
                        $drupal_item->url = property_exists($item,'url') && !empty($item->url) ? $item->url : null;
                        $drupal_item->runtime = property_exists($item,'trt') && !empty($item->trt) ? $item->trt : 0;
                        $drupal_item->drupal_published_at = property_exists($item,'published') && !empty($item->published) ? Carbon::parse($item->published) : null;
                        $drupal_item->drupal_changed_at = property_exists($item,'changed') && !empty($item->changed) ? Carbon::parse($item->changed) : null;
                        $drupal_item->save();

                        if(property_exists($item,'videoCaptions') && property_exists($item->videoCaptions,'sidecars') && (property_exists($item->videoCaptions,'webvtt') && !empty($item->videoCaptions->webvtt) || property_exists($item->videoCaptions,'scc') && !empty($item->videoCaptions->scc))){
                            if(property_exists($item->videoCaptions,'webvtt') && !empty($item->videoCaptions->webvtt)){
                                $drupal_video_captions = DrupalVideoCaption::where('sidecar_webvtt_url','=',$item->videoCaptions->webvtt)->first();
                            }
                            elseif(property_exists($item->videoCaptions,'scc') && !empty($item->videoCaptions->scc)){
                                $drupal_video_captions = DrupalVideoCaption::where('sidecar_scc_url','=',$item->videoCaptions->scc)->first();
                            }
                            if(empty($drupal_video_captions)){
                                $drupal_video_captions = new DrupalVideoCaption();
                            }
                            $drupal_video_captions->sidecar_scc_url = property_exists($item->videoCaptions,'scc') && !empty($item->videoCaptions->scc) ? $item->videoCaptions->scc : null;
                            $drupal_video_captions->sidecar_webvtt_url = property_exists($item->videoCaptions,'webvtt') && !empty($item->videoCaptions->webvtt) ? $item->videoCaptions->webvtt : null;
                            $drupal_video_captions->drupal_video_id = $drupal_item->id;
                            $drupal_video_captions->save();
                        }
                    }
                    elseif($item->type === 'article'){
                        if(property_exists($item,'uuid') && !empty($item->uuid)){
                            $drupal_item = DrupalArticle::where('drupal_uuid','=',$item->uuid)->first();
                        }
                        elseif(property_exists($item,'nid') && !empty($item->nid)){
                            $drupal_item = DrupalArticle::where('nid','=',$item->nid)->first();
                        }
                        if(empty($drupal_item)){
                            $this->info('Found new Article. Creating...');
                            $drupal_item = new DrupalArticle();
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->teaser = property_exists($item,'teaser') && !empty($item->teaser) ? $item->teaser : null;
                        }
                        elseif(!$drupal_item->is_locally_edited){
                            // Only update the following if it hasn't been changed locally (reserved for things like title, description, etc.)
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->teaser = property_exists($item,'teaser') && !empty($item->teaser) ? $item->teaser : null;
                        }
                        $drupal_item->drupal_uuid = property_exists($item,'uuid') && !empty($item->uuid) ? $item->uuid : null;
                        $drupal_item->nid = property_exists($item,'nid') && !empty($item->nid) ? $item->nid : null;
                        $drupal_item->api_uri = property_exists($item,'apiUri') && !empty($item->apiUri) ? $item->apiUri : null;
                        $drupal_item->brand = property_exists($item,'brand') && !empty($item->brand) ? $item->brand : null;
                        $drupal_item->url = property_exists($item,'url') && !empty($item->url) ? $item->url : null;
                        $drupal_item->body = property_exists($item,'content') && !empty($item->content) ? $item->content : null;
                        $drupal_item->body_raw = property_exists($item,'raw') && !empty($item->raw) ? $item->raw : null;
                        $drupal_item->drupal_published_at = property_exists($item,'published') && !empty($item->published) ? Carbon::parse($item->published) : null;
                        $drupal_item->drupal_changed_at = property_exists($item,'changed') && !empty($item->changed) ? Carbon::parse($item->changed) : null;
                        $drupal_item->save();
                    }
                    elseif($item->type === 'gallery'){
                        if(property_exists($item,'uuid') && !empty($item->uuid)){
                            $drupal_item = DrupalGallery::where('drupal_uuid','=',$item->uuid)->first();
                        }
                        elseif(property_exists($item,'nid') && !empty($item->nid)){
                            $drupal_item = DrupalGallery::where('nid','=',$item->nid)->first();
                        }
                        if(empty($drupal_item)){
                            $this->info('Found new Gallery. Creating...');
                            $drupal_item = new DrupalGallery();
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->teaser = property_exists($item,'teaser') && !empty($item->teaser) ? $item->teaser : null;
                            $drupal_item->caption = property_exists($item,'caption') && !empty($item->caption) ? $item->caption : null;
                            $drupal_item->credit = property_exists($item,'credit') && !empty($item->credit) ? $item->credit : null;
                        }
                        elseif(!$drupal_item->is_locally_edited){
                            // Only update the following if it hasn't been changed locally (reserved for things like title, description, etc.)
                            $drupal_item->title = property_exists($item,'title') && !empty($item->title) ? $item->title : null;
                            $drupal_item->headline = property_exists($item,'headline') && !empty($item->headline) ? $item->headline : null;
                            $drupal_item->teaser = property_exists($item,'teaser') && !empty($item->teaser) ? $item->teaser : null;
                            $drupal_item->caption = property_exists($item,'caption') && !empty($item->caption) ? $item->caption : null;
                            $drupal_item->credit = property_exists($item,'credit') && !empty($item->credit) ? $item->credit : null;
                        }
                        $drupal_item->drupal_uuid = property_exists($item,'uuid') && !empty($item->uuid) ? $item->uuid : null;
                        $drupal_item->nid = property_exists($item,'nid') && !empty($item->nid) ? $item->nid : null;
                        $drupal_item->api_uri = property_exists($item,'apiUri') && !empty($item->apiUri) ? $item->apiUri : null;
                        $drupal_item->brand = property_exists($item,'brand') && !empty($item->brand) ? $item->brand : null;
                        $drupal_item->url = property_exists($item,'url') && !empty($item->url) ? $item->url : null;
                        $drupal_item->drupal_published_at = property_exists($item,'published') && !empty($item->published) ? Carbon::parse($item->published) : null;
                        $drupal_item->drupal_changed_at = property_exists($item,'changed') && !empty($item->changed) ? Carbon::parse($item->changed) : null;
                        $drupal_item->save();

                        $gallery_image_sync_array = [];
                        if(property_exists($item,'media') && !empty($item->media)){
                            foreach($item->media as $photo){
                                if(property_exists($photo,'raw') && property_exists($photo->raw,'url') && !empty($photo->raw->url)){
                                    $drupal_gallery_image = DrupalGalleryImage::where('raw_image_url','=',$photo->raw->url)->first();
                                }
                                elseif(property_exists($photo,'source') && !empty($photo->source)){
                                    $drupal_gallery_image = DrupalGalleryImage::where('source_url','=',$photo->source)->first();
                                }
                                if(empty($drupal_gallery_image)){
                                    $drupal_gallery_image = new DrupalGalleryImage();
                                }
                                $drupal_gallery_image->source_url = property_exists($photo,'source') && !empty($photo->source) ? $photo->source : null;
                                $drupal_gallery_image->raw_image_url = property_exists($photo,'raw') && property_exists($photo->raw,'url') && !empty($photo->raw->url) ? $photo->raw->url : null;
                                $drupal_gallery_image->raw_image_focal_point = property_exists($photo,'raw') && property_exists($photo->raw,'focal_point') && property_exists($photo->raw->focal_point,'xoffset') && property_exists($photo->raw->focal_point,'yoffset') ? $photo->raw->focal_point->xoffset.','.$photo->raw->focal_point->yoffset : null;
                                $drupal_gallery_image->tile_image_url = property_exists($photo,'tile') && !empty($photo->tile) ? $photo->tile : null;
                                $drupal_gallery_image->mobile_image_url = property_exists($photo,'mobile') && !empty($photo->mobile) ? $photo->mobile : null;
                                $drupal_gallery_image->portrait_image_url = property_exists($photo,'portrait') && !empty($photo->portrait) ? $photo->portrait : null;
                                $drupal_gallery_image->landscape_image_url = property_exists($photo,'landscape') && !empty($photo->landscape) ? $photo->landscape : null;
                                $drupal_gallery_image->caption = property_exists($photo,'caption') && !empty($photo->caption) ? $photo->caption : null;
                                $drupal_gallery_image->alt_text = property_exists($photo,'alt_text') && !empty($photo->alt_text) ? $photo->alt_text : null;
                                $drupal_gallery_image->credit = property_exists($photo,'credit') && !empty($photo->credit) ? $photo->credit : null;
                                $drupal_gallery_image->type = property_exists($photo,'type') && !empty($photo->type) ? $photo->type : null;
                                $drupal_gallery_image->save();
                                array_push($gallery_image_sync_array,$drupal_gallery_image->id);
                            }
                        }
                        $drupal_item->drupalGalleryImages()->sync($gallery_image_sync_array);
                    }

                    if(!empty($drupal_item)){
                        $tags_sync_array = [];
                        // Generics
                        if(property_exists($item,'taxonomy')){
                            // Find and define Drupal author
                            if(property_exists($item->taxonomy,'writer') && property_exists($item->taxonomy->writer,'id')){
                                $drupal_author = DrupalAuthor::where('drupal_id','=',$item->taxonomy->writer->id)->first();
                                if(empty($drupal_author)){
                                    $drupal_author = new DrupalAuthor();
                                    $drupal_author->drupal_id = $item->taxonomy->writer->id;
                                }
                                $drupal_author->email = property_exists($item->taxonomy->writer,'email') && !empty($item->taxonomy->writer->email) ? $item->taxonomy->writer->email : null;
                                $drupal_author->title = property_exists($item->taxonomy->writer,'title') && !empty($item->taxonomy->writer->title) ? $item->taxonomy->writer->title : null;
                                $drupal_author->name = property_exists($item->taxonomy->writer,'name') && !empty($item->taxonomy->writer->name) ? $item->taxonomy->writer->name : null;
                                $drupal_author->save();
                                $drupal_item->drupal_author_id = $drupal_author->id;
                            }

                            // If Tags module is enabled...
                            if($tags_enabled){

                                // Check for coach tags
                                if(property_exists($item->taxonomy,'coaches') && !empty($item->taxonomy->coaches)){
                                    foreach($item->taxonomy->coaches as $tax){
                                        if(property_exists($tax,'id') && !empty($tax->id) && property_exists($tax,'value')){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'coach_id', 'name' => $tax->id],
                                                ['display_name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                                // Check for team tags
                                if(property_exists($item->taxonomy,'teams') && !empty($item->taxonomy->teams)){
                                    foreach($item->taxonomy->teams as $tax){
                                        if(property_exists($tax,'id') && !empty($tax->id) && property_exists($tax,'value')){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'team_id', 'name' => $tax->id],
                                                ['display_name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                                // Check for player tags
                                if(property_exists($item->taxonomy,'players') && !empty($item->taxonomy->players)){
                                    foreach($item->taxonomy->players as $tax){
                                        if(property_exists($tax,'id') && !empty($tax->id) && property_exists($tax,'value')){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'player_id', 'name' => $tax->id],
                                                ['display_name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                                // Check for freeform tags
                                if(property_exists($item->taxonomy,'freeform') && !empty($item->taxonomy->freeform)){
                                    foreach($item->taxonomy->freeform as $tax){
                                        if(property_exists($tax,'value') && !empty($tax->value)){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'drupal_tag', 'name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                                // Check for game tags
                                if(property_exists($item->taxonomy,'games') && !empty($item->taxonomy->games)){
                                    foreach($item->taxonomy->games as $tax){
                                        if(property_exists($tax,'id') && !empty($tax->id) && property_exists($tax,'value')){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'game_id', 'name' => $tax->id],
                                                ['display_name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                                // Check for section tags
                                if(property_exists($item->taxonomy,'section') && !empty($item->taxonomy->section)){
                                    foreach($item->taxonomy->section as $tax){
                                        if(property_exists($tax,'value') && !empty($tax->value)){
                                            $tag = Tag::updateOrCreate(
                                                ['type' => 'drupal_section', 'name' => $tax->value]
                                            );
                                            array_push($tags_sync_array,$tag->id);
                                        }
                                    }
                                }
                            }
                        }
                        // Only update the image if the node hasn't been updated locally
                        if(property_exists($item,'listImage') && !$drupal_item->is_locally_edited){
                            if(property_exists($item->listImage,'raw') && property_exists($item->listImage->raw,'url')){
                                $drupal_item->image_url = $item->listImage->raw->url;
                                if(property_exists($item->listImage->raw,'focal_point') && property_exists($item->listImage->raw->focal_point,'xoffset') && property_exists($item->listImage->raw->focal_point,'yoffset')){
                                    $drupal_item->image_focal_point = $item->listImage->raw->focal_point->xoffset.','.$item->listImage->raw->focal_point->yoffset;
                                }
                            }
                            elseif(property_exists($item->listImage,'source')){
                                $drupal_item->image_url = $item->listImage->source;
                            }
                            elseif(property_exists($item->listImage,'large')){
                                $drupal_item->image_url = $item->listImage->large;
                            }
                            elseif(property_exists($item->listImage,'mobile')){
                                $drupal_item->image_url = $item->listImage->mobile;
                            }
                            elseif(property_exists($item->listImage,'landscape')){
                                $drupal_item->image_url = $item->listImage->landscape;
                            }
                            elseif(property_exists($item->listImage,'thumbnail')){
                                $drupal_item->image_url = $item->listImage->thumbnail;
                            }
                        }
                        $drupal_item->save();
                        $drupal_item->tags()->sync($tags_sync_array);
                    }
                }

                //!! TURN THIS BACK ON WHEN YOU CAN !!//
                /*
                $is_prod = config('app.env') === 'production' ? true : false;
                $update = $this->call('hubfeeds:update',[
                    '--prod' => $is_prod
                ]);
                */
            }
            else{
                $this->error('Content API 2.0 responded to request successfully but the response could not be parsed');
            }
        }
        else{
            $this->error('Could not reach Content API 2.0.');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
