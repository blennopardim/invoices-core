<?php 

namespace Invoices\Core;

trait InvoiceCoreUserTraid
{
    /**
     * The invoices that belong to the user.
     */
    public function invoices()
    {
        return $this->hasMany('Invoices\Core\Models\Invoice');
    }
    
}