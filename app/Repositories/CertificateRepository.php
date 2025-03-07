<?php

namespace App\Repositories;

use App\Models\Certificate;

class CertificateRepository
{
    public function getCertificates()
    {
        return Certificate::paginate(100);
    }

    public function getCertificate($id)
    {
        return Certificate::find($id);
    }

    public function create($data)
    {
        return Certificate::create($data);
    }

    public function update($id, $data)
    {
        $certificate = Certificate::find($id);
        $certificate->update($data);
        return $certificate;
    }

    public function delete($id)
    {
        $certificate = Certificate::find($id);
        $certificate->delete();
    }
}
