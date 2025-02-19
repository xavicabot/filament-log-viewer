<?php

namespace XaviCabot\FilamentLogViewer\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use XaviCabot\FilamentLogViewer\FilamentLogViewer;

class Log extends Model
{
    use Sushi;

    public $timestamps = true;
    public static ?string $storage_path = NULL;

    public static function withPath(string $path)
    {
        static::$storage_path = $path;
        return new static();
    }


    public function getRows()
    {
        $data = $this->getData();
        $logs = $data['logs'];

        if ($logs === null) {
            return [[
                'id' => 1,
                'level' => 'error',
                'context' => 'system',
                'folder' => $data['current_folder'],
                'level_class' => 'danger',
                'level_img' => 'error',
                'date' => now(),
                'text' => 'El archivo es demasiado grande (>50MB) para ser leído',
                'in_file' => $data['current_file'],
                'stack' => 'File size exceeds limit',
            ]];
        }

        $data = [];

        foreach ($logs as $key => $log) {
            $data[] = [
                'id' => $key,
                'level' => $log['level'],
                'context' => $log['context'],
                'folder' => $log['folder'],
                'level_class' => $log['level_class'],
                'level_img' => $log['level_img'],
                'date' => $log['date'],
                'text' => $log['text'],
                'in_file' => $log['in_file'],
                'stack' => $log['stack'],
            ];
        }

        return $data;
    }

    public function getData():array
    {
        $log_viewer = new FilamentLogViewer;

        if(static::$storage_path) {
            $log_viewer->setStoragePath(static::$storage_path);
        }

        $log_viewer->setFile('laravel.log');

        $folderFiles = $log_viewer->getFolderFiles(true);

        $data = [
            'logs' => $log_viewer->all(),
            'folders' => $log_viewer->getFolders(),
            'current_folder' => $log_viewer->getFolderName(),
            'folder_files' => $folderFiles,
            'files' => $log_viewer->getFiles(true),
            'current_file' => $log_viewer->getFileName(),
            'standardFormat' => true,
            'structure' => $log_viewer->foldersAndFiles(),
            'storage_path' => $log_viewer->getStoragePath(),

        ];

        if (is_array($data['logs']) && count($data['logs']) > 0) {
            $firstLog = reset($data['logs']);
            if ($firstLog) {
                if (! $firstLog['context'] && ! $firstLog['level']) {
                    $data['standardFormat'] = false;
                }
            }
        }

        return $data;
    }
}
