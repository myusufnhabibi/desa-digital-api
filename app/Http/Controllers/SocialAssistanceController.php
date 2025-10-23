<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceStoreRequest;
use App\Http\Requests\SocialAssistanceUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceResource;
use App\Interfaces\SocialAssistanceInterface;
use App\Models\SocialAssistance;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SocialAssistanceController extends Controller implements HasMiddleware
{
    private SocialAssistanceInterface $socialAssistanceRepository;

    public function __construct(SocialAssistanceInterface $socialAssistanceRepository)
    {
        $this->socialAssistanceRepository = $socialAssistanceRepository;
    }

    public static function middleware() {
        return [
            new Middleware(PermissionMiddleware::using(['social-assistance-list|social-assistance-create|social-assistance-edit|social-assistance-delete']), ['only' => ['index','show','getAllPaginated']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-create']), ['only' => ['store']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-edit']), ['only' => ['update']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-delete']), ['only' => ['destroy']]),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->getAll($request->search, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil diambil', SocialAssistanceResource::collection($socialAssistance), 200);
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
            $socialAssistance = $this->socialAssistanceRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            // dd($socialAssistance);

            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil diambil', PaginateResource::make($socialAssistance, socialAssistanceResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $socialAssistance = $this->socialAssistanceRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil ditambahkan', new SocialAssistanceResource($socialAssistance), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->show($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Data social assistance tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil diambil', new SocialAssistanceResource($socialAssistance), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceUpdateRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $socialAssistance = $this->socialAssistanceRepository->show($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Data social assistance tidak ditemukan', null, 404);
            }

            $socialAssistance = $this->socialAssistanceRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil diupdate', new SocialAssistanceResource($socialAssistance), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $socialAssistance = $this->socialAssistanceRepository->show($id);

            if (!$socialAssistance) {
                return ResponseHelper::jsonResponse(false, 'Data social assistance tidak ditemukan', null, 404);
            }

            $this->socialAssistanceRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data social assistance berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }
}
