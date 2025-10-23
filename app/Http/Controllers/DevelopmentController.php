<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentStoreRequest;
use App\Http\Requests\DevelopmentUpdateRequest;
use App\Http\Resources\DevelopmentResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentInterface;
use App\Models\Development;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DevelopmentController extends Controller implements HasMiddleware
{
    private DevelopmentInterface $developmentRepository;

    public function __construct(DevelopmentInterface $developmentRepository)
    {
        $this->developmentRepository = $developmentRepository;
    }

    public static function middleware() {
        return [
            new Middleware(PermissionMiddleware::using(['development-list|development-create|development-edit|development-delete']), ['only' => ['index','show','getAllPaginated']]),
            new Middleware(PermissionMiddleware::using(['development-create']), ['only' => ['store']]),
            new Middleware(PermissionMiddleware::using(['development-edit']), ['only' => ['update']]),
            new Middleware(PermissionMiddleware::using(['development-delete']), ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        try {
            $developments = $this->developmentRepository->getAll($request->search, $request->limit, true);

           return ResponseHelper::jsonResponse(true, 'Data development berhasil diambil', DevelopmentResource::collection($developments), 200);
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
            $developments = $this->developmentRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            return ResponseHelper::jsonResponse(true, 'Data development berhasil diambil', PaginateResource::make($developments, DevelopmentResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $development = $this->developmentRepository->getById($id);

            if (!$development) {
                return ResponseHelper::jsonResponse(false, 'Data development tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data development berhasil diambil', new DevelopmentResource($development), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function store(DevelopmentStoreRequest $request)
    {
        $validated = $request->validated();

        try {
            $development = $this->developmentRepository->create($validated);

            return ResponseHelper::jsonResponse(true, 'Data development berhasil dibuat', new DevelopmentResource($development), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(DevelopmentUpdateRequest $request, $id) {
        $validated = $request->validated();

        try {
            $developmentcek = $this->developmentRepository->getById($id);

            if (!$developmentcek) {
                return ResponseHelper::jsonResponse(false, 'Data development tidak ditemukan', null, 404);
            }

             $development = $this->developmentRepository->update($id, $validated);

            return ResponseHelper::jsonResponse(true, 'Data development berhasil diperbarui', new DevelopmentResource($development), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $development = $this->developmentRepository->getById($id);

            if (!$development) {
                return ResponseHelper::jsonResponse(false, 'Data development tidak ditemukan', null, 404);
            }

            $this->developmentRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data development berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }
}
