<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agen;

class AgenController extends Controller
{
    public function index()
    {
        $agens = Agen::orderBy('created_at', 'DESC')->paginate(10);
        return view('agen.index', compact('agens'));
    }

    public function create()
    {
        return view('agen.add');
    }

    public function save(Request $request)
    {
    $this->validate($request, [
        'name' => 'required|string',
        'phone' => 'required|max:13', 
        'address' => 'required|string',
    ]);

    try {
        $agen = Agen::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect('/agen')->with(['success' => 'Data telah disimpan']);
    }
     catch (\Exception $e) {
     return redirect()->back()->with(['error' => $e->getMessage()]);
    }
    }

    public function edit($id)
    {
        $agens = Agen::find($id);
        return view('agen.edit', compact('agens'));
    }

    public function update(Request $request, $id)
    {
        $agen = Agen::find($id);
        $agen->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect('/agen')->with(['success' => '<strong>' . $agen->name . '</strong> Diperbaharui']);
    }

    public function destroy($id)
    {
    $agen = Agen::find($id);
    $agen->delete();
    return redirect()->back()->with(['success' => '<strong>' . $agen->name . '</strong> Telah dihapus']);
    }
}
