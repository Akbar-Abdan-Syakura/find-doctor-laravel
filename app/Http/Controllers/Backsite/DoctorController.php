<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

// use library here
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

// use request here
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Requests\Doctor\StoreDoctorRequest;

// simlple use here
use Gate;
use Auth;
use File;

// model here
use App\Models\User;
use App\Models\Operational\Doctor;
use App\Models\MasterData\Poli;

// thirdparty package

class DoctorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('doctor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // for table grid
        $doctor = Doctor::orderBy('created_at', 'desc')->get();
        // use select2 = asc from a to z
        $poli = Poli::orderBy('name', 'asc')->get();

        return view('pages.backsite.operational.doctor.index', compact('doctor', 'poli'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {
        // get all data from frontsite
        $data = $request->all();

        // store to database
        $doctor = Doctor::create($data);

        alert()->success('Success Message', 'Successfully added new doctor');
        return redirect()->route('backsite.doctor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.backsite.operational.doctor.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // use select2 = asc from a to z
        $poli = Poli::orderBy('name', 'asc')->get();

        return view('pages.backsite.operational.doctor.edit', compact('doctor', 'poli'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        // get all data request from frontsite
        $data = $request->all();

        // update to database
        $doctor->update($data);

        alert()->success('Success Message', 'Successfully updated doctor');
        return redirect()->route('backsite.doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        abort_if(Gate::denies('doctor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->forceDelete();

        alert()->success('Success Message', 'Successfully deleted doctor');
        return back();
    }
}
