<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestForm;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FormController extends BackendController
{
    protected $user;

    /*
     *Using Repositories pattern for Models
     */

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->user->all();
//            dd($data);
        } catch (\Exception $e) {
            throw new \PDOException('Error in fetching records' . $e->getMessage());

        }
        return view($this->backendPagePath . 'form_page', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestForm $request)
    {
        $validated = $request->validated();

        try {
            $this->user->store($validated);
        } catch (\Exception $e) {
            throw new \PDOException('Error in saving form' . $e->getMessage());
        }
        return response()->json(['route' => route('test.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $editData = $this->user->get($id);
        } catch (\Exception $e) {
            throw new \PDOException('Error in editing item' . $e->getMessage());
        }
        return view($this->backendPagePath . 'form_edit', compact('editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestForm $request, $id)
    {
        $validated = $request->validated();
        try {
            $this->user->update($id,$validated);
        } catch (\Exception $e) {
            throw new \PDOException('Error in saving form' . $e->getMessage());
        }
        return response()->json(['route' => route('test.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->user->delete($id);
        } catch (\Exception $e) {
            throw new \PDOException('Error in deleteing item' . $e->getMessage());
        }
        return response()->json(['route' => route('test.index')]);
    }
}
