<?php

namespace Nodesol\Lightcms\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Nodesol\Lightcms\Models\Page;
use Nodesol\Lightcms\Models\PageContent;

class PageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $pages = Page::all();

        return view('lightcms::admin.pages.index', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'unique:pages,name'],
            'slug' => ['required', 'unique:pages,slug'],
        ]);
        $page = Page::create($data);

        return redirect()->route('lightcms-admin-pages-index');
    }

    public function edit($id)
    {
        $page = Page::find($id);

        return view('lightcms::admin.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        $request->validate([
            'name' => ['required', 'unique:pages,name,'.$id],
            'slug' => ['required', 'unique:pages,slug,'.$id],
        ]);

        $page->name = $request->input('name');
        $page->slug = $request->input('slug');
        $page->title = $request->input('title');
        $page->meta_description = $request->input('meta_description');
        $page->meta_keywords = $request->input('meta_keywords');
        $page->save();

        $errors = [];
        foreach ($page->contents as $content) {
            switch ($content->type) {
                case 'image':
                    if (! $request->hasFile('contents.'.$content->name)) {
                        continue 2;
                    }
                    $old_path = json_decode($content->data, true)['path'];
                    $file_path = config('lightcms.image_path');
                    if (config('filesystems.default') == 'local') {
                        $file_path = 'public/'.$file_path;
                    }
                    $content->data = json_encode(['path' => $request->file('contents.'.$content->name)->store($file_path, ['disk' => config('lightcms.storage_disk')])]);
                    Storage::disk(config('lightcms.storage_disk'))->delete($old_path);
                    break;
                case 'list':
                    $content->data = $request->input('contents.'.$content->name);
                    break;
                case 'objects':
                    $data = $request->input('contents.'.$content->name);
                    $data = preg_replace('/[[:cntrl:]]/', '', $data); //clean it
                    if ($data = json_decode($data, true)) {
                        $content->data = json_encode(['structure' => $content->structure, 'items' => $data]);
                    } else {
                        $errors[] = ['msg' => "Unable to save data for field '".$content->name."'"];
                    }
                    break;
                default:
                    $content->data = json_encode(['value' => $request->input('contents.'.$content->name)]);
            }
            $content->save();
        }

        if (count($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        return redirect()->route('lightcms-admin-pages-index');
    }

    public function contents($id)
    {
        $page = Page::find($id);
        $page->load('contents');

        return view('lightcms::admin.pages.contents', ['page' => $page]);
    }

    public function contentStore(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $request->validate([
            'name' => ['required'/*, "unique:page_contents,name"*/],
            'type' => ['required', 'in:text,textarea,list,image,objects'],
        ]);
        $data = ['value' => ''];

        switch ($request->input('type')) {
            case 'list':
                $data = $request->input('value', []);
                break;
            case 'objects':
                $data = ['structure' => [], 'items' => []];
                foreach ($request->input('value.name', []) as $key => $name) {
                    $data['structure'][$name] = $request->input('value.type.'.$key);
                }
                break;
            case 'image':
                if (! $request->hasFile('value')) {
                    $data = ['path' => ''];
                } else {
                    $file_path = config('lightcms.image_path');
                    if (config('filesystems.default') == 'local') {
                        $file_path = 'public/'.$file_path;
                    }
                    $data = ['path' => $request->file('value')->store($file_path, ['disk' => config('lightcms.storage_disk')])];
                }
                break;
            default:
                $data = ['value' => $request->input('value', '')];
        }
        $content = PageContent::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'page_id' => $page->id,
            'data' => json_encode($data),
        ]);

        return redirect()->route('lightcms-admin-contents-index', $page->id);
    }
}
