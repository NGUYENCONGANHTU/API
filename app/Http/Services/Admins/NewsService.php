<?php

namespace App\Http\Services\Admins;
use App\Repositories\NewsRepositories;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\Admins\BaseService;
use Exception;

class NewsService extends BaseService
{
    /**
     * @var Repository
     */
    protected $newRepositories;
  
    /**
     * Construct
     */
    public function __construct()
    {
        $this->newRepositories = new NewsRepositories();
    }

    /**
     * medias File news
     *
     * @param [type] $params
     * @return void
     */
    public function add($param)
    {
        try {
            //upload images
            $file = $param['images']->getClientOriginalName();
            $fileName = $this->fileName($file);
            $url = $param['images']->move(public_path("upload/news/"), $fileName);
            $param['images'] = "upload/news/" . $fileName;
            $this->checkFolder($url);
            $model = $this->newRepositories->create($param);
            return $model;
        } catch (\Throwable $th) {
            throw new Exception("Create news fail!!!");
        }
    }

     /**
     * medias File news
     * @param [type] $id
     * @param [type] $request
     * @return void
     */

     public function update($param)
     {
        $news = $this->newRepositories->findOrFail($param['id']);
        if(!$news){
            throw new Exception("get news fail!!!");
        }
        if((int)$param['isUpload'] === 0){
            $param['images'] = $news->images;
        }else{
            // Upload file
        $path = "upload/news/";
            if ($path.$param['images']->getClientOriginalName() !=  $news->images) {
                Storage::delete($news->images);
                $file = $param['images']->getClientOriginalName();
                $fileName = $this->fileName($file);
                $url = $param['images']->move(public_path($path), $fileName);
                $param['images'] = "upload/news/" . $fileName;
                $this->checkFolder($url);
            } else {
                $param['images'] = $news->images;
            }
        }
        $model = $this->newRepositories->update($param, $news->id);
        return $model;
     }

     /**
     * delete news
     * @param [type] $id
     * @return void
     */
    public function delete($id){
        $news = $this->newRepositories->findOrFail($id);
        if(!$news){
            throw new Exception("get news fail!!!");
        }
        $imagePath = storage_path('app/public/'. $news->images);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        $model = $this->newRepositories->delete($news->id);
        return $model;
    }
}
