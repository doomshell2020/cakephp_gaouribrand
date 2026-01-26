<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouponsProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouponsProductsTable Test Case
 */
class CouponsProductsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CouponsProductsTable
     */
    public $CouponsProducts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CouponsProducts',
        'app.Coupons',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CouponsProducts') ? [] : ['className' => CouponsProductsTable::class];
        $this->CouponsProducts = TableRegistry::getTableLocator()->get('CouponsProducts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CouponsProducts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
