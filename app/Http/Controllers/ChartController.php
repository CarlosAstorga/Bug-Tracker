<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChartController extends Controller
{

    public function chartTicketsByCategory()
    {
        return [
            'title' => 'Tickets por categoría',
            'data'  => $this->prepareTicketQuery('category_id')
        ];
    }

    public function chartTicketsByStatus()
    {
        return [
            'title' => 'Tickets por estatus',
            'data'  => $this->prepareTicketQuery('status_id')
        ];
    }

    public function chartTicketsByPriority()
    {
        return [
            'title' => 'Tickets por prioridad',
            'data'  => $this->prepareTicketQuery('priority_id')
        ];
    }

    public function chartTicketsBySubmitter()
    {
        return [
            'title' => 'Tickets creados por usuario',
            'data'  => $this->prepareTicketQuery('submitter_id', 'total')
        ];
    }

    public function chart()
    {
        $chart = [
            'submitter' =>  $this->chartTicketsBySubmitter(),
            'status'    =>  $this->chartTicketsByStatus(),
            'priority'  =>  $this->chartTicketsByPriority(),
            'category'  =>  $this->chartTicketsByCategory()
        ];

        $this->removeEmptyElements($chart);

        return [
            'chart' => count($chart) > 0 ? $chart : [],
            'total' => count($chart)
        ];
    }

    public function removeEmptyElements(&$array)
    {
        foreach ($array as $key => &$item) {
            if (count($item['data']) <= 0) {
                unset($array[$key]);
            }
        }

        return $array;
    }

    public function prepareTicketQuery($field, $orderBy = null)
    {
        $query = Ticket::groupBy($field)->select($field, DB::raw('count(*) as total'));
        if (Gate::denies('assign-users')) {
            $query->where('submitter_id', auth()->user()->id);
        }

        if ($orderBy) {
            $query->orderBy($orderBy, 'desc')->take(5);
        }
        return $query->get();
    }
}
