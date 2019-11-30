<?php

namespace App\Imports;


use App\Guest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GuestsImport implements ToModel, WithHeadingRow , WithValidation ,SkipsOnFailure , WithBatchInserts, WithChunkReading
{
    use Importable,SkipsFailures;

    public function model(array $row)
    {
        return new Guest([
            'user_id' => auth('api')->user()->id,
            'organization_id' => auth('api')->user()->organization_id,
            'location_id' => auth('api')->user()->location_id,
            'guest_name' => $row['guest_name'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'cell_phone' => $row['cell_phone'],
            'home_phone' => $row['home_phone'],
            'address1' => $row['address1'],
            'address2' => $row['address2'],
            'zip' => $row['zip'],
            'city' => $row['city'],
            'state' => $row['state'],
            'country' => $row['country'],
            'birthdate' => $row['birthdate'],
            'email_opt' => $row['email_opt'],
            'ip' => $row['ip'],
            'location' => $row['location'],
            'browser' => $row['browser'],
            'referrer_url' => $row['referrer_url'],
            'os' => $row['os'],
            'is_mobile' => $row['is_mobile'],
            'screen_size' => $row['screen_size'],
            'textarea' => $row['textarea'],
            'last_reservation' => $row['last_reservation'],
            'total_reservation' => $row['total_reservation'],
            'total_nights' => $row['total_nights'],
            'household_size' => $row['household_size'],
            'anniversary_date' => $row['anniversary_date'],
            'marked' => $row['marked'] ?? 0
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
            'email' => 'required|unique:guests,email',
        ];
    }
    
    public function customValidationMessages()
    {
        return [
            'last_name' => 'Last Name',
        ];
    }
}