<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RockClass;
use App\Models\Mineral;
use App\Models\Rock;
use App\Models\RockFamily;
use App\Models\RockKind;
use App\Models\RockSquad;
use App\Models\RockStructure;
use App\Models\RockTexture;
use App\Models\RockType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RockController extends Controller
{

    public function home()
    {
//        dump(Auth::check());
//        dump(Auth::user());
        if (Auth::check() && Auth::user()->isUser()) {
            return view('main.index', ['items' => Rock::all()]);
        }
        return view('main.index', ['items' => Rock::where('is_public', 1)->get()]);
    }

    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return view('admin.rocks.index', ['items' => Rock::all()]);
            }
            if (Auth::user()->isUser()) {
                return view('main.index', ['items' => Rock::all()]);
            }
        }
        return view('main.index', ['items' => Rock::where('is_public', 1)->get()]);
    }

    public function info($id)
    {
        if (empty($id)) {
            return false;
        }
        /** @var Rock $rock */
        $rock = Rock::find($id);

        if (empty($rock)) {
            return false;
        }

        if (!Auth::check() && !$rock->isPublic()) {
            abort(404);
        }
        return view('main.rock', ['item' => $rock]);
    }

    public function create()
    {
        return view(
            'admin.rocks.create',
            [
                'rockTypes' => RockType::pluck('name', 'id'),
                'minerals' => Mineral::pluck('name', 'id'),
                'rockClasses' => RockClass::pluck('name', 'id'),
                'rockSquads' => RockSquad::pluck('name', 'id'),
                'rockFamilies' => RockFamily::pluck('name', 'id'),
                'rockKinds' => RockKind::pluck('name', 'id'),
                'rockTextures' => RockTexture::pluck('name', 'id'),
                'rockStructures' => RockStructure::pluck('name', 'id'),
            ]
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>'required|max:255',
            'photo' => 'nullable|image',
        ]);
        $rock = Rock::add($request->all());
        $rock->uploadPhoto($request->file('photo'));
        $rock->setRockType($request->get('rock_type_id'));
        $rock->setRockClass($request->get('rock_class_id'));
        $rock->setRockSquad($request->get('rock_squad_id'));
        $rock->setRockFamily($request->get('rock_family_id'));
        $rock->setRockKind($request->get('rock_kind_id'));
        $rock->setRockTexture($request->get('rock_texture_id'));
        $rock->setRockStructure($request->get('rock_structure_id'));
        $rock->setFormingMinerals($request->get('forming_minerals'));
        $rock->setSecondMinerals($request->get('second_minerals'));
        $rock->setAccessoryMinerals($request->get('accessory_minerals'));
        $rock->toggleStatus($request->get('is_public'));
        $rock->save();

        return redirect()->route('rocks.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return false;
        }

        $rock = Rock::find($id);

        if (empty($rock)) {
            return false;
        }

        $selectedFormMinerals = $rock->formingMinerals->pluck('id')->all();
        $selectedSecMinerals = $rock->secondMinerals->pluck('id')->all();
        $selectedAcMinerals = $rock->accessoryMinerals->pluck('id')->all();

        return view(
            'admin.rocks.edit',
            [
                'rock' => $rock,
                'rockTypes' => RockType::pluck('name', 'id'),
                'minerals' => Mineral::pluck('name', 'id'),
                'rockClasses' => RockClass::pluck('name', 'id'),
                'rockSquads' => RockSquad::pluck('name', 'id'),
                'rockFamilies' => RockFamily::pluck('name', 'id'),
                'rockKinds' => RockKind::pluck('name', 'id'),
                'rockTextures' => RockTexture::pluck('name', 'id'),
                'rockStructures' => RockStructure::pluck('name', 'id'),
                'selectedFormMinerals' => $selectedFormMinerals,
                'selectedSecMinerals' => $selectedSecMinerals,
                'selectedAcMinerals' => $selectedAcMinerals
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'photo' => 'nullable|image'
        ]);

        /** @var Rock $rock */
        $rock = Rock::find($id);
        $rock->edit($request->all());
        $rock->uploadPhoto($request->file('photo'));
        $rock->setRockType($request->get('rock_type_id'));
        $rock->setRockClass($request->get('rock_class_id'));
        $rock->setRockSquad($request->get('rock_squad_id'));
        $rock->setRockFamily($request->get('rock_family_id'));
        $rock->setRockKind($request->get('rock_kind_id'));
        $rock->setRockTexture($request->get('rock_texture_id'));
        $rock->setRockStructure($request->get('rock_structure_id'));
        $rock->setFormingMinerals($request->get('forming_minerals'));
        $rock->setSecondMinerals($request->get('second_minerals'));
        $rock->setAccessoryMinerals($request->get('accessory_minerals'));
        $rock->toggleStatus($request->get('is_public'));
        $rock->save();

        return redirect()->route('rocks.index');
    }

    public function destroy($id)
    {
        $rock = Rock::find($id)->remove();
        return redirect()->route('rocks.index');
    }

    public function getMicroPhotos($id): string
    {
        if (empty($id)) {
            return json_encode([]);
        }
        $publicPath = Rock::IMAGE_PATH_ROCK_MICRO . $id . '/';
        $photos = [
            'ppl' => $this->getMicroPhotoPaths($publicPath . 'ppl'),
            'xpl' => $this->getMicroPhotoPaths($publicPath . 'xpl')
        ];
        return json_encode($photos);
    }

    private function getMicroPhotoPaths(string $publicPath): array
    {
        $path = $publicPath;
        if (!is_dir(public_path($path))) {
            return [];
        }
        $photos = array_values(array_diff(
            scandir(public_path($path)), ['.', '..']
        ));
        return array_map(function ($item) use ($path) {
            return env('APP_URL') . $path . '/' . $item;
        },
            $photos
        );
    }

}
