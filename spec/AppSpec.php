<?php 
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

use Invoices\Core\Models\User;
use Invoices\Core\Models\Invoice;

function setUp()
{
    Eloquent::unguard();
    $db = new DB;
    $db->addConnection([
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
    $db->bootEloquent();
    $db->setAsGlobal();
    
    $schema = $db->schema();
    $schema->create('users', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->string('cpf')->unique();
        $table->date('birthdate');
        $table->timestamps();
    });

    $schema->create('invoices', function ($table) {
        $table->increments('id');
        $table->string('company_name');
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('user');
        $table->float('invoice_value');
        $table->date('invoice_due');
        $table->boolean('paid');
        $table->timestamps();
    });
}

setUp();

describe('test user', function()
{
    it('insert new user is user instaceOf and id is integer', function () {
        $user = User::create([
            'name' => 'Blenno Pardim',
            'cpf'  => '03869076178',
            'birthdate' => '1990-08-23'
        ]);
        expect($user)->toBeAnInstanceOf(User::class); 
        expect($user->id)->toBeA('integer');
    });

    it('Delete user', function ()
    {
        User::where('cpf', '03869076178')->delete();
        expect(User::where('cpf', '03869076178')->exists())->toBe(false);
    });
});

describe('test invoices', function()
{
    it('create invoice', function () {
    
        
        $user = User::create([
            'name' => 'Blenno Pardim',
            'cpf'  => '03869076178',
            'birthdate' => '1990-08-23'
        ]);
        
        $invoice_values = [
            'company_name' => 'Acme Company',
            'invoice_value'  => 50.0,
            'invoice_due' => '2017-12-01',
            'paid' => false
        ];

        $invoice = $user->invoices()->save(
            new Invoice($invoice_values)
        );
        
        expect($invoice->id)->toBeA('integer');        
        expect($invoice)->toBeAnInstanceOf(Invoice::class);
        expect($invoice->user->id)->toBe($user->id);
    });

    it('delete invoice', function() {
        Invoice::where('company_name', 'Acme Company')->delete();
        expect(Invoice::where('company_name', 'Acme Company')->exists())->toBe(false);
    });
    
    it('create multiple invoices', function () {
    
        $user = User::where('cpf', '03869076178')->first();
        $invoices_values = [
            [
            'company_name' => 'Acme Company',
            'invoice_value'  => 39.0,
            'invoice_due' => '2017-12-01',
            'paid' => false
            ],
            [
            'company_name' => 'Acme Company',
            'invoice_value'  => 43.0,
            'invoice_due' => '2017-12-01',
            'paid' => true
            ]
        ];

        $invoices = $user->invoices()->saveMany([
            new Invoice($invoices_values[0]),
            new Invoice($invoices_values[1])            
        ]);
        
        expect($invoices)->toBeA('array');
        expect($user->invoices->count())->toBe(2);
        expect($user->invoices[0]->paid)->toBe('0');
        expect($user->invoices[1]->paid)->toBe('1');
    });

});