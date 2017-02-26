<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;

class DriveEloquent extends BaseEloquent {

    protected $model;
    protected $service;

    public function __construct(\App\Models\Media $model) {
        $this->model = $model;
        $client = new \Google_Client();
        $client->setApplicationName(config('services.google.app_name'));
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setScopes(explode(',', config('services.google.scopes')));
        $client->setRedirectUri(config('services.google.redirect_url'));
        $client->setApprovalPrompt(config('services.google.approval_prompt'));
        $client->setAccessType(config('services.google.access_type'));

        $this->service = new \Google_Service_Drive($client);
    }

    public function upload($file) {
        $mime_type = $file->getClientMimeType();
        $file_name = $file->getClientOriginalName();
        
        $google_file = new \Google_Service_Drive_DriveFile();
        $google_file->setName($file_name);
        $google_file->setMimeType($mime_type);
        
        $insert_file = $this->service->files->create($google_file, [
            'data' => $file,
            'mimeType' => $mime_type,
            'uploadType' => 'multipart'
        ]);
        
        return $insert_file;
    }

}
