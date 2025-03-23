<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilityCalendar extends Component
{
    public Property $property;
    public $month;
    public $year;
    
    protected $listeners = ['booking-created' => '$refresh'];
    
    public function mount(Property $property)
    {
        $this->property = $property;
        $this->month = now()->month;
        $this->year = now()->year;
    }
    
    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->addMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }
    
    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->year, $this->month, 1)->subMonth();
        $this->month = $date->month;
        $this->year = $date->year;
    }
    
    public function getBookedDatesProperty()
    {
        $startOfMonth = Carbon::createFromDate($this->year, $this->month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth();
        
        $bookings = Booking::where('property_id', $this->property->id)
            ->where(function($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->where('start_date', '<=', $startOfMonth)
                            ->where('end_date', '>=', $endOfMonth);
                    });
            })
            ->get();
        
        $bookedDates = [];
        
        foreach ($bookings as $booking) {
            $period = CarbonPeriod::create($booking->start_date, $booking->end_date);
            foreach ($period as $date) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }
        
        return $bookedDates;
    }
    
    public function render()
    {
        $firstDayOfMonth = Carbon::createFromDate($this->year, $this->month, 1);
        $lastDayOfMonth = Carbon::createFromDate($this->year, $this->month, 1)->endOfMonth();
        
        $daysInMonth = $lastDayOfMonth->day;
        $startOfCalendar = $firstDayOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfCalendar = $lastDayOfMonth->copy()->endOfWeek(Carbon::SUNDAY);
        
        $calendar = [];
        $currentDay = $startOfCalendar->copy();
        
        while ($currentDay <= $endOfCalendar) {
            $calendar[] = [
                'day' => $currentDay->day,
                'month' => $currentDay->month,
                'date' => $currentDay->format('Y-m-d'),
                'isCurrentMonth' => $currentDay->month === $this->month,
                'isBooked' => in_array($currentDay->format('Y-m-d'), $this->getBookedDatesProperty()),
                'isPast' => $currentDay->isPast(),
            ];
            
            $currentDay->addDay();
        }
        
        return view('livewire.availability-calendar', [
            'calendar' => $calendar,
            'monthName' => $firstDayOfMonth->format('F Y'),
        ]);
    }
}
