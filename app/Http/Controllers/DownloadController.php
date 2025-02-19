<?php

namespace App\Http\Controllers;

use App\Models\MataPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadController extends Controller
{
    public function mataPembelajaranTemplate($id)
    {
        $mataPembelajaran = MataPembelajaran::with('attachments')->findOrFail($id);

        if ($mataPembelajaran->attachments->isEmpty()) {
            return back()->with('error', 'Tidak ada file untuk diunduh.');
        }

        $zipFileName = 'attachments_' . $id . '.zip';
        $zipFilePath = storage_path('app/public/attachments/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($mataPembelajaran->attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment->path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
        } else {
            return back()->with('error', 'Gagal membuat file ZIP.');
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
