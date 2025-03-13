<?php

namespace App\Models;

use CodeIgniter\Model;

class OfficeLocationModel extends Model
{
    protected $table = 'office_locations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get all active office locations
    public function getActiveLocations()
    {
        return $this->where('is_active', true)->findAll();
    }

    // Check if a given coordinate is within any office radius
    public function isWithinOfficeRadius($latitude, $longitude)
    {
        $locations = $this->getActiveLocations();
        
        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $location['latitude'],
                $location['longitude']
            );
            
            if ($distance <= $location['radius']) {
                return true;
            }
        }
        
        return false;
    }

    // Calculate distance between two coordinates in meters using Haversine formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta/2) * sin($latDelta/2) +
            cos($lat1) * cos($lat2) *
            sin($lonDelta/2) * sin($lonDelta/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }
}
