<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaxTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testSetTax() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin_panel/taxes')
                    ->type('tax_rate', '10')
                    ->check('enable')
                    ->press('Set Tax')
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
}
