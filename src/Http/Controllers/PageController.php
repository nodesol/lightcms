<?php

namespace Nodesol\Lightcms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Nodesol\Lightcms\Models\Page;

class PageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $pages = Page::all();
        return view("lightcms::admin.pages.index", ["pages" => $pages]);
    }

    public function edit($id) {
        $page = Page::find($id);
        return view("lightcms::admin.pages.edit", ["page" => $page]);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);

        $page->title = $request->input('title');
        $page->meta_description = $request->input('meta_description');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->save();

        foreach($page->contents as $content) {
            switch($content->type) {
                case "list":
                    $content->data = $request->input("contents." . $content->name);
                    break;
                case "objects":
                    $content->data = json_encode(["structure" => $content->structure, "items" => json_decode($request->input("contents." . $content->name),true)]);
                    break;
                default:
                    $content->data = json_encode(["value" => $request->input("contents." . $content->name)]);
            }
            $content->save();
        }

        return redirect()->route("lightcms-admin-pages-index");
    }
}
