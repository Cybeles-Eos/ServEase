<?php

namespace App\Services;

class PhilippineZipcodeService
{
    /** @var array<int, array{location:string,region:?string,municipality:string,post_code:int}>|null */
    private static ?array $records = null;

    public function lookup(string $city, string $barangay = ''): ?string
    {
        $city = trim($city);
        $barangay = trim($barangay);

        if ($city === '') {
            return null;
        }

        $records = $this->records();
        $normalizedCity = $this->normalize($city);
        $normalizedBarangay = $this->normalize($barangay);

        if ($normalizedBarangay !== '') {
            $barangayMatches = array_values(array_filter(
                $records,
                fn (array $record) => $this->normalize($record['municipality']) === $normalizedBarangay
                    && (
                        $this->normalize($record['location']) === $normalizedCity
                        || str_contains($this->normalize($record['location']), $normalizedCity)
                        || str_contains($normalizedCity, $this->normalize($record['location']))
                    )
            ));

            if (count($barangayMatches) === 1) {
                return $this->formatZipcode($barangayMatches[0]['post_code']);
            }
        }

        $cityMatches = array_values(array_filter(
            $records,
            fn (array $record) => $this->normalize($record['municipality']) === $normalizedCity
        ));

        if (count($cityMatches) === 1) {
            return $this->formatZipcode($cityMatches[0]['post_code']);
        }

        $partialCityMatches = array_values(array_filter(
            $records,
            fn (array $record) => str_contains($this->normalize($record['municipality']), $normalizedCity)
                || str_contains($normalizedCity, $this->normalize($record['municipality']))
        ));

        if (count($partialCityMatches) === 1) {
            return $this->formatZipcode($partialCityMatches[0]['post_code']);
        }

        return null;
    }

    private function records(): array
    {
        if (self::$records !== null) {
            return self::$records;
        }

        $path = database_path('data/ph_postal_codes.json');

        if (! is_file($path)) {
            self::$records = [];

            return self::$records;
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        self::$records = is_array($decoded) ? $decoded : [];

        return self::$records;
    }

    private function normalize(string $value): string
    {
        $value = preg_replace('/^city of\s+/i', '', trim($value)) ?? trim($value);
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return strtolower($value);
    }

    private function formatZipcode(int|string $value): string
    {
        $digits = preg_replace('/\D/', '', (string) $value) ?? '';

        return str_pad(substr($digits, -4), 4, '0', STR_PAD_LEFT);
    }
}
