<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {
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
                    ->type('name', 'TestProduct')
                    ->type('sku', '1000')
                    ->type('base_price', '100')
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
}
