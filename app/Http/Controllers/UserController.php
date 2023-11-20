<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBalanceHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function chart(Request $request)
    {
        return view('welcome', [
            'users' => User::get(),
        ]);
    }

    public function api(Request $request)
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalIn = UserBalanceHistory::query()
                ->whereMonth('created_at', $i)
                ->where('type', 'in')
                ->filter()
                ->sum('amount');

            $totalOut = UserBalanceHistory::query()
                ->whereMonth('created_at', $i)
                ->where('type', 'out')
                ->filter()
                ->sum('amount');

            $data[] = [
                'month' => Carbon::create()->day(1)->month($i)->translatedFormat('F'),
                'in' => $totalIn,
                'out' => $totalOut,
            ];
        }

        return [
            'list' => $data,
        ];
    }
}
