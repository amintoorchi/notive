<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Morilog\Jalali\Jalalian;

class JalaliCalendarModal extends Component
{
    public int $year;
    public int $month;

    private array $monthNames = [
        1 => 'فروردین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند',
    ];

    public function mount(): void
    {
        $today = Jalalian::now();

        $this->year = $today->getYear();
        $this->month = $today->getMonth();
    }

    public function previousMonth(): void
    {
        $date = (new Jalalian($this->year, $this->month, 1))->subMonths(1);

        $this->year = $date->getYear();
        $this->month = $date->getMonth();
    }

    public function nextMonth(): void
    {
        $date = (new Jalalian($this->year, $this->month, 1))->addMonths(1);

        $this->year = $date->getYear();
        $this->month = $date->getMonth();
    }

    public function render()
    {
        $date = new Jalalian($this->year, $this->month, 1);

        $calendarDays = array_merge(
            array_fill(0, $date->getDayOfWeek(), null),
            range(1, $date->getMonthDays())
        );

        $today = Jalalian::now();

        return view('components.jalali-calendar-modal', [
            'monthName' => $this->monthNames[$this->month],
            'calendarDays' => $calendarDays,
            'today' => $today,
        ]);
    }
}
