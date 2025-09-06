<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class CalendarMonth extends Component {
    public function __construct(public Carbon $month, public $ridesByDate) {}
    public function render(){ return view('components.calendar-month'); }
}
@php
$start = $month->copy()->startOfMonth()->startOfWeek();
$end = $month->copy()->endOfMonth()->endOfWeek();
@endphp
<div class="grid grid-cols-7 gap-1 text-sm">
  @for ($d=$start->copy(); $d->lte($end); $d->addDay())
    @php $key=$d->format('Y-m-d'); $rides=$ridesByDate[$key] ?? []; @endphp
    <div class="p-2 rounded {{ $d->month==$month->month?'bg-outdoor-cream':'bg-gray-100' }}">
      <div class="text-xs text-gray-600">{{ $d->day }}</div>
      @foreach($rides as $r)
        <a href="{{ route('rides.show',$r->slug) }}" class="block mt-1 truncate text-outdoor-earth hover:underline">
          {{ Str::limit($r->title,16) }}
        </a>
        
      @endforeach
    </div>
  @endfor
</div>
