<?php

namespace EdiExpert\WebapiModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AddressType;

/**
 * Class Address
 *
 * @property int $id
 * @property int $addressable_id
 * @property string $addressable_type
 * @property int $address_type
 * @property string|null $full_name
 * @property string|null $landmark
 * @property string $street_name
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string $city
 * @property string|null $state
 * @property string|null $postal_code
 * @property string $country
 * @property string|null $phone_number
 * @property string|null $email
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read string $addressTypeLabel
 *
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;

    /** To use connection */
    protected $connection = 'ticketsender';

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'address_type',
        'full_name',
        'landmark',
        'street_name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'phone_number',
        'email',
        'latitude',
        'longitude',
        'notes',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Get the label of the address type.
     *
     * @return string
     */
    public function getAddressTypeLabelAttribute(): string
    {
        return AddressType::label((int) $this->address_type);
    }

    /**
     * Returns a formatted single-line string representation of the address.
     *
     * This method dynamically builds a readable address string using available fields
     * such as name, building, room number, street, city, and country. Empty fields are
     * automatically excluded to avoid unnecessary commas or gaps.
     *
     * @return string
     */
    public function formatted(): string
    {
        $parts = array_filter([
            $this->full_name,
            $this->address_line_1,    // e.g., hotel name, building name
            $this->address_line_2,    // e.g., room number, floor
            $this->street_name,
            $this->landmark,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }
}
