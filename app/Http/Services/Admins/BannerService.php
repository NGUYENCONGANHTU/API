<?php

namespace App\Http\Services\Admins;
use App\Repositories\BannerRepositories;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\Admins\BaseService;
use Exception;

class BannerService extends BaseService
{
    /**
     * @var Repository
     */
    protected $bannerRepositories;
  
    /**
     * Construct
     */
    public function __construct()
    {
        $this->bannerRepositories = new BannerRepositories();
    }

    /**
     * medias File banner
     *
     * @param [type] $params
     * @return void
     */
    public function addBanner($param)
    {
        try {
            //upload images
            $file = $param['images']->getClientOriginalName();
            $fileName = $this->fileName($file);
            $url = $param['images']->move(public_path("upload/banner/"), $fileName);
            $param['images'] = "upload/banner/" . $fileName;
            $this->checkFolder($url);
            $model = $this->bannerRepositories->create($param);
            return $model;
        } catch (\Throwable $th) {
            throw new Exception("Create banner fail!!!");
        }
    }

     /**
     * medias File banner
     * @param [type] $id
     * @param [type] $request
     * @return void
     */

     public function updateBanner($param)
     {
        $banner = $this->bannerRepositories->findOrFail($param['id']);
        if(!$banner){
            throw new Exception("get banner fail!!!");
        }
        if((int)$param['isUpload'] === 0){
            $param['images'] = $banner->images;
        }else{
            // Upload file
        $path = "upload/banner/";
            if ($path.$param['images']->getClientOriginalName() !=  $banner->images) {
                Storage::delete($banner->images);
                $file = $param['images']->getClientOriginalName();
                $fileName = $this->fileName($file);
                $url = $param['images']->move(public_path($path), $fileName);
                $param['images'] = "upload/banner/" . $fileName;
                $this->checkFolder($url);
            } else {
                $param['images'] = $banner->images;
            }
        }
        $model = $this->bannerRepositories->update($param, $banner->id);
        return $model;
     }

     /**
     * delete banner
     * @param [type] $id
     * @return void
     */
    public function delete($id){
        $banner = $this->bannerRepositories->findOrFail($id);
        if(!$banner){
            throw new Exception("get banner fail!!!");
        }
        $imagePath = public_path('app/public/'. $banner->images);
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
        $model = $this->bannerRepositories->delete($banner->id);
        return $model;
    }
}
