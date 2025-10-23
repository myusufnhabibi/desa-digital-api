<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceRecepientStoreRequest;
use App\Http\Requests\SocialAssistanceRecepientUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecepientResource;
use App\Interfaces\SocialAssistanceRecepientsInterface;
use App\Models\SocialAssistanceRecepient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SocialAssistanceRecepientController extends Controller implements HasMiddleware
{
    private SocialAssistanceRecepientsInterface $socialAssistanceRecepientsRepository;

    public function __construct(SocialAssistanceRecepientsInterface $socialAssistanceRecepientsRepository)
    {
        $this->socialAssistanceRecepientsRepository = $socialAssistanceRecepientsRepository;
    }

     public static function middleware() {
        return [
            new Middleware(PermissionMiddleware::using(['social-assistance-recepient-list|social-assistance-recepient-create|social-assistance-recepient-edit|social-assistance-recepient-delete']), ['only' => ['index','show','getAllPaginated']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-recepient-create']), ['only' => ['store']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-recepient-edit']), ['only' => ['update']]),
            new Middleware(PermissionMiddleware::using(['social-assistance-recepient-delete']), ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request) {
        try {
            $socialAssistanceRecepients = $this->socialAssistanceRecepientsRepository->getAll($request->search, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil diambil', SocialAssistanceRecepientResource::collection($socialAssistanceRecepients), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request) {

         $request = $request->validate([
            'search' => 'nullable|string|max:255',
            'row_per_page' => 'required|integer|min:1',
        ]);

        try {
            $socialAssistanceRecepients = $this->socialAssistanceRecepientsRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil diambil', PaginateResource::make($socialAssistanceRecepients, SocialAssistanceRecepientResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function store(SocialAssistanceRecepientStoreRequest $request) {
        $data = $request->validated();

        try {
            $socialAssistanceRecepient = $this->socialAssistanceRecepientsRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Penerima bantuan sosial berhasil ditambahkan', new SocialAssistanceRecepientResource($socialAssistanceRecepient), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function show(string $id) {
        try {
            $socialAssistanceRecepient = $this->socialAssistanceRecepientsRepository->show($id);

            if (!$socialAssistanceRecepient) {
                return ResponseHelper::jsonResponse(false, 'Data penerima bantuan sosial tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil diambil', new SocialAssistanceRecepientResource($socialAssistanceRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(string $id, SocialAssistanceRecepientUpdateRequest $request) {
        $data = $request->validated();

        try {
             $socialAssistanceRecepient = $this->socialAssistanceRecepientsRepository->show($id);

            if (!$socialAssistanceRecepient) {
                return ResponseHelper::jsonResponse(false, 'Data penerima bantuan sosial tidak ditemukan', null, 404);
            }

            $socialAssistanceRecepient = $this->socialAssistanceRecepientsRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil diupdate', new SocialAssistanceRecepientResource($socialAssistanceRecepient), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function destroy(string $id) {
        try {
             $socialAssistanceRecepient = $this->socialAssistanceRecepientsRepository->show($id);
            if (!$socialAssistanceRecepient) {
                return ResponseHelper::jsonResponse(false, 'Data penerima bantuan sosial tidak ditemukan', null, 404);
            }

            $this->socialAssistanceRecepientsRepository->delete($id);


            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }
}
