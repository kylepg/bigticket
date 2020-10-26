<?php

namespace Modules\Render\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Storage;
use View;

class RenderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('render::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('render::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('render::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('render::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function draft(Request $request, $blog = false)
    {
        if ($request->has('render')) {
            $view = View::make('render::draft.draft');
            $sections = $view->renderSections(); // returns an associative array of 'content', 'head' and 'footer'
            $html = str_replace('http://127.0.0.1:8000/render-assets/', 'https://www.nba.com/resources/static/team/v2/celtics/cdn/', $sections['content']);
            echo '<pre lang="html">';
            echo htmlspecialchars($html);
            echo '</pre>';
            return false;
        }
        $data = storage_path('/json/draft-order_2019.json');
        $order = json_decode(file_get_contents($data), true);
        // $order = json_decode(file_get_contents(resource_path('views/draft/data/draft-order.json')), true);
        return view('render::draft.draft')->with(compact('order'));
    }

    public function careerCenter(Request $request)
    {
        $data = storage_path('/json/career-center.json');
        $ccc = json_decode(file_get_contents($data), true);
        foreach ($ccc['panels'] as $panel) {
            if (! isset($ccc[$panel['type']])) {
                $ccc[$panel['type']] = [];
            }
            $panel['displayDate'] = Carbon::parse($panel['endDate'])->format('D, M j Y');
            $panel['past'] = Carbon::create($panel['endDate'])->isPast();
            array_push($ccc[$panel['type']], $panel);
        }
        if ($request->has('render')) {
            $view = View::make('render::team.career-center.career-center')->with(compact('ccc'));
            $sections = $view->renderSections(); // returns an associative array of 'content', 'head' and 'footer'
            $html = str_replace('http://127.0.0.1:8000/render-assets/', 'https://www.nba.com/resources/static/team/v2/celtics/cdn/', $sections['content']);
            echo '<pre lang="html">';
            echo htmlspecialchars($html);
            echo '</pre>';
            return false;
        }
        // dd($ccc);
        return view('render::team.career-center.career-center')->with(compact('ccc'));
    }

    public function careerCenterBlog(Request $request, $blog)
    {
        if ($request->has('render')) {
            $view = View::make('render::team.career-center.blogs.'.$blog);
            $sections = $view->renderSections(); // returns an associative array of 'content', 'head' and 'footer'
            $html = str_replace('http://127.0.0.1:8000/render-assets/', 'https://www.nba.com/resources/static/team/v2/celtics/cdn/', $sections['content']);
            echo '<pre lang="html">';
            echo htmlspecialchars($html);
            echo '</pre>';
            return false;
        }
        return view('render::team.career-center.blogs.'.$blog);
    }
}
