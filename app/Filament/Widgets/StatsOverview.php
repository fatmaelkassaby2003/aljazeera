<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي العملاء', \App\Models\Client::count())
                ->description('إجمالي العملاء')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('إجمالي القطاعات', \App\Models\Sector::count())
                ->description('القطاعات النشطة')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('primary'),
            Stat::make('إجمالي الخدمات', \App\Models\SectorService::count())
                ->description('خدمات عبر جميع القطاعات')
                ->color('info'),
        ];
    }
}
