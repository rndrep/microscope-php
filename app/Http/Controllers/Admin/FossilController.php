<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fossil;
use App\Models\IndexFossil;
use App\Models\Invertebrate;
use App\Models\Rock_Fossil;
use Illuminate\Http\Request;

class FossilController extends Controller
{

    const ITEMS_PER_PAGE = 12;
    const SEARCH_FIELDS = [
        'fossilName' => ['prop' => 'name', 'strict' => false],
        'invertebrate' => ['prop' => 'invertebrate_id', 'strict' => true],
        'indexFossil' => ['prop' => 'index_fossil_id', 'strict' => true],
    ];

    /**
     * Get items for search page
     */
    public function list(Request $request)
    {
        $params = $request->json()->all();
        $params = array_intersect_key($params, self::SEARCH_FIELDS);
        $query = Fossil::query();

        foreach ($params as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if (self::SEARCH_FIELDS[$key]['strict']) {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], $value);
            } else {
                $query->where(self::SEARCH_FIELDS[$key]['prop'], 'LIKE', '%' . $value . '%');
            }
        }

//        $result = $query->orderBy('name')->paginate(self::ITEMS_PER_PAGE);
        $result = $query->orderBy('name')->get();
        $result->map(function ($item) {
            $item->photo = $item->getPhoto();
            $item->microscope_url = '';
            $item->info_url = route('fossil_info', $item->id);
            return $item;
        });
        return ['data' => $result];
    }

    public function index()
    {
        $items = Fossil::orderBy('name')->get();
        return view('admin.fossils.index', [
            'items' => $items,
            'fields' => Fossil::getInputs()]);
    }

    public function create()
    {
        return view(
            'admin.fossils.create',
            [
                'fields' => Fossil::getInputs(),
                'invertebrates' => Invertebrate::orderBy('name')->pluck('name', 'id'),
                'indexFossils' => IndexFossil::orderBy('name')->pluck('name', 'id'),
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'	=>	'required'
        ]);

        $item = Fossil::add($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->uploadGallery($request->file('gallery') ?? []);
        $item->save();
        return redirect()->route('fossils.index');
    }

    public function edit($id)
    {
        return view(
            'admin.fossils.edit',
            [
                'item' => Fossil::find($id),
                'fields' => Fossil::getInputs(),
                'invertebrates' => Invertebrate::orderBy('name')->pluck('name', 'id'),
                'indexFossils' => IndexFossil::orderBy('name')->pluck('name', 'id')
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required'
        ]);
        /** @var Fossil $item */
        $item = Fossil::find($id);
        $item->update($request->all());
        $item->uploadPhoto($request->file('photo'));
        $item->uploadGallery($request->file('gallery') ?? []);
        $item->save();
        return redirect()->route('fossils.index');
    }

    public function destroy($id)
    {
        //Maybe allow to remove? Just also remove record in rock__fossils table.
        if (Rock_Fossil::firstWhere('fossil_id', $id)) {
            return 'Нельзя удалить окаменелость. Существует порода с данной окаменелостью.';
        }
        Fossil::find($id)->remove();
        return redirect()->route('fossils.index');
    }

    public function getMicroPhotosJson($id)
    {
        //no microscope
    }

    public function info($id)
    {
        if (empty($id)) {
            return false;
        }
        /** @var Fossil $item */
        $item = Fossil::find($id);
        if (empty($item)) {
            return false;
        }
        return view('dist.mineral',
            [
                'item' => $item,
                'fields' => $item->getInfoFields(),
                'gallery' => $item::getPhotoUrls(Fossil::GALLERY_PATH . $item->id),
            ]
        );
    }

}
