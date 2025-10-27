<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\FamilyMemberStoreRequest;
use App\Http\Requests\FamilyMemberUpdateRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\FamilyMemberInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class FamilyMemberController extends Controller implements HasMiddleware
{
    private FamilyMemberInterface $familyMemberRepository;

    public function __construct(FamilyMemberInterface $familyMemberRepository)
    {
        $this->familyMemberRepository = $familyMemberRepository;
    }

     public static function middleware() {
        return [
            new Middleware(PermissionMiddleware::using(['family-meber-list|family-meber-create|family-meber-edit|family-meber-delete']), only: ['index','show','getAllPaginated']),
            new Middleware(PermissionMiddleware::using(['family-meber-create']), only: ['store']),
            new Middleware(PermissionMiddleware::using(['family-meber-edit']), only: ['update']),
            new Middleware(PermissionMiddleware::using(['family-meber-delete']), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $familyMember = $this->familyMemberRepository->getAll($request->search, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data family member berhasil diambil', FamilyMemberResource::collection($familyMember), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string|max:255',
            'row_per_page' => 'required|integer|min:1',
        ]);

        try {
            $familyMember = $this->familyMemberRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            // dd($familyMember);

            return ResponseHelper::jsonResponse(true, 'Data family member berhasil diambil', PaginateResource::make($familyMember, FamilyMemberResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function store(FamilyMemberStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data family member berhasil ditambahkan', new FamilyMemberResource($familyMember), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function show(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->show($id);

            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Data family member tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data family member berhasil diambil', new FamilyMemberResource($familyMember), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(FamilyMemberUpdateRequest $request, string $id) {
        $request = $request->validated();

        try {
            $familyMember = $this->familyMemberRepository->show($id);

            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Data family member tidak ditemukan', null, 404);
            }

            $familyMember = $this->familyMemberRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Data family member berhasil diupdate', new FamilyMemberResource($familyMember), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->show($id);


            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'family member tidak ditemukan', null, 404);
            }

            $familyMember = $this->familyMemberRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'family member berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

}
