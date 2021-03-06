<?php

namespace App\Http\Controllers;

use App\Http\Requests\DossierStoreRequest;
use Illuminate\Http\Request;
use App\Dossier;
use App\Partie;
use App\Tribunal;

class DossierController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function index(){
        $dossiers = Dossier::orderBy('annee', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view("dossiers.index", ['dossiers' => $dossiers]);
    }
    public function show($id)
    {
        $dossier = Dossier::findOrFail($id);
        $parties = Partie::all();
        return view("dossiers.show", ['dossier' => $dossier, 'parties' => $parties]);
    }
    public function create(){

        return view("dossiers.create", ['tribunals' => Tribunal::all(), 'dossiers' => Dossier::all()]);
    }
    public function store(DossierStoreRequest $request){
       
        $validatedData = $request->validate([
            'ref' => 'nullable',
            'encours' => 'nullable|in:on',
            'niveau' => 'nullable',
            'type' => 'nullable|string',
            'annee' => 'nullable|between:2010,2022',
            'tribunal' => 'numeric|nullable',
            'observation' => 'nullable',
           
        ]);
        $dossier = new Dossier();
        $inputs = $request->except(['_token']);
        $inputs['encours'] = $request->has('encours');
        //dd($inputs);
        // $article->title = $request->has('title')
        $createdDossier = $dossier->create($inputs);
        if($createdDossier){
            $dossiers = Dossier::with(['tribunal'])->get();
            return view("dossiers.index", ['dossiers' => $dossiers]);
        }


    }
    public function edit(Request $request, $id)
    {
        $dossier = Dossier::findOrFail($id);
      


        return view('dossiers.edit', ['tribunals' => Tribunal::all(), 'monDossier' => $dossier, 'dossiers' => Dossier::all()]);
    }
    public function update(Request $request, $id){
       
        $dossier = Dossier::findOrFail($id);
        $inputs = $request->except(['_token']);
        $inputs['encours'] = $request->has('encours');
       
            $dossier->update($inputs);
      
        $dossiers = Dossier::all();
        return view("dossiers.index", ['dossiers' => $dossiers]);


    }

    public function destroy($id)
    {
        $tribunal = Dossier::find($id);
        $tribunal->delete();
        return redirect()->route('dossiers.index');
       
    }
   
   
}
