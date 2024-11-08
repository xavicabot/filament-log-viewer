<?php

namespace XaviCabot\FilamentLogViewer\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use XaviCabot\FilamentLogViewer\FilamentLogViewer;

class Log extends Model
{
    use Sushi;

    public $timestamps = true;

    public function getRows()
    {
        $logs = $this->getData()['logs'];

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

    public function getData()
    {
        $log_viewer = new FilamentLogViewer;

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
