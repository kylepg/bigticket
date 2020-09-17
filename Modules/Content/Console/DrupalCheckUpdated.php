<?php

namespace Modules\Content\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Modules\Content\Entities\DrupalArticle;
use Modules\Content\Entities\DrupalGallery;
use Modules\Content\Entities\DrupalVideo;

class DrupalCheckUpdated extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'content:drupal_check_updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the Content API 1.1 for any changes to Drupal Items that may have snuck through the cracks.';

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
        $this->info('Determining most recent sucessful pull from Content API.');
        // The amount of items to return from the Content API 1.1 (2.0 does not let you sort by changed value)
        $count = 50;

        // Set comparison date for most recent updated content to a month ago
        $compare_date = Carbon::now()->subMonth();

        // Get most recent article
        $last_article = DrupalArticle::orderBy('drupal_changed_at','desc')->first();
        // Compare drupal_changed_at value with $compare_date and return most recent value
        $compare_date = !empty($last_article) && $last_article->drupal_changed_at > $compare_date ? $last_article->drupal_changed_at : $compare_date;

        // Get most recent gallery
        $last_gallery = DrupalGallery::orderBy('drupal_changed_at','desc')->first();
        // Compare drupal_changed_at value with $compare_date and return most recent value
        $compare_date = !empty($last_gallery) && $last_gallery->drupal_changed_at > $compare_date ? $last_gallery->drupal_changed_at : $compare_date;

        // Get most recent video
        $last_video = DrupalVideo::orderBy('drupal_changed_at','desc')->first();
        // Compare drupal_changed_at value with $compare_date and return most recent value
        $compare_date = !empty($last_video) && $last_video->drupal_changed_at > $compare_date ? $last_video->drupal_changed_at : $compare_date;

        $url = 'https://www.nba.com/celtics/api/1.1/json/?size='.$count.'&sort=changed';

        $this->info('Checking Content API 1.1 to find recently updated nodes (2.0 does not support sorting by change date).');
        $client = new GuzzleClient();
        $result = $client->get($url,['http_errors' => false]);
        if($result->getStatusCode() === 200){
            $api_data = @json_decode($result->getBody()->getContents());
            if(!empty($api_data) && property_exists($api_data,'content') && !empty($api_data->content)){
                $this->info('Got the '.$count.' most recently changed nodes. Checking against database...');
                $update_nodes_array = [];
                $timezone = config('app.timezone');
                foreach($api_data->content as $item){
                    $item_changed = Carbon::parse($item->changed)->timezone($timezone);
                    if($item_changed > $compare_date){
                        $this->info('Found a change after the last successful pull date.');
                        if($item->type === 'story'){
                            $drupal_item = DrupalArticle::where('nid','=',$item->nid)->first();
                            $new_type = 'article';
                        }
                        elseif($item->type === 'video'){
                            $drupal_item = DrupalVideo::where('nid','=',$item->nid)->first();
                            $new_type = 'video';
                        }
                        elseif($item->type === 'photo_gallery'){
                            $drupal_item = DrupalGallery::where('nid','=',$item->nid)->first();
                            $new_type = 'gallery';
                        }
                        if(!empty($drupal_item) && $item_changed > $drupal_item->drupal_changed_at){
                            $this->info('Found a database item to update. Adding to the update pile.');
                            // Item is in the database but values are outdated. Pass to function to grab new info
                            array_push($update_nodes_array,$item->nid.'|'.$new_type);
                        }
                        else{
                            $this->error('Node doesn\'t exist in the database. Deferring database entry to Content API 2.0 function.');
                        }
                    }
                }
                if(!empty($update_nodes_array)){
                    $this->info('Calling updater command for '.count($update_nodes_array).' items.');
                    $update_nodes = implode(',',$update_nodes_array);
                    $update = $this->call('content:drupal_update_targeted', [
                        'nodes' => $update_nodes
                    ]);
                    if($update){
                        $this->info('Completed all database updates successfully.');
                    }
                    else{
                        $this->error('Did not complete all database updates successfully.');
                    }
                }
                else{
                    $this->info('Nothing to update.');
                }
            }
            else{
                $this->error('Content API 1.1 responded but was empty.');
            }
        }
        else{
            $this->error('Could not reach Content API 1.1.');
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
