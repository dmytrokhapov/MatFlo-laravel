<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'farmer_id',
        'aggregator_id',
        'sy_no',
        'acres',
        'guntha',
        'pin_code',
        'village',
        'user_id',
        'property_type',
        'title_deed_in_name_of',
        'title_deed_status',
        'date_of_purchase',
        'date_of_sale_deed',
        'document_number',
        'aggrement_value',
        'ats',
        'gpa',
        'stamp_duty_on_sale_deed',
        'sale_registration',
        'dhc_charges',
        'aggregator_commission',
        'na_charges',
        'facilitation_charges',
        'crop_compensation',
        'row_charges',
        'any_other_expense',
        'total_cost_as_per_records',
        'total_cost_as_per_books',
        'difference',
        'reason',
        'status',
        'date_of_sale',
        'customer_name',
        'sale_of_consideration',
        'stamp_duty',
        'registration',
        'others',
        'total_sale_value',
        'profit_loss_on_sale_on_land',
        'capital_gains',
        'start_date',
        'end_date',
        'lease_value',
        'lease_stamp_duty',
        'liasoning_charges',
    ];

    public function payment_detail() {
		return $this->hasMany(PaymentDetail::class);
	}

    public function expense_detail() {
		return $this->hasMany(ExpenseDetail::class);
	}
}
