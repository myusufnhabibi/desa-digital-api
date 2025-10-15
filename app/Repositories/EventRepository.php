<?php

namespace App\Repositories;

use App\Interfaces\EventInterface;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventRepository implements EventInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $q = Event::where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        });

        if ($limit) {
            $q->take($limit);
        }

        $q->orderBy('created_at', 'DESC');

        if ($excecute) {
            return $q->get();
        }

        return $q;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $event = new Event();
            $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            $event->name = $data['name'];
            $event->description = $data['description'];
            $event->price = $data['price'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->is_active = $data['is_active'];
            $event->save();
            DB::commit();
            return $event;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        $event = Event::where('id', $id)->first();
        return $event;
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $event = $this->getById($id);
            if (isset($data['thumbnail'])) {
                $event->thumbnail = $data['thumbnail']->store('assets/events', 'public');
            }
            $event->name = $data['name'];
            $event->description = $data['description'];
             $event->price = $data['price'];
            $event->date = $data['date'];
            $event->time = $data['time'];
            $event->is_active = $data['is_active'];
            $event->save();
            DB::commit();
            return $event;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $event = $this->getById($id);
            $event->delete();
            DB::commit();
            return $event;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
