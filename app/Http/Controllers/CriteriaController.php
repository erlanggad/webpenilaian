<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criterias = Criteria::all();

        // if (Criteria::exists()) {
        //     $roc = new RankOrderCentroidController();
        //     $criteriaWeight = $roc->criteriaWeight();

        //     return view('admin.criteria.index', compact('criterias', 'criteriaWeight'));
        // }

        return view('criteria.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        return view('criteria.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'criteria' => 'required',
            'information' => 'required|string',
            'weight' => 'numeric|between:0,99.99',
            'type' => 'required|in:benefit,cost',
        ]);

        // Mengambil data terakhir
        $lastData = Criteria::latest()->first();

        // Mengecek apakah ada data sebelumnya
        if ($lastData) {
            // Mengambil angka dari data terakhir
            $lastNumber = intval(substr($lastData->criteria, 1));

            // Membuat kode baru dengan increment
            $newNumber = $lastNumber + 1;
            $newKode = 'C' . $newNumber;
        } else {
            // Jika tidak ada data sebelumnya, maka kode baru adalah C1
            $newKode = 'C1';
        }

        //Simpan data baru dengan kode otomatis
        $criteria = new Criteria;
        $criteria->criteria = $newKode;
        if($newKode == 'C1'){
            $criteria->weight = 0.4;
        }else if($newKode == 'C2'){
            $criteria->weight = 0.3;
        }else if($newKode == 'C3'){
            $criteria->weight = 0.2;
        }else if($newKode == 'C4'){
            $criteria->weight = 0.1;
        }
        $criteria->information = $request->input('information');
        $criteria->type = $request->input('type');
        $criteria->save();

        return redirect()->route('kriteria.index')->with('success', 'Criteria has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($criteria);
        $criteria = Criteria::findOrFail($id);

        return view('criteria.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'criteria' => 'required',
            'information' => 'required|string',
            // 'weight' => 'numeric|between:0,99.99',
            'type' => 'required|in:benefit,cost',
        ]);
        $criteria = Criteria::findOrFail($id);

        // $criteria = new Criteria;
        // // $criteria->criteria = $newKode;
        // $criteria->information = $request->input('information');
        // $criteria->type = $request->input('type');
        // $criteria->save();

        $criteria->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Criteria Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria = Criteria::findOrFail($id);

        $criteria->delete();
        // dd($criteria);

        // dd($criteria->errors());

        // foreach ($criteria as $index => $data) {
        //     $data->criteria = $index + 1;
        //     $data->save();
        // }

        return redirect()->route('kriteria.index')->with('success', 'Criteria has been deleted successfully');
    }
}
