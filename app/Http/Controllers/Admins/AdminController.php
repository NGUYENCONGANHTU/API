<?php

/**
 * Copyright 2021 DevFast Limited. All rights reserved.
 * Email: tech@devfast.us
 * Website: http://devfast.us/
 */

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AdminRepository;
// use App\Http\Services\Admins\AdminService;
use App\Http\Requests\Admins\AdminRequest;
use App\Http\Requests\UpdateAdminPasswordRequest;
use App\Http\Resources\Auth\AdminResource;

class AdminController extends Controller
{
    /**
     * @var Repository
     */
    protected $adminRepository;
    // protected $adminService;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
    }

    /**
     * Get data by multiple fields.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $params = $request->all();
        $admins = $this->adminRepository->search($params);
        $jsonAdmins = AdminResource::collection($admins);

        return $jsonAdmins;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {

        try {
            $admin = $this->adminRepository->create($request->all());
            $admin->syncRoles($request->roles);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonAdmin = new AdminResource($admin);

        return $jsonAdmin;
    }

    /**
     * Get Object By Id.
     *
     * @param  int  $id - admin id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $admin = $this->adminRepository->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonAdmin = new AdminResource($admin);

        return $jsonAdmin;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\UpdateAdminPasswordRequest  $request
     * @param  int  $id - admin id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminPasswordRequest $request, $id)
    {
        try {
            $admin = $this->adminRepository->update($request->all(), $id);
            $admin->syncRoles($request->roles);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonAdmin = new AdminResource($admin);

        return $jsonAdmin;
    }

    /**
     * Update Status.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  int  $id - admin id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $admin = $this->adminRepository->update($request->only('status'), $id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        $jsonAdmin = new AdminResource($admin);

        return $jsonAdmin;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id - User id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
             $this->adminRepository->delete($id);
        } catch (\Throwable $th) {
            return response()->json([
                'data' => ['errors' => ['exception' => $th->getMessage()]]
            ], 400);
        }
        return response()->json(true); 
    }
}