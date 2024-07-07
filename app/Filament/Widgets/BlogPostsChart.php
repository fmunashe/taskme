<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Widgets\ChartWidget;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Users Monthly Registrations';
    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $userStats = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('count', 'month')
            ->all();

        // Initialize an array with current month elements (one for each month up to the current month)
        $monthlyStats = array_fill(0, $currentMonth, 0);

        // Populate the array with actual data
        foreach ($userStats as $month => $count) {
            $monthlyStats[$month - 1] = $count; // $month - 1 because array is 0-indexed
        }
        return [
            'datasets' => [
                [
                    'label' => 'Registered Users',
                    'data' => $monthlyStats,//[0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
