<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:temp-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes tempfiles that are older than 1 hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = DB::table('temporary_files')->where('created_at', '<', now()->subHour())->get();

        foreach ($files as $file) {
            $path = storage_path('app/tmp/' . $file->folder);
            error_log($path);

            if (is_dir($path)) {
                // Delete directory and all its contents
                $this->deleteDirectory($path);
            } else {
                // Delete file
                unlink($path);
            }

            DB::table('temporary_files')->where('id', $file->id)->delete();
        }
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
