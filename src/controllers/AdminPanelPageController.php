<?php

namespace SmartContact\AdminPanel\controllers;

use SmartContact\AdminPanel\models\AdminPanelPage;
use SmartContact\AdminPanel\requests\AdminPanelPageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminPanelPageController extends Controller
{
    public function index()
    {
        return view('andor9229.adminpanelgenerator.pages.AdminPanelPage.index')
            ->with('adminpanelpages', AdminPanelPage::paginate(10))
            ->with('type', 'index');
    }

    public function create()
    {
        return view('andor9229.adminpanelgenerator.pages.AdminPanelPage.create')
            ->with('data', AdminPanelPage::getData());
    }

    public function show(AdminPanelPage $adminpanelpage)
    {
        return view('pages.AdminPanelPage.show')
            ->with('adminpanelpage', $adminpanelpage)
            ->with('columns', AdminPanelPage::getColumns());
    }

    public function store(AdminPanelPageRequest $request)
    {
        $normalizeName = normalizeName($request->name);

        $adminpanelpage = AdminPanelPage::create([
           'name' => $request->name,
           'normalizeName' => $normalizeName,
           'config' => $request->config,
           'queryData' => $request->queryData,
           'url' => "/dashboard/$normalizeName" ,
           'page_id' => $request->page_id,
        ]);

        return [
            'code' => 200,
            'message' => 'Inserimento Ok',
        ];
    }

    public function edit(AdminPanelPage $adminpanelpage)
    {
        return view('pages.AdminPanelPage.update', compact('adminpanelpage'))
            ->with('data', AdminPanelPage::getData());
    }

    public function update(AdminPanelPageRequest $request, AdminPanelPage $adminpanelpage)
    {
        $adminpanelpage->update([
            //TODO insert fields
        ]);

        return redirect(route("adminpanelpage.index"))
            ->with([
                'notification' =>  __('admin.AdminPanelPage update correctly!'),
            ]);
    }

    public function delete(AdminPanelPage $adminpanelpage)
    {
        $adminpanelpage->delete();

        return redirect(route("adminpanelpage.index"))
            ->with([
                'notification' =>  __('admin.AdminPanelPage delete correctly!'),
            ]);
    }

    public function trash()
    {
        $adminpanelpages = AdminPanelPage::onlyTrashed()->get();

        return view('pages.AdminPanelPage.trash')
            ->with('adminpanelpages', $adminpanelpages)
            ->with('type', 'trash');
    }

    public function restore($id)
    {
        $adminpanelpage = AdminPanelPage::onlyTrashed()->find($id);
        $adminpanelpage->restore();

        return redirect(route("adminpanelpage.index"))
            ->with([
                'notification' =>  __('admin.AdminPanelPage restore correctly!'),
            ]);
    }

    public function destroy($id)
    {
        $adminpanelpage = AdminPanelPage::onlyTrashed()->find($id);
        $adminpanelpage->forceDelete();

        return redirect(route("adminpanelpage.index"))
            ->with([
                'notification' =>  __('admin.AdminPanelPage delete correctly!'),
            ]);
    }

    public function to($slug)
    {
        $app = AdminPanelPage::where('normalizeName', $slug)->first();
        $layout = $this->getLayout($app);
        $query = collect($app->queryData)->map(function($data) {
            return DB::select($this->getQuery($data));
        });

        return view('welcome')
            ->with('layout', $layout)
            ->with('data', $query);
    }

    private function getLayout($app)
    {
        return $app->config;
    }

    private function getQuery($app)
    {
        $select = ! is_null($app['select']) ? "SELECT " . $app['select'] : '';
        $from = " FROM " . $app['from'];
        $where = ! is_null($app['where']) ? " WHERE " . $app['where'] : '';
        $groupBy = ! is_null($app['groupBy']) ? " GROUP BY " . $app['groupBy'] : '';
        $orderBy = ! is_null($app['orderBy']) ? " GROUP BY  " . $app['orderBy'] : '';

        return $select . $from . $where . $groupBy . $orderBy;
    }
}
