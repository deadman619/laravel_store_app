<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class AdminTest extends DuskTestCase
{

    // LOGIN
    public function testLogin()
    {
        if(!User::find(1)) {
            $user = factory(User::class)->create([
                'email' => 'taylor@laravel.com',
            ]);
        }
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', "taylor@laravel.com")
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }

    // C R U D
    public function testCreateProduct()
    {
        for($i = 0; $i<3; $i++) {
            $this->browse(function (Browser $browser) {
                $browser->loginAs(User::find(1))
                        ->visit('/admin_panel/create')
                        ->type('name', 'TestProduct')
                        ->type('sku', '1000')
                        ->type('base_price', '100')
                        ->type('image', 'https://loremflickr.com/359/240')
                        ->press('Create Product')
                        ->assertSee('Product Added');
            });
        }
    }

    public function testReadProduct() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel')
                    ->click('a[class="btn btn-sm btn-success"]')
                    ->assertSee('Price:');
        });
    }

    public function testUpdateProduct() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel')
                    ->click('a[class="btn btn-sm btn-warning"]')
                    ->type('name', 'TestProductRenamed')
                    ->type('sku', '1001')
                    ->type('base_price', '80')
                    ->type('image', 'https://loremflickr.com/359/240')
                    ->press('Update Product')
                    ->assertSee('Product Updated');
        });
    }

    public function testDeleteProduct() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel')
                    ->click('a[class="btn btn-sm btn-danger"]')
                    ->assertSee('Product Deleted');
        });
    }

    // TAX

    public function testSetTax() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel/taxes')
                    ->type('name', 'Tenner Tax')
                    ->type('tax_rate', '10')
                    ->check('enable')
                    ->press('Set Tax')
                    ->assertSee('110€')
                    ->visit('admin_panel/taxes')
                    ->assertSee('10%')
                    ->assertSee('enabled');
        });
    }

    public function testDisableTax() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel/taxes')
                    ->uncheck('enable')
                    ->press('Set Tax')
                    ->assertSee('100€')
                    ->visit('admin_panel/taxes')
                    ->assertSee('disabled');
        });
    }

    public function testSetGlobalDiscount() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel/taxes')
                    ->type('global_discount', '5')
                    ->press('Set Tax')
                    ->assertSee('5% off');
        });
    }

    public function testDisableGlobalDiscount() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel/taxes')
                    ->type('global_discount', '')
                    ->press('Set Tax')
                    ->visit('/admin_panel/taxes')
                    ->assertSee('not set');
        });
    }

    public function testMassDelete() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel')
                    ->check('input')
                    ->press('Delete Selected')
                    ->assertSee('Products Deleted');
        });
    }
}

