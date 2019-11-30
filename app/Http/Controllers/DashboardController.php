<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonImmutable;
use App\Guest;
use App\Folio;

class DashboardController extends Controller
{
    public function index()
    {

        $guest_data = $this->getGuestTotals();
        $group_data = $this->getGroupTotals();

        return response()->json([
            'total_guests' => $guest_data,
            'total_groups' => $group_data,
        ], 200);
    }

    private function getGuestTotals()
    {

        $total_guests = Guest::all()->count();

        return $total_guests;
    }


    private function getGroupTotals()
    {

        $total_groups = Folio::all()->count();

        return $total_groups;
    }

}
