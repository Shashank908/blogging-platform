<?php

namespace App\Import;

use DB;
use Config;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ImportPosts
{
    public function handle()
    {
        $decoded_data = $this->getAPIdata();

        DB::beginTransaction();

        try {
            // Interacting with the database
            $prepare_data = [];
            foreach ($decoded_data->data as $key => $value) 
            {
                $prepare_data[] = array (
                    'id' => (string) Str::uuid(),
                    'title' => $value->title,
                    'body' => $value->description,
                    'is_published' => Config::get('blog.post_insert.is_published'),
                    'user_id' => Config::get('blog.post_insert.admin_id'),
                    'created_at' => Carbon::now(),
                    'updated_at' => $value->publication_date
                );
            }
            DB::table('posts')->insert($prepare_data);

            DB::commit();
        } catch (\Exception $e) {
            dump('exception');
            dump("=================");
            dump($e->getMessage());
            dump("=================");
            DB::rollback();
        }

        return true;
    }

    public function getAPIdata()
    {
        $url = Config::get('blog.post_insert.api_endpoint');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close ($ch);

        return json_decode($response);
    }
}