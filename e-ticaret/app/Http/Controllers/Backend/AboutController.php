<?php

namespace App\Http\Controllers\Backend;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index(){
        $about = About::where('id', 1)->first();
        return view('backend.pages.about.index', compact('about'));
    }

    public function update(Request $request, $id=1){

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/about/';
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }

            $about = About::where('id',$id)->first();

            About::updateOrCreate(
            ['id' => $id],
            [
                'image' => $imageurl ?? $product->image,
                'name' => $request->name,
                'content' => $request->content,
                'text_1_icon' => $request->text_1_icon,
                'text_1' => $request->text_1,
                'text_1_content' => $request->text_1_content,
                'text_2_icon' => $request->text_2_icon,
                'text_2' => $request->text_2,
                'text_2_content' => $request->text_2_content,
                'text_3_icon' => $request->text_3_icon,
                'text_3' => $request->text_3,
                'text_3_content' => $request->text_3_content,
            ]
            );

            return back()->withSuccess('Başarıyla Güncellendi.');
    }
}
