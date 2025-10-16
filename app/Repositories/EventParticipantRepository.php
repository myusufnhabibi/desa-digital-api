<?php

namespace App\Repositories;

use App\Interfaces\EventParticipantInterface;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;

class EventParticipantRepository implements EventParticipantInterface
{
    public function getAll($search, $limit, $excecute)
    {
        $q = EventParticipant::where(function ($q) use ($search) {
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

    public function getAllPaginated($search, $rowPerPage)
    {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {

        DB::beginTransaction();
        try {
            $event = Event::where('id', $data['event_id'])->first();

            $eventParticipant = new EventParticipant();
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            $eventParticipant->quantity = $data['quantity'];
            $eventParticipant->total_price = $event->price * $data['quantity'];
            $eventParticipant->payment_status = 'pending';
            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function getById(string $id)
    {
        $eventParticipant = EventParticipant::where('id', $id)->first();
        return $eventParticipant;
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $event = Event::where('id', $data['event_id'])->first();

            $eventParticipant = $this->getById($id);
            $eventParticipant->event_id = $data['event_id'];
            $eventParticipant->head_of_family_id = $data['head_of_family_id'];
            if (isset($data['quantity'])) {
                $eventParticipant->quantity = $data['quantity'];
            } else {
                $data['quantity'] = $eventParticipant->quantity;
            }
            $eventParticipant->total_price = $event->price * $data['quantity'];
            $eventParticipant->payment_status = $data['payment_status'];
            $eventParticipant->save();

            DB::commit();
            return $eventParticipant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $eventParticipant = $this->getById($id);
            $eventParticipant->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
