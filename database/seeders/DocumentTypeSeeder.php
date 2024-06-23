<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $docTypes = [
            ['documentType' => 'CV', 'description' => 'Curriculum Vitae', 'status' => 'Active'],
            ['documentType' => 'Police Clearance', 'description' => 'Policy Clearance', 'status' => 'Active'],
            ['documentType' => 'National ID', 'description' => 'National Identification Number', 'status' => 'Active'],
            ['documentType' => 'Passport', 'description' => 'Passport Document', 'status' => 'Active'],
            ['documentType' => 'Proof of Residence', 'description' => 'Proof of Residence', 'status' => 'Active'],
        ];

        foreach ($docTypes as $doc) {
            $currentDoc = DocumentType::query()->firstWhere('documentType', '=', $doc['documentType']);
            if ($currentDoc != null) {
                continue;
            }
            DocumentType::query()->create($doc);
        }

    }
}
