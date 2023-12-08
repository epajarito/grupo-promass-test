<?php

namespace App\Services\Users;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class PdfReport
{
    /**
     * Method to generate pdf report
     *
     * @return string
    */
    public function handle(): string
    {
        $users = User::latest()->get();
        $pdf = Pdf::loadView('users.index', compact('users'))->setOption(['isRemoteEnabled' => true]);

        $fileName = str()->slug(now()->format('Y-m-d H:i:s')) . ".pdf";
        $pdf->save("users/pdf/{$fileName}", 'public');

        return asset(Storage::url("users/pdf/{$fileName}"));
    }
}