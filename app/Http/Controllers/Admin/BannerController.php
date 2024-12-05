<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BannerModel;
//use App\Models\BannerModel as ModelsBannerModel;
use App\Models\BannerCategoryModel;

class BannerController extends Controller
{
  public function index(Request $request)
  {
    $banner = BannerModel::with('banner_cate')->orderBy('created_at', 'desc')->get();
    //return $banner;
    $banner_categories = BannerCategoryModel::orderBy('created_at')->get();
    $filter_categories = 0; //chua loi undefined $filter_categories khi them moi banner
    if ($request->input('banner_categories')) {
      $filter_categories = (int)$request->input('banner_categories');
      $banner = BannerModel::with('banner_cate')->where('parent_id', $request->input('banner_categories'))->orderBy('created_at', 'desc')->get();
    }
    return view('admin.banner.banners', compact('banner', 'banner_categories', 'filter_categories'));
  }

  public function add()
  {
    //$banner = BannerModel::with('banner_cate')->orderBy('created_at','desc')->get();
    $banner_cate = BannerCategoryModel::orderBy('created_at')->get();
    return view('admin.banner.banners_edit', compact('banner_cate'));
  }
  public function edit($id = NULL)
  {
    $banner = BannerModel::with('banner_cate')->find($id);
    //return $banner;
    $banner_cate = BannerCategoryModel::orderBy('created_at')->get();
    return view('admin.banner.banners_edit', compact('banner', 'banner_cate'));
  }

  public function delete($id)
  {
    $record = BannerModel::find($id);
    if (!$record) {
      return redirect()
        ->route('banner')
        ->withErrors('error', 'Bản ghi không tồn tại');
    }
    $record->delete();
    return redirect()
      ->route('banner')
      ->with('success', 'Bản ghi đã được xoá thành công');
  }

  public function banner_store(Request $request)
  {
    $banner_cat = new BannerModel();
    if ($banner_cat->banner_store($request)) {
      return redirect()
        ->route('banner')
        ->with('success', 'Them thanh cong');
    } else {
      return redirect()
        ->route('banner')
        ->with('error', 'Có lỗi xảy ra vui lòng thử lại');
    }
  }
}
