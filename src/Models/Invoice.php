<?php 

namespace Invoices\Core\Models;

class Invoice extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'company_name', 'invoice_value', 'invoice_due', 'paid'];

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo('Invoices\Core\Models\User');
    }
}
