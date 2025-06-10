<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\DataPelatihan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::everyMinute()->call(function () {
    \Log::info('Running auto delete task...');
    \App\Models\DataPelatihan::onlyTrashed()
        ->where('deleted_at', '<', now()->subdays(15))
        ->forceDelete();
})->name('auto-delete-expired-pelatihan')
  ->description('Hapus data pelatihan soft delete yang lebih dari 15 hari')
  ->sendOutputTo(storage_path('logs/scheduler.log'));

