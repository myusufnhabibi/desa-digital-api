<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\EventParticipantStoreRequest;
use App\Http\Requests\EventParticipantUpdateRequest;
use App\Http\Resources\EventParticipantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\EventParticipantInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class EventParticipantController extends Controller implements HasMiddleware
{
    private EventParticipantInterface $eventParticipantRepository;

    public function __construct(EventParticipantInterface $eventParticipantRepository)
    {
        $this->eventParticipantRepository = $eventParticipantRepository;
    }

    public static function middleware() {
        return [
            new Middleware(PermissionMiddleware::using(['event-participant-list|event-participant-create|event-participant-edit|event-participant-delete']), ['only' => ['index','show','getAllPaginated']]),
            new Middleware(PermissionMiddleware::using(['event-participant-create']), ['only' => ['store']]),
            new Middleware(PermissionMiddleware::using(['event-participant-edit']), ['only' => ['update']]),
            new Middleware(PermissionMiddleware::using(['event-participant-delete']), ['only' => ['destroy']]),
        ];
    }

    public function index(Request $request)
    {
        try {
            $events = $this->eventParticipantRepository->getAll($request->search, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil diambil', EventParticipantResource::collection($events), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
        //
    }

    public function getAllPaginated(Request $request)
    {
        try {
            $events = $this->eventParticipantRepository->getAllPaginated($request->search, $request->rowPerPage ?? 10);

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil diambil', PaginateResource::make($events, EventParticipantResource::class ), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function store(EventParticipantStoreRequest $request)
    {
        try {
            $event = $this->eventParticipantRepository->create($request->validated());

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil ditambahkan', new EventParticipantResource($event), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $event = $this->eventParticipantRepository->getById($id);

            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Data event peserta tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil diambil', new EventParticipantResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(EventParticipantUpdateRequest $request, $id) {
        $request = $request->validated();

        try {
            $event = $this->eventParticipantRepository->getById($id);

            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Data event peserta tidak ditemukan', null, 404);
            }

            $event = $this->eventParticipantRepository->update($id,$request);

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil diupdate', new EventParticipantResource($event), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $event = $this->eventParticipantRepository->getById($id);

            if (!$event) {
                return ResponseHelper::jsonResponse(false, 'Data event peserta tidak ditemukan', null, 404);
            }

            $this->eventParticipantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Data event peserta berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }
}
