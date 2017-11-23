<?php 

namespace Invoices\Core\Models;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'name', 'cpf', 'birthdate'];

    /**
     * The invoices that belong to the user.
     */
    public function invoices()
    {
        return $this->hasMany('Invoices\Core\Models\Invoice');
    }
    
}
