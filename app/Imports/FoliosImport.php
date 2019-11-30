<?php

namespace App\Imports;


use App\Folio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FoliosImport implements ToModel, WithHeadingRow , WithValidation ,SkipsOnFailure , WithBatchInserts, WithChunkReading
{
    use Importable,SkipsFailures;

    public function model(array $row)
    {
        return new Folio([
            'user_id' => auth('api')->user()->id,
            'organization_id' => auth('api')->user()->organization_id,
            'location_id' => auth('api')->user()->location_id,
            'folio_name' => $row['folio_name'],
            'email' => $row['email'],
            'cell_phone' => $row['cell_phone'],
            'home_phone' => $row['home_phone'],
            'address1' => $row['address1'],
            'address2' => $row['address2'],
            'zip' => $row['zip'],
            'city' => $row['city'],
            'state' => $row['state'],
            'country' => $row['country'],
            'last_reservation' => $row['last_reservation'],
            'total_reservation' => $row['total_reservation'],
            'total_nights' => $row['total_nights']
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
    public function onFailure(Failure ...$failures)
    {
        
    }
    public function rules(): array
    {
        return [
            'file' => 'mimetypes:text/csv',
            'email' => 'required|unique:folios,email',
        ];
    }
    
    public function customValidationMessages()
    {
        return [
            'last_name' => 'Last Name',
        ];
    }
}