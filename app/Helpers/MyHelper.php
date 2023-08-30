<?php

use App\Models\Transaction\BookLoan;
use Carbon\Carbon;

function getNumberOfDays($start, $end)
{
    return Carbon::parse($start)->diffInDays($end);
}

function getLateReunds() 
{
    $lateRefunds = BookLoan::whereDate('end_date', '<', now())
                            ->where('refund', false)
                            ->select('id', 'code', 'user_id')
                            ->with(['user:id,name'])
                            ->get();

    return $lateRefunds;
}


// // mendapatkan hari kerja
// $nextweekday = Carbon::parse($request->end_date)->nextWeekday();
// // dd($nextweekday->format('Y-m-d'));

// // mendapatkan jumlah hari 
// $totalDay = Carbon::parse($request->start_date)->diffInDays($request->end_date);

// dd($totalDay);
